<a class="btn btn-success show-image" data-url="{{ route('delete.media', [$file->id]) }}"
   data-path="{{ $file->path }}" data-is_image="{{ isImage($file->path) }}"
   data-size="{{ formatBytes($file->size) }}" data-type="{{ $file->type }}" data-name="{{ $file->name }}"><i class="fa fa-file-text"></i> Show</a>
{{--<a class="btn btn-info" href="{!! route('pages.edit', ['page' => $page->slug]) !!}"><i class="fa fa-pencil-square-o"></i> Edit</a>--}}
<a class="btn btn-danger" data-url="{!! route('delete.media', ['id' => $file->id]) !!}" data-token="{!! Session::getToken() !!}" data-method="DELETE"> Delete</a>