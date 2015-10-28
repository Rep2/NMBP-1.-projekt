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
        $datDo = \DateTime::createFromFormat('Y-m-d', $request->input("datum_do"));
        $type = $request->input("type");

        $queryString = "SELECT * FROM crosstab ('SELECT query, date, count(*)
          FROM log
          GROUP BY query, date
          ORDER BY query, date')
          AS pivotTable (ds text";
// WHERE date::DATE >= to_date('" .$datOd->format('d-m-Y'). "', 'd-m-Y') AND date::Date <= to_date('" .$datDo->format('d-m-Y'). "', 'd-m-Y')

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($datOd, $interval, $datDo);

     //   foreach ($period as $dt)
     //       $queryString .= ", " . $dt->format('d-m-Y') . " int";

        //   while (strtotime($datOd) <= strtotime($datDo)) {
        //    $queryString += ", " + $datOd + " int";
        //  }

        $queryString .= ", prvi int, prvi2 int, prvi3 int, prvi4 int) ORDER BY ds";

        $result = DB::select($queryString);

        return response()->json(["str" => $result], 200);
    }
}
