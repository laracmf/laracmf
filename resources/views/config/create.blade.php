@extends('layouts.default')

@section('title')
    Create Environment Config
@stop

@section('top')
    <div class="page-header">
        <h1>Create Environment Config</h1>
    </div>
@stop

@section('content')
    <div class="well half">
        <?php
        $form = ['url' => route('create.environment'),
                '_method' => 'POST',
                'method' => 'POST',
                'button' => 'Create Environment',
                'defaults' => [
                        'environment' => [],
                        'name' => ''
                ],
        ];
        ?>
        @include('config.form')
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css">
@stop

@section('js')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".make-switch").bootstrapSwitch();
        });
    </script>
@stop
