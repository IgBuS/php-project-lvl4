@extends('layouts.app')
@section('content')
{{ Form::model($task, ['route' => ['tasks.update', $task], 'method' => 'PATCH']) }}
    @include('tasks.form')
    <button type="submit" class="btn btn-primary">Обновить</button>
{{ Form::close() }}
@endsection