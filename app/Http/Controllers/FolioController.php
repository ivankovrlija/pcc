<?php

namespace App\Http\Controllers;

use App\Folio;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Exports\FoliosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FoliosImport;
use Maatwebsite\Excel\Exceptions\NoTypeDetectedException;
use Maatwebsite\Excel\Validators\ValidationException;

class FolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $folio = Folio::all();
        // return response()->json($folio, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function addGuest(Request $request, $id)
    {
        $folio = Folio::find($id);
        $folioid = $folio->id;
        $guestid = $request->guest_id;
        
        if($guestid){
            $folio->guests()->attach($guestid);
            $response = [ 'status' => 'success' ];
        }else{
            $response = [ 'status' => 'error' ];
        }
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'folio_name' => 'required|string|max:255'
        ]);

        if ( Folio::create($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $folio = Folio::find($id);
        return response()->json($folio, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'folio_name' => 'required|string|max:255'
        ]);

        $folio = Folio::find($id);        

        if ($request->lead_owner) {
            $request->user_id = auth('api')->user()->id;
        }

        if (!$folio) {
            return response()->json([ 'status' => 'error' ], 404);
        }

        if ( $folio->update($request->except([ 'lead_owner' ])) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folio  $folio
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $folio = Folio::find($id);

        if(!$folio) {
            return response()->json([
                'status' => 'success',
                'message' => 'Group does not exists or already deleted'
            ]);
        }

        $folio->delete();

        return response()->json([ 'status' => 'success' ], 200);
    }

    public function datatable(Request $request) {
        $sort     = $request->sort['sort'] ?? 'desc';
        $field    = $request->sort['field'] ?? 'id';
        $page     = $request->pagination['page'];
        $per_page = $request->pagination['perpage'];
        $filter_by = $request->input('filter');
        $conditions = json_decode($request->input('conditions'), true);
        $searchable = ['folio_name', 'email', 'address1', 'zip', 'city', 'state', 'country'];
        
        $query = $request->input('query') ?? [];
        $built_query = $this->buildQuery($query, $filter_by, $conditions);
        $offset = ($page - 1) * $per_page;
        $total = Folio::where($built_query)->count();
        
        if ($offset > $total) { $offset = 0; }
                
        if (isset($query['general'])) {
            $term = $query['general'];
            $iterator = 0;
            foreach ($searchable as $search_key) {
                $iterator++;
                $search_query   = $built_query;
                $search_query[] = [$search_key, 'like', "%{$term}%"];
                if ($iterator === 1) {
                    $data = Folio::where($search_query);
                } else {
                    $data->orWhere($search_query);
                }
            }
        } else {
            $data = Folio::where($built_query);
        }
        $base = $data->orderBy($field, $sort)->offset($offset)->limit($per_page)->get();
        $paginated = $data->orderBy($field, $sort)->paginate($per_page);

        $datatable['data']            = $base;
        $datatable['meta']['page']    = $page;
        $datatable['meta']['pages']   = $paginated->lastPage();
        $datatable['meta']['perpage'] = $paginated->perPage();
        $datatable['meta']['sort']    = $sort;
        $datatable['meta']['filter']  = $filter_by;
        $datatable['meta']['total']   = $paginated->total();
        $datatable['meta']['field']   = 'id';
        return $datatable;
    }

    private function getDateFilter(String $filter_by): Array {
        if ($filter_by === 'last7Days') {
            return ['created_at', '>=', Carbon::now()->subDays(7)->toDateTimeString()];
        } elseif ($filter_by === 'last30Days') {
            return ['created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString()];
        } elseif ($filter_by === 'today') {
            return ['created_at', '>=', Carbon::now()->subDays(1)->toDateTimeString()];
        } elseif ($filter_by === 'owned') {
            return ['user_id', '=', auth('api')->user()->id];
        }
    }

    private function buildQuery(Array $queries = [], String $filter_by = '', $conditions = null): Array {
        $collection = []; 

        if (auth('api')->user()->organization_id) {
            $collection[] = ['organization_id', '=', auth('api')->user()->organization_id];
        }

        if (auth('api')->user()->location_id) {
            $collection[] = ['location_id', '=', auth('api')->user()->location_id];
        }

        if (!empty($queries)) {
            foreach ($queries as $key => $value) {
                if ($key !== 'general') {
                    $collection[] = [$key, 'like', "%{$value}%"];
                }
            }
        }
        if (!empty($filter_by) && $filter_by !== 'all') {
            $collection[] = $this->getDateFilter($filter_by);
        }
        if ($conditions && count($conditions) > 0) {
            foreach ($conditions as $condition) {
                $field    = $condition['value'];
                $operator = $condition['condition'] === 'equal' ? '=' : ($condition['condition'] === 'not_equal' ? '!=' : 'like');
                $value = $operator === 'like' ? "%{$condition['conditionValue']}%" : $condition['conditionValue'];
                $collection[] = [$field, $operator, $value];
            }
        }
        return $collection;
    }

    public function export($id)
    {
        return Excel::download(new FoliosExport($id), 'folios_all.csv');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required'
        ]);

        try {
            Excel::import(new FoliosImport, $request->file, \Maatwebsite\Excel\Excel::CSV);
            return response()->json([ 'status' => 'success' ], 200);
        } 
        catch(NoTypeDetectedException $e){
            return response()->json([
                'status'  => 'error',
                'message' => 'File format not supported!'
            ], 422);
        } 
        catch (ValidationException $e){
            return response()->json([ 'status' => 'error' ]);
        }
    }
}
