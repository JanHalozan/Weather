<!DOCTYPE html>
<html>
    <head>
        {{ HTML::style('//fonts.googleapis.com/css?family=Roboto:400,100,300,500') }}
        {{ HTML::style('css/master.css') }}
    </head>
    <body>
        <div id="wrapper">
            <header>
                <div id="header-content">
                    @yield('header')
                </div>
            </header>
            <section id="content">
                @yield('content')
            </section>

            <!-- pushes the footer to the bottom of the page -->
            <div id="push-div"></div>
        </div>
        <footer>
            @yield('footer')
        </footer>
    </body>
</html>


<?php