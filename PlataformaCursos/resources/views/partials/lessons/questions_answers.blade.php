<div align="center">
	<div class="card" style="width: 50rem;">
		<div class="card-body">
			@if($lesson->course->estado == \App\Course::PENDIENTE)
				<table class="table table-hover">
					<thead>
						<tr align="center">
							<th scope="col">{{ __("Pregunta") }}</th>
							<th scope="col">{{ __("¿Respuestas creadas?") }}</th>
				    	</tr>
					</thead>
					<tbody>
						@foreach($lesson->questions as $question)
							<tr>
								<td>
									<a href="{{ route('lessons.answers', $question->id) }}" style="text-decoration: none; color: black;">{{ $question->question }}</a>
								</td>
								<td align="center">
									@if($question->answers->count() > 0)
										<i class="fa fa-check" style="color: green; font-size: 20px;"></i>
									@else
										<i class="fa fa-close" style="color: red; font-size: 20px;"></i>
									@endif
								</td>
						    </tr>
						@endforeach
					</tbody>
				</table>
			@else
				<table class="table table-hover">
					<thead>
						<tr align="center">
							<th scope="col">{{ __("Pregunta") }}</th>
							<th scope="col">{{ __("Respuestas") }}</th>
				    	</tr>
					</thead>
					<tbody>
						@foreach($lesson->questions as $question)
							<tr>
								<td>{{ $question->question }}</td>
								<td>
									@foreach($question->answers as $answer)
										@if($answer->type == \App\Result::CORRECTO)
											<i class="fa fa-check" style="color: green; font-size: 20px;"></i>
										@else
											<i class="fa fa-close" style="color: red; font-size: 20px;"></i>
										@endif
										{{ $answer->answer }}<br>
									@endforeach
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>				
			@endif
		</div>
	</div>
</div>