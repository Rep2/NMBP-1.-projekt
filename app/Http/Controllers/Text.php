<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class Text extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()],400);
        }

        $text = $request->input('text');

        DB::insert("INSERT INTO texts VALUES (nextval('textsSequence'), '" .$text. "')");

        return response()->json(['message' => 'Redak dodan'], 200);
    }

    public function get($id){

        $result = DB::select("SELECT text FROM texts where id=:id", ['id' => $id]);

        return response()->json($result[0]=>get("text"), 200);
    }

}
