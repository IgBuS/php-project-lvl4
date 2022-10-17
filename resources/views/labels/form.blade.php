<div class="mb-3">
    <label for="name" name='name' class="form-label">{{__('label.name')}}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', optional($label)->name)}}">
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>

<div class="mb-3">
  <label for="description" class="form-label">{{ Form::label('description', __('label.description')) }}</label>
  <textarea class="form-control" id="description" name="description" rows="5">{{old('description', optional($label)->description)}}</textarea>
</div>
