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
            width:150px;
            float:left;
            padding:5px;
        }
        #section {
            width:350px;
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
        <li>Menu</li>
        <ul>
            <li>Search</li>
            <li>Add</li>
        </ul>
    </ul>
</div>

<div id="section">
    <textarea id="text" rows="30" cols="60"></textarea>
    <br>
    <input type="button" value="Dodaj" id="button" />​
    <p id="text1">Upisite tekst koji zelite dodati</p>
</div>

<script>
    document.getElementById("button").addEventListener('click', function () {
        $text = document.getElementById("text").value;

        $.ajax({
            type: "POST",
            url : "http://46.101.238.99/add",
            data : {"text": $text},
            success : function(data){
                window.alert(data);
                var text = document.getElementById("text1");
                text.innerHTML = 'sads dadas'
            }
        },"json");
    });
</script>

</body>
</html>

