<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\ClientException;
use Exception;
use App\Post;
use App\User;
use Abraham\TwitterOAuth\TwitterOAuth;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookSDKException;

class SendScheduledPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $posts = Post::where([
            [ 'sent', '=', false ],
            [ 'published_at', '<', Carbon::now() ]
        ])->get();
        foreach ($posts as $post) {
            $user = User::find($post->user->id);

            try {
                if (!count($user->integrations)) {
                    throw new Exception("No integrations found for user: {$user->email}");
                }

                $integrations = $user->integrations()->get()->toArray();
                
                $facebook_index = array_search('facebook', array_column($integrations, 'provider'));
                $linkedin_index = array_search('linkedin', array_column($integrations, 'provider'));
                $twitter_index  = array_search('twitter', array_column($integrations, 'provider'));

                $facebook_tokens = $integrations[$facebook_index] ?? null;
                $linkedin_tokens = $integrations[$linkedin_index] ?? null;
                $twitter_tokens  = $integrations[$twitter_index] ?? null;

                $platforms = explode(', ', $post->platforms);

                if (in_array('facebook', $platforms)) {
                    if ($facebook_tokens) {
                        $this->publish_facebook($post->message, $post->image, $facebook_tokens);
                    } else {
                        throw new Exception("Invalid/Missing Facebook token");
                    }
                }

                if (in_array('linkedin', $platforms)) {
                    if ($linkedin_tokens) {
                        $this->publish_linkedin($post->message, $post->image, $linkedin_tokens);
                    } else {
                        throw new Exception("Invalid/Missing LinkedIn token");
                    }
                }

                if (in_array('twitter', $platforms)) {
                    if ($twitter_tokens) {
                        $this->publish_twitter($post->message, $post->image, $twitter_tokens);
                    } else {
                        throw new Exception("Invalid/Missing Twitter token");
                    }
                }

                $post->sent = true;
                $post->save();
            } catch (Exception $e) {
                print_r($e->getMessage());
            }
        }
    }

    public function publish_facebook(String $publish_message, String $media_link, $integration)
    {
        $facebook = new Facebook([
            'app_id'                => config('services.facebook.client_id'),
            'app_secret'            => config('services.facebook.client_secret'),
            'default_graph_version' => 'v3.3'
        ]);

        $facebook->setDefaultAccessToken($integration['access_token']);

        if (!empty($media_link)) {
            $endpoint = 'photos';
            $data = [
                'caption' => $publish_message,
                'url'     => $media_link
            ];
        } else {
            $endpoint = 'feed';
            $data = [
                'message' => $publish_message
            ];
        }

        $pages = $facebook->get('/me/accounts', $integration['access_token']);
        $pages = $pages->getGraphEdge()->asArray();

        foreach ($pages as $page) {
            try {
                $facebook->post("/{$page['id']}/{$endpoint}", $data, $page['access_token']);
            } catch (FacebookSDKException $e) {
                throw new exception($e->getMessage());
            }
        }
    }

    public function publish_linkedin(String $publish_message, String $media_link, $integration)
    {
        if (!empty($media_link)) {
            $publish_message .= ' ' . $media_link;
        }

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $publish_message, $match);

        $medias = [];
        $shareMediaCategory = 'NONE';
        foreach ($match[0] as $link) {
            $medias[] = [
                'status'      => 'READY',
                'originalUrl' => $link
            ];
        }
        if (count($medias)) {
            $shareMediaCategory = 'ARTICLE';
        }

        $client = new Client([ 'timeout' => 300 ]);

        $headers = [
            'Authorization' => "Bearer {$integration['access_token']}",
            'Content-Type'  => 'application/json',
            'X-Restli-Protocol-Version' => '2.0.0'
        ];

        try {
            $profileResponse = $client->get('https://api.linkedin.com/v2/me', [ 'headers' => $headers ]);
            $content = $profileResponse->getBody(true)->getContents();
            $me = json_decode($content);
            $id = $me->id;
            $urn = "urn:li:person:{$id}";
            $data = [
                'author' => $urn,
                'lifecycleState' => 'PUBLISHED',
                'visibility' => [
                    "com.linkedin.ugc.MemberNetworkVisibility" => 'PUBLIC'
                ],
                'specificContent' => [
                    'com.linkedin.ugc.ShareContent' => [
                        'shareCommentary' => [
                            'text' => $publish_message
                        ],
                        'shareMediaCategory' => $shareMediaCategory
                    ]
                ]
            ];
            if ($shareMediaCategory === 'ARTICLE') {
                $data['specificContent']['com.linkedin.ugc.ShareContent']['media'] = $medias;
            }
            
            try {
                $client->post('https://api.linkedin.com/v2/ugcPosts', [
                    'headers' => $headers,
                    'json'    => $data
                ]);
            } catch(ServerException $e) {
                throw new Exception($e->getMessage());
            }
        } catch(ClientException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function publish_twitter(String $publish_message, String $media_link, $integration)
    {
        $filename   = basename($media_link);
        $images     = base_path() . "/public/storage/social-medias/$filename";
        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $integration['access_token'], $integration['secret_token']);
        $connection->setTimeouts(10, 15);

        if ($media_link) {
            $img_arr = [];
            if (is_array($images)) {
                foreach ($images as $image) {
                    $media = $connection->upload('media/upload', ['media' => $image]);
                    array_push($img_arr, $media->media_id_string);
                }
            } else {
                $media = $connection->upload('media/upload', ['media' => $images]);
                array_push($img_arr, $media->media_id_string);
            }
        }

        $parameters = ['status' => $publish_message];

        if (isset($img_arr) && count($img_arr) > 0) {
            $parameters['media_ids'] = implode(',', $img_arr);
        }

        $connection->post("statuses/update", $parameters);
    }
}
