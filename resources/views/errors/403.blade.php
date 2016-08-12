<!DOCTYPE html>
<html>
<head>
    <title>Be right back.</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
            background-color : #ddd;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
            width : 600px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <!-- <div class="title">You don't have permission to save in this location</div> -->
        <img class="title" src="{{ asset('images\404.jpg') }}"/>
    </div>
</div>
</body>
</html>
