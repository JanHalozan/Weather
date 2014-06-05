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
                            <a href="forecast"><li><img src="images/ForecastIcon2.png"></li></a>
                            @if(Auth::check())
                                <li class="dropDown">
                                    <img src="images/SettingsIcon.png">
                                    <ul>
                                        <li><a href="me">{{ Auth::user()->username }}</a></li>
                                        <li><a href="logout">{{ Lang::get('guides.logout') }}</a></li>
                                    </ul>
                                </li>
                            @else
                                <li class="dropDown">
                                    <img src="images/LoginIcon.png">
                                    <ul>
                                        <li><a href="login">{{ Lang::get('guides.login') }}</a></li>
                                        <li><a href="register">{{ Lang::get('guides.register') }}</a></li>
                                    </ul>
                                </li>
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