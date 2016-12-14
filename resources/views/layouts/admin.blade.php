<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>{{ Config::get('app.name') }} - @section('title')
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
    @section('js')
    @show
</head>
<body class="admin">
<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('base') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top top-bar">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle right-side-items" data-toggle="dropdown">
                        {{ Credentials::getUser()->email }} <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu logout-item">
                        <li>
                            <a href="{!! route('account.logout') !!}">
                                <i class="fa fa-power-off fa-fw"></i> Logout
                            </a>
                        </li>
                    </ul>
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
                <img src="{{ asset('assets/images/avatar.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Credentials::getUser()->first_name }} {{ Credentials::getUser()->last_name }}</p>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
                <a href="{{ route('admin.show') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('logviewer.index') }}">
                    <i class="fa fa-wrench fa-fw"></i>
                    <span>View Logs</span>
                </a>
            </li>
            <li>
                <a href="{{ route('show.create.category.page') }}">
                    <i class="fa fa-pencil fa-fw"></i>
                    <span>Create Categories</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('show.categories') }}">
                    <i class="fa fa-folder-open fa-fw"></i>
                    <span>View Categories</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('show.all.media') }}">
                    <i class="fa fa-camera fa-fw"></i>
                    <span>Media</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('users.create') }}">
                    <i class="fa fa-star fa-fw"></i>
                    <span>Create User</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('users.index') }}">
                    <i class="fa fa-user fa-fw"></i>
                    <span>View Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('show.environment') }}">
                    <i class="fa fa-pencil fa-fw"></i>
                    <span>View Environment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pages.index') }}">
                    <i class="fa fa-pencil fa-fw"></i>
                    <span>View pages list</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pages.create') }}">
                    <i class="fa fa-pencil fa-fw"></i>
                    <span>Create Page</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ route('comments.show') }}">
                    <i class="fa fa-comment fa-fw"></i>
                    <span>Comments moderation</span>
                </a>
            </li>
        </ul>
    </section>
</aside>
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
