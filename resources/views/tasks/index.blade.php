@extends('layouts.app')


@section('content')
  @auth
    <a href="{{route('tasks.create')}}" class="btn btn-primary">Создать задачу</a>

  @endauth
  <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Статус</th>
      <th scope="col">Имя</th>
      <th scope="col">Автор</th>
      <th scope="col">Исполнитель</th>
      <th scope="col">Дата создания</th>
      @auth
      <th scope="col">Действия</th>
      @endauth
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($tasks as $task)
    <tr>
      <th scope="row">{{ $task->id }}</th>
      <td>{{ $task->status->name }}</td>
      <td>
        <a class="link " href="/tasks/{{$task->id}}">{{ $task->name }}</a>
      </td>
      <td>{{ $task->created_by->name }}</td>
      <td>{{ optional($task->assigned_to)->name }}</td>
      <td>{{ $task->created_at }}</td>
      
      @auth
      <td> 
      <a href="{{route('tasks.edit', $task->id)}}">Редактировать</a></td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
{{ $tasks->links() }}
@endsection