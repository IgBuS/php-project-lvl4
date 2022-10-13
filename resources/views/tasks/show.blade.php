@extends('layouts.app')


@section('content')

<h2>
  Просмотр задачи:
  <small class="text-muted">{{ $task->name }}</small>
</h2>

<div class="mb-3">
<p>Имя: {{ $task->name }}</p>
<p>Статус: {{ $task->status->name }}</p>
<p>Описание: {{ $task->description }}</p>
<p>Метки:
@foreach ($task->labelsNames() as $name)
<span class="badge badge-info">{{$name}}</span>
@endforeach
</p>
</div>
@endsection