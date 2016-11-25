@extends('layouts.default')

@section('title')
    Configuration Environments
@stop

@section('top')
    <div class="page-header">
        <h1>Configuration Environments</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <p class="lead">Here is a list of all current environments:</p>
        </div>
        @if(isRole('admin'))
        <div class="col-xs-4">
            <div class="pull-right">
                <a class="btn btn-primary" href="{!! route('show.create.form') !!}"><i class="fa fa-folder"></i> New Configuration Environment</a>
            </div>
        </div>
        @endif
    </div>
    <hr>
    <div class="well half">
        {{ csrf_field() }}
        @foreach($environments as $environment)
            <a class="env" href="{{ route('show.edit.form', [$environment]) }}">
                <button type="button" class="btn btn-primary btn-lg btn-block">
                    {{ $environment }}
                </button>
            </a>
            <button type="button" class="delete" data-url="{{ route('delete.environment', [$environment]) }}"><i class="fa fa-close"></i></button>
        @endforeach
    </div>
@stop