<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{ asset('css/app.css?v='.filemtime(public_path('css/app.css'))) }}">
</head>
<body>
<div id="app">
    <app></app>
</div>
<script type="text/javascript" src="{{ asset('js/app.js?v='.filemtime(public_path('js/app.js'))) }}"></script>
@csrf
</body>
</html>
