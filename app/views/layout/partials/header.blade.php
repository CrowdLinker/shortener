<div class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo-static" href="/"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @if(Request::segment(1) == 'dashboard' && Request::segment(2) == '')
                <li class="active"><a href="/dashboard">Dashboard</a></li>
                @else
                <li><a href="/dashboard">Dashboard</a></li>
                @endif
                @if(Request::segment(2) == 'settings')
                <li class="active"><a href="/dashboard/settings">Settings</a></li>
                @else
                <li><a href="/dashboard/settings">Settings</a></li>
                @endif
                <li><a href="/logout">Logout</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>