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
    <label for="name" name='name' class="form-label">{{__('status.name')}}</label>
    <input type="text" class="form-control" id="name" name="name" value="{{old('name', optional($taskStatus)->name)}}">
</div>