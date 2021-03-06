@extends('layouts.admin')

@section('title')
    Edit Environment Config
@stop

@section('top')
    <div class="page-header">
        <h1>Edit Environment Config</h1>
    </div>
@stop

@section('content')
    <div class="half">
        <div class="box">
            <div class="box-header">
                <?php
                $form = ['url' => route('edit.environment'),
                        '_method' => 'PUT',
                        'method' => 'POST',
                        'button' => 'Edit Environment',
                        'defaults' => [
                                'environment' => $environment
                        ],];
                ?>
                @include('config.form')
            </div>
        </div>
    </div>
@stop
