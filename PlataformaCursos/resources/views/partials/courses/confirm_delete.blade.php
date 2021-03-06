<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color: black;">{{ __("Eliminar curso") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" align="left">
        <p style="color: black;">¿ {{ __("Está seguro de eliminar este curso") }} ?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Cerrar") }}</button>
        <form action="{{ route('courses.delete', $course->id) }}" method="POST">
            @csrf
            @method('delete')
            <button class="btn btn-danger" type="submit">
              <i class="fa fa-trash" style="color: white;"></i> {{ __("Confirmar") }}
            </button>
        </form>
      </div>
    </div>
  </div>
</div>