@extends('layouts.admin')

@section('title')
    Create Page
@stop

@section('top')
    <div class="page-header">
        <h1>Create Category</h1>
    </div>
@stop

@section('content')
    <div class="well half">
        <?php
        $form = ['url' => route('create.category'),
                'method' => 'POST',
                'button' => 'Create New Category',
                'defaults' => [
                        'name' => '',
                        'pages' => []
                ], ];
        ?>
        @include('categories.form')
    </div>
@stop