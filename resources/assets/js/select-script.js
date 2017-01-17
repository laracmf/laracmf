$(document).ready(function () {
    var token = $("input[name='_token']").val();

    $(".selectPages").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        placeholder: 'Pages',
        multiple: true,
        ajax: {
            url: baseURL + '/search/pages',
            dataType: 'json',
            data: function(params, page) {
                return {
                    query: params.term,
                    _token: token
                };
            },
            processResults: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
});

$(document).ready(function () {
    var token = $("input[name='_token']").val();

    $(".selectCategories").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        placeholder: 'Pages',
        multiple: true,
        ajax: {
            url: baseURL + '/search/categories',
            dataType: 'json',
            data: function(params, page) {
                return {
                    query: params.term,
                    _token: token
                };
            },
            processResults: function(data, page) {
                return {
                    results: data
                };
            }
        }
    });
});