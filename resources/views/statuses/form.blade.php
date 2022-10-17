<div class="mb-3">
    <label for="name" name='name' class="form-label">{{__('status.name')}}</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{old('name', optional($taskStatus)->name)}}">
    @error('name')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>