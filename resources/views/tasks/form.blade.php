<div class="mb-3">
    {{ Form::bsText('name', null, ['formName' => 'task']) }}
    {{ Form::bsTextarea('description', null, ['formName' => 'task']) }}
    {{ Form::bsSelect('status_id', $taskStatuses, null, ['formName' => 'task']) }}
    {{ Form::bsSelect('assigned_to_id', $users, null, ['formName' => 'task']) }}
    {{ Form::bsSelect('labels', $labels, $task->labels, ['formName' => 'task', 'multiple' => 'multiple']) }}
</div>