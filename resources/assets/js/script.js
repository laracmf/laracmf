var baseURL = window.location.origin;

$(document).ready(function () {
    $('.add-new-pair').on('click', function () {
        $('table tr:last').after(
            '<tr>' +
            '<td>' +
            '<input name="keys[]" value="" type="text" class="form-control">' +
            '</td>' +
            '<td>' +
            '<input name="values[]" value="" type="text" class="form-control">' +
            '</td>' +
            '<td>' +
            '<button type="button" class="delete-pair"><i class="fa fa-close"></i></button>' +
            '</td>' +
            '</tr>'
        );
    });

    $('div.alert').not('.alert-important').delay(5000).fadeOut(350);

    $(document).on('click', '.delete', function () {
        var token = $("input[name='_token']").val();

        $.ajax({
            type: "DELETE",
            url: $(this).data('url'),
            data: {
                _token: token
            },
            success: function (data) {
                location.reload();
            }
        });
    });

    function multipleActions(multipleAction) {
        var action = baseURL + '/comments/multiple/' + multipleAction;
        var $commentsForm = $('.comments-form');

        $commentsForm.prop('action', action);
        $commentsForm.submit();
    }

    $(document).on('click', '.mass-deleting', function () {
        multipleActions('delete');
    });

    $(document).on('click', '.mass-approving', function () {
        multipleActions('approve');
    });

    $(document).on('click', '.delete-pair', function () {
        $(this).closest('tr').remove();
    });

    $(document).on('click', '.img-minimized', function (event) {
        var path = event.target.getAttribute('src') || $(this).data('path');
        var size = $(this).data('size');
        var name = $(this).data('name');
        var type = $(this).data('type');
        var delteUrl = $(this).data('url');
        var $partial = '<a href="' + path + '">Download ' + name + '</a>';
        var modalSize = 0;

        if ($(this).data('is_image')) {
            $partial = '<img src="' + path + '"/>';
            modalSize = 'modal';
        } else if (type.split('/')[0] === 'video') {
            $partial = '<video controls>' +
                '<source src="' + path + '">' +
                '</video>';

            modalSize = 'modal-lg';
        }

        $(document.body).append(
            '<div class="modal fade media-modal" tabindex="-1" role="dialog">' +
            '<div class="modal-dialog ' + modalSize + '" role="document">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<h4 class="modal-title">' + name + '</h4>' +
            '</div>' +
            '<div class="modal-body">' +
            '<div class="img-block-modal">' +
            $partial +
            '</div>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<div class="info-block">' +
            '<ul>' +
            '<li>' +
            'Size: ' + size +
            '</li>' +
            '<li>' +
            'Type: ' + type +
            '</li>' +
            '</ul>' +
            '</div>' +
            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
            '<button type="button" data-url="' + delteUrl + '" class="btn btn-danger delete">Delete</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>');

        $('.modal').modal('show');
    });

    $(document).on('hidden.bs.modal', '.media-modal', function () {
        $('.modal').remove();
    });

    $(document).on('mousemove', '.img-block', function () {
        $(this).css('cursor', 'pointer');
    });

    $('#contact-submit').on('click', function () {
        var token = $("input[name='_token']").val();

        $.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: {
                body: $('#body').val(),
                _token: token
            },
            success: function (data, status, xhr) {
                if (!xhr.responseJSON) {
                    cmsCommentMessage("There was an unknown error!", "error");
                    cmsCommentLock = false;
                    return;
                }

                if (xhr.responseJSON.success !== true || !xhr.responseJSON.msg || !xhr.responseJSON.contents || !xhr.responseJSON.comment_id) {
                    if (!xhr.responseJSON.msg) {
                        cmsCommentMessage("There was an unknown error!", "error");
                        cmsCommentLock = false;
                        return;
                    }

                    cmsCommentMessage(xhr.responseJSON.msg, "error");
                    cmsCommentLock = false;

                    return;
                }

                cmsCommentMessage(xhr.responseJSON.msg, "success");

                if ($("#comments > div").length == 0) {
                    $("#nocomments").fadeOut(cmsCommentTime, function () {
                        $(this).remove();
                        $(xhr.responseJSON.contents).prependTo('#comments').hide().slideDown(cmsCommentTime, function () {
                            cmsTimeAgo("#timeago_comment_" + xhr.responseJSON.comment_id);
                            cmsCommentEdit("#editable_comment_" + xhr.responseJSON.comment_id + "_1");
                            cmsCommentEdit("#editable_comment_" + xhr.responseJSON.comment_id + "_2");
                            cmsCommentDelete("#deletable_comment_" + xhr.responseJSON.comment_id + "_1");
                            cmsCommentDelete("#deletable_comment_" + xhr.responseJSON.comment_id + "_2");
                            cmsCommentLock = false;
                        });
                    });
                } else {
                    $(xhr.responseJSON.contents).prependTo('#comments').hide().slideDown(cmsCommentTime, function () {
                        cmsTimeAgo("#timeago_comment_" + xhr.responseJSON.comment_id);
                        cmsCommentEdit("#editable_comment_" + xhr.responseJSON.comment_id + "_1");
                        cmsCommentEdit("#editable_comment_" + xhr.responseJSON.comment_id + "_2");
                        cmsCommentDelete("#deletable_comment_" + xhr.responseJSON.comment_id + "_1");
                        cmsCommentDelete("#deletable_comment_" + xhr.responseJSON.comment_id + "_2");
                        cmsCommentLock = false;
                    });
                }

                cmsCommentLock = true;
                $('#body').val('');
            },
            error: function (xhr, status, error) {
                if (!xhr.responseJSON || !xhr.responseJSON.msg) {
                    cmsCommentMessage("There was an unknown error!", "error");
                    cmsCommentLock = false;
                    return;
                }

                cmsCommentMessage(xhr.responseJSON.msg, "error");
                cmsCommentLock = false;
            }
        });
    });

    $('.editable').on('click', function () {
        var commentId = $(this).data('pk');
        var action = baseURL + '/blog/comments/' + commentId;

        $('#edit_comment_ok').data('url', action);
    });

    $('#select-all').on('click', function () {
        var $comment = $('.comment');
        if ($(this).is(':checked')) {
            $comment.css({'background-image': 'inherit', 'background-color': 'silver'});

            $comment.each(function (i, comment) {
                var $hiddenInput = $(comment).find('input[type=hidden]');
                $hiddenInput.val($(this).data('pk'));
            });
        } else {
            $comment.css({'background-image': '', 'background-color': ''});

            $comment.each(function (i, comment) {
                var $hiddenInput = $(comment).find('input[type=hidden]');
                $hiddenInput.val('');
            });
        }
    });

    $('.comment').on('click', function () {
        var $hiddenInput = $(this).find('input[type=hidden]');

        if ($hiddenInput.val()) {
            $(this).css({'background-image': '', 'background-color': ''});
            $hiddenInput.val('');
        } else {
            $(this).css({'background-image': 'inherit', 'background-color': 'silver'});
            $hiddenInput.val($(this).data('pk'));
        }
    });

    $('.eye').on('click', function () {
        var $password = $('#password');

        if ($(this).hasClass('fa-eye')) {
            $password.attr('type', 'password');
            $(this).removeClass('fa-eye');
            $(this).addClass('fa-eye-slash');
        } else {
            $password.attr('type', 'text');
            $(this).removeClass('fa-eye-slash');
            $(this).addClass('fa-eye');
        }
    });
});

$(document).ready(function () {
    var url = window.location;
    var logviewer = url.origin + '/' + 'logviewer';
    var urlLink = url.href;

    if ((url.href).includes(logviewer)) {
        urlLink = logviewer;
    }

    $('.treeview a[href="' + urlLink + '"]').parent().addClass('active');

    $('.treeview a').filter(function () {
        return this.href == url.href;
    }).parent().parent().parent().addClass('active');
});