<div align="center">
	<div class="card" style="width: 50rem;">
		<div class="card-body">
			<table class="table table-hover">
				<thead>
					<tr align="center">
						<th scope="col">N.</th>
						<th scope="col">{{ __("Lección") }}</th>
						@if($course->estado == \App\Course::PENDIENTE)
							<th scope="col">{{ __("Editar") }}</th>
						@endif
			    	</tr>
				</thead>
				<tbody>
					@forelse($course->lessons as $lesson)
						<tr>
							<td align="center">{{ $lesson->prioridad }}</td>
							<td>
								<a href="{{ route('lessons.details', $lesson->id) }}" style="text-decoration: none; color: black;">{{ $lesson->titulo }}</a>
							</td>
							@if($course->estado == \App\Course::PENDIENTE)
								<td align="center">
									<a href="{{ route('lessons.edit', $lesson->id) }}" class="btn btn-warning">
										<i class="fa fa-pencil"></i>
									</a>
								</td>
								
							@endif
					    </tr>
					@empty
						<tr>
	                        <td colspan="4">
	                        	<div class="alert alert-dark" role="alert" align="center">
									<i class="fa fa-exclamation"></i> {{ __("Este curso aún no tiene lecciones") }}
								</div>
	                        </td>
	                    </tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>