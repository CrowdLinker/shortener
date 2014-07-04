<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">
    <title>Crowdlinker - {{ $title }}</title>
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@crowdlinker">
    <meta name="twitter:title" content="Crowdlinker - URL Shortener">
    <meta property="og:site_name" content="Crowdlinker"/>
    <meta property="og:title" content="Crowdlinker - URL Shortener" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://shortener.crowdlinker.com" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap-social.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ng-app="shortenerApp" ng-csp>
@if(Request::segment(1) != 'start')
<div class="row">
    <div class="container">
        <br/>
        <ul class="nav nav-pills pull-right">
            <li><a href="/">Home</a></li>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
        </ul>
    </div>
</div>
@else
<br/>
<br/>
<br/>
@endif
@yield('content')
@include('layout.partials.javascript')
<!-- Please don't use massive JS files for minor functionality. This is okay for the demo, though. -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.17/angular.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js"></script>
<script src="/js/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/js/jquery-jvectormap-world-mill-en.js"></script>
<script src="/js/ui-bootstrap-tpls-0.11.0.min.js"></script>
<script src="/js/angles.js"></script>
<script src="/js/app.js"></script>
<script src="/js/services.js"></script>
<script src="/js/controllers.js"></script>
@yield('javascript')
</body>
</html>
