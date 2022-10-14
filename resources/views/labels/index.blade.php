@extends('layouts.app')


@section('content')
  @auth
  <div class="mb-3">
    <a href="{{route('labels.create')}}" class="btn btn-primary">Создать метку</a>
  </div>
  @endauth
  <table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Имя</th>
      <th scope="col">Описание</th>
      <th scope="col">Дата создания</th>
      @auth
      <th scope="col">Действия</th>
      @endauth
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($labels as $label)
    <tr>
      <th scope="row">{{ $label->id }}</th>
      <td>
        <a class="link " href="/labels/{{$label->id}}">{{ $label->name }}</a>
      </td>
      <td>{{ $label->description }}</td>
      <td>{{ $label->created_at }}</td>
      
      @auth
      <td> 
      <div class="form-inline">

        <form action="{{ route('labels.destroy',$label) }}" method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')"> Удалить </button>
        </form>

        <form action="{{ route('labels.edit',$label->id) }}" method="get">
          <button type="submit" class="btn btn-outline-info btn-sm"> Редактировать </button>
        </form>

      </div>
    </td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
{{ $labels->links() }}
@endsection