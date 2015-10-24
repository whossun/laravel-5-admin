@extends('layout.backend')

@section('toolbars')
<div class="toolbars">
    <a class="btn btn-success btn-new"><i class="fa fa-fw fa-plus"></i>{{ trans('messages.new') }}</a>
    <a class="btn btn-danger btn-remove hide"><i class="fa fa-fw fa-times"></i>{{ trans('messages.delete') }}</a>
</div>
@stop

@section('breadcrumbs')
    {!! Breadcrumbs::render($route['current']) !!}
@stop


@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::open(['method' => 'DELETE', 'id' => 'frmList', 'route' => ['admin.'.$route['table'].'.destroy', null]]) !!}
                            @yield('table')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop