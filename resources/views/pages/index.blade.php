@extends(Config::get('credentials.admin-layout'))

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
    <div class="row">
        <div class="col-xs-8">
            <p class="lead">Here is all pages list: </p>
        </div>
        @if(isAdmin())
            <div class="col-xs-4">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::route('pages.create') !!}"><i class="fa fa-user"></i> New Page</a>
                </div>
            </div>
        @endif
    </div>
    <hr>
    <div class="well">
        <table class="table">
            {!! $grid !!}
        </table>
    </div>
@stop
