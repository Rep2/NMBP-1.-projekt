<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Pivoting extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pivoting');
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
            'datum_od' => 'required',
            'datum_do' => 'required',
            'type' => 'required|int'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()],400);
        }

        $datOd = $request->input("datum_od");
        $datDo = $request->input("datum_do");
        $type = $request->input("type");

        $queryString = "SELECT * FROM crosstab ('SELECT query, CAST(date AS DATE) as newDate, count(*)
          FROM log
          GROUP BY query, newDate
          ORDER BY query, newDate)
          AS pivotTable (query varchar";

        while (strtotime($datOd) <= strtotime($datDo)) {
            $queryString += ", " + $datOd + " int";
        }

        $queryString += ") ORDER BY query";

        return response()->json(["str" => $queryString],200);

    }
}
