@extends('layouts.app')


@section('content')
  @auth
  <div class="mb-3">
    <a href="{{route('task_statuses.create')}}" class="btn btn-primary">Создать статус</a>
  </div>

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
    @foreach ($taskStatuses as $taskStatus)
    <tr>
      <th scope="row">{{ $taskStatus->id }}</th>
        <td>
            <a class="link " href="/task_statuses/{{$taskStatus->id}}">{{ $taskStatus->name }}</a>
        </td>
      <td>{{ $taskStatus->created_at }}</td>
      @auth
      <td> 
      <div class="form-inline">

        <form action="{{ route('task_statuses.destroy',$taskStatus->id) }}" method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-outline-danger btn-sm"> Удалить </button>
        </form>

        <form action="{{ route('task_statuses.edit',$taskStatus->id) }}" method="get">
          <button type="submit" class="btn btn-outline-info btn-sm"> Редактировать </button>
        </form>

      </div>
    </td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
{{ $taskStatuses->links() }}
@endsection