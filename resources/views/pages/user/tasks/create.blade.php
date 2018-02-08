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
            <br>
            <a href="{{ action('User\TaskController@index') }}" class="btn btn-default">< Go Back</a>
            <br><br>
            Create a new task:
            <br><br>
            <form action="{!! action('User\TaskController@store') !!}" method="post">
                {!! csrf_field() !!}
                Name:
                <input type="text" name="name" placeholder="enter a name" id="input_name" autofocus value="{{$task->name}}">
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
                <button type="submit" class="btn btn-default">Create New Task</button>
            </form>
        </div>
    </section>
    <script>
        // auto select the input text name field
        document.getElementById('input_name').select();
    </script>
@stop
