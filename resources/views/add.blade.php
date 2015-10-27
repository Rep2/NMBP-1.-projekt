@extends('base')

@section('content')

<div id="section">
    <textarea id="text" rows="15" cols="80"></textarea>
    <br>
    <input type="button" value="Dodaj" id="button" />​
    <p id="text1">Upišite td</p>
</div>

<script>
    document.getElementById("button").addEventListener('click', function () {
        $text = document.getElementById("text").value;

        if ($text != null && $text != ""){
            $.ajax({
                type: "POST",
                url : "http://46.101.238.99/add",
                data : {"text": $text},
                success : function(data){
                    document.getElementById("text1").innerHTML = data["message"];
                }
            },"json");
        }else{
            document.getElementById("text1").innerHTML = "Prvo upišite tekst koji želite pohraniti";
        }
    });
</script>

@stop
