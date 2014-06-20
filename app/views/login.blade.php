<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crowdlinker Shortener - Login</title>
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@crowdlinker">
    <meta name="twitter:title" content="Crowdlinker - URL Shortener">
    <meta property="og:site_name" content="Crowdlinker"/>
    <meta property="og:title" content="Crowdlinker - URL Shortent" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://shortener.crowdlinker.com" />
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
            <div class="login-form-content" ng-controller="AuthController">
                <p class="text-center"><a href="/"><img src="/image/scrolllogo.svg" width="166"></a></p>
                <h3>Please Log In, or <a href="/register">Sign Up</a></h3>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <p class="text-center"><a href="/social/facebook" class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i> Facebook</a></p>
                    </div>
                </div>
                <div class="login-or">
                    <hr class="hr-or">
                    <span class="span-or">or</span>
                </div>
                <div ng-if="error" class="alert alert-danger" ng-cloak>Username or password is incorrect or does not exist</div>
                <form ng-submit="authorize()" role="form">
                    <div class="form-group">
                        <label for="inputUsernameEmail">Email</label>
                        <input type="email" ng-model="account.email" class="form-control" id="inputUsernameEmail">
                    </div>
                    <div class="form-group">
                        <a class="pull-right" href="/password/remind">Forgot password?</a>
                        <label for="inputPassword">Password</label>
                        <input type="password" ng-model="account.password" class="form-control" id="inputPassword">
                    </div>
                    <div class="checkbox pull-right">
                        <label>
                            <input ng-model="account.remember" ng-true-value="yes" ng-false-value="no" type="checkbox">
                            Remember me </label>
                    </div>
                    <button type="submit" class="btn btn btn-primary">
                        Log In
                    </button>
                </form>
                <br/>
                <br/>
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