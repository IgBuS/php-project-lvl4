@extends('layouts.app')


@section('content')
  @auth
    <a href="{{route('task_statuses.create')}}" class="btn btn-primary">Создать статус</a>

  @endauth
  <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Имя</th>
      <th scope="col">Дата создания</th>
      @auth
      <th scope="col">Действия</th>
      @endauth
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($taskStatuses as $status)
    <tr>
      <th scope="row">{{ $status->id }}</th>
        <td>
            <a class="link " href="/task_statuses/{{$status->id}}">{{ $status->name }}</a>
        </td>
      <td>{{ $status->created_at }}</td>
      @auth
      <td> 
      <form action="{{ route('task_statuses.destroy',$status->id) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="remove"> Удалить </button>
      </form>  
      <a href="{{route('task_statuses.edit', $status)}}">Редактировать</a></td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
{{ $taskStatuses->links() }}
@endsection