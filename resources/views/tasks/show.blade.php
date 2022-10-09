@extends('layouts.app')


@section('content')

<h2>
  Просмотр задачи:
  <small class="text-muted">{{ $task->name }}</small>
</h2>

<p>Имя: {{ $task->name }}</p>
<p>Статус: {{ $task->status->name }}</p>
<p>Описание: {{ $task->description }}</p>

@endsection