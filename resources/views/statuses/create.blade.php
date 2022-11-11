@extends('layouts.app')
@section('content')
{{ Form::model($taskStatus, ['route' => 'task_statuses.store']) }}
    @include('statuses.form')
    {{ Form::submit(__('buttons.create'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection