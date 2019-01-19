@foreach($users as $user)
    @foreach($conversations->where('teacher_id', $user->teacher->id) as $conversation)
        <a href="{{ route('conversations.chat_student', $conversation->teacher->id) }}" style="text-decoration: none; color: black;" >
        	<li class="list-group-item">
            	<div class="row">
            		<div class="col-md-2">
            			<img 
        				    style="width:30px; height:30px; border-radius:150px;"  
        				    src="{{ $user->pathAttachment() }}" alt="{{ $user->name }}"
        			    >
            		</div>
            		<div class="col-md-10">{{ $user->name }} {{ $user->lastName }}</div>
            	</div>
            </li>
        </a>
    @endforeach
@endforeach 