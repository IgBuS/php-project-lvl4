@extends('layouts.app')
@section('content')
{{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH']) }}
    @include('labels.form')
    {{ Form::submit(__('buttons.refresh'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection