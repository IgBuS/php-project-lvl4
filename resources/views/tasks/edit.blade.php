@extends('layouts.app')
@section('content')
{{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
    @include('tasks.form')
    {{ Form::submit(__('buttons.refresh'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection