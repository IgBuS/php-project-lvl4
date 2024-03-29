@extends('layouts.app')


@section('content')
<h1>{{__('pages.label.title')}}</h1>
  @auth
  <div class="mb-3">
    <a href="{{route('labels.create')}}" class="btn btn-primary">{{__('buttons.create_label')}}</a>
  </div>
  @endauth
  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{__('pages.label.id')}}</th>
      <th scope="col">{{__('pages.label.name')}}</th>
      <th scope="col">{{__('pages.label.description')}}</th>
      <th scope="col">{{__('pages.label.creation_date')}}</th>
      @auth
      <th scope="col">{{__('pages.label.actions')}}</th>
      @endauth
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($labels as $label)
    <tr>
      <td>{{ $label->id }}</td>
      <td>{{ $label->name }}</td>
      <td>{{ $label->description }}</td>
      <td>{{\Carbon\Carbon::parse($label->created_at)->format('d.m.Y') }}</td>
      
      @auth
      <td> 
      <div class="form-inline">

      <a class="btn btn-outline-danger btn-sm mr-3"
        href="{{ route('labels.destroy', $label) }}"
        onclick="event.preventDefault();
        confirm('{{__('warnings.sure')}}');
        document.getElementById('delete-form-{{ $label->id }}').submit();">
        {{__('buttons.delete')}}
      </a>

      <form id="delete-form-{{ $label->id }}" action="{{ route('labels.destroy',  $label) }}"
          method="POST" style="display: none;">
          @csrf
          @method('delete')
      </form>

      <a class="btn btn-outline-info btn-sm"
        href="{{ route('labels.edit',$label->id) }}">
        {{__('buttons.edit')}} </a>

      </div>
    </td>
      @endauth
    </tr>
    @endforeach
  </tbody>
</table>
{{ $labels->links() }}
@endsection