@extends('layout.frontmaster')
@section('content')
    <div class="row">
        <div class="main">
            <div class="login-form-content" ng-controller="AuthController">
                <p class="text-center"><a href="/"><img src="/image/scrolllogo.svg" width="166"></a></p>
                <h3 class="login">Please Log In, or <a href="/register">Sign Up</a></h3>
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
@stop