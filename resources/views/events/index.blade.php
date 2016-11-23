@extends('layouts.default')

@section('title')
Events
@stop

@section('top')
<div class="page-header">
<h1>Events</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-8">
        <p class="lead">
            @if (count($events) == 0)
                There are currently no events.
            @else
                Here you may find our events:
            @endif
        </p>
    </div>
    @if(isRole('editor'))
        <div class="col-xs-4">
            <div class="pull-right">
                <a class="btn btn-primary" href="{!! route('events.create') !!}"><i class="fa fa-calendar"></i> New Event</a>
            </div>
        </div>
    @endif
</div>
@foreach($events as $event)
    <h2>{!! $event->title !!}</h2>
    <p>
        <strong>{!! $event->date->format(Config::get('date.php_display_format')) !!}</strong>
    </p>
    <p>
        <a class="btn btn-success" href="{!! route('events.show', array('events' => $event->id)) !!}"><i class="fa fa-file-text"></i> Show Event</a>
        @if(isRole('editor'))
             <a class="btn btn-info" href="{!! route('events.edit', array('events' => $event->id)) !!}"><i class="fa fa-pencil-square-o"></i> Edit Event</a> <a class="btn btn-danger" href="#delete_event_{!! $event->id !!}" data-toggle="modal" data-target="#delete_event_{!! $event->id !!}"><i class="fa fa-times"></i> Delete Event</a>
        @endif
    </p>
    <br>
@endforeach
{!! $links !!}
@stop

@section('bottom')
    @if(isRole('editor'))
        @include('events.deletes')
    @endif
@stop
