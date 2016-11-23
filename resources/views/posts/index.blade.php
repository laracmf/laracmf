@extends('layouts.default')

@section('title')
Blog
@stop

@section('top')
<div class="page-header">
<h1>Blog</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-8">
        <p class="lead">
            @if (count($posts) == 0)
                There are currently no blog posts.
            @else
                Here you may find our blog posts:
            @endif
        </p>
    </div>
    @if(isRole('blogger'))
        <div class="col-xs-4">
            <div class="pull-right">
                <a class="btn btn-primary" href="{!! route('blog.posts.create') !!}"><i class="fa fa-book"></i> New Post</a>
            </div>
        </div>
    @endif
</div>
@foreach($posts as $post)
    <h2>{!! $post->title !!}</h2>
    <p>
        <strong>{!! $post->summary !!}</strong>
    </p>
    <p>
        <a class="btn btn-success" href="{!! route('blog.posts.show', array('posts' => $post->id)) !!}"><i class="fa fa-file-text"></i> Show Post</a>
        @if(isRole('blogger'))
             <a class="btn btn-info" href="{!! route('blog.posts.edit', array('posts' => $post->id)) !!}"><i class="fa fa-pencil-square-o"></i> Edit Post</a> <a class="btn btn-danger" href="#delete_post_{!! $post->id !!}" data-toggle="modal" data-target="#delete_post_{!! $post->id !!}"><i class="fa fa-times"></i> Delete Post</a>
        @endif
    </p>
    <br>
@endforeach
{!! $links !!}
@stop

@section('bottom')
    @if(isRole('blogger'))
        @include('posts.deletes')
    @endif
@stop
