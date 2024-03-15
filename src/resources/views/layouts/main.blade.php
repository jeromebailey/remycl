<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @yield('meta-data')

        @yield('head-links')
    </head>
    <body>
        @include('layouts.common.sidebar')
        <div class="wrapper d-flex flex-column min-vh-100 bg-light">
            @include('layouts.common.top-header')
            <div class="body flex-grow-1 px-3">
                <div class="container-lg">
                    @yield('content')
                </div>
            </div> 
            @include('layouts.common.footer')
        </div>
        @yield('scripts')
        
    </body>
</html>
