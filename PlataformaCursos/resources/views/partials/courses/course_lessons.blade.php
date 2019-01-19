<div class="card">
	<div class="card-body">
		<div class="row">
			<div class="col-md-9">
				<table class="table table-hover">
					<thead>
						<tr align="center">
							<th scope="col">N.</th>
							<th scope="col">{{ __("Lección") }}</th>
				    	</tr>
					</thead>
					<tbody>
						@foreach($course->lessons as $lesson)
							<tr>
								<td>{{ $lesson->prioridad }}</td>
								@if(((100 / $course->lessons_count) * ($correctas->where('opportunity', 1)->count())) > 79)
									<td>{{ $lesson->titulo }}</td>
								@else
									@if(((100 / $course->lessons_count) * ($correctas->where('opportunity', 2)->count())) <= 79 && $results->where('opportunity', 2)->count() == $course->lessons_count)
								    	@if($results->where('opportunity', 3)->count() == $course->lessons_count)
								    		<td>{{ $lesson->titulo }}</td>
								    	@else
								    		<td>
									    		<a href="{{ route('courses.question', [$lesson->id, 3]) }}" style="text-decoration: none; color: black;">
									    			{{ $lesson->titulo }}
									    		</a> 
									    	</td>
								    	@endif
								    @else
								    	@if($results->where('opportunity', 2)->count() == $course->lessons_count)
								    		<td>{{ $lesson->titulo }}</td>
								    	@else
								    		<td>
									    		<a href="{{ route('courses.question', [$lesson->id, 2]) }}" style="text-decoration: none; color: black;">
									    			{{ $lesson->titulo }}
									    		</a>
									    	</td>
								    	@endif
								    @endif	
								@endif
						    </tr>
						@endforeach
					</tbody>
				</table>
			</div>
			@include('partials.courses.result', ['number' => 1])
			@include('partials.courses.result', ['number' => 2])
			@include('partials.courses.result', ['number' => 3])
		</div>
	</div>
</div>