@extends('layout.frontmaster')
@section('content')
    <div class="row">
        <div class="main">
            <div class="login-form-content" ng-controller="RegisterController">
                <p class="text-center"><a href="/"><img src="/image/scrolllogo.svg" width="166"></a></p>
                <h3 class="login">Register</h3>
                <div ng-if="success" class="alert alert-success" ng-cloak>Registered successfully !. Please sign in</div>
                <div ng-if="error" class="alert alert-danger" ng-cloak>
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
                </form>
            </div>
        </div>
    </div>
</div>
@stop