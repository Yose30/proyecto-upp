<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ __("Dar de baja usuario") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿ {{ __("Esta seguro de dar de baja a este usuario") }} ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Cerrar") }}</button>
        <form action="{{ route('profile.destroy_user', $user->id) }}" method="POST">
            @csrf
            @method('delete')
            <button class="btn btn-danger" type="submit">
              <i class="fa fa-close" style="color: white;"></i> {{ __("Confirmar") }}
            </button>
        </form>
      </div>
    </div>
  </div>
</div>