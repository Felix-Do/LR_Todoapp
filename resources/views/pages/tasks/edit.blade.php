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
            @include("inc.messages")
            <a href="/tasks" class="btn btn-default">< Go Back</a>
            <br><br>
            Edit this task:
            <br><br>
            <form action="{!! action('User\TasksController@update', $task->id) !!}" method="post">
                {!! csrf_field() !!}
                <input name="_method" type="hidden" value="PUT">
                Name:
                <input type="text" name="name" placeholder="enter a name" value="{{$task->name}}">
                Description:
                <input type="text" name="description" placeholder="description goes here" value="{{$task->description}}">
                Due Date:
                <input type="date" name="duedate" value="{{$task->duedate}}">
                Status: 
                <input type="radio" name="status" value=0 
                    @if($task->status == 0)
                        checked
                    @endif
                > Not Started
                <input type="radio" name="status" value=1 
                    @if($task->status == 1)
                        checked
                    @endif
                > In Progress
                <input type="radio" name="status" value=2 
                    @if($task->status == 2)
                        checked
                    @endif
                > Finished
                <br><br>
                Label: 
                <input type="radio" name="label" value=0 
                    @if($task->label==0)
                        checked
                    @endif
                > No Label
                <input type="radio" name="label" value=1 
                    @if($task->label==1)
                        checked
                    @endif
                > Label 1
                <input type="radio" name="label" value=2 
                    @if($task->label==2)
                        checked
                    @endif
                > Label 2
                <input type="radio" name="label" value=3 
                    @if($task->label==3)
                        checked
                    @endif
                > Label 3
                <input type="radio" name="label" value=4 
                    @if($task->label==4)
                        checked
                    @endif
                > Label 4
                <input type="radio" name="label" value=5 
                    @if($task->label==5)
                        checked
                    @endif
                > Label 5
                <br><br>
                <button type="submit" class="btn btn-default" name="actionBtn" value="update">Save This Task</button>
                <button type="submit" class="btn btn-default" name="actionBtn" value="delete">Delete This Task</button>
            </form>
        </div>
    </section>
@stop