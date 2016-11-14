@extends('layouts.default')

@section('title')
    Edit Category
@stop

@section('top')
    <div class="page-header">
        <h1>Edit Category</h1>
    </div>
@stop

@section('content')
    <div class="well half">
        <?php
        $form = ['url' => route('edit.category', [$id]),
                'method' => 'POST',
                'button' => 'Edit Category',
                'defaults' => [
                        'name' => $category->name,
                        'pages' => $category->pages
                ], ];
        ?>
        @include('categories.form')
    </div>
@stop