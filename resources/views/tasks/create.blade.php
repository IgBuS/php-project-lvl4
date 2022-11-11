@extends('layouts.app')
@section('content')


{{ Form::model($task, ['route' => 'tasks.store']) }}
    @include('tasks.form')
    {{ Form::submit(__('buttons.create'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection