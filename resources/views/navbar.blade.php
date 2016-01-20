@inject('request', 'App\Request')

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="\">LCCB</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @if(Auth::check())
                    @if(Auth::user()->hasRole(['administrator', 'approver']))
                        <li class="@if(Request::is('/')) active @endif"><a href="\">Dashboard</a></li>
                    @endif
                @endif
                <li class="@if(Request::is('lccb/create')) active @endif"><a href="\lccb\create">LCCB Request</a></li>
                @if(Auth::check())
                    @if(Auth::user()->hasRole(['administrator', 'approver']))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Request Administration
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/lccb/status/new">
                                        <div style="float:left">New Requests</div>
                                        <div style="float:right" class="badge">{{ $request->requestStatus('1')->count() }}</div>
                                        <div style="clear:both"></div>
                                    </a>
                                </li>
                                <li><a href="/lccb/status/open-needs-further-review">
                                        <div style="float:left">Open/Review</div>
                                        <div style="float:right" class="badge">{{ $request->requestStatus('2')->count() }}</div>
                                        <div style="clear:both"></div>
                                    </a>
                                </li>
                                <li><a href="/lccb/status/waiting-for-approval">
                                        <div style="float:left">Waiting Approval</div>
                                        <div style="float:right" class="badge">{{ $request->requestStatus('3')->count() }}</div>
                                        <div style="clear:both"></div>
                                    </a>
                                </li>

                                <li><a href="/search">Search</a></li>
                                <li class="divider"></li>
                                <li class="dropdown-header">Nav header</li>
                                <li><a href="#">Separated link</a></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                    @endif
                @endif
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Reporting
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/reports/minutes">LCCB Meeting Minutes</a></li>
                        </ul>
                    </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> {!! Auth::user()->name !!}
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="/my/requests">My Requests</a></li>
                            <li><a href="#">My Profile</a></li>
                            <li><a href="/auth/logout">Logout</a></li>
                            @if(Entrust::hasRole('administrator'))
                                <li class="divider"></li>
                                <li class="dropdown-header">Administrator</li>
                                <li><a href="/admin/users">Users</a></li>
                                <li><a href="/admin/vendors">Vendors</a></li>
                            @endif
                        </ul>
                    </li>
                @else
                    <li><a href="/auth/login">Log In</a></li>
                    <li><a href="/auth/register">Register</a></li>
                @endif
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>