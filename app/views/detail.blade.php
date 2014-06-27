@extends('layout.master')
@section('content')
<div class="container" ng-controller="AnalyticsController">
    <div class="col-md-12 container-analytics">
        <div class="row">
            <h1 class="text-center"><% pagetitle %><br/><small><% domainprovider %></small></h1>
            <p class="text-center"><a href="<% originallink %>" target="_blank"><i class="fa fa-link"></i> Original link</a></p>
        </div>
        <br/>
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
                <table class="table table-condensed table-responsive">
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
                        <td colspan="3">No clicks yet</td>
                    </tr>
                    </tbody>
                </table>
                <br/>
                <h3>Traffic Source</h3>
                <hr/>
                <table class="table table-condensed table-responsive">
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
                        <td ng-if="totalclicks == 0" colspan="3">No traffic yet</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12">
                <br/>
                <h3>Geo Demographics</h3>
                <hr/>
                <br/>
                <div id="world-map" style="height:400px"></div>
                <br/>
                <div class="row">
                    <div class="col-md-6">
                        <h3>Top 5 Cities</h3>
                        <table class="table table-condensed table-responsive">
                            <thead>
                            <th>#</th>
                            <th>City</th>
                            <th>Clicks</th>
                            </thead>
                            <tbody>
                            <tr ng-repeat="value in topcities" ng-if="topcities.length > 0">
                                <td><% value.rank %></td>
                                <td><% value.city %></td>
                                <td><% value.count %></td>
                            </tr>
                            <tr>
                                <td colspan="3">No Data</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h3>Top 5 Countries</h3>
                        <table class="table table-condensed table-responsive">
                            <thead>
                            <th>#</th>
                            <th>Country</th>
                            <th>Clicks</th>
                            </thead>
                            <tbody>
                            <tr ng-repeat="value in topcountries" ng-if="topcountries.length > 0">
                                <td><% value.rank %></td>
                                <td><% value.city %></td>
                                <td><% value.count %></td>
                            </tr>
                            <tr>
                                <td colspan="3">No Data</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script>
    $(function(){
        $('#world-map').vectorMap();
    });
</script>
@stop