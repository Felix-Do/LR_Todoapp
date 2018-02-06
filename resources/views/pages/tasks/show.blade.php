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
            <a href="/tasks" class="btn btn-default">GoBack</a>
            <br>
            <h1>{{$task->name}}</h1>
            <p>{{$task->description}}</p>
            <p>DueDate: {{$task->duedate}}</p>
            <p>Status: {{$task->status}}</p>
            <p>Label: {{$task->label}}</p>
        </div>
    </section>
@stop
