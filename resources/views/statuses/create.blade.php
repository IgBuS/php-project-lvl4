@extends('layouts.app')
@section('content')
{{ Form::model($status, ['route' => 'task_statuses.store']) }}
    @include('statuses.form')
{{ Form::submit('Сохранить') }}
{{ Form::close() }}
@endsection