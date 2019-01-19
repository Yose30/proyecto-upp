<div class="form-group row">
    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Tipo') }}</label>
    <div class="col-md-6">
        <select class="form-control" name="type" id="type">
            <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>Correcto</option>
            <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>Incorrecto</option>
        </select>
    </div>
</div>