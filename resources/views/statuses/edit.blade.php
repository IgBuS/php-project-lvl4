@extends('layouts.app')
@section('content')
{{ Form::model($status, ['route' => ['task_statuses.update', $status], 'method' => 'PATCH']) }}
    @include('statuses.form')
    {{ Form::submit('Обновить') }}
{{ Form::close() }}
@endsection