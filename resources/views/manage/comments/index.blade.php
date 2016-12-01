@extends(isRole('admin')?'layouts.admin':config('app.layout'))

@section('title')
Comments manager
@stop

@section('top')
<div class="page-header">
<h1>Comments manager</h1>
</div>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-8">
            <p class="lead">Unapproved comments</p>
        </div>
    </div>
    <form class="comments-form" action="" method="POST">
        {{ csrf_field() }}
        <div class="top-header clearfix col-xs-12">
            <div class="col-md-8 col-sm-8">
                <p class="select-all"><input id="select-all" type="checkbox"> Select all</p>
            </div>
            <div class="hidden-xs">
                <div class="col-md-4 col-sm-4 common-actions">
                    <div class="pull-right">
                        <a class="btn btn-danger mass-deleting"><i class="fa fa-times"></i> Delete</a><a class="btn btn-success mass-approving"><i class="fa fa-pencil-square-o"></i> Approve</a>
                    </div>
                </div>
            </div>
        </div>
        @foreach($comments as $comment)
            <div id="comment_{!! $comment->id !!}" class="comment well clearfix col-xs-12 animated bounceIn{!! rand(0, 1) ? 'Left': 'Right' !!}" data-pk="{!! $comment->id !!}" data-ver="{!! $comment->version !!}">
                <input type="hidden" name="comments[]" value="">
                @if(isRole('moderator') || isRole('admin'))
                    <div class="col-md-8 col-sm-8">
                        <p><strong>{!! $comment->author !!}</strong> - {!! html_ago($comment->created_at, 'timeago_comment_'.$comment->id) !!}</p>
                        <p id="main_comment_{!! $comment->id !!}" class="main">{!! nl2br(e($comment->body)) !!}</p>
                    </div>
                    <div class="hidden-xs">
                        <div class="col-md-4 col-sm-4">
                            <div class="pull-right">
                                <a id="deletable_comment_{!! $comment->id !!}_1" class="btn btn-danger deletable" href="{!! route('posts.comments.destroy', ['comment' => $comment->id]) !!}"><i class="fa fa-times"></i> Delete</a><a class="btn btn-success" href="{!! route('comment.approve', ['id' => $comment->id]) !!}"><i class="fa fa-pencil-square-o"></i> Approve</a><a id="editable_comment_{!! $comment->id !!}_1" class="btn btn-info editable" href="#edit_comment" data-pk="{!! $comment->id !!}"><i class="fa fa-pencil-square-o"></i> Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="visible-xs">
                        <div class="col-xs-12">
                            <a id="deletable_comment_{!! $comment->id !!}_2" class="btn btn-danger deletable" href="{!! route('posts.comments.destroy', ['comment' => $comment->id]) !!}"><i class="fa fa-times"></i> Delete</a><a class="btn btn-success" href="{!! route('comment.approve', ['id' => $comment->id]) !!}"><i class="fa fa-pencil-square-o"></i> Approve</a><a id="editable_comment_{!! $comment->id !!}_2" class="btn btn-info editable" href="#edit_comment" data-pk="{!! $comment->id !!}"><i class="fa fa-pencil-square-o"></i> Edit</a>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12">
                        <p><strong>{!! $comment->author !!}</strong> - {!! html_ago($comment->created_at, 'timeago_comment_'.$comment->id) !!}</p>
                        <p id="main_comment_{!! $comment->id !!}" class="main">{!! nl2br(e($comment->body)) !!}</p>
                    </div>
                @endif
            </div>
        @endforeach
        {!! $comments->links() !!}
        @endsection
    </form>

@section('bottom')
    @if(isRole('blogger'))
        @include('posts.delete')
    @endif
    @if(isRole('moderator') || isRole('admin'))
        <div id="edit_comment" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Comment</h4>
                    </div>
                    <div class="modal-body">
                        <form id="edit_commentform" class="form-vertical" action="" method="PATCH" data-pk="0">
                            {{ csrf_field() }}
                            <input id="version" name="version" value="1" type="hidden">
                            <div class="form-group">
                                <textarea id="edit_body" name="edit_body" class="form-control comment-box" placeholder="Type a comment..." rows="3"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button id="edit_comment_ok" data-url="" type="button" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endif
@stop

@section('js')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
    <script>
        var cmsCommentInterval = {!! Config::get('cms.commentfetch') !!};
        var cmsCommentTime = {!! Config::get('cms.commenttrans') !!};
    </script>
    <script type="text/javascript" src="{{ asset('assets/scripts/cms-comment.js') }}"></script>
@stop