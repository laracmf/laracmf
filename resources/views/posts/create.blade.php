@extends('layouts.default')

@section('title')
Create Post
@stop

@section('top')
<div class="page-header">
<h1>Create Post</h1>
</div>
@stop

@section('content')
<div class="well">
    <?php
    $form = ['url' => route('blog.posts.store'),
        'method' => 'POST',
        'button' => 'Create New Post',
        'defaults' => [
            'title' => '',
            'summary' => '',
            'body' => '',
    ], ];
    ?>
    @include('posts.form')
</div>
@stop