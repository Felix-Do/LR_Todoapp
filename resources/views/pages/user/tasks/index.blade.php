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
            <p>{{ $sort['column'] }} - {{ $sort['direction'] }}</p>
            <form
                action="{!! action('User\TaskController@index') !!}"
                method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="GET">
                <input type="hidden" name="sort_column_current" value="{{ $sort['column'] }}">
                <input type="hidden" name="sort_direction_current" value="{{ $sort['direction'] }}">
                <input type="text" name="filter" value="{{ $filter }}" placeholder="filter">
                <button type="submit" name="actionBtn" value="filter" class="btn btn-default">Search</button>
                <button type="submit" name="actionBtn" 
                    value="cycle_direction" class="btn btn-default">
                    Sort: {{ $sort['direction'] }}
                </button>
                <button type="submit" name="actionBtn" 
                    value="cycle_column" class="btn btn-default">
                    Sort: {{ $sort['column'] }}
                </button>
            </form>
            <br>
            {{--  <p>current user: {{$user->id}} - {{$user->email}}</p>  --}}
            <a href="{{ action('User\TaskController@create') }}"
                class="btn btn-default">@lang('user.pages.tasks.buttons.new')</a>
            @if ( count($tasks) >= 1 )
                <br>
                <p>@lang('user.pages.tasks.top.index'):</p>
                <br>
                @foreach($tasks as $task)
                    <a href="{{ action('User\TaskController@edit', $task->id) }}">
                        <div class="well">
                            <h3>{{ $task->name }}</h3>
                            <p>{{ $task->description }}</p>
                            <p>@lang('tables\tasks\columns.duedate'): {{ $task->duedate }}</p>
                            <p>@lang('tables\tasks\columns.status'): {{ $task->present()->statusName }}</p>
                            <p>@lang('tables\tasks\columns.label'): {{ $task->present()->labelName }}</p>
                        </div>
                    </a>
                @endforeach
                {{$tasks->links()}}
            @else
                <br>
                <p>@lang('user.pages.tasks.top.index_empty')</p>
            @endif
        </div>
    </section>
@stop
