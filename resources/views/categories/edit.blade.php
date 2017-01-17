@extends('layouts.admin')

@section('title')
    Edit Category
@stop

@section('top')
    <div class="page-header">
        <h1>Edit Category</h1>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="half">
            <div class="box box-group">
                <div class="box-header">
                    <h3 class="box-title">Edit category</h3>
                </div>
                <div class="box-body">
                    <?php
                    $form = ['url' => route('edit.category', [$id]),
                            'method' => 'POST',
                            'button' => 'Edit Category',
                            'defaults' => [
                                    'name' => $category->name,
                                    'pages' => $category->pages
                            ],];
                    ?>
                    @include('categories.form')
                </div>
            </div>
        </div>
    </div>
@stop