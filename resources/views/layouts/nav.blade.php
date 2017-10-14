<!-- Fixed navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#navbar" aria-expanded="false"
                    aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Sample Project</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse pull-right">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/">Home</a></li>
                @if (Auth::check() && Auth::user()->isAdmin())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                           role="button" aria-haspopup="true" aria-expanded="false">
                            Users<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/user">Users</a></li>
                            <li><a href="/profile">Profiles</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                           role="button" aria-haspopup="true" aria-expanded="false">
                            Calendar<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/calendar">calendar</a></li>
                            <li><a href="/calendar/create">create calendar</a></li>
                        </ul>
                    </li>
                    <li><a href="/show-admin-time-keeping">TimeKeepingsUser</a></li>

                @endif
                @if (Auth::check()&& !Auth::user()->isAdmin())
                    <li><a href="/calendar">calendar</a></li>
                    <li class="dropdown"><a href="#" class="dropdown-toggle"
                                            data-toggle="dropdown" role="button" aria-haspopup="true"
                                            aria-expanded="false">TimeKeeping <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/timekeeping/create">Create timekeeping</a></li>
                            <li><a href="/timekeeping">show timekeeping</a></li>
                        </ul>
                    </li>
                @endif
                @if (Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle"
                           data-toggle="dropdown" role="button"
                           aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }}
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            @if(Auth::user()->isAdmin())
                            <li><a href="/admin">Admin</a></li>
                            @endif
                            <li><a href="/determine-profile-route">Profile</a></li>
                                <li>
                                <a href="/logout"
                                   onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>


                        </ul>
                    </li>
                @else

                    <li><a href="/login">Login</a></li>
                    <li><a href="/register">Register</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>