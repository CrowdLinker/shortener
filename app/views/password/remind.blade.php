@extends('layout.frontmaster')
@section('content')
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
@stop