@extends('layouts.user.application', [
    'bodyClasses' => ''
])

@section('metadata')
@stop

@section('styles')
    @parent
@stop

@section('title')
    Top
@stop

@section('scripts')
    @parent
@stop

@section('content')
    <section>
        <div class="container">
            <br>
            <a href="{{ action('User\TaskController@index') }}" class="btn btn-default">
                @lang('user.pages.tasks.buttons.back')
            </a>
            <br><br>
            @lang('user.pages.tasks.top.create'):
            <br><br>
            <form action="{!! action('User\TaskController@store') !!}" method="post">
                {!! csrf_field() !!}
                @lang('tables\tasks\columns.name'):
                <input type="text" name="name"
                    placeholder="@lang('user.pages.tasks.field_placeholder.name')"
                    id="autoselect_element" class="autoselect" autofocus value="{{$task->name}}">
                @if(empty($task->name))
                    <div class="alert alert-danger">
                        @lang('user.pages.tasks.field_warning.name')
                    </div>
                @endif
                @lang('tables\tasks\columns.description'):
                <input type="text" name="description"
                    placeholder="@lang('user.pages.tasks.field_placeholder.description')"
                    value="{{$task->description}}">
                @lang('tables\tasks\columns.duedate'):
                <input type="date" name="duedate" value="{{$task->duedate}}">
                @if(empty($task->duedate))
                    <div class="alert alert-danger">
                        @lang('user.pages.tasks.field_warning.duedate')
                    </div>
                @endif
                @lang('tables\tasks\columns.status'): 
                @for ($i = 0; $i < $task->present()->statusCount; $i++)
                    <input type="radio" name="status" value={{$i}}
                        {{ $task->present()->statusCheck($i) }}
                    > {{ $task->present()->statusName($i) }}
                @endfor
                <br><br>
                @lang('tables\tasks\columns.label'): 
                @for ($i = 0; $i < $task->present()->labelCount; $i++)
                    <input type="radio" name="label" value={{$i}}
                        {{ $task->present()->labelCheck($i) }}
                    > {{ $task->present()->labelName($i) }}
                @endfor
                <br><br>
                <button type="submit" class="btn btn-default">@lang('user.pages.tasks.buttons.create')</button>
            </form>
        </div>
    </section>
    @include('pages.user.tasks.autoselect');
@stop
