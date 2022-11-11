@php
    $sectionName = $attributes['formName'] ?? 'default';
@endphp
<div class="form-group">
    {{ Form::label($name, __("pages.forms.{$sectionName}.{$name}")) }}
    {{
        Form::text($name,$value,
            ['class' => ($errors->has($name)) ? 'form-control is-invalid' : 'form-control'])
    }}
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>