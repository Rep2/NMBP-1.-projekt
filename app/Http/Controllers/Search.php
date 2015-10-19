<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;

class Search extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('search');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
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
            'text' => 'required|max:1000',
            'andor' => 'required|int',
            'type' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()],400);
        }

        $text = $request->input('text');

        $isIn = false;
        $firstIndex = 0;
        $tokenArray = [];

        $strlen = strlen( $text );
        for( $i = 0; $i <= $strlen; $i++ ) {
            $char = substr( $text, $i, 1 );

            if ($char == '\"'){
                if ($isIn){
                    if ($i > $firstIndex) {
                        array_push($tokenArray, substr($text, $firstIndex, $i - $firstIndex));
                    }

                    $firstIndex = $i + 1;
                    $isIn = false;
                }else{
                    if ($i > $firstIndex) {
                        array_push($tokenArray, substr($text, $firstIndex, $i - $firstIndex));
                    }

                    $firstIndex = $i + 1;
                    $isIn = true;
                }
            }else if ($char == ' ' && !$isIn){
                if ($i > $firstIndex) {
                    array_push($tokenArray, substr($text, $firstIndex, $i - $firstIndex));
                }

                $firstIndex = $i + 1;
            }
        }

        if (($i - $firstIndex) - 1 > 0) {
            array_push($tokenArray, substr($text, $firstIndex, $i - $firstIndex - 1));
        }

        return response()->json(['message' => $tokenArray], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
