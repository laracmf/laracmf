<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}  @section('title')
        @show</title>
    @include('partials.header')
    @section('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/admin.css') }}">
    @show
    @section('scripts')
        <script src="{{ asset('assets/scripts/admin.js') }}"></script>
    @show
    @section('css')
    @show
</head>
<body class="hold-transition {{ session('theme') }} fixed sidebar-mini">
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('base') }}" class="logo">
        <span class="logo-lg"><b>{{ config('app.name') }}</b></span>
        <span class="logo-mini">{{ config('app.abbreviation') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top top-bar">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle right-side-items" data-toggle="dropdown">
                        {{ Credentials::getUser()->email }} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu logout-item">
                        <li>
                            <a href="{{ route('base') }}">
                                <i class="fa fa-user-circle"></i> Home
                            </a>
                        </li>
                        <li>
                            <a href="{!! route('account.logout') !!}">
                                <i class="fa fa-power-off"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="main-sidebar">
    <section class="sidebar left-side-menu">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('assets/images/avatar.jpg') }}" class="logotype img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Credentials::getUser()->first_name }} {{ Credentials::getUser()->last_name }}</p>
            </div>
        </div>
        <div class="user-panel">
            <div class="pull-left">

            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="{{ route('admin.show') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        <a href="{{ route('users.index') }}">
                            <i class="fa fa-user fa-fw"></i>
                            <span>View Users</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('users.create') }}">
                            <i class="fa fa-star fa-fw"></i>
                            <span>Create User</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-window-maximize"></i>
                    <span>Pages</span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        <a href="{{ route('pages.index') }}">
                            <i class="fa fa-window-restore"></i>
                            <span>View pages</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('pages.create') }}">
                            <i class="fa fa-pencil fa-fw"></i>
                            <span>Create Page</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-folder-open fa-fw"></i>
                    <span>Categories</span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        <a href="{{ route('show.categories') }}">
                            <i class="fa fa-folder-open fa-fw"></i>
                            <span>View Categories</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="{{ route('show.create.category.page') }}">
                            <i class="fa fa-pencil fa-fw"></i>
                            <span>Create Category</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="{{ route('show.all.media') }}">
                    <i class="fa fa-camera fa-fw"></i>
                    <span>Media</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('comments.show') }}">
                    <i class="fa fa-comment fa-fw"></i>
                    <span>Comments moderation</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('logviewer.index') }}">
                    <i class="fa fa-wrench fa-fw"></i>
                    <span>View Logs</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
        <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
        <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane" id="control-sidebar-home-tab">
            <h3 class="control-sidebar-heading">Recent Activity</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                            <p>Will be 23 on April 24th</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                            <p>New phone +1(800)555-1234</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                            <p>nora@example.com</p>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                            <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                            <p>Execution time 5 seconds</p>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

            <h3 class="control-sidebar-heading">Tasks Progress</h3>
            <ul class="control-sidebar-menu">
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Custom Template Design
                            <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Update Resume
                            <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Laravel Integration
                            <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                            Back End Framework
                            <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                            <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                    </a>
                </li>
            </ul>
            <!-- /.control-sidebar-menu -->

        </div>
        <!-- /.tab-pane -->
        <!-- Stats tab content -->
        <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
        <!-- /.tab-pane -->
        <!-- Settings tab content -->
        <div class="tab-pane" id="control-sidebar-settings-tab">
            <form method="post">
                <h3 class="control-sidebar-heading">General Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Some information about this general settings option
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Other sets of options are available
                    </p>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                    </label>

                    <p>
                        Allow the user to show his name in blog posts
                    </p>
                </div>
                <!-- /.form-group -->

                <h3 class="control-sidebar-heading">Chat Settings</h3>

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                    </label>
                </div>
                <!-- /.form-group -->

                <div class="form-group">
                    <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                    </label>
                </div>
                <!-- /.form-group -->
            </form>
        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<script src="{{ asset('assets/scripts/demo.js') }}"></script>
<div class="control-sidebar-bg"></div>
<div class="content-wrapper">
    @include('partials.notifications')
    @section('content')
    @show
</div>
@include('partials.footer')
@section('bottom')
@show
</body>
</html>
