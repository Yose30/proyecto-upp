<style type="text/css">
	.estilo > a i {background-color: transparent; color: #a3a3a3; font-size: 18px;}
</style>

@cannot('inscribe', $course)
<br><br>
<div class="card">
	<div class="card-header" style="background-color: #70299b; color: white;">
		<h5 class="card-title">{{ __('Lecciones del curso') }}</h5>
	</div>
	<div class="card-body">
		<table class="table table-hover">
			<thead>
				<tr align="center">
					<th scope="col"></th>
		      		<th scope="col"></th>
		    	</tr>
			</thead>
			<tbody>
		  		@foreach($course->lessons as $lesson)
				<tr>
					@forelse($lesson->advances->where('student_id', Auth::user()->student->id) as $advance)
						@if($advance->estado == \App\Lesson::CONCLUIDO)
							<td align="right">
								<i 
					    			class="fa fa-check-circle" 
					    			style="color: green; font-size: 20px;">
					    		</i> {{ $lesson->prioridad }}.
					    	</td>

				    	@else
							<td align="right">
					    		<i 
					    			class="fa fa-circle-thin" 
					    			style="color: #b5b5b5; font-size: 20px;">
					    		</i> {{ $lesson->prioridad }}.
					    	</td>
				    	@endif
				    	<td>
				    		<a 
				    			href="{{ route('lessons.lesson', $lesson->id) }}" 
				    			style="text-decoration: none; color: black;"
				    		>
				    			{{ $lesson->titulo }}
				    		</a>
				    	</td>
			    	@empty
				    	<td align="right">
				    		<i 
				    			class="fa fa-circle-thin" 
				    			style="color: #b5b5b5; font-size: 20px;">
				    		</i> {{ $lesson->prioridad }}.
				    	</td>
				    	@if($lesson->prioridad == 1)
							<td>
					    		<a 
					    			href="{{ route('lessons.lesson', $lesson->id) }}" 
					    			style="text-decoration: none; color: black;"
					    		>
					    			{{ $lesson->titulo }}
					    		</a>
					    	</td>
					    @else
					    	<td>
					    		<a style="text-decoration: none; color: black;">
					    			{{ $lesson->titulo }}
					    		</a>
					    	</td>
					    @endif
		    		@endforelse
				</tr>
				@endforeach
	  		</tbody>
		</table>
	</div>
</div>

@endcannot