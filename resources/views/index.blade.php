<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'BLIS') }}</title>
        <link rel='stylesheet prefetch' href='css/icon.css'>
        <link href="css/vuetify.min.css" rel="stylesheet">
    </head>
    <body>

        <div id="app">
            <index title="{{ config('app.name', 'BLIS') }}" user_name="Name of the User">
                <router-view></router-view>
            </index>
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

