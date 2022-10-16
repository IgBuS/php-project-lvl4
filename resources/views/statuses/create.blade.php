@extends('layouts.app')
@section('content')
{{ Form::model($taskStatus, ['route' => 'task_statuses.store']) }}
    @include('statuses.form')
    <button type="submit" class="btn btn-primary">{{__('buttons.create')}}</button>
{{ Form::close() }}
@endsection