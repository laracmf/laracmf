@extends(config('app.layout'))
@section('title')
    Error
@stop

@section('content')
    <div class="error">
        <h1 class="error-text">NOT FOUND</h1>
        <div class="error-text">
            <a href="{{ route('base') }}">Home</a>
        </div>
    </div>
@stop