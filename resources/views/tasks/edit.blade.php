@extends('layouts.app')
@section('content')
{{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
    @include('tasks.form')
    {{ Form::submit('Обновить') }}
{{ Form::close() }}
@endsection