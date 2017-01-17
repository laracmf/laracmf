<form class="form-horizontal" action="{{ route('contact.post') }}" method="POST">
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

    <div class="form-group{!! ($errors->has('message')) ? ' has-error' : '' !!}">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <textarea name="message" id="message" class="form-control" placeholder="Message" rows="8">{!! Request::old('message') !!}</textarea>
            {!! ($errors->has('message') ? $errors->first('message') : '') !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12 col-xs-12 register-buttons">
            <button class="btn btn-primary registration-button" type="submit"><i class="fa fa-rocket"></i> Submit</button>
            <button class="btn btn-inverse registration-button" type="reset">Reset</button>
        </div>
    </div>

</form>
