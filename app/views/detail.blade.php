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
                            <tr ng-if="topcities.length == 0">
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
                                <td><% value.country %></td>
                                <td><% value.count %></td>
                            </tr>
                            <tr ng-if="topcountries.length == 0">
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
        $('#world-map').vectorMap({
            map: 'world_mill_en',
            scaleColors: ['#C8EEFF', '#0071A4'],
            normalizeFunction: 'polynomial',
            hoverOpacity: 0.7,
            hoverColor: false,
            markerStyle: {
                initial: {
                    fill: '#F8E23B',
                    stroke: '#383f47'
                }
            },
            backgroundColor: '#383f47',
            markers: [
                {latLng: [41.90, 12.45], name: 'Vatican City'},
                {latLng: [43.73, 7.41], name: 'Monaco'},
                {latLng: [-0.52, 166.93], name: 'Nauru'},
                {latLng: [-8.51, 179.21], name: 'Tuvalu'},
                {latLng: [43.93, 12.46], name: 'San Marino'},
                {latLng: [47.14, 9.52], name: 'Liechtenstein'},
                {latLng: [7.11, 171.06], name: 'Marshall Islands'},
                {latLng: [17.3, -62.73], name: 'Saint Kitts and Nevis'},
                {latLng: [3.2, 73.22], name: 'Maldives'},
                {latLng: [35.88, 14.5], name: 'Malta'},
                {latLng: [12.05, -61.75], name: 'Grenada'},
                {latLng: [13.16, -61.23], name: 'Saint Vincent and the Grenadines'},
                {latLng: [13.16, -59.55], name: 'Barbados'},
                {latLng: [17.11, -61.85], name: 'Antigua and Barbuda'},
                {latLng: [-4.61, 55.45], name: 'Seychelles'},
                {latLng: [7.35, 134.46], name: 'Palau'},
                {latLng: [42.5, 1.51], name: 'Andorra'},
                {latLng: [14.01, -60.98], name: 'Saint Lucia'},
                {latLng: [6.91, 158.18], name: 'Federated States of Micronesia'},
                {latLng: [1.3, 103.8], name: 'Singapore'},
                {latLng: [1.46, 173.03], name: 'Kiribati'},
                {latLng: [-21.13, -175.2], name: 'Tonga'},
                {latLng: [15.3, -61.38], name: 'Dominica'},
                {latLng: [-20.2, 57.5], name: 'Mauritius'},
                {latLng: [26.02, 50.55], name: 'Bahrain'},
                {latLng: [0.33, 6.73], name: 'São Tomé and Príncipe'}
            ]
        });
    });
</script>
@stop