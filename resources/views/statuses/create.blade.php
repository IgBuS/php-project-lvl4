@extends('layouts.app')
@section('content')
{{ Form::model($taskStatus, ['route' => 'task_statuses.store']) }}
    @include('statuses.form')
{{ Form::submit('Сохранить') }}
{{ Form::close() }}
@endsection