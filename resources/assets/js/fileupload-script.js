$(document).ready(function () {
    var token = $("input[name='_token']").val();
    var $fileupload = $('#fileupload');

    $fileupload.fileupload({
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result, function (index, file) {
                var $partial = '';

                if (file.isImage) {
                    $partial = '<img src="' + file.path + '">' + '<p class="centered"><b>' + file.name + '</b></p>';
                } else {
                    $partial = '<img src="assets/images/file-icon.png">' +
                        '<p class="centered"><b>' + file.name + '</b></p>';
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