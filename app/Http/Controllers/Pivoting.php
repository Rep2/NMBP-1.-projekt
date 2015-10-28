<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Support\Facades\DB;

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
     * @param  \Illuminate\Http\Request $request
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
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $datOd = \DateTime::createFromFormat('Y-m-d', $request->input("datum_od"));
        $datOd->setTime(0,0);
        $datDo = \DateTime::createFromFormat('Y-m-d', $request->input("datum_do"));
        $datDo->setTime(23,0);
        $type = $request->input("type");

        $dateQuery = "DD.MM.YYYY";
        if ($type == 1){
            $dateQuery .= " HH";
        }

        $queryString = "SELECT * FROM crosstab ('SELECT query, to_char(date, ''" .$dateQuery. "'') newDate, count(*)
          FROM log
          WHERE date::DATE >= ''" .$datOd->format('Y-m-d'). "'' AND date::DATE <= ''" .$datDo->format('Y-m-d'). "''
          GROUP BY query, newDate
          ORDER BY query, newDate')
          AS pivotTable (query varchar(1000)";

        $interval = $type == 0 ?  \DateInterval::createFromDateString('1 day') : \DateInterval::createFromDateString('1 hour');
        $period = new \DatePeriod($datOd, $interval, $datDo);

        $dateQuery2 = "d.m.Y";
        if ($type == 1){
            $dateQuery2 .= " H";
        }
        foreach ($period as $dt)
            $queryString .= ", \"" . $dt->format($dateQuery2) . "\" bigint";

        $queryString .= ", 'SELECT DISTINCT to_char(date, ''" .$dateQuery. "'') FROM log ORDER BY 1') ORDER BY query";

        $result = DB::select($queryString);

        return response()->json(["result" => $result], 200);
    }
}
