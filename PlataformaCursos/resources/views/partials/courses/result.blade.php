<div class="col-md-1">
	<table class="table">
		<thead>
			<tr align="center">
				<th scope="col">{{ $number }}</th>
	    	</tr>
		</thead>
		<tbody>
	  		@foreach($results->where('opportunity', $number) as $result)
				<tr>
					<td align="center">
						@if($result->answer == 1)
							<i 
								class="fa fa-check" 
								style="color: green; font-size: 20px;">
							</i>
						@else
							<i 
								class="fa fa-close" 
								style="color: red; font-size: 20px;">
							</i>
						@endif
					</td>
				</tr>
			@endforeach
  		</tbody>
	</table>
</div>

