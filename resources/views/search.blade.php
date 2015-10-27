@extends('base')

@section('content')

<div id="section">

    <div>
        <input type="text" value="" id="search" style="width:436px"/>​
        <input type="button" value="Pretraži" id="button"/>​
    </div>

    <br>

    <form action="">
        <input type="radio" id="and" name="andor" value="and" checked="checked"> AND
        <input type="radio" id="or" name="andor" value="or"> OR
    </form>

    <br>

    <form action="">
        <input type="radio" id="exact" name="type" value="exact" checked="checked"> Exact string matching
        <input type="radio" id="dict" name="type" value="dict"> Use dictionaries
        <input type="radio" id="fuzzy" name="type" value="fuzzy"> Fuzzy string matching
    </form>

    <br>
    <textarea id="text" rows="15" cols="80"></textarea>
    <br>

    <p id="text1">Upišite željeni uzorak riječi, izaberite opcije i pritisnite "Pretraži"</p>

</div>

<script>
    document.getElementById("button").addEventListener('click', function () {
        $text = document.getElementById("search").value;

        $andOr = 1;
        if (document.getElementById("and").checked){
            $andOr = 0;
        }

        $type = 0;
        if (document.getElementById("dict").checked){
            $type = 1;
        }else if (document.getElementById("fuzzy").checked) {
            $type = 2
        }

        if ($text != null && $text != ""){
            $.ajax({
                type: "POST",
                url : "http://46.101.238.99/search",
                data : {"text": $text, "andor":$andOr, "type":$type},
                success : function(data){
                    document.getElementById("text").innerHTML = data["select"];

                    $newText = "";

                    $.each(data["result"], function(index, val) {
                        $newText += val["title"] + "[" + val["rank"] + "] <br>";
                    });

                    document.getElementById("text1").innerHTML = $newText;
                }
            },"json");
        }else{
            document.getElementById("text1").innerHTML = "Prvo upišite željeni uzorak riječi";
        }
    });
</script>

@stop

