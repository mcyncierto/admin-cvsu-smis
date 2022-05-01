<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <strong><a href="#" class="nav-link">{{ config('app.name', 'Laravel') }}</a></strong>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset('storage/profile-pictures/' . Auth::user()->profile_picture) }}"
                            class="user-image img-circle elevation-2" alt="User Image"
                            onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}';">
                        <span
                            class="d-none d-md-inline">{{ implode(' ', [Auth::user()->first_name, Auth::user()->middle_name, Auth::user()->last_name]) }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <li class="user-header bg-success">
                            <img src="{{ asset('storage/profile-pictures/' . Auth::user()->profile_picture) }}"
                                class="user-image img-circle elevation-2" alt="User Image"
                                onerror="this.onerror=null;this.src='{{ asset('images/user.png') }}';">
                            <p>
                                {{ Auth::user()->name }}
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <button type="button" class="btn btn-default btn-flat" data-toggle="modal"
                                data-target="#user-modal">Account</button>
                            <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        @include('user.account')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-dark-olive">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('images/cvsu-logo.png') }}" alt="CvSU Logo"
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">&nbsp;</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link @if (\Request::is('scholarships*')) active @endif">
                                <i class="fas fa-graduation-cap"></i>
                                <p>Scholarship</p>
                                <i class="right fas fa-angle-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('scholarships.create') }}"
                                        class="nav-link
                                        @if (\Request::is('scholarships/create')) active @endif">
                                        <span class="ml-3">
                                            <i class="fas fa-clipboard-list"></i>
                                            <p>Application Form</p>
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('scholarships.index') }}"
                                        class="nav-link
                                    @if (\Request::is('scholarships') || \Request::is('scholarships/index')) active @endif">
                                        <span class="ml-3">
                                            <i class="fas fa-list"></i>
                                            <p>List</p>
                                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (Auth::user()->type == 'Admin')
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}"
                                    class="nav-link 
                                @if (\Request::is('users*')) active @endif">
                                    <i class=" fas fa-users"></i>
                                    <p>Manage Accounts</p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('announcements.index') }}"
                                class="nav-link
                            @if (\Request::is('announcements*')) active @endif">
                                <i class="fas fa-bullhorn"></i>
                                <p>Announcements</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="
                                        @if (Auth::user()->type == 'Admin') {{ route('inquiries.index') }}
                                        @else
                                            {{ route('inquiries.create') }} @endif
                                    "
                                class="nav-link
                                    @if (\Request::is('inquiries*')) active @endif">
                                <i class="fas fa-question-circle"></i>
                                <p>Inquiries</p>
                                @if ($message_count != 0)
                                    <span style="font-size: 12px" class="badge badge-danger right">{{$message_count}}</span>
                                @endif
                            </a>
                        </li>
                        @if (Auth::user()->type == 'Admin')
                            <li class="nav-item">
                                <a href="{{ route('gpa-checker.create') }}"
                                    class="nav-link
                                        @if (\Request::is('gpa-checker*')) active @endif">
                                    <i class="fas fa-sort-numeric-up-alt"></i>
                                    <p>GPA Checker</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <section class="content-header"></section>
                <section class="content">
                    @yield('content')
                </section>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2021 CvSU Scholarship Management Information System</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Toastr Notifications -->
    <script>
        @if (Session::has('message'))
            @if (Session::has('message'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.success("{{ session('message') }}");
            @endif
        
            @if (Session::has('error'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.error("{{ session('error') }}");
            @endif
        
            @if (Session::has('info'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.info("{{ session('info') }}");
            @endif
        
            @if (Session::has('warning'))
                toastr.options =
                {
                "closeButton" : true,
                "progressBar" : true
                }
                toastr.warning("{{ session('warning') }}");
            @endif
        @endif

        var objDiv = document.getElementById("div-messages");
        objDiv.scrollTop = objDiv.scrollHeight;
    </script>
</body>

</html>
