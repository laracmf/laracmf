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
        $.ajax({
            type: "DELETE",
            url: $(this).data('url'),
            data: []
        })
            .success(function (data) {
                location.reload();
            })
    });

    $(document).on('click', '.delete-pair', function (event) {
        $(this).closest('tr').remove();
    });

    $(document).on('click', '.img-minimized', function (event) {
        var path = event.target.getAttribute('src') || $(this).data('path');
        var size = $(this).data('size');
        var name = $(this).data('name');
        var type = $(this).data('type');
        var delteUrl = $(this).data('url');
        var $partial = '<b>' + name + '</b>';
        var modalSize = '';

        if ($(this).data('is_image')) {
            $partial = '<img src="'+ path +'"/>';
            modalSize = 'modal-lg';
        } else if (type.split('/')[0] === 'video') {
            $partial = '<video controls>' +
                '<source src="' + path + '">' +
                '</video>';

            modalSize = 'modal-lg';
        }

        $(document.body).append(
            '<div class="modal fade" tabindex="-1" role="dialog">' +
            '<div class="modal-dialog ' + modalSize + '" role="document">' +
            '<div class="modal-content">' +
            '<div class="modal-header">' +
            '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
            '<h4 class="modal-title">' + name + '</h4>' +
            '</div>' +
            '<div class="modal-body">' +
            '<div class="img-block img-block-modal">' +
            $partial +
            '</div>' +
            '<div class="img-block">' +
            '<ul>' +
            '<li>' +
            'Size: ' + size +
            '</li>' +
            '<li>' +
            'Type: ' + type +
            '</li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
            '<button type="button" data-url="' + delteUrl + '" class="btn btn-danger delete">Delete</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>');

        $('.modal').modal('show');
    });

    $(document).on('hidden.bs.modal', '.modal', function () {
        $('.modal').remove();
    });

    $(document).on('mousemove', '.img-block', function () {
        $(this).css('cursor', 'pointer');
    });
});