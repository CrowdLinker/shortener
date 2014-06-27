@extends('layout.master')
@section('content')
<div class="container" ng-controller="AnalyticsController">
    <div class="col-md-12 container-analytics">
        <div class="row">
            <h1 class="text-center"><% pagetitle %><br/><small><% domainprovider %></small></h1>
            <p class="text-center"><a href="<% originallink %>" target="_blank"><i class="fa fa-link"></i> Original link</a></p>
        </div>
        <br/>
        <ul class="nav nav-tabs" role="tablist">
            <li class="active"><a href="#clicks" role="tab" data-toggle="tab">Clicks</a></li>
            <li><a href="#geo" role="tab" data-toggle="tab">Geo Demographics</a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <div class="tab-pane active" id="clicks">
                <div class="row">
                    <br/>
                    <br/>
                    <br/>
                    <div class="col-md-6">
                        <canvas ng-if="totalclicks > 0" barchart options="options" data="chart" width="430" height="300" style="width:100% !important"></canvas>
                    </div>
                    <div class="col-md-6">
                        <h3>Total Clicks</h3>
                        <hr/>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Clicks</th>
                                <th>Unique Clicks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-if="totalclicks > 0">
                                <td>clicks</td>
                                <td><% totalclicks %></td>
                                <td><% uniqueclicks %></td>
                            </tr>
                            <tr ng-if="totalclicks == 0">
                                <td colspan="2">No clicks yet</td>
                            </tr>
                            </tbody>
                        </table>
                        <br/>
                        <h3>Traffic Source</h3>
                        <hr/>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Source</th>
                                <th>Clicks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="value in traffic" ng-if="totalclicks > 0">
                                <td><% value.rank %></td>
                                <td><% value.source %></td>
                                <td><% value.count %></td>
                            </tr>
                            <tr>
                                <td ng-if="totalclicks == 0" colspan="2">No traffic yet</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="geo">
                <div class="col-md-12">
                    <br/>
                    <h3>Geo Demographics</h3>
                    <hr/>
                </div>
            </div>
        </div>
    </div>
</div>
@stop