<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>troc-app</title>

        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
        @inertiaHead
        @routes

        <script>
            Ziggy.url = '{{ env('APP_URL') }}'
        </script>
    </head>

    <body>
        @inertia
    </body>
</html>
