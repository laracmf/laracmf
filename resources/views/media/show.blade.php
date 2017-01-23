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
    <div class="{{ isAdmin() ? 'col-lg-10' : 'col-lg-12' }}">
        <div class="box">
            <table class="table table-bordered table-hover">
                {!! $grid !!}
            </table>
        </div>
    </div>
    @if(isRole('admin'))
        <div class="col-lg-2 pull-right">
            <div class="fileUpload btn btn-primary">
                <span><i class='fa fa-camera'></i> Upload New Media</span>
                {{ csrf_field() }}
                <input id="fileupload" type="file" class="upload" name="files[]" data-url="{{ route('upload.media') }}" multiple>
            </div>
        </div>
    @endif
@stop