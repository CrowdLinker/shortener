<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crowdlinker Shortener - Login</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/css/bootstrap-social.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ng-app="shortenerApp" ng-csp>
<div class="container">
    <div class="row">
        <div class="container">
            <br/>
            <ul class="nav nav-pills pull-right">
                <li><a href="/login">Login</a></li>
                <li><a href="/register">Register</a></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="main">
            <div class="login-form-content" ng-controller="ResetController">
                <p class="text-center"><a href="/"><img src="/image/scrolllogo.svg" width="166"></a></p>
                <h3 class="login">Forgot your password ?</h3>
                @if(Session::has('error'))
                <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @elseif(Session::has('status'))
                <div class="alert alert-success">{{ Session::get('status') }}</div>
                @endif
                {{Form::open() }}
                    <div class="form-group">
                        <label for="inputUsernameEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="inputUsernameEmail">
                    </div>
                    <button type="submit" class="btn btn-primary">
                       Submit
                    </button>
                {{Form::close() }}
            </div>
        </div>
    </div>
</div>
@include('layout.partials.javascript')
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.18/angular.min.js"></script>
<script src="/js/app.js"></script>
<script src="/js/services.js"></script>
<Script src="/js/controllers.js"></Script>
</body>
</body>
</html>