<!DOCTYPE html>
<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300,500' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/master.css" type="text/css">
    </head>
    <body>
        <div id="wrapper">
            <header>
                @section('header')
                <a href="/">
                    <h1 id="title">
                        Weatherbound
                    </h1>
                </a>
                <ul id="navigation">
                    <li>Log in</li>
                </ul>
                @show
            </header>
            <section id="content">
                @section('content')
                    <p>
                        Some content appears to be missing. Please return <a href="/">home</a>.
                    </p>
                @show
            </section>
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