<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Roboto+Condensed:100,300,400,500,700,900">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SPA - Privatif</title>
    <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" />

    <script src="{{ asset('js/home.js') }}" defer></script>

</head>
<body>
<v-app id="app">
    <home></home>
</v-app>
</body>
</html>
