@extends('layout.frontmaster')
@section('content')
<div class="row">
    <div class="main">
        <div class="login-form-content" ng-controller="TwitterController">
            <p class="text-center"><a href="/"><img src="/image/scrolllogo.svg" width="166"></a></p>
            <br/>
            <h3 class="text-center">Welcome !<br/><small>Add your email address below to get started. If you have existing account, please enter primary email of account/facebook email.</small></h3><br/>
            <div ng-if="error" class="alert alert-danger" ng-cloak>Username or password is incorrect or does not exist</div>
            <form ng-submit="setEmail()" role="form">
                <div class="form-group">
                    <label for="inputUsernameEmail">Email</label>
                    <input type="email" ng-model="account.email" class="form-control" id="inputUsernameEmail">
                </div>
                <button type="submit" class="btn btn btn-primary">
                    Continue
                    <i class="fa fa-chevron-right"></i>
                </button>
            </form>
            <br/>
            <br/>
        </div>
    </div>
</div>
</div>
@stop