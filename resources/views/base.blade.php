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
            height:500px;
            width:180px;
            float:left;
            padding:5px;
        }
        #section {
            width:80%;
            float:left;
            padding:10px;
        }
        #footer {
            clear:both;
            text-align:center;
            padding:5px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>

<div id="main" class="row">

    <div id="header">
        <h1>Full & fuzzy text search</h1>
    </div>

    <div id="nav">
        <ul>
            <li><a href="http://46.101.238.99/search">Pretraživanje</a></li>
            <li><a href="http://46.101.238.99/add">Dodaj novi tekst</a></li>
            <li><a href="http://46.101.238.99/pivoting">Analiza upita</a></li>
        </ul>
    </div>

    @yield('content')

</div>

<footer class="row" id="footer">
    <div id="copyright text-right">Ivan Rep, 0036475497 </div>
</footer>

</body>
</html>

