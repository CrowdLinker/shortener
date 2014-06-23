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
            <button class="btn btn-default" data-toggle="modal" data-target="#createpassword">Create New Password</button>
            <button class="btn btn-default" data-toggle="modal" data-target="#changepassword">Change Password</button>
        </div>
        <div class="modal fade" id="createpassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Create Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" placeholder="Minimum 6 characters" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="One more time..." name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Change Password</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="currentpassword">Current Password</label>
                            <input type="password" class="form-control" name="currentpassword">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" placeholder="Minimum 6 characters" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="One more time..." name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary">Create</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
    </div>
</div>
@stop