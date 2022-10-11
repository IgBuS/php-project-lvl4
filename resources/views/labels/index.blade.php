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
      <form action="{{ route('labels.destroy',$label) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger"> Удалить </button>
      </form>  

      <a href="{{route('labels.edit', $label->id)}}">Редактировать</a>
    </td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
{{ $labels->links() }}
@endsection