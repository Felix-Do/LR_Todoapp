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
            <p>current user: {{$data['user']->id}} - {{$data['user']->email}}</p>
            @if ( count($data['tasks']) < 1 )
                <p>You don't have any task</p>
                <a href="{{ action('User\TaskController@create') }}" class="btn btn-default">Create New Task<a>
            @else
                <p>You have {{count($data['tasks'])}} upcoming
                    @if ( count($data['tasks']) > 1 )
                        tasks
                    @else
                        task
                    @endif
                </p>
                <a href="{{ action('User\TaskController@create') }}" class="btn btn-default">Create New Task<a>
                <br>
                <input type="text" name="filter" value="" placeholder="filter">
                <br>
                @foreach($data['tasks'] as $task)
                    <a href="tasks/{{$task->id}}/edit">
                        <div class="well">
                            <h3>{{$task->name}}</h3>
                            <p>{{$task->description}}</p>
                            <p>DueDate: {{$task->duedate}}</p>
                            <p>Status: 
                                @if($task->status==1)
                                    In Progress
                                @elseif($task->status==2)
                                    Finished
                                @else
                                    Not Started
                                @endif
                            </p>
                            <p>Label: {{$task->label}}</p>
                        </div>
                    </a>
                @endforeach
                {{$data['tasks']->links()}}
            @endif
        </div>
    </section>
@stop
