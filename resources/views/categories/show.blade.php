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
    <div class="col-lg-offset-4 col-lg-4">
        <div class="box">
            <div class="box-body">
                <table class="table table-bordered table-hover">
                    {{ csrf_field() }}
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr class="centered">
                            <td>{!! $category->name !!}</td>
                            <td>
                                &nbsp;<a class="btn btn-info" href="{!! route('show.edit.category.page', ['id' => $category->id]) !!}"><i class="fa fa-pencil-square-o"></i> Edit</a>
                                &nbsp;<a class="btn btn-danger delete" href="#" data-url="{!! route('delete.category', ['id' => $category->id]) !!}"><i class="fa fa-times"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @if(isRole('admin'))
            <div class="col-xs-12">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! route('show.create.category.page') !!}"><i class="fa fa-folder"></i> New Category</a>
                </div>
            </div>
        @endif
    </div>
@stop
