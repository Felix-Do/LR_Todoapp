@extends('layouts.admin.application', ['menu' => 'branches'] )

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
    Branch
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\BranchController@index') !!}"><i class="fa fa-files-o"></i> Branch</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $branch->id }}</li>
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
        <form action="{!! action('Admin\BranchController@store') !!}" method="POST" enctype="multipart/form-data">
@else
        <form action="{!! action('Admin\BranchController@update', [$branch->id]) !!}" method="POST" enctype="multipart/form-data">
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
                    <label for="name">@lang('tables/branches/columns.name')</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $branch->name }}">
                </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group @if ($errors->has('country_code')) has-error @endif">
                    <label for="country_code">@lang('tables/branches/columns.country_code')</label>
                    <input type="text" class="form-control" id="country_code" name="country_code" value="{{ old('country_code') ? old('country_code') : $branch->country_code }}">
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
