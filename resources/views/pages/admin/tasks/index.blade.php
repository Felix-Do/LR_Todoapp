@extends('layouts.admin.application', ['menu' => 'tasks'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
    <script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
Task
@stop

@section('breadcrumb')
    <li class="active">Task</li>
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">
                <p class="text-right">
                    <a href="{!! action('Admin\TaskController@create') !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.create')</a>
                </p>
            </h3>
            {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, []) !!}
        </div>
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 10px">ID</th>
                    <th>@lang('tables/tasks/columns.user_id')</th>
                    <th>@lang('tables/tasks/columns.name')</th>
                    <th>@lang('tables/tasks/columns.description')</th>
                    <th>@lang('tables/tasks/columns.duedate')</th>
                    <th>@lang('tables/tasks/columns.status')</th>
                    <th>@lang('tables/tasks/columns.label')</th>
                    <th style="width: 40px">&nbsp;</th>
                </tr>
                @foreach( $models as $model )
                    <tr>
                        <td>{{ $model->id }}</td>
                                <td>{{ $model->present()->user_id }}</td>
                                <td>{{ $model->present()->name }}</td>
                                <td>{{ $model->present()->description }}</td>
                                <td>{{ $model->present()->duedate }}</td>
                                <td>{{ $model->present()->status }}</td>
                                <td>{{ $model->present()->label }}</td>
                        <td>
                            <a href="{!! action('Admin\TaskController@show', $model->id) !!}" class="btn btn-block btn-primary btn-sm">@lang('admin.pages.common.buttons.edit')</a>
                            <a href="#" class="btn btn-block btn-danger btn-sm delete-button" data-delete-url="{!! action('Admin\TaskController@destroy', $model->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="box-footer">
            {!! \PaginationHelper::render($offset, $limit, $count, $baseUrl, []) !!}
        </div>
    </div>
@stop
