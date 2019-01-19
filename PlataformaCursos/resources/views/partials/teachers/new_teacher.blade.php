<div class="modal fade" id="new_teacher" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">{{ __("Nuevo formador") }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row justify-content-center">
          <form id="form_new_teacher">
            <div class="form-group row">
              <label for="nameu" class="col-md-3 col-form-label text-md-right">{{ __("Nombre") }}</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="nameu">
              </div>
            </div>
            <div class="form-group row">
              <label for="lastname" class="col-md-3 col-form-label text-md-right">{{ __("Apellidos") }}</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="lastname">
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-md-3 col-form-label text-md-right">{{ __("Correo") }}</label>
              <div class="col-md-9">
                <input type="email" class="form-control" name="email">
              </div>
            </div>
            <div class="form-group row">
              <label for="profesion" class="col-md-3 col-form-label text-md-right">{{ __("Profesión") }}</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="profesion">
              </div>
            </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="button" class="btn" id="btn-guardar" style="background-color: #70299b; color: white;"><i class="fa fa-check"></i> {{ __('Guardar') }}
                </button><br><br>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <div id="res-correcta" class="alert alert-success" style="display: none;">
          <i class="fa fa-check"></i> {{ __("Datos guardados") }}!!
        </div>
        <div id="res-validate" class="alert alert-danger" style="display: none;">
          <i class="fa fa-close"></i> {{ __("Ocurrió un error al guardar, verifica los datos y vuelve a intentar") }}
        </div>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Cerrar") }}</button>
      </div>
    </div>
  </div>
</div>