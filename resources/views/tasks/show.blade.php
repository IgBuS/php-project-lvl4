@extends('layouts.app')


@section('content')

<h2>
  Просмотр задачи:
  <small class="text-muted">{{ $task->name }}</small>
</h2>

<div class="mb-3">
<p>{{__('pages.task.name')}}: {{ $task->name }}</p>
<p>{{__('pages.task.status_id')}}: {{ $task->status->name }}</p>
<p>{{__('pages.task.description')}}: {{ $task->description }}</p>
<p>{{__('pages.task.labels')}}:
@foreach ($task->labelsNames() as $name)
<span class="badge badge-info">{{$name}}</span>
@endforeach
</p>
</div>
@endsection