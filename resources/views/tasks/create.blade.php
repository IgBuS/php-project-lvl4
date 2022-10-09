@extends('layouts.app')
@section('content')


{{ Form::model($task, ['route' => 'tasks.store']) }}
    @include('tasks.form')
    <button type="submit" class="btn btn-primary">Сохранить</button>
{{ Form::close() }}
@endsection