<form class="form-horizontal category-form" action="{{ $form['url'] }}" method="{{ $form['method'] }}">

    {{ csrf_field() }}
    <input type="hidden" name="_method" value="{{ isset($form['_method'])? $form['_method'] : $form['method'] }}">

    <div class="form-group{!! ($errors->has('name')) ? ' has-error' : '' !!}">
        <label class="col-md-2 control-label" for="title">Category Name</label>
        <div class="col-lg-10">
            <input name="name" id="name" value="{!! Request::old('name', $form['defaults']['name']) !!}" type="text" class="form-control" placeholder="Category Name">
            {!! ($errors->has('name') ? $errors->first('name') : '') !!}
        </div>
    </div>

    <div class="form-group{!! ($errors->has('pages')) ? ' has-error' : '' !!}">
        <label class="col-md-2 control-label" for="title">Pages List</label>
        <div class="col-lg-10">
            <select name="pages[]" class="form-control selectPages" multiple>
                @foreach( $form['defaults']['pages'] as $page)
                    <option selected value="{{ $page->id }}">{{ $page->title }}</option>
                @endforeach
            </select>
            {!! ($errors->has('pages') ? $errors->first('pages') : '') !!}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-2 col-sm-offset-3 col-sm-10 col-xs-12">
            <button class="btn btn-primary" type="submit"><i class="fa fa-rocket"></i> {!! $form['button'] !!}</button>
        </div>
    </div>
</form>
