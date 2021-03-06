<div class="navbar {!! ($inverse == true) ? 'navbar-inverse' : 'navbar-default' !!} navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{!! $main[0]['url'] !!}">{{ $title }}</a>
        </div>
        <div class="collapse navbar-collapse">
            <div id="main-nav">
                <ul class="nav navbar-nav">
                    @foreach($main as $item)
                        <li{!! ($item['active'] ? ' class="active"' : '') !!}>
                            <a href="{!! $item['url'] !!}">
                                {!! ((!$item['icon'] == '') ? '<i class="fa fa-'.$item['icon'].' fa-inverse fa-fw"></i> ' : '') !!}{{ $item['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div id="bar-nav">
                <ul class="nav navbar-nav navbar-right">
                    @if (isRole('admin'))
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                {!! $side !!} <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('account.profile') }}">
                                        <i class="fa fa-cog fa-fw"></i> View profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.show') }}">
                                        <i class="fa fa-user-circle"></i> Admin panel
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! route('account.logout') !!}">
                                        <i class="fa fa-power-off"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @else
                        @if ($bar)
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    {!! $side !!} <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($bar as $item)
                                        <li>
                                            <a href="{!! $item['url'] !!}">
                                                {!! ((!$item['icon'] == '') ? '<i class="fa fa-'.$item['icon'].' fa-fw"></i> ' : '') !!}{{ $item['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{!! route('account.logout') !!}">
                                            <i class="fa fa-power-off"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li {!! (Request::is('account/login') ? 'class="active"' : '') !!}>
                                <a href="{!! route('account.login') !!}">
                                    Login
                                </a>
                            </li>
                            @if (config('credentials.regallowed'))
                                <li {!! (Request::is('account/register') ? 'class="active"' : '') !!}>
                                    <a href="{!! route('account.register') !!}">
                                        Register
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
