@extends(config('credentials.admin-layout'))

@section('title')
    <?php $__navtype = 'admin'; ?>
    Users
@stop

@section('top')
    <div class="page-header">
        <h1>Users</h1>
    </div>
@stop

@section('content')
    <div class="{{ isAdmin() ? 'col-lg-11' : 'col-lg-12' }}">
        <div class="box">
            <table class="table table-bordered table-hover">
                {!! $grid !!}
            </table>
        </div>
    </div>
    @if(isAdmin())
        <div class="col-lg-1 pull-right">
            <a class="btn btn-primary" href="{!! route('pages.create') !!}">
                <i class="fa fa-user"></i> New Page
            </a>
        </div>
    @endif
@stop
