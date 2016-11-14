@extends('layouts.default')

@section('title')
Create Page
@stop

@section('top')
<div class="page-header">
<h1>Create Page</h1>
</div>
@stop

@section('content')
<div class="well">
    <?php
    $form = ['url' => route('pages.store'),
        'method' => 'POST',
        'button' => 'Create New Page',
        'defaults' => [
            'title' => '',
            'nav_title' => '',
            'slug' => '',
            'icon' => '',
            'body' => '',
            'css' => '',
            'js' => '',
            'categories' => [],
            'show_title' => true,
            'show_nav' => true,
    ], ];
    ?>
    @include('pages.form')
</div>
@stop
