<div class="modal fade" id="modal-inf" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
    	<div class="modal-content">
      		<div class="modal-header">
        		<h5 class="modal-title"><b>{{ __("Información") }}</b></h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      		</div>
      		<div class="modal-body">
        		<h6><b>{{ __("Nombre") }}</b>: <p id="nombre"></p></h6>
        		<h6><b>{{ __("Carrera") }}</b>: <p id="carrera"></p></h6>
        		<h6><b>{{ __("Correo electrónico") }}</b>: <p id="email"></p></h6>
            <h6><b>{{ __("Domicilio") }}</b>: <p id="domicilio"></p></h6>
            <h6><b>{{ __("Teléfono") }}</b>: <p id="telefono"></p></h6>
        		<hr>
    				<h6><b>{{ __("Fecha de registro") }}</b></h6>
    				<h6 id="fecha"></h6>
    				<div id="modal-form"></div>
      		</div>
      		<div class="modal-footer">
      			<div id="respuesta"></div>
    				<button type="button" class="btn btn-success" id="btn-aprobar">
    					<i class="fa fa-check"></i> {{ __("Aprobar") }}
    				</button>
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Cerrar") }}</button>
      		</div>
    	</div>
  	</div>
</div>