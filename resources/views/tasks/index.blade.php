@extends('layouts.app')


@section('content')

<div class="mb-3">
<form method="GET" action="/tasks" accept-charset="UTF-8" class="">
<div class="form-row">

    <div class="col">
    <select class="form-select" id="filter[status_id]" name="filter[status_id]" aria-label="----------">
      <option value="" selected>Статус</option>
      @foreach ($taskStatuses as $status)
          @if($status->id == optional(request()->query('filter'))['status_id'])
              <option value="{{$status->id}}"selected>{{$status->name}} </option>
          @else
              <option value="{{$status->id}}">{{$status->name}}</option>
          @endif
      @endforeach
    </select>
    </div>

    <div class="col">
    <select class="form-select" id="filter[created_by_id]" name="filter[created_by_id]" aria-label="----------" >
      <option value="" selected>Автор</option>
      @foreach ($authors as $user)
          @if($user->id == optional(request()->query('filter'))['created_by_id'])
              <option value="{{$user->id}}"selected>{{$user->name}} </option>
          @else
              <option value="{{$user->id}}">{{$user->name}}</option>
          @endif
      @endforeach
    </select>
    </div>

    <div class="col">
    <select class="form-select" id="filter[assigned_to_id]" name="filter[assigned_to_id]" aria-label="----------" >
      <option value="" selected>Исполнитель</option>
      @foreach ($pespPersona as $user)
          @if($user->id == optional(request()->query('filter'))['assigned_to_id'])
              <option value="{{$user->id}}"selected>{{$user->name}} </option>
          @else
              <option value="{{$user->id}}">{{$user->name}}</option>
          @endif
      @endforeach
    </select>
    </div>

    <div class="col">
        <input type="submit" class="btn btn-primary" value="Применить">
    </div>

    @auth
    <div class="ml-auto">
      <a href="{{route('tasks.create')}}" class="btn btn-primary">Создать задачу</a>
    </div>
  @endauth
    
</div>
</form>
</div>

<div class="mb-3">
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
      <td>{{ $task->createdBy->name }}</td>
      <td>{{ optional($task->assignedTo)->name }}</td>
      <td>{{ $task->created_at }}</td>
      
      @auth
      <td> 
      <a href="{{route('tasks.edit', $task->id)}}">Редактировать</a></td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
</div>
{{ $tasks->links() }}
@endsection