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
                            <textarea id="edit_body" name="edit_body" class="form-control comment-box"
                                      placeholder="Type a comment..." rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="edit_comment_ok" type="button" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>
    </div>
@endif