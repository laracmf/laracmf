$(document).ready(function () {
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
                    query: params.term
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
                    query: params.term
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