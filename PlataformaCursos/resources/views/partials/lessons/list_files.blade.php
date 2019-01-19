<hr>
<div>
  <table class="table table-hover">
    <thead>
      <tr align="left">
        <th scope="col">{{ __('Titulo') }}</th>
        <th scope="col">{{ __('Descripción') }}</th>
        <th scope="col">{{ __('Tamaño') }}</th>
        <th scope="col">{{ __('Subido por') }}</th>
        <th scope="col">{{ __('Descargar') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
        @foreach($lesson->files->where('user_id', $user->id) as $file)
          <tr>
            <td>
              <a href="{{ $file->public_url }}" style="text-decoration: none; color: black;">
                {{ $file->titulo }}
              </a>
            </td>
            <td>{{ $file->descripcion }}</td>
            <td>{{ $file->sizeInKb }} KB</td>
            <td>
              @if($file->user->role_id == \App\Role::PROFESOR)
                <span class="badge badge-secondary">{{ __("Profesor") }}</span>
              @endif
              @if($file->user->role_id == \App\Role::ADMINISTRADOR)
                <span class="badge badge-success">{{ __("Admin") }}</span>
              @endif
              {{ $file->user->name }} {{ $file->user->lastName }}
            </td>
            <td align="center">
              <a  
                class="btn btn-primary" 
                href="{{ route('files.download', $file) }}"
              >
                <i class="fa fa-download"></i>
              </a>
            </td>
          </tr>
        @endforeach
      @endforeach
    </tbody>
  </table>
</div>