@if(\DB::table('course_student')->where([
            ['student_id', $student['id']], 
            ['situacion', \App\Course::CURSANDO]
        ])->count() > 0)
    <h6><b>{{ __("Fecha de baja") }}</b>: {{ $deleted_at }}</h6>
	<br>
	<div class="row">
		<div class="col-md-3">
			<a href="{{ route('profile.restore_user', $id) }}" class="btn btn-success" style="color: white;">
			    <i class="fa fa-check"></i> {{ __("Activar") }}
			</a>
		</div>
		<div class="col-md-3">
			<form action="{{ route('admin.remove_status', $student['id']) }}" method="POST">
		        @csrf
		        @method('delete')
		        <button class="btn btn-danger" type="submit">
		          <i class="fa fa-close" style="color: white;"></i> {{ __("Baja definitiva") }}
		        </button>
		    </form>
		</div>
	</div>
@else
	<h6><b>{{ __("Baja definitiva") }}</b></h6>
@endif
