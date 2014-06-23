@extends('layout.master')
@section('content')
<div class="container" ng-controller="AnalyticsController">
    <div class="col-md-12 container-analytics">
        <div class="row">
                <h1 class="text-center"><% pagetitle %><br/><small><% domainprovider %></small></h1>
                <p class="text-center"><a href="<% originallink %>" target="_blank"><i class="fa fa-link"></i> Original link</a></p>
        </div>
        <div class="row">
            <br/>
            <br/>
            <br/>
            <div class="col-md-6">
                <canvas ng-if="totalclicks > 0" barchart options="options" data="chart" width="430" height="300"></canvas>
            </div>
            <div class="col-md-6">
                <h3>Total Clicks</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Action</th>
                        <th>Clicks</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-if="totalclicks > 0">
                        <td>clicks</td>
                        <td><% totalclicks %></td>
                    </tr>
                    <tr ng-if="totalclicks == 0">
                        <td colspan="2">No clicks yet</td>
                    </tr>
                    </tbody>
                </table>
                <h3>Traffic Source</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Source</th>
                            <th>Clicks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="(key,value) in traffic" ng-if="totalclicks > 0">
                                <td><% key %></td>
                                <td><% value %></td>
                        </tr>
                        <tr>
                            <td ng-if="totalclicks == 0" colspan="2">No traffic yet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop