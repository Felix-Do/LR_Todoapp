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
            {{--  <p>current user: {{$user->id}} - {{$user->email}}</p>  --}}
            <a href="{{ action('User\TaskController@create') }}"
                class="btn btn-default">@lang('user.pages.tasks.buttons.new')</a>
            @if ( count($tasks) >= 1 )
                <br>
                <p>@lang('user.pages.tasks.top.index'):</p>
                <br>
                <input type="text" name="filter" value="" placeholder="filter">
                <br>
                @foreach($tasks as $task)
                    <a href="tasks/{{$task->id}}/edit">
                        <div class="well">
                            <h3>{{$task->name}}</h3>
                            <p>{{$task->description}}</p>
                            <p>@lang('tables\tasks\columns.duedate'): {{$task->duedate}}</p>
                            <p>@lang('tables\tasks\columns.status'): {{ $task->present()->statusName }}</p>
                            <p>@lang('tables\tasks\columns.label'): {{ $task->present()->labelName }}</p>
                        </div>
                    </a>
                @endforeach
                {{$tasks->links()}}
            @endif
        </div>
    </section>
@stop
