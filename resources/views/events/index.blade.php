@extends(config('app.layout'))

@section('title')
    Events
@stop

@section('top')
    <div class="page-header">
        <h1>Events</h1>
    </div>
@stop

@section('content')
    <div class="{{ isAdmin() ? 'col-lg-11' : 'col-lg-12' }}">
        @if (!count($events))
            <p class="lead">
                There are no events.
            </p>
        @else
            @foreach($events as $event)
                <h2>{!! $event->title !!}</h2>
                <p>
                    <strong>{!! $event->date->format(config('date.php_display_format')) !!}</strong>
                </p>
                <p>
                    <a class="btn btn-success" href="{!! route('events.show', array('events' => $event->id)) !!}">
                        <i class="fa fa-file-text"></i> Show Event
                    </a>
                    @if(isRole('editor'))
                        <a class="btn btn-info" href="{!! route('events.edit', array('events' => $event->id)) !!}">
                            <i class="fa fa-pencil-square-o"></i> Edit Event
                        </a>
                        <a class="btn btn-danger" href="#delete_event_{!! $event->id !!}" data-toggle="modal" data-target="#delete_event_{!! $event->id !!}">
                            <i class="fa fa-times"></i> Delete Event
                        </a>
                    @endif
                </p>
                <br>
            @endforeach
        @endif
    </div>
    @if(isRole('editor') || isAdmin())
        <div class="col-xs-1 pull-right">
            <a class="btn btn-primary" href="{!! route('events.create') !!}"><i class="fa fa-calendar"></i> New
                Event</a>
        </div>
    @endif
    {!! $links !!}
@stop

@section('bottom')
    @if(isRole('editor'))
        @include('events.deletes')
    @endif
@stop
