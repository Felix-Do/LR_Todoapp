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
            Create a new task:
            <br><br>
            <form action="{!! action('User\TasksController@store') !!}" method="post">
                {!! csrf_field() !!}
                Name:
                <input type="text" name="name" placeholder="enter a name" value="">
                Description:
                <input type="text" name="description" placeholder="description goes here">
                Due Date:
                <input type="date" name="duedate">
                Status: 
                <input type="radio" name="status" value=0 checked> Not Started
                <input type="radio" name="status" value=1> In Progress
                <input type="radio" name="status" value=2> Finished
                <br><br>
                Label: 
                <input type="radio" name="label" value=0 checked> No Label
                <input type="radio" name="label" value=1> Label 1
                <input type="radio" name="label" value=2> Label 2
                <input type="radio" name="label" value=3> Label 3
                <input type="radio" name="label" value=4> Label 4
                <input type="radio" name="label" value=5> Label 5
                <br><br>
                <button type="submit" class="btn btn-default">Create New Task</button>
            </form>
        </div>
    </section>
@stop
