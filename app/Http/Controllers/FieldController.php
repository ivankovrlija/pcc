<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Field;
use App\Guest;

class FieldController extends Controller

/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
{
    public function addField(Request $request){


		$request->validate([
            'field_name'      => 'required|min: 2000',
        ]);

        if ( Field::create($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }

        $id = Field::all()->last();

        return response()->json($id, 200);


    }

    public function updateField(Request $request, $id){

        $guest = Guest::where('id', $id)->get();

        //$field = Field::where('id', $guest->field_id)->get();

        $field = Field::where('id', $guest[0]['field_id'])->get();

        $fields = [
            'field_name' => $field[0]['field_name'],
            'id' => $field[0]['id'],
        ];        

        return response()->json($fields, 200);
    }



    public function updateFieldName(Request $request, $id){

        $field = Field::where('id', $id)->get();
        //$field->update();

        DB::table('fields')->where('id', $id)->update(['field_name' => $request->field_name]);

        //$id = $guest[0]['field_id'];
        return response()->json($id, 200);
    }
}
