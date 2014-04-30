<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        {{ HTML::style('//fonts.googleapis.com/css?family=Roboto:400,100,300,500') }}
        {{ HTML::style('css/master.css') }}
        {{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') }}
        {{ HTML::script('/js/master.js') }}
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
                        @if(Auth::check())
                        <li>{{ Auth::user()->username }}</li>
                        <a href="logout"><li>{{ Lang::get('guides.logout') }}</li></a>
                        @else
                        <a href="register"><li>{{ Lang::get('guides.register') }}</li></a>
                        <a href="login"><li>{{ Lang::get('guides.login') }}</li></a>
                        @endif
                    </ul>
                    @show
                </div>

                @if(isset($message))
                <div id="master-message">
                    <label>{{ $message }}</label>
                    <a href="#" id="master-close">x</a>
                </div>
                @endif
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