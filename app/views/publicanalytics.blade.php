@extends('layout.frontmaster')
@section('content')
<div class="container" ng-controller="AnalyticsController">
    <div class="col-md-12 container-analytics">
        <br/>
        <br/>
        <br/>
        <div class="row">
            <h1 class="text-center"><% pagetitle %><br/><small><% domainprovider %></small></h1>
            <p class="text-center"><a href="<% originallink %>" target="_blank"><i class="fa fa-link"></i> Original link</a></p>
        </div>
        <br/>
        <div class="row">
            <br/>
            <br/>
            <br/>
            @if(Auth::check())
            <div class="col-md-6">
                <canvas ng-if="totalclicks > 0" barchart options="options" data="chart" width="430" height="300" style="width:100% !important"></canvas>
            </div>
            @endif
            @if(Auth::check())
            <div class="col-md-6">
            @else
            <div class="col-md-12">
            @endif
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
                @if(Auth::check())
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
                @else
                <h3><a href="/login">Sign In</a></h3>
                @endif
            </div>
            <div class="col-sm-12">
                <br/>
                <h3>Geo Demographics</h3>
                <hr/>
                <br/>
                @if(Auth::check())
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
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                    </div>
                </div>
                @else
                <h3><a href="/login">Sign In</a></h3>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script>
    $(function(){
        $.getJSON(shortener.url + '/api/links/map/' + shortener.id, function(data){
            var data = data;
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
                markers: data ,
                onMarkerLabelShow: function(event, label, index) {
                    label.html(data[index].name + ' - ' + data[index].count + ' click');
                }
            });
        });
    });
</script>
@stop