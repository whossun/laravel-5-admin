<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
    <head>
        <meta charset="UTF-8">
        <title>
        @yield('title',($route['action']== 'index') ? trans('messages.'.$route['table']) : trans('messages.'.$route['action']).trans('messages.'.$route['table'])."-".config('custom.name'))
        </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{{ asset('favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link href="{{ elixir('css/theme.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body class="skin-blue">
        @yield('template')
        <script src="{{ elixir('js/theme.js') }}" type="text/javascript"></script>
        @yield('scripts')
        @include('layout.partials.flash')
    </body>
</html>