@extends('layout.master')
@section('content')
<div class="container" ng-controller="SettingsController">
    <div class="col-md-12">
        <div class="row">
            <h1 class="text-center">Settings</h1>
            <hr/>
        </div>
        <div class="row">
            <br/>
            <h3>
                Email
                <br/>
                <small>Your email can be used to sign in to Crowdlinker Shortener app on web.</small>
            </h3>
            <br/>
            <div class="row">
                <div class="col-md-4">
                    <div ng-if="success" class="alert alert-success" ng-cloak>Email successfully updated.</div>
                    <div ng-if="error" class="alert alert-danger" ng-cloak><% errormessage %></div>
                </div>
            </div>
            <form  ng-submit="updateEmail" class="form">
                <div class="form-group col-xs-4 col-md-4 col-sm-4 col-lg-4" style="padding-left:0">
                    <div class="input-group">
                        <input type="email" ng-model="settings.email" name="email" class="form-control">
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
            <button ng-if="createpassword" class="btn btn-default" data-toggle="modal" data-target="#createpassword">Create New Password</button>
            <button ng-if="changepassword" class="btn btn-default" data-toggle="modal" data-target="#changepassword">Change Password</button>
        </div>
        <div class="modal fade" id="createpassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Create Password</h4>
                    </div>
                    <div class="modal-body">
                        <div ng-if="newpassword_success" class="alert alert-success" ng-cloak> Password successfully created.</div>
                        <div ng-if="newpassword_error" class="alert alert-danger" ng-cloak>
                            <ul>
                                <li ng-repeat="errors in newpassword_errormessage">
                                    <% errors %>
                                </li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" ng-model="newpassword.password" class="form-control" placeholder="Minimum 6 characters" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" ng-model="newpassword.password_confirmation" class="form-control" placeholder="One more time..." name="password_confirmation">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" ng-click="createNewPassword()" class="btn btn-primary">Create</button>
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
                        <div class="alert alert-success"></div>
                        <div class="alert alert-danger"></div>
                        <div class="form-group">
                            <label for="currentpassword">Current Password</label>
                            <input type="password" ng-model="updatepassword.currentpassword" class="form-control" name="currentpassword">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" ng-model="updatepassword.password" class="form-control" placeholder="Minimum 6 characters" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" ng-model="updatepassword.password_confirmation" class="form-control" placeholder="One more time..." name="password_confirmation">
                        </div>
                        <a href="/password/remind" target="_blank">Forgot your password ?</a>
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