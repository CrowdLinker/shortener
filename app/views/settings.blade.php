@extends('layout.master')
@section('content')
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <h1 class="text-center">Settings</h1>
            <hr/>
        </div>
        <div class="row">
            <br/>
            <h3>Connected Account</h3>
        </div>
        <div class="row">
            <br/>
            <h3>
                Email
                <br/>
                <small>Your email can be used to sign in to Crowdlinker Shortener app on web.</small>
            </h3>
            <br/>
            <form class="form">
                <div class="form-group col-xs-4 col-md-4 col-sm-4 col-lg-4" style="padding-left:0">
                    <div class="input-group">
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Save</button>
                 </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="row">
            <br/>
            <h3>
                Access & Password
                <br/>
                <small>Use your password to sign in to Crowdlinker Shortener app on web.</small>
             </h3>
            <br/>
            <button class="btn btn-default">Create New Password</button>
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
    </div>
</div>
@stop