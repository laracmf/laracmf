@extends(config('app.layout'))

@section('title')
    Register
@stop

@section('top')
    <div class="page-header">
        <h1>Register</h1>
    </div>
@stop

@section('content')
    <div class="login-box-body">
        <div class="col-sm-12 col-xs-12 centered"><h2>Sign up to {{ config('app.name') }}</h2></div>
        <div class="col-lg-offset-4 col-lg-4 well">
            <form class="form-horizontal" action="{{ route('account.register.post') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group{!! ($errors->has('first_name')) ? ' has-error' : '' !!}">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input name="first_name" id="first_name" value="{!! Request::old('first_name') !!}" type="text" class="form-control" placeholder="First Name">
                        {!! ($errors->has('first_name') ? $errors->first('first_name') : '') !!}
                    </div>
                </div>

                <div class="form-group{!! ($errors->has('last_name')) ? ' has-error' : '' !!}">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input name="last_name" id="last_name" value="{!! Request::old('last_name') !!}" type="text" class="form-control" placeholder="Last Name">
                        {!! ($errors->has('last_name') ? $errors->first('last_name') : '') !!}
                    </div>
                </div>

                <div class="form-group{!! ($errors->has('email')) ? ' has-error' : '' !!}">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input name="email" id="email" value="{!! Request::old('email') !!}" type="text" class="form-control" placeholder="Email">
                        {!! ($errors->has('email') ? $errors->first('email') : '') !!}
                    </div>
                </div>

                <div class="form-group{!! $errors->has('password') ? ' has-error' : '' !!}">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input name="password" id="password" value="" type="password" class="form-control" placeholder="Password">
                        {!! ($errors->has('password') ?  $errors->first('password') : '') !!}
                    </div>
                </div>

                <div class="form-group{!! $errors->has('password_confirmation') ? ' has-error' : '' !!}">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input name="password_confirmation" id="password_confirmation" value="" type="password" class="form-control" placeholder="Confirm Password">
                        {!! ($errors->has('password_confirmation') ? $errors->first('password_confirmation') : '') !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12 col-xs-12 register-buttons">
                        <button class="btn btn-primary registration-button" type="submit"><i class="fa fa-rocket"></i> Register</button>
                        <button class="btn btn-default registration-button" type="reset">Reset</button>
                    </div>
                    <div class="col-sm-12 col-xs-12 centered socials-capture">
                        Or sign up using following services
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