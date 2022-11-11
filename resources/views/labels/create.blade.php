@extends('layouts.app')
@section('content')


{{ Form::model($label, ['route' => 'labels.store']) }}
    @include('labels.form')
    {{ Form::submit(__('buttons.create'), ['class' => 'btn btn-primary']) }}
{{ Form::close() }}
@endsection