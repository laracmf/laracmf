@if (isset($errors) && count($errors->all()) > 0)

<div class="alert alert-danger cms-alert">
    <a class="close" data-dismiss="alert">×</a>
    <ul class="list-unstyled">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    {{--Please check the form below for errors--}}
</div>
@endif

<?php $types = ['success', 'error', 'warning', 'info']; ?>

@foreach ($types as $type)
    @if ($message = Session::get($type))
        <?php if ($type === 'error') $type = 'danger'; ?>
        <div class="alert alert-{{ $type }} cms-alert">
            <a class="close" data-dismiss="alert">×</a>
            {!! $message !!}
        </div>
    @endif
@endforeach

@if (session()->has('flash_notification.message'))
    <div class="alert alert-{{ session('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {!! session('flash_notification.message') !!}
    </div>
@endif
{!! Breadcrumbs::renderIfExists() !!}

@if(Request::path() === config('credentials.home'))
    {!! Breadcrumbs::render('home') !!}
@endif