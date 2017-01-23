<div class="img-block img-minimized">
    @if (isImage($file->path))
        <img src="{{ $file->path }}"/>
    @else
        <img src="{{ asset('assets/images/file-icon.png') }}"/>
    @endif
</div>
