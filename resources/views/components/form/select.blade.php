@php
    use Illuminate\Support\Arr;
    $sectionName = $attributes['formName'] ?? 'default';
    $placeholder = __("pages.forms.placeholders.{$sectionName}.{$name}");
    $multiple = Arr::get($attributes, 'multiple','');
    $isMultiple = $multiple !== '';
@endphp

<div class="form-group">
    {{ Form::label($name, __("pages.forms.{$sectionName}.{$name}")) }}
    {{
        Form::select(
            $isMultiple === true ? "{$name}[]" : $name,
            $values,
            $value,
            ['class' => ($errors->has($name)) ? 'form-control is-invalid' : 'form-control', $multiple, 'placeholder' => $placeholder])
    }}
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>