<!DOCTYPE html>
<html>
    <head>
        {{ HTML::style('//fonts.googleapis.com/css?family=Roboto:400,100,300,500') }}
        {{ HTML::style('css/master.css') }}
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') }}
        @yield('head')
    </head>
    <body>
        <div id="wrapper">
            <header>
                <div id="header-content">
                    @section('header')
                    <a href="/">
                        <h1 id="title">
                            Weatherbound
                        </h1>
                    </a>
                    <ul id="navigation">
                        <a href="login"><li>Log in</li></a>
                    </ul>
                    @show
                </div>
            </header>
            <section id="content">
                @yield('content')
            </section>

            <!-- pushes the footer to the bottom of the page -->
            <div id="push-div"></div>
        </div>
        <footer>
            @section('footer')
            <div id="footer-content">
                <p>
                    Copyright &copy; Weatherbound.
                </p>
            </div>
            @show
        </footer>
    </body>
</html>


<?php