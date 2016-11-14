@extends('layouts.default')

@section('title')
    Create Environment Config
@stop

@section('top')
    <div class="page-header">
        <h1>Create Environment Config</h1>
    </div>
@stop

@section('content')
    <div class="well half">
        <?php
        $form = ['url' => route('create.environment'),
                '_method' => 'POST',
                'method' => 'POST',
                'button' => 'Create Environment',
                'defaults' => [
                        'environment' => [],
                        'name' => ''
                ],
        ];
        ?>
        @include('config.form')
    </div>
@stop