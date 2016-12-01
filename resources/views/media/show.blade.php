@extends('layouts.admin')

@section('title')
    Media
@stop

@section('top')
    <div class="page-header">
        <h1>Media</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <p class="lead">Here is a list of all media:</p>
        </div>
        @if(isRole('admin'))
        <div class="col-xs-4">
            <div class="pull-right">
                <div class="fileUpload btn btn-primary">
                    <span><i class='fa fa-camera'></i> Upload New Media</span>
                    {{ csrf_field() }}
                    <input id="fileupload" type="file" class="upload" name="files[]" data-url="{{ route('upload.media') }}" multiple>
                </div>
            </div>
        </div>
        @endif
    </div>
    <hr>
    <div class="well">
        @foreach($files as $file)
            <div class="img-block img-minimized" data-url="{{ route('delete.media', [$file->id]) }}" data-path="{{ $file->path }}" data-is_image="{{ isImage($file->path) }}" data-size="{{ formatBytes($file->size) }}" data-type="{{ $file->type }}" data-name="{{ $file->name }}">
                @if (isImage($file->path))
                    <img src="{{ $file->path }}"/>
                @else
                    <b>{{ $file->name }}</b>
                @endif
            </div>
        @endforeach
    </div>
@stop