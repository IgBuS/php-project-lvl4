
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
    <label for="name" name='name' class="form-label">Имя</label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Краткое название задачи" value="{{old('name', optional($task)->name)}}">
</div>

<div class="mb-3">
  <label for="description" class="form-label">{{ Form::label('description', 'Описание') }}</label>
  <textarea class="form-control" id="description" name="description" placeholder="Описание сути задачи" rows="5">{{old('description', optional($task)->description)}}</textarea>
</div>

<div class="mb-3">
<label for="status_id" class="form-label">{{ Form::label('status_id', 'Статус') }}</label>
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
<label for="assigned_to_id" class="form-label">{{ Form::label('assigned_to_id', 'Исполнитель') }}</label>
<select class="form-select" id="assigned_to_id" name="assigned_to_id" aria-label="----------" >
    <option value="" selected disabled>----------</option>
    @foreach ($users as $user)
        @if($user->id == old('assigned_to_id', optional($task->assigned_to)->id))
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
        @if(in_array($label->id, old('labels', optional($task)->labels_ids())))
            <option value="{{$label->id}}"selected>{{$label->name}} </option>
        @else
            <option value="{{$label->id}}">{{$label->name}}</option>
        @endif
    @endforeach
</select>
</div>