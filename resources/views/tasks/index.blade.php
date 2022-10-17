@extends('layouts.app')


@section('content')

<h1>{{__('task.title')}}</h1>

<div class="mb-3">
<form method="GET" action="/tasks" accept-charset="UTF-8" class="">
<div class="form-row">

    <div class="col">
    <select class="form-select" id="filter[status_id]" name="filter[status_id]" aria-label="----------">
      <option value="" selected>{{__('task.status')}}</option>
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
      <option value="" selected>{{__('task.author')}}</option>
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
      <option value="" selected>{{__('task.assigned_to')}}</option>
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
        <input type="submit" class="btn btn-primary" value="{{__('buttons.execute')}}">
    </div>

    @auth
    <div class="ml-auto">
      <a href="{{route('tasks.create')}}" class="btn btn-primary">{{__('buttons.create_task')}}</a>
    </div>
  @endauth
    
</div>
</form>
</div>

<div class="mb-3">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{__('task.id')}}</th>
      <th scope="col">{{__('task.status')}}</th>
      <th scope="col">{{__('task.name')}}</th>
      <th scope="col">{{__('task.author')}}</th>
      <th scope="col">{{__('task.assigned_to')}}</th>
      <th scope="col">{{__('task.creation_date')}}</th>
      @auth
      <th scope="col">{{__('task.actions')}}</th>
      @endauth
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($tasks as $task)
    <tr>
      <td>{{ $task->id }}</td>
      <td>{{ $task->status->name }}</td>
      <td>
        <a class="link " href="/tasks/{{$task->id}}">{{ $task->name }}</a>
      </td>
      <td>{{ $task->createdBy->name }}</td>
      <td>{{ optional($task->assignedTo)->name }}</td>
      <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d.m.Y') }}</td>
      
      @auth
      <td>
      @if(Auth::id() == $task->createdBy->id)
        <div class="form-inline">
        <a class="btn btn-outline-danger btn-sm"
        href="{{ route('tasks.destroy', $task) }}"
        onclick="event.preventDefault();
        confirm('{{__('warnings.sure')}}');
        document.getElementById('delete-form-{{ $task->id }}').submit();">
        {{__('buttons.delete')}}
        </a>

        <form id="delete-form-{{ $task->id }}" action="{{ route('tasks.destroy',  $task) }}"
            method="POST" style="display: none;">
            @csrf
            @method('delete')
        </form>
      @endif
      <a class="btn btn-outline-info btn-sm"
        href="{{ route('tasks.edit',$task->id) }}">
        {{__('buttons.edit')}} </a>

        </div>
      </td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
</div>
{{ $tasks->links() }}
@endsection