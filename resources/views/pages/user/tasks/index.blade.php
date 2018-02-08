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
            <a href="{{ action('User\TaskController@create') }}" class="btn btn-default">Create New Task</a>
            @if ( count($tasks) >= 1 )
                <br>
                <p>You have these tasks active:</p>
                <br>
                <input type="text" name="filter" value="" placeholder="filter">
                <br>
                @foreach($tasks as $task)
                    <a href="tasks/{{$task->id}}/edit">
                        <div class="well">
                            <h3>{{$task->name}}</h3>
                            <p>{{$task->description}}</p>
                            <p>DueDate: {{$task->duedate}}</p>
                            <p>Status: {{ $task->present()->statusName }}</p>
                            <p>Label: {{ $task->present()->labelName }}</p>
                        </div>
                    </a>
                @endforeach
                {{$tasks->links()}}
            @endif
        </div>
    </section>
@stop
