@extends('base')

@section('content')

<div id="section">

    <div>
        Unesite vremenski period
        <br><br>
        <form>
            Datum od
            <input type="date" id="datumOd"/><br>
        </form>
        <form>
            Datum do
            <input type="date" id="datumDo"/>​<br>
        </form>
    </div>
    <br>

    Odaberite granulaciju
    <form action="">
        <br>
        <input type="radio" id="date" name="type" value="exact" checked="checked"> Dan
        <input type="radio" id="time" name="type" value="dict"> Sat
    </form>

    <br>
    <input type="button" id="button" value="Dohvati podatke"><br>

    <p id="text1">Unesite datum od i datum do, odaberite granulaciju i pokrenite analizu</p>

</div>

<script>
    document.getElementById("button").addEventListener('click', function () {
        $datumOd = document.getElementById("datumOd").value;
        $datumDo = document.getElementById("datumDo").value;

        $type = 0;
        if (document.getElementById("time").checked){
            $type = 1;
        }

        if ($datumOd == "" || $datumDo == ""){
            document.getElementById("text1").innerHTML = "Unesite datum od i datum do";
        }

        alert($datumOd);



        /*
        if ($text != null && $text != ""){
            $.ajax({
                type: "POST",
                url : "http://46.101.238.99/newSearch",
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
        }*/
    });
</script>

@stop

