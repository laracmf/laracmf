@extends('layouts.admin')

@section('title')
    Categories
@stop

@section('top')
    <div class="page-header">
        <h1>Categories</h1>
    </div>
@stop

@section('content')
    <div class="{{ isAdmin() ? 'col-lg-11' : 'col-lg-12' }}">
        <div class="box">
            <table class="table table-bordered table-hover">
                {!! $grid !!}
            </table>
        </div>
    </div>
    @if(isAdmin())
        <div class="col-lg-1 pull-right">
            <a class="btn btn-primary" href="{!! route('show.create.category.page') !!}">
                <i class="fa fa-user"></i> New Category
            </a>
        </div>
    @endif
@stop
