@extends('layouts.app')
@section('content')
{{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH']) }}
    @include('labels.form')
    <button type="submit" class="btn btn-primary">{{__('buttons.refresh')}}</button>
{{ Form::close() }}
@endsection