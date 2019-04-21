<!-- Logo -->
<a href="" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">AP</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo"><img src="{{asset('/assets/images/logo.png')}}"/></span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top" role="navigation">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>
    <strong class="top_link">
        <span style="color: #fff;">Running Session : {{ config('running_session') }}</span> ||
        <a href="{{ URL :: to('') }}" target="_blank" style="color: #fff;">Visit Website</a>
    </strong>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user"> </i>{{ Auth::user()->name }} <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ URL :: to('/student/profile') }}"> View Profile </a>
                    </li>
                    <li>
                        <a href="{{ URL :: to('/student/edit_profile') }}"> Edit Profile </a>
                    </li>
                    <li>
                        <a href="{{ URL :: to('/student/change_password') }}"> Change Password </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('student.auth.logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('student.auth.logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
