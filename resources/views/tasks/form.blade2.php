@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label for="name" class="form-label">{{ Form::label('name', 'Имя') }}</label>
    {{ Form::text('name') }}
</div>

<div class="mb-3">
{{ Form::label('description', 'Описание') }}
{{ Form::text('description') }}
</div>

<div class="mb-3">
{{ Form::label('status_id', 'Статус') }}
{{ Form::select('status_id', $taskStatuses, '----------')}}
</div>

<div class="mb-3">
{{ Form::label('assigned_to_id', 'Исполнитель') }}
{{ Form::select('assigned_to_id', $users, '----------')}}
</div>
