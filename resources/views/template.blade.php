<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootswatch/4.4.1/sketchy/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            zoom: 150%;
        }

        .avatar1 {
            border-radius: 50%;
            border: #17a2b8 dotted;
        }

        .avatar0 {
            border-radius: 50%;
            border: #dc3545 dotted;
        }

        .centered {
            text-align: center;
        }

        .rightered {
            text-align: right;
        }

        .container.narrow {
            max-width: 800px;
        }

        [type="radio"]:checked:before {
            background-color: #9ea904;
        }
    </style>
    <script
        src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
    <title>Ping pong</title>
</head>
<body>
<div class="container narrow text-success">
    <h2>Ping pong manager&nbsp;&nbsp;&nbsp;&nbsp;<img src="https://i.imgur.com/Lr3OaYr.png" width="150" height="110" /></h2>
</div>
<div>
    @yield('section')
</div>
</body>
</html>
