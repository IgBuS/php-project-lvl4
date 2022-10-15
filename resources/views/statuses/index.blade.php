@extends('layouts.app')


@section('content')

<h1>{{__('status.title')}}</h1>
  @auth
  <div class="mb-3">
    <a href="{{route('task_statuses.create')}}" class="btn btn-primary">{{__('buttons.create_status')}}</a>
  </div>

  @endauth
  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{__('status.id')}}</th>
      <th scope="col">{{__('status.name')}}</th>
      <th scope="col">{{__('status.creation_date')}}</th>
      @auth
      <th scope="col">{{__('status.actions')}}</th>
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

        <form action="{{ route('task_statuses.destroy',$taskStatus) }}" method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('{{__('warnings.sure')}}')"> {{__('buttons.delete')}} </button>
        </form>

        <form action="{{ route('task_statuses.edit',$taskStatus->id) }}" method="get">
          <button type="submit" class="btn btn-outline-info btn-sm"> {{__('buttons.edit')}} </button>
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