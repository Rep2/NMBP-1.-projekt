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
</head>

<body>

<script> var db = openDatabase('mydb', '1.0', 'my first database', 2 * 1024 * 1024); </script>

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
    <textarea name="input" rows="10" cols="30"></textarea>
    <br>
    <button type="button" onclick="alert('Hello World!')">Dodaj</button>
    <p id="text1">Upisite tekst koji zelite dodati</p>
</div>

</body>
</html>
