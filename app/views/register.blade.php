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
    <link rel="stylesheet" href="/css/bootstrap-social.css">
    <link rel="stylesheet" href="css/style.min.css">
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
        <div class="main">
            <div class="login-form-content" ng-controller="RegisterController">
                <p class="text-center"><img src="/image/scrolllogo.svg" width="166"></p>
                <h3>Register</h3>
                <div ng-if="success" class="alert alert-success">Registered successfully !. Please sign in</div>
                <div ng-if="error" class="alert alert-danger">
                    <ul>
                        <li ng-repeat="error in errormessage">
                            <% error %>
                        </li>
                    </ul>
                </div>
                <form ng-submit="createAccount()" role="form">
                    <div class="form-group">
                        <label for="inputUsernameEmail">First Name</label>
                        <input type="text" ng-model="account.firstname" class="form-control" id="inputUsernameEmail">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Last Name</label>
                        <input type="text" ng-model="account.lastname" class="form-control" id="inputPassword">
                    </div>
                    <div class="form-group">
                        <label for="inputUsernameEmail">Email</label>
                        <input type="email" ng-model="account.email" class="form-control" id="inputUsernameEmail">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Password</label>
                        <input type="password" ng-model="account.password" class="form-control" id="inputPassword">
                    </div>
                    <div class="form-group">
                        <label for="inputPassword">Confirm Password</label>
                        <input type="password" ng-model="account.password_confirmation" class="form-control" id="inputPassword">
                    </div>
                    <button type="submit" class="btn btn btn-primary">
                        Create My Account
                    </button>
                    <a href="/login" class="btn btn btn-primary">
                        Sign In
                    </a>
                </form>
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
</html>