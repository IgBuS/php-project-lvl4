@extends('layouts.app')
@section('content')
{{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
    @include('statuses.form')
    {{ Form::submit(__('buttons.refresh'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection