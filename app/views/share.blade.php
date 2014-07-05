@extends('layout.master')
@section('content')
<div class="container">
    <div class="col-md-12 sharebar" ng-controller="ShareController">
        <h2>Share</h2>
        <hr/>
        <div ng-if="success" class="alert alert-success" ng-cloak><% successmessage %></div>
        <div ng-if="error" class="alert alert-danger" ng-cloak><% errormessage %></div>
        <section class="composer clearfix">
            <div class="col-md-12">
                <div class="row">
                    <div ng-repeat="value in socialaccounts" ng-class="(selected) ? 'selected' : ''"  ng-init="selected=false;tooltip='select'" ng-click="selected = !selected;selectAccount($index,value,selected)" class="profile share avatar <% value.provider %> clearfix">
                        <img width="48" ng-src="<% value.profileimage %>">
                        <span></span>
                    </div>
                </div>
                <div class="row">
                    <textarea class="form-control" rows="3" ng-model="sharedata.message" ng-trim="false" maxlength="140" placeholder="Write your post here"></textarea>
                </div>
                <div class="row">
                    <br/>
                    <div class="pull-left">
                       <span class="characterlimit"><% 140 - sharedata.message.length %> left</span>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-success" ng-click="postNow()">Post Now</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@stop