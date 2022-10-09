@extends('layouts.app')
@section('content')
{{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
    @include('statuses.form')
    {{ Form::submit('Обновить') }}
{{ Form::close() }}
@endsection