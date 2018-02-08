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
            {{--  @include("layouts.user.messages")  --}}
            <a href="{{ action('User\TaskController@index') }}" class="btn btn-default">< Go Back</a>
            <br><br>
            Edit this task:
            <br><br>
            <form action="{!! action('User\TaskController@update', $task->id) !!}" method="post">
                {!! csrf_field() !!}
                <input name="_method" type="hidden" value="PUT">
                Name:
                <input type="text" name="name" placeholder="enter a name" autofocus value="{{$task->name}}">
                @if(empty($task->name))
                    <div class="alert alert-danger">Please Enter a Name</div>
                @endif
                Description:
                <input type="text" name="description" placeholder="description goes here" value="{{$task->description}}">
                Due Date:
                <input type="date" name="duedate" value="{{$task->duedate}}">
                @if(empty($task->duedate))
                    <div class="alert alert-danger">Please Enter a Due Date</div>
                @endif
                Status: 
                @for ($i = 0; $i < $task->present()->statusCount; $i++)
                    <input type="radio" name="status" value={{$i}}
                        {{ $task->present()->statusCheck($i) }}
                    > {{ $task->present()->statusName($i) }}
                @endfor
                <br><br>
                Label: 
                @for ($i = 0; $i < $task->present()->labelCount; $i++)
                    <input type="radio" name="label" value={{$i}}
                        {{ $task->present()->labelCheck($i) }}
                    > {{ $task->present()->labelName($i) }}
                @endfor
                <br><br>
                <button type="submit" class="btn btn-default" name="actionBtn" value="update">Save This Task</button>
            </form>
            <div>
                <form action="{!! action('User\TaskController@destroy', $task->id) !!}" method="post">
                    {!! csrf_field() !!}
                    <input name="_method" type="hidden" value="DELETE">
                    <button type="submit" class="btn btn-default" name="actionBtn" value="delete">Delete This Task</button>
                </form>
            </div>
        </div>
    </section>
@stop
