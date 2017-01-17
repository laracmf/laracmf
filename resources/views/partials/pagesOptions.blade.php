<a class="btn btn-success" href="{!! route('pages.show', ['page' => $page->slug]) !!}"><i class="fa fa-file-text"></i> Show</a>
<a class="btn btn-info" href="{!! route('pages.edit', ['page' => $page->slug]) !!}"><i class="fa fa-pencil-square-o"></i> Edit</a>
<a class="btn btn-danger" href="{!! route('pages.destroy', ['pages' => $page->slug]) !!}" data-token="{!! Session::getToken() !!}" data-method="DELETE"> Delete</a>
