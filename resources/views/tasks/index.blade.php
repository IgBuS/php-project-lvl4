@extends('layouts.app')


@section('content')

<h1>{{__('pages.task.title')}}</h1>

<div class="mb-3">
<div class="d-flex">
{{ Form::open(['url' => route('tasks.index'), 'method' => 'get', 'class' => 'form-inline']) }}
{{ Form::select('filter[status_id]', $taskStatuses, Arr::get($filter, 'status_id', ''), [
  'class' => 'form-control mr-2',
  'placeholder' => __('pages.task.status_id')
  ]) }}
{{ Form::select('filter[created_by_id]', $authors, Arr::get($filter, 'created_by_id', ''), [
  'class' => 'form-control mr-2',
  'placeholder' => __('pages.task.author')
  ]) }}
{{ Form::select('filter[assigned_to_id]', $pespPerson, Arr::get($filter, 'assigned_to_id', ''), [
  'class' => 'form-control mr-2',
  'placeholder' => __('pages.task.assigned_to_id')
  ]) }}

  {{ Form::submit(__('buttons.execute'), ['class' => 'btn btn-outline-primary mr-2']) }}
  {{ Form::close() }}

    @auth
    <div class="ml-auto">
      <a href="{{route('tasks.create')}}" class="btn btn-primary">{{__('buttons.create_task')}}</a>
    </div>
  @endauth
    
</div>
</div>

<div class="mb-3">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{__('pages.task.id')}}</th>
      <th scope="col">{{__('pages.task.status_id')}}</th>
      <th scope="col">{{__('pages.task.name')}}</th>
      <th scope="col">{{__('pages.task.author')}}</th>
      <th scope="col">{{__('pages.task.assigned_to_id')}}</th>
      <th scope="col">{{__('pages.task.creation_date')}}</th>
      @auth
      <th scope="col">{{__('pages.task.actions')}}</th>
      @endauth
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($tasks as $task)
    <tr>
      <td>{{ $task->id }}</td>
      <td>{{ $task->status->name }}</td>
      <td>
        <a class="link " href="{{route('tasks.show', $task)}}">{{ $task->name }}</a>
      </td>
      <td>{{ $task->createdBy->name }}</td>
      <td>{{ optional($task->assignedTo)->name }}</td>
      <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d.m.Y') }}</td>
      
      @auth
      <td>
      @if(Auth::id() == $task->createdBy->id)
        <div class="form-inline">
        <a class="btn btn-outline-danger btn-sm mr-3"
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