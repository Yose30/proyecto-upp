<div class="modal fade" id="appModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>{{ __("Lección terminada") }}</h5>
        <h5>
          <i class="fa fa-check" style="color: #10d331;"></i>
          <b> {{ $lesson->titulo }}</b>
        </h5>
        <br>
      </div>
      <div class="modal-footer">
        @if($advance > 0)
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            {{ __("Cerrar") }}
          </button>
        @else
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            {{ __("Permanecer aqui") }}
          </button>
          <a 
            href="{{ route('lessons.question', $lesson->id) }}" 
            type="button" 
            class="btn" 
            style="background-color: #70299b; color: white;"
          >
            {{ __("Continuar") }}
          </a>
        @endif
      </div>
    </div>
  </div>
</div>