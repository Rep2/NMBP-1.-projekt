<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class NewSearch extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('newSearch');
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

        for( $i = 0; $i <= strlen( $text ); $i++ ) {
            $char = substr( $text, $i, 1 );

            // Checks if char == "
            if (ord($char) == 34){
                if ($isIn){
                    if ($i > $firstIndex) {
                        array_push($tokenArray, "(" .trim(substr($text, $firstIndex, $i - $firstIndex)). ")");
                    }

                    $firstIndex = $i + 1;
                    $isIn = false;
                }else{
                    if ($i > $firstIndex) {
                        array_push($tokenArray, "(" .trim(substr($text, $firstIndex, $i - $firstIndex)). ")");
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

        $parsedTokenArray = [];
        for( $i = 0; $i < count($tokenArray); $i++) {
            array_push($parsedTokenArray, preg_replace('!\s+!', ' & ', $tokenArray[$i]));
        }

        $separator = $request->input('andor') == 0 ? " & " : " | ";

        $queryString = "'" .implode($separator, $parsedTokenArray). "'";

        $selectQuery = "SELECT ts_headline('english', text, to_tsquery('english', '" .substr($tokenArray[0], 1, strlen($tokenArray[0]) - 2). "')) title,
               ts_rank(to_tsvector(text), to_tsquery(" .$queryString. ")) rank" .chr(10). "FROM texts ";

        $separator = $request->input('andor') == 0 ? "AND " : "OR ";

        $selectQuery .= "" .chr(10). "WHERE";



        for( $i = 0; $i < count($tokenArray); $i++) {

            if ($request->input('type') == 0) {
                if ($tokenArray[$i][0] == '(') {
                    $selectQuery .= " text LIKE '%" . substr($tokenArray[$i], 1, strlen($tokenArray[$i]) - 2) . "%'";
                } else {
                    $selectQuery .= " text LIKE '%" . $tokenArray[$i] . "%'";
                }
            }else if ($request->input('type') == 1) {
                if ($tokenArray[$i][0] == '(') {
                    $selectQuery .= " to_tsvector(text) @@ to_tsquery('english','" .substr($parsedTokenArray[$i], 1, strlen($parsedTokenArray[$i]) - 2). "')";
                } else {
                    $selectQuery .= " to_tsvector(text) @@ to_tsquery('english','" .$parsedTokenArray[$i]. "')";
                }
            }else{
                if ($tokenArray[$i][0] == '(') {
                    $selectQuery .= " to_tsvector(text) % '" . substr($tokenArray[$i], 1, strlen($tokenArray[$i]) - 2) . "'";
                } else {
                    $selectQuery .= " to_tsvector(text) % '" . $tokenArray[$i] . "'";
                }
            }

            if ($i < (count($tokenArray) - 1)){
                $selectQuery .= chr(10);
                $selectQuery .= $separator;
            }
        }

        $selectQuery .= "" .chr(10). "ORDER BY rank DESC LIMIT 10";

        $result = DB::select($selectQuery);

        return response()->json(['select' => $selectQuery, 'result' => $result], 200);
    }
}
