
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="name" name='name' class="form-label">{{__('task.name')}}</label>
    <input type="text" class="form-control" id="name" name="name" value="{{old('name', optional($task)->name)}}">
</div>

<div class="mb-3">
  <label for="description" class="form-label">{{ Form::label('description', __('task.description')) }}</label>
  <textarea class="form-control" id="description" name="description" rows="5">{{old('description', optional($task)->description)}}</textarea>
</div>

<div class="mb-3">
<label for="status_id" class="form-label">{{ Form::label('status_id', __('task.status')) }}</label>
<select class="form-select" id="status_id" name="status_id" aria-label="----------">
    <option value="" selected disabled>----------</option>
    @foreach ($taskStatuses as $status)
        @if($status->id == old('status_id', optional($task->status)->id))
            <option value="{{$status->id}}"selected>{{$status->name}} </option>
        @else
            <option value="{{$status->id}}">{{$status->name}}</option>
        @endif
    @endforeach
</select>
</div>

<div class="mb-3">
<label for="assigned_to_id" class="form-label">{{ Form::label('assigned_to_id', __('task.assigned_to')) }}</label>
<select class="form-select" id="assigned_to_id" name="assigned_to_id" aria-label="----------" >
    <option value="" selected disabled>----------</option>
    @foreach ($users as $user)
        @if($user->id == old('assigned_to_id', optional($task->assignedTo)->id))
            <option value="{{$user->id}}"selected>{{$user->name}} </option>
        @else
            <option value="{{$user->id}}">{{$user->name}}</option>
        @endif
    @endforeach
</select>
</div>

<div class="mb-3">
<select multiple="multiple" name="labels[]" class="form-select" id="labels">
    @foreach ($labels as $label)
        @if(in_array($label->id, old('labels', optional($task)->labelsIds())))
            <option value="{{$label->id}}"selected>{{$label->name}} </option>
        @else
            <option value="{{$label->id}}">{{$label->name}}</option>
        @endif
    @endforeach
</select>
</div>