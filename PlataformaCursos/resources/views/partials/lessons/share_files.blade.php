<br>
<form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-md-2" align="center">
      <div class="form-group">
        <div id="estilo-file">
          <img class="file-rounded" src="{{ asset('images/upload.png') }}">
          <input type="file" name="file" class="custom-file-input{{ $errors->has('file') ? ' is-invalid' : ''}}" id="file" required>
        </div> 
      </div>
    </div>
    <div class="col-md-7">
      <div class="form-group">
        <label for="titulo">{{ __("Titulo del archivo") }}</label>
        <input class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}"  type="text" name="titulo" placeholder="Titulo" required>
        @if($errors->has('titulo'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('titulo') }}</strong>
          </span>
        @endif
      </div>
      <div class="form-group">
        <label for="descripcion">{{ __("Descripción del archivo") }}</label>
        <input class="form-control{{ $errors->has('descripcion') ? ' is-invalid' : '' }}" type="text" name="descripcion" placeholder="Descripción del archivo" required>
        @if($errors->has('descripcion'))
          <span class="invalid-feedback">
            <strong>{{ $errors->first('descripcion') }}</strong>
          </span>
        @endif
      </div>
      <input type="hidden" name="lesson_id" value="{{ $lesson->id }}"/>
      <button type="submit" class="btn" style="background-color: #70299b; color: white;">
        <i class="fa fa-cloud-upload"></i> {{ ("Subir") }}
      </button>
    </div>
    <div class="col-md-3">
      <h5><b>{{ __("Requisitos") }}</b></h5>
      <ol>
        <li>{{ __("Tamaño máximo: 3 MB") }}</li>
        <li>{{ __("Archivos permitidos") }}</li>
        <ul>
          <li>.pdf</li>
          <li>.xls ó .xlsx</li>
          <li>.doc ó .docx</li>
          <li>.jpg ó .jpeg</li>
          <li>.png</li>
        </ul>
      </ol>
    </div>
  </div>
</form>
<br><hr><h5 align="center">{{ __("Material compartido por mí") }}</h5>
<div>
  <table class="table table-hover">
    <thead>
      <tr align="left">
        <th scope="col">{{ __('Titulo') }}</th>
        <th scope="col">{{ __('Extensión') }}</th>
        <th scope="col">{{ __('Tamaño') }}</th>
        <th scope="col">{{ __('Eliminar') }}</th>
      </tr>
    </thead>
    <tbody>
      @forelse($lesson->files->where('user_id', Auth::user()->id) as $file)
        <tr>
          <td>
            <a href="{{ $file->public_url }}" style="text-decoration: none; color: black;">
              {{ $file->titulo }}
            </a>
          </td>
          <td>{{ $file->extension }}</td>
          <td>{{ $file->sizeInKb }} KB</td>
          <td align="left">
            <!--<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#exampleModal">-->
            <!--  <i class="fa fa-trash" style="color: white;"></i>-->
            <!--</button>-->
            <form action="{{ route('files.destroy', $file) }}" method="POST">
                @csrf
                @method('delete')
                <button class="btn btn-danger" type="submit">
                  <i class="fa fa-trash" style="color: white;"></i>
                </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">
            <div class="alert alert-dark" role="alert" align="center">
              <i class="fa fa-exclamation"></i> {{ __("Aún no has subido material de apoyo") }}
            </div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>