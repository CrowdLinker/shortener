<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">
    <title>Crowdlinker - URL Shortener</title>
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
<body>
<div class="row">
    <div class="container">
        <br/>
        <ul class="nav nav-pills pull-right">
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
        </ul>
    </div>
</div>
<div class="panel-background">
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-8 col-md-4 col-md-offset-4 col-xs-offset-2">
                    <p class="text-center"><a href="https://crowdlinker.com"><img  class="img-responsive center-block" src="/image/scrolllogo.svg" alt="Crowdlinker Inc."></a></p>
                </div>
            </div>
            <div class="col-lg-10 col-md-10 col-xs-10 col-sm-10 col-md-offset-1 col-xs-offset-1 col-sm-offset-1">
                <br/>
                <h1 class="mainpage">Shorten a URL</h1>
                <div class="row">
                    <form method="POST" action="{{ URL::to('/links') }}" accept-charset="UTF-8">
                        <div class="form-group">
                            <input name="_token" type="hidden" value="{{ csrf_token() }}">
                            <div class="input-group">
                                <input class="form-control" id="shorten-input" placeholder="https://crowdlinker.com" name="url" type="url" required>
                    <span class="input-group-btn">
                        <button class="btn btn-lg btn-specs btn-primary" type="submit"><i class="fa fa-link"></i> Shrink it !</button>
                     </span>
                            </div>
                            {{ $errors->first('url', '<div class="error">:message</div>') }}
                        </div>
                    </form>
                </div>
                <div class="row">
                    @if (Session::has('hashed'))
                    <div style="width:500px;margin:50px auto;padding:30px;border:2px dotted #000000;font-size:20px;font-family: 'Lato', sans-serif;">
                        <label>Copy the link:</label>
                        <input type="text" class="form-control output" value="http://crdln.kr/{{ Session::get('hashed') }}">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Please don't use massive JS files for minor functionality. This is okay for the demo, though. -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
</body>
</html>