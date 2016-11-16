$(document).ready(function () {
    var token = $("input[name='_token']").val();
    var $fileupload = $('#fileupload');

    $fileupload.fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                var $partial = '<b>' + file.name + '</b>';

                if (file.isImage) {
                    $partial = '<img src="' + file.path + '">';
                }

                $('.well').append('<div class="img-block img-minimized"' +
                    ' data-url="' + file.deleteUrl + '"' +
                    ' data-name="' + file.name + '"' +
                    ' data-size="' + file.size + '"' +
                    ' data-type="' + file.type + '"' +
                    ' data-path="' + file.path + '"' +
                    ' data-is_image="' + file.isImage + '">' +
                    $partial +
                    '</div>');
            });
        }
    });

    $fileupload.bind('fileuploadsubmit', function (e, data) {
        data.formData = {
            _token: token
        };
    });
});