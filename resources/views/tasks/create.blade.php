@extends('layouts.app')
@section('content')


{{ Form::model($task, ['route' => 'tasks.store']) }}
    @include('tasks.form')
    <div>
        <button type="submit" class="btn btn-primary">{{__('buttons.create')}}</button>
    </div>
{{ Form::close() }}
@endsection