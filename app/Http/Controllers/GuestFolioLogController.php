<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use App\GuestFolioLog;
use App\Folio;
use App\User;
use App\Guest;
use App\Mail\GuestEmailLog;
use Mail;

class GuestFolioLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guest_log = GuestFolioLog::all();
        return response()->json($guest_log, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'guestfolio_id' => 'required',
        ]);

        $guest_logs  = new GuestFolioLog;
        $guest_logs->user_id = $request->user_id;
        $guest_logs->organization_id = auth('api')->user()->organization_id;
        $guest_logs->guestfolio_id = $request->guestfolio_id;
        $guest_logs->type    = $request->type;

        if ($request->type === 'notes') {
            $guest_logs->note_title = $request->title;
            $guest_logs->note_body  = $request->message;
        }

        if (in_array($request->type, ['notes'])) {
            $guest_logs->save();
        }

        if ($guest_logs->save()){
            $response = ['status' => 'success'];
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GuestFolioLog  $GuestFolioLog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $guest_logs = GuestFolioLog::where('guestfolio_id', '=', $id)->orderBy('created_at', 'desc')->get();
        
        $guest_logs_array = $guest_logs->toArray();
        $mapped_GuestFolioLogs = array_map(function($guest_log) {
            $created_at = new CarbonImmutable($guest_log['created_at']);
            $guest_log['created_at'] = $created_at->format('M d');
            $guest_log['name'] = Folio::find($guest_log['guestfolio_id'])->guestfolio_name;
            $guest_log['user'] = User::find($guest_log['user_id'])->full_name;
            return $guest_log;
        }, $guest_logs_array);
        return response()->json($mapped_GuestFolioLogs);

    }

    public function gueststable($id){

        $folios = Folio::where('id', $id)->with('guests')->first();
        $gueststable_array = $folios->guests->toArray();
        $mapped_GuestFolioTable = array_map(function($folio) {
            $created_at = new CarbonImmutable($folio['created_at']);
            $folio['created_at'] = $created_at->format('M d');
            return $folio;
        }, $gueststable_array);
        return response()->json($mapped_GuestFolioTable, 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GuestFolioLog  $GuestFolioLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    
    public function datatable(Request $request) {
        $page     = $request->pagination['page'];
        $sort     = $request->sort['sort'] ?? 'desc';
        $field    = $request->sort['field'] ?? 'id';
        $per_page = $request->pagination['perpage'];

        $searchable = ['first_name', 'last_name', 'email', 'address1', 'zip', 'city', 'state', 'country'];

        $query = $request->input('query') ?? [];

        $built_query = $this->buildQuery($query);

        $offset = ($page - 1) * $per_page;
        $total = Guest::count();
        
        if ($offset > $total) { $offset = 0; }

        if (isset($query['generalSearch'])) {
            $term = $query['generalSearch'];
            $iterator = 0;
            foreach ($searchable as $search_key) {
                $iterator++;
                $search_query   = $built_query;
                $search_query[] = [$search_key, 'like', "%{$term}%"];

                if ($iterator === 1) {
                    $data = Guest::where($search_query);
                } else {
                    $data->orWhere($search_query);
                }
            }
        } else {
            $data = Guest::where($built_query);
        }

        $base = $data->orderBy($field, $sort)->offset($offset)->limit($per_page)->get();
        $paginated = $data->orderBy($field, $sort)->paginate($per_page);

        $datatable['data']            = $base;
        $datatable['meta']['page']    = $page;
        $datatable['meta']['pages']   = $paginated->lastPage();
        $datatable['meta']['perpage'] = $paginated->perPage();
        $datatable['meta']['sort']    = $sort;
        $datatable['meta']['total']   = $paginated->total();
        $datatable['meta']['field']   = 'id';

        return $datatable;
    }

    private function buildQuery(Array $queries = []): Array {
        $collection = [];

        if (auth('api')->user()->type) {
            $collection[] = ['type', '=', auth('api')->user()->type];
        }

        if (!empty($queries)) {
            foreach ($queries as $key => $value) {
                if ($key !== 'generalSearch') {
                    $collection[] = [$key, 'like', "%{$value}%"];
                }
            }
        }

        return $collection;
    }

}
