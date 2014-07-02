@extends('layout.frontmaster')
@section('content')
<div class="panel-background" ng-controller="HomeController">
    <div class="container">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-8 col-md-4 col-md-offset-4 col-xs-offset-2">
                    <p class="text-center"><a href="https://crowdlinker.com"><img  class="img-responsive center-block" src="/image/scrolllogo.svg" alt="Crowdlinker Inc."></a></p>
                </div>
            </div>
            <div class="col-lg-10 col-md-10 col-xs-10 col-sm-10 col-md-offset-1 col-xs-offset-1 col-sm-offset-1">
                <br/>
                <h1 class="mainpage">Shorten a URL</h1>
                <div class="row">
                    <form ng-submit="generateLink()">
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control" id="shorten-input" placeholder="Paste a link" name="url" ng-model="generate.url" type="url" required>
                                <span class="input-group-btn">
                                    <button class="btn btn-lg btn-specs btn-primary" type="submit"><i class="fa fa-link"></i> Shrink it !</button>
                                 </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div ng-if="created" class="row" ng-cloak>
                    <div style="width:500px;margin:50px auto;padding:30px;border:2px dotted #000000;font-size:20px;font-family: 'Lato', sans-serif;">
                        <p class="text-center">Done !</p>
                        <h3><% pagetitle %><br/><small><% domainprovider %></small></h3><br/>
                        <h4 class="text-center">Copy the Link</h4>
                        <input id="linktext" type="text" class="form-control output" value="<% url %>">
                        <br/>
                       <p><a class="stats" href="/<% hash %>"><i class="fa fa-bar-chart-o" style="margin-right:10px"></i> <% clicks %></a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop