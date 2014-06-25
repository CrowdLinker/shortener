@extends('layout.master')
@section('content')
<div class="container" ng-controller="LinkDataController">
    <div class="col-md-12">
        <div class="col-md-8 col-md-offset-2 shortlink-container">
            <div class="row">
                <h1 class="text-center">Create a short link</h1>
                <br/>
                <form ng-submit="submitLink()" role="form">
                    <div class="input-group">
                        <input class="form-control" id="shorten-input" placeholder="Paste link here" name="url" ng-model="shortlink.url" type="url" required>
                    <span class="input-group-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-link"></i> Shrink it !</button>
                     </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12 created-links">
            <div class="row">
                <h2 class="text-left">Created links</h2>
                <br/>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Link</th>
                        <th>Date</th>
                        <th>Page</th>
                        <th>Clicks</th>
                        <th>Unique Clicks</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="value in shortlinks" ng-if="shortlinks.length > 0">
                        <td><a href="<% value.link %>" target="_blank"><% value.link %></a></td>
                        <td><% value.created_at %></td>
                        <td><h5><% value.pagetitle %><br/><small><% value.provider %></small></h5></td>
                        <td><% value.clicks %></td>
                        <td><% value.unique_clicks %></td>
                        <td><a href="/dashboard/<% value.id %>">View Stats</a></td>
                    </tr>
                    <tr ng-if="shortlinks.length === 0">
                        <td class="text-center" colspan=4"><h4>No short links created yet</h4></td>
                    </tr>
                    </tbody>
                </table>
                <div data-pagination="" data-num-pages="numPages()"  data-current-page="currentPage" data-boundary-links="true"></div>
            </div>
        </div>
    </div>
</div>
@stop