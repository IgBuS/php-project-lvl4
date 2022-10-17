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
      <td>{{ $taskStatus->id }}</td>
      <td>{{ $taskStatus->name }}</td>
      <td>{{\Carbon\Carbon::parse($taskStatus->created_at)->format('d.m.Y') }}</td>
      @auth
      <td> 
      <div class="form-inline">

      <a class="btn btn-outline-danger btn-sm"
        href="{{ route('task_statuses.destroy', $taskStatus) }}"
        onclick="event.preventDefault();
        confirm('{{__('warnings.sure')}}');
        document.getElementById('delete-form-{{ $taskStatus->id }}').submit();">
        {{__('buttons.delete')}}
      </a>

      <form id="delete-form-{{ $taskStatus->id }}" action="{{ route('task_statuses.destroy',  $taskStatus) }}"
          method="POST" style="display: none;">
          @csrf
          @method('delete')
      </form>

      <a class="btn btn-outline-info btn-sm"
        href="{{ route('task_statuses.edit',$taskStatus->id) }}">
        {{__('buttons.edit')}} </a>

      </div>
    </td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
{{ $taskStatuses->links() }}
@endsection