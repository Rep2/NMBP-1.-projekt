<!DOCTYPE html>
<html>

<head>
    <title>Full & fuzzy text search</title>

    <style>
        #header {
            background-color:black;
            color:white;
            text-align:center;
            padding:5px;
        }
        #nav {
            line-height:30px;
            background-color:#eeeeee;
            height:300px;
            width:180px;
            float:left;
            padding:5px;
        }
        #section {
            width:650px;
            float:left;
            padding:10px;
        }
        #footer {
            background-color:black;
            color:white;
            clear:both;
            text-align:center;
            padding:5px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>

<div id="header">
    <h1>Full & fuzzy text search</h1>
</div>

<div id="nav">
    <ul>
        <li><a href="http://46.101.238.99/search">Pretraživanje</a></li>
        <li><a href="http://46.101.238.99/add">Dodaj novi tekst</a></li>
    </ul>
</div>

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
                    $newText = "";

                    $.each(data["message"], function(index, val) {
                        $newText += JSON.parse(val);
                    });

                    document.getElementById("text1").innerHTML = $newText;
                }
            },"json");
        }else{
            document.getElementById("text1").innerHTML = "Prvo upišite željeni uzorak riječi";
        }
    });
</script>

</body>
</html>

