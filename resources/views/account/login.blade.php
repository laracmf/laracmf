@extends(config('app.layout'))

@section('title')
    Login
@stop

@section('top')
    <div class="page-header">
        <h1>Login</h1>
    </div>
@stop

@section('content')
    <div class="login-box-body">
        <div class="col-sm-12 col-xs-12 centered"><h2>Sign in to {{ config('app.name') }}</h2></div>
        <div class="col-lg-offset-4 col-lg-4 well">
            <form class="form-horizontal" action="{{ route('account.login.post') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group{!! ($errors->has('email')) ? ' has-error' : '' !!}">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                        <input name="email" id="email" value="{!! Request::old('email') !!}" type="text" class="form-control" placeholder="Email">
                        {!! ($errors->has('email') ? $errors->first('email') : '') !!}
                    </div>
                </div>

                <div class="form-group{!! ($errors->has('password')) ? ' has-error' : '' !!}">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                        <input name="password" id="password" value="" type="password" class="form-control" placeholder="Password">
                        {!! ($errors->has('password') ? $errors->first('password') : '') !!}
                    </div>
                    <label class="col-md-1 col-sm-1 col-xs-1 control-label password-label" for="password">
                        <i class="fa fa-eye-slash eye" aria-hidden="true"></i>
                    </label>
                </div>

                <div class="form-group">
                    <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                        <button class="btn btn-primary col-md-7" type="submit"><i class="fa fa-rocket"></i> Log In</button>
                        <label class="col-md-offset-1"><input type="checkbox" name="rememberMe" value="1"> Remember Me</label>
                    </div>
                    <div class="col-md-offset-1 col-sm-offset-1 col-sm-10 col-xs-12">
                        <p>
                            @if (config('credentials.activation'))
                                <label>
                                    <a href="{!! route('account.reset') !!}" class="btn btn-link">
                                        Forgot Password?
                                    </a>
                                    /
                                    <a href="{!! route('account.resend') !!}" class="btn btn-link">
                                        Not Activated?
                                    </a>
                                </label>
                            @else
                                <label>
                                    <a href="{!! route('account.reset') !!}" class="btn btn-link">
                                        Forgot Password?
                                    </a>
                                </label>
                            @endif
                        </p>
                    </div>
                    <div class="col-sm-12 col-xs-12 centered socials-capture">
                        Or sign in using following services
                    </div>
                    <div class="col-md-offset-2 col-sm-offset-3 col-sm-10 col-xs-12">
                        <a href="{{ route('auth.social', ['social' => 'github']) }}"><img id="githubLink" src="{{ asset('assets/images/github.png') }}"></a>
                        <a href="#"><img id="githubLink" src="{{ asset('assets/images/facebook.png') }}"></a>
                        <a href="#"><img id="githubLink" src="{{ asset('assets/images/instaicon.png') }}"></a>
                        <a href="#"><img id="githubLink" src="{{ asset('assets/images/twitter.png') }}"></a>
                        <a href="#"><img id="githubLink" src="{{ asset('assets/images/youtube.png') }}"></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop