@extends('layout.master')
@section('content')
<div class="container" ng-controller="SettingsController">
    <div class="col-md-12">
        <div class="row">
            <h1 class="text-center"><i class="fa fa-cog"></i>  Settings</h1>
            <hr/>
        </div>
        <div class="row">
            <br/>
            <h3>
                Connected Social Media Accounts
                <br/>
                <small>List of connected accounts</small>

            </h3>
            <br/>
            <div class="row">
                <div ng-repeat="value in socialaccounts" class="profile avatar <% value.provider %>">
                        <img ng-src="<% value.profileimage %>" width="48">
                        <span></span>
                </div>
            </div>
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
            <form  ng-submit="updateEmail()" class="form">
                <div class="form-group col-md-4" style="padding-left:0">
                    <div class="input-group">
                        <input type="email" ng-model="settings.email" name="email" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Save</button>
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
            <button ng-if="createpassword" class="btn btn-default" data-toggle="modal" data-target="#createpassword" ng-cloak>Create New Password</button>
            <button ng-if="changepassword" class="btn btn-default" data-toggle="modal" data-target="#changepassword" ng-cloak>Change Password</button>
        </div>
        <div class="row">
            <br/>
            <h3>
                Deactivate Account
                <br/>
                <small>Note: On deactivating account all links would be deleted.</small>
                <br/>
                <br/>
                <button class="btn btn-danger" data-toggle="modal" data-target="#confirmation">Deactivate</button>
            </h3>
        </div>
        <div class="modal fade" id="confirmation" tabindex="-1" role="dialog" aria-labelledby="confirmation" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        <h3>Are you sure ?<br/><br/><small>Your account would be deleted <b>permanently</b></small>.</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" ng-click="deactivateAccount()" class="btn btn-success">Delete</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
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
                        <div ng-if="changepassword_success" class="alert alert-success" ng-cloak>Password changed successfully.</div>
                        <div ng-if="changepassword_error" class="alert alert-danger" ng-cloak>
                            <ul>
                                <li ng-repeat="errors in changepassword_errormessage">
                                    <% errors %>
                                </li>
                            </ul>
                        </div>
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
                        <button type="button" ng-click="changePassword()" class="btn btn-primary">Change</button>
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