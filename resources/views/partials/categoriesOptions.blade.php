<a class="btn btn-info" href="{!! route('show.edit.category.page', ['id' => $category->id]) !!}"><i class="fa fa-pencil-square-o"></i> Edit</a>
<a class="btn btn-danger" href="{!! route('delete.category') !!}" data-token="{!! Session::getToken() !!}" data-method="DELETE"> Delete</a>
