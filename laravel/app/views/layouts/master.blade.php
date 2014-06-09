<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="A different weather portal.">
        <meta name="keywords" content="HTML,CSS,HTML5,JavaScript,Google,Weather,Weatherbound,clothes,fashion,funny,task,activity,forecast,yahoo,register,login,fun">
        <meta name="author" content="Jan Halozan, Luka Horvat, Zoran Kelenc, Martin Fras, Saso Markovic">
        <title>Weatherbound</title>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-27826743-3', 'weatherbound.net');
        ga('send', 'pageview');

        </script>

        {{ HTML::style('//fonts.googleapis.com/css?family=Roboto:400,100,300,500&subset=latin,latin-ext') }}
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
                            <li><a href="/">{{ Lang::get('guides.home') }}</a></li>
                            <li><a href="forecast">{{ Lang::get('guides.forecast') }}</a></li>
                            <li tabindex="1">
                                <a>{{ Lang::get('guides.language') }}</a>
                                <ul>
                                    <li><a href="lang-select/si">{{ Lang::get('guides.slovene') }}</a></li>
                                    <li><a href="lang-select/en">{{ Lang::get('guides.english') }}</a></li> 
                                </ul>
                            </li>
                            @if(Auth::check())
                                <li tabindex="2">
                                    <a>{{ Lang::get('guides.options') }}</a>
                                    <ul>
                                        <li><a href="me">{{ Lang::get('guides.profile') }}</a></li>
                                        <li><a href="city">{{ Lang::get('guides.city') }}</a></li>
                                        <li><a href="tasks">{{ Lang::get('guides.tasks') }}</a></li>
                                        @if (Auth::user()->is_admin)
                                        <li><a href="example-generator">{{ Lang::get('guides.example_generator') }}</a></li>
                                        <li><a href="tasks-generator">{{ Lang::get('guides.tasks_generator') }}</a></li>
                                        @endif
                                        <li><a href="logout">{{ Lang::get('guides.logout') }}</a></li>
                                    </ul>
                                </li>
                            @else
                                <li>
                                    <a href="login">{{ Lang::get('guides.access') }}</a>
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
                    {{ Lang::get('other.copyright') }}
                </p>
            </div>
            @show
        </footer>
    </body>
</html>