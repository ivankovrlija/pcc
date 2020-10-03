<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	//return $request->name;
        $request->validate([
            'name'      			  => 'required',
            'type'      			  => 'required',
            'year'      			  => 'required',
            'number_of_employees'     => 'required',
            'details'   			  => 'required',
        ]);

        if ( Course::create($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guest  $Guest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);

        return response()->json($course, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type'  => 'required',
            'year'      => 'required',
            'details'      => 'required',
            'number_of_employees'      => 'required',
        ]);

        $course = Course::find($id);        

        if (!$course) {
            return response()->json([ 'status' => 'error' ], 404);
        }

        if ( $course->update($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $course = Course::find($id);

        if(!$course) {
            return response()->json([
                'status' => 'success',
                'message' => 'Course does not exists or already deleted'
            ]);
        }

        $course->delete();

        return response()->json([ 'status' => 'success' ], 200);
    }

    public function datatable(Request $request) {
        $sort     = $request->sort['sort'] ?? 'desc';
        $field    = $request->sort['field'] ?? 'id';
        $page     = $request->pagination['page'];
        $per_page = $request->pagination['perpage'];
        $filter_by = $request->input('filter');
        $conditions = json_decode($request->input('conditions'), true);
        $searchable = ['first_name', 'last_name', 'email', 'address1', 'zip', 'city', 'state', 'country'];
        
        $query = $request->input('query') ?? [];
        $built_query = $this->buildQuery($query, $filter_by, $conditions);
        $offset = ($page - 1) * $per_page;
        $total = Course::where($built_query)->count();
        
        if ($offset > $total) { $offset = 0; }
                
        if (isset($query['general'])) {
            $term = $query['general'];
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
            $data = Course::where($built_query);
        }
        $base = $data->orderBy($field, $sort)->offset($offset)->limit($per_page)->get();
        $paginated = $data->orderBy($field, $sort)->paginate($per_page);

        $datatable['data']            = $base;
        $datatable['meta']['page']    = $page;
        $datatable['meta']['pages']   = $paginated->lastPage();
        $datatable['meta']['perpage'] = $paginated->perPage();
        //$datatable['meta']['sort']    = $sort;
        //$datatable['meta']['filter']  = $filter_by;
        $datatable['meta']['total']   = $paginated->total();
        $datatable['meta']['field']   = 'id';
        return $datatable;
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

    private function getDateFilter(String $filter_by): Array {
        if ($filter_by === 'last7Days') {
            return ['created_at', '>=', Carbon::now()->subDays(7)->toDateTimeString()];
        } elseif ($filter_by === 'last30Days') {
            return ['created_at', '>=', Carbon::now()->subDays(30)->toDateTimeString()];
        } elseif ($filter_by === 'today') {
            return ['created_at', '>=', Carbon::now()->subDays(1)->toDateTimeString()];
        } elseif ($filter_by === 'owned') {
            return ['id', '>', '0'];
        }
    }
}
