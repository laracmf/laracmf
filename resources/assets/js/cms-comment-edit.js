var pk = 0;
var baseURL = window.location.origin;

function cmsCommentSubmit(that) {
    var token = $("input[name='_token']").val();
    var action = baseURL + '/blog/comments/' + this.pk;

    $.ajax({
        url: action,
        type: 'PUT',
        dataType: 'json',
        data: {
            body: $('#edit_body').val(),
            version: $('#version').val(),
            _token: token
        },
        clearForm: true,
        resetForm: true,
        success: function(data, status, xhr) {
            if (!xhr.responseJSON) {
                $("#edit_comment").modal("hide");
                return;
            }
            if (xhr.responseJSON.success !== true || !xhr.responseJSON.msg || !xhr.responseJSON.comment_id || !xhr.responseJSON.comment_ver || !xhr.responseJSON.comment_text) {
                $("#edit_comment").modal("hide");
                return;
            }
            $("#comment_"+xhr.responseJSON.comment_id).data("ver", xhr.responseJSON.comment_ver);
            $("#main_comment_"+xhr.responseJSON.comment_id).fadeOut(cmsCommentTime/2, function() {
                $(this).html(xhr.responseJSON.comment_text);
                $(this).fadeIn(cmsCommentTime/2, function() {
                    $("#edit_comment").modal("hide");
                });
            });
        },
        error: function(xhr, status, error) {
            $("#edit_comment").modal("hide");
        }
    });
}

function cmsCommentEditShow(that) {
    this.pk = $(that).data('pk');

    $("#version").attr("value", $("#comment_"+$(that).data('pk')).data('ver'));
    $("#edit_body").val($("#main_comment_"+$(that).data('pk')).text().replace(/<br\s*[\/]?>/gi, "\n"));
    $("#edit_comment").modal("show");
}

function cmsCommentEdit(bindval) {
    bindval = bindval || ".editable";
    $(bindval).click(function() {
        var that = this;
        var cmsCommentEditCheck = setInterval(function() {
            if (!cmsCommentLock) {
                cmsCommentLock = true;
                cmsCommentEditShow(that);
            } else {
                clearInterval(cmsCommentEditCheck);
            }
        }, 10);
        return false;
    });
}

function cmsCommentModel() {
    $(document).on('hidden.bs.modal', '#edit_comment', function () {
        cmsCommentLock = false;
    });

    $(document).on('click', '#edit_comment_ok', function(event) {
        cmsCommentSubmit(this);
        event.stopImmediatePropagation();
    });
}