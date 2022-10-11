
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
    <input type="text" class="form-control" id="name" name="name" placeholder="Название метки" value="{{old('name', optional($label)->name)}}">
</div>

<div class="mb-3">
  <label for="description" class="form-label">{{ Form::label('description', 'Описание') }}</label>
  <textarea class="form-control" id="description" name="description" placeholder="Описание метки" rows="5">{{old('description', optional($label)->description)}}</textarea>
</div>
