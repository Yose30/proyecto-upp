@foreach($users as $user)
	@foreach($conversations->where('user_id', $user->id) as $conversation)
		<a href="{{ route('conversations.chat_teacher', $conversation->user->id) }}" style="text-decoration: none; color: black;" >
			<li class="list-group-item">
		    	<div class="row">
		    		<div class="col-md-2">
		    			<img 
						    style="width:30px; height:30px; border-radius:150px;"  
						    src="{{ $conversation->user->pathAttachment() }}" alt="{{ $conversation->user->name }}"
					    >
		    		</div>
		    		<div class="col-md-10">
		    			{{ $conversation->user->name }} {{ $conversation->user->lastName }}   
						@if($conversation->user->role_id == \App\Role::ADMINISTRADOR)
							<span class="badge badge-success">{{ __("Admin") }}</span>
			    		@else
							<span class="badge badge-primary">{{ __("Estudiante") }}</span>
			    		@endif
		    		</div>
		    	</div>
		    </li>
		</a>
	@endforeach
@endforeach 