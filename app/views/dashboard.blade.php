<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=1024">
    <title>Crowdlinker - URL Shortener</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap-social.css">
    <link rel="stylesheet" href="/css/style.min.css">
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body ng-app="shortenerApp" ng-controller="LinkDataController" ng-csp>
<div class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo-scroll" href="https://crowdlinker.com"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right" style="margin-top:5px">
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="col-md-12">
        <div class="row">
            <h1>Create a Short Link</h1>
            <form ng-submit="submitLink()" role="form">
                <div class="input-group">
                    <input class="form-control" id="shorten-input" placeholder="https://crowdlinker.com" name="url" ng-model="shortlink.url" type="url" required>
                    <span class="input-group-btn">
                        <button class="btn btn-lg btn-specs btn-primary" type="submit"><i class="fa fa-link"></i> Shrink it !</button>
                     </span>
                </div>
            </form>
            <br/>
            <br/>
            <br/>
        </div>
        <div class="row">
            <h2 class="pull-left">Created links</h2>
            <br/>
            <table class="table">
                <thead>
                <tr>
                    <th>Link</th>
                    <th>Date</th>
                    <th>Page</th>
                    <th>Clicks</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="value in shortlinks" ng-if="shortlinks.length > 0">
                    <td><a href="<% value.link %>" target="_blank"><% value.link %></a></td>
                    <td><% value.created_at %></td>
                    <td><h5><% value.pagetitle %><br/><small><% value.provider %></small></h5></td>
                    <td><% value.clicks %></td>
                    <td><a href="#">Details</a></td>
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
@include('layout.partials.javascript')
<!-- Please don't use massive JS files for minor functionality. This is okay for the demo, though. -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.17/angular.min.js"></script>
<script src="/vendors/angular-bootstrap/ui-bootstrap.min.js"></script>
<script src="/js/app.js"></script>
<script src="/js/services.js"></script>
<script src="/js/controllers.js"></script>
</body>
</html>