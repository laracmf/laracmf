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
        @if(isAdmin())
            <div class="col-xs-12">
                <div class="pull-right">
                    <a class="btn btn-primary" href="{!! URL::route('users.create') !!}"><i class="fa fa-user"></i> New User</a>
                </div>
            </div>
        @endif
    </div>
    <hr>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Users list</h3>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                {!! $grid !!}
            </table>
        </div>
    </div>
@stop

@section('bottom')
    @if(isAdmin())
        @include('credentials::users.resets')
        @include('credentials::users.deletes')
    @endif
@stop