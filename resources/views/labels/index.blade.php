@extends('layouts.app')


@section('content')
<h1>{{__('label.title')}}</h1>
  @auth
  <div class="mb-3">
    <a href="{{route('labels.create')}}" class="btn btn-primary">{{__('buttons.create_label')}}</a>
  </div>
  @endauth
  <table class="table">
  <thead>
    <tr>
      <th scope="col">{{__('label.id')}}</th>
      <th scope="col">{{__('label.name')}}</th>
      <th scope="col">{{__('label.description')}}</th>
      <th scope="col">{{__('label.creation_date')}}</th>
      @auth
      <th scope="col">{{__('label.actions')}}</th>
      @endauth
      
      
    </tr>
  </thead>
  <tbody>
    @foreach ($labels as $label)
    <tr>
      <th scope="row">{{ $label->id }}</th>
      <td>{{ $label->name }}</td>
      <td>{{ $label->description }}</td>
      <td>{{ $label->created_at }}</td>
      
      @auth
      <td> 
      <div class="form-inline">

        <form action="{{ route('labels.destroy',$label) }}" method="post">
          @csrf
          @method('delete')
          <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('{{__('warnings.sure')}}')"> {{__('buttons.delete')}} </button>
        </form>

        <form action="{{ route('labels.edit',$label->id) }}" method="get">
          <button type="submit" class="btn btn-outline-info btn-sm"> {{__('buttons.edit')}} </button>
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