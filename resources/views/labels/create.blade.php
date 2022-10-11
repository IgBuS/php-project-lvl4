@extends('layouts.app')
@section('content')


{{ Form::model($label, ['route' => 'labels.store']) }}
    @include('labels.form')
    <button type="submit" class="btn btn-primary">Сохранить</button>
{{ Form::close() }}
@endsection