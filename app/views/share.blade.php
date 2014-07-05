@extends('layout.master')
@section('content')
<div class="container">
    <div class="col-md-12 sharebar">
        <h2>Share</h2>
        <hr/>
        <section class="composer clearfix" ng-controlle="ShareController">
            <div class="col-md-12">
                <div class="row">
                    <div class="profile share avatar twitter selected clearfix">
                        <img width="48" src="http://pbs.twimg.com/profile_images/378800000592248225/e44c27219a7e433f898965df0970b975_normal.jpeg">
                        <span></span>
                    </div>
                    <div class="profile share avatar twitter">
                        <img width="48" src="http://pbs.twimg.com/profile_images/378800000592248225/e44c27219a7e433f898965df0970b975_normal.jpeg">
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
                        <button class="btn btn-success">Post Now</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@stop