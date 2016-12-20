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
    <div class="row">
        <div class="half">
            <div class="box box-group">
                <div class="box-header">
                    <h3 class="box-title">Create category</h3>
                </div>
                <div class="box-body">
                    <?php
                    $form = ['url' => route('create.category'),
                            'method' => 'POST',
                            'button' => 'Create New Category',
                            'defaults' => [
                                    'name' => '',
                                    'pages' => []
                            ],];
                    ?>
                    @include('categories.form')
                </div>
            </div>
        </div>
    </div>
@stop