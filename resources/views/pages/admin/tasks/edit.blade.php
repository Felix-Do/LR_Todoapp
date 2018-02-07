@extends('layouts.admin.application', ['menu' => 'tasks'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss'});
    </script>
@stop

@section('title')
@stop

@section('header')
    Task
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\TaskController@index') !!}"><i class="fa fa-files-o"></i> Task</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $task->id }}</li>
    @endif
@stop

@section('content')
@if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
@foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
@endforeach
            </ul>
        </div>
@endif

@if( $isNew )
        <form action="{!! action('Admin\TaskController@store') !!}" method="POST" enctype="multipart/form-data">
@else
        <form action="{!! action('Admin\TaskController@update', [$task->id]) !!}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
@endif
        {!! csrf_field() !!}
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"></h3>
            </div>
            <div class="box-body">
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group @if ($errors->has('name')) has-error @endif">
                    <label for="name">@lang('tables/tasks/columns.name')</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $task->name }}">
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group @if ($errors->has('description')) has-error @endif">
                    <label for="description">@lang('tables/tasks/columns.description')</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ old('description') ? old('description') : $task->description }}">
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group @if ($errors->has('duedate')) has-error @endif">
                    <label for="duedate">@lang('tables/tasks/columns.duedate')</label>
                    <input type="text" class="form-control" id="duedate" name="duedate" value="{{ old('duedate') ? old('duedate') : $task->duedate }}">
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group @if ($errors->has('status')) has-error @endif">
                    <label for="status">@lang('tables/tasks/columns.status')</label>
                    <input type="text" class="form-control" id="status" name="status" value="{{ old('status') ? old('status') : $task->status }}">
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group @if ($errors->has('label')) has-error @endif">
                    <label for="label">@lang('tables/tasks/columns.label')</label>
                    <input type="text" class="form-control" id="label" name="label" value="{{ old('label') ? old('label') : $task->label }}">
                </div>
            </div>
            </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
