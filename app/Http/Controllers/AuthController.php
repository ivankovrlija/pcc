<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Abraham\TwitterOAuth\TwitterOAuth;
use Socialite;
use Auth;
use App\Integration;
use App\User;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'handleProviderCallback', 'saveToken']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        $request->validate([
            'email' => 'required|email:user',
            'password' => 'required'
        ]);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $me = User::where('id', auth('api')->user()->id)->with(['integrations', 'role', 'location', 'organization'])->first();
        return response()->json($me);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'integrations' => $this->guard()->user()->integrations,
            'role'         => $this->guard()->user()->role,
            'organization' => $this->guard()->user()->organization,
            'location'     => $this->guard()->user()->location,
            'user'         => $this->guard()->user(),
            'token_type'   => 'bearer',
            'expires_in'   => ((auth('api')->factory()->getTTL() * 60) * 24) * 7
        ]);
    }

    public function guard()
    {
        return Auth::Guard('api');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param  string $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(Request $request, $provider)
    {
        if (isset($request->scopes) && count($request->scopes) > 0) {
            return [
                'url' => Socialite::driver($provider)
                    ->scopes($request->scopes)
                    ->stateless()
                    ->redirect()
                    ->getTargetUrl(),
            ];
        } else {
            if ($provider === 'twitter') {
                return [
                    'url' => $this->redirectToTwitter()
                ];
            } else {
                return [
                    'url' => Socialite::driver($provider)
                        ->stateless()
                        ->redirect()
                        ->getTargetUrl(),
                ];
            }
        }
    }

    private function redirectToTwitter() {
        $tempId = str_random(40);
    
        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'));
        $connection->setTimeouts(30, 60);
        $requestToken = $connection->oauth('oauth/request_token', [ 'oauth_callback' => config('services.twitter.redirect') . '?user=' . $tempId ]);
    
        \Cache::put($tempId, $requestToken['oauth_token_secret'], 1);
         $url = $connection->url('oauth/authorize', array('oauth_token' => $requestToken['oauth_token']));
         return $url;
      }

    /**
     * Obtain the user information from the provider.
     *
     * @param  string $driver
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        $data = $provider !== 'twitter'
            ? Socialite::driver($provider)->stateless()->user()
            : $this->handleTwitterLoginCallback($request);

        $users = User::orderBy('email', 'asc')->get();

        return view('integrations.index', [
            'data' => json_encode($data),
            'provider' => $provider,
            'users' => $users
        ]);
    }

    private function handleTwitterLoginCallback(Request $request) {
        $connection = new TwitterOAuth(config('services.twitter.client_id'), config('services.twitter.client_secret'), $request->oauth_token, $request->user);
        $connection->setTimeouts(30, 60);
        $access_token = $connection->oauth('oauth/access_token', [ 'oauth_verifier' => $request->oauth_verifier ]);
        return $access_token;
    }

    public function saveFBToken(Request $request)
    {
        $integration = Integration::where([
            ['user_id', '=', auth('api')->user()->id],
            ['provider', '=','facebook']
        ])->first();

        // $test = $request->access_token;
        if ($integration) {
            $integration->provider        = 'facebook';
            $integration->access_token    = $request->access_token;
        } else {
            $integration                  = new Integration();
            $integration->user_id         = auth('api')->user()->id;
            $integration->organization_id = null;
            $integration->provider        = 'facebook';
            $integration->access_token    = $request->access_token;
        }


        $integration->save();

        return response()->json([ 'status' => 'success' ], 200);
    }

    public function removeFbToken(Request $request)
    {
        $integration = Integration::where([
            ['user_id', '=', auth('api')->user()->id],
            ['provider', '=','facebook']
        ])->first();

        if(!$integration) {
            return response()->json([
                'status' => 'success',
                'message' => 'Lead does not exists or already deleted'
            ]);
        }

        $integration->delete();

        return response()->json([ 'status' => 'success' ], 200);
    }

    public function saveToken(Request $request, $provider)
    {

        $data = json_decode($request->data);
        
        $token   = null;
        $expiry  = null;
        $refresh = null;
        $secret  = null;

        switch($provider) {
            case 'linkedin':
                $token   = $data->token;
                $refresh = $data->refreshToken;
                $expiry  = $data->expiresIn;
                break;
            case 'google':
                $token   = $data->token;
                $refresh = $data->refreshToken;
                $expiry  = $data->expiresIn;
                break;
            case 'twitter':
                $token  = $data->oauth_token;
                $secret = $data->oauth_token_secret;
                break;
            case 'facebook':
                $token   = $data->token;
                $refresh = $data->refreshToken;
                $expiry  = $data->expiresIn;
                break;
        }

        // Bail early if no token is received
        if (!$token) { return false; }


        $integration = Integration::where([
            ['user_id', '=', $request->user],
            ['provider', '=', $provider]
        ])->first();

        if ($integration) {
            $integration->provider        = $provider;
            $integration->access_token    = $token;
            $integration->secret_token    = $secret;
            $integration->refresh_token   = $refresh;
            $integration->expiry          = $expiry;
        } else {
            $integration                  = new Integration();
            $integration->user_id         = $request->user;
            $integration->organization_id = null;
            $integration->provider        = $provider;
            $integration->access_token    = $token;
            $integration->secret_token    = $secret;
            $integration->refresh_token   = $refresh;
            $integration->expiry          = $expiry;
        }


        $integration->save();

        return response()->json([ 'status' => 'success' ], 200);
    }
}
