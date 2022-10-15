@extends('layouts.app')
@section('content')
{{ Form::model($taskStatus, ['route' => ['task_statuses.update', $taskStatus], 'method' => 'PATCH']) }}
    @include('statuses.form')
    <button type="submit" class="btn btn-primary">{{__('buttons.refresh')}}</button>
{{ Form::close() }}
@endsection