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
    <input type="text" value="This is some text" id="text" style="width: 500px; height: 200px;"/>
    <br>
    <input type="button" value="Dodaj" id="button" />​
    <p id="text1">Upisite tekst koji zelite dodati</p>
</div>

<script>
    // var db = openDatabase('mydb', '1.0', 'my first database', 2 * 1024 * 1024);

    document.getElementById("button").addEventListener('click', function () {
        $text = document.getElementById("text").value;

        $.ajax({
            type: "POST",
            url : "http://localhost:8888/add",
            data : {"text": $text},
            success : function(data){
                window.alert(data);
                var text = document.getElementById("text1");
                text.innerHTML = 'sads dadas'
            }
        },"json");

      /*  var posting = $.post("http://localhost:8888/add", {"text": $text});

        posting.done(function( data ) {
            window.alert(data);
            var text = document.getElementById("text1");
            text.innerHTML = 'sads dadas'
        });*/

    });
</script>

</body>
</html>

