@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-1" align="right">
						<img 
					      style="width:35px; height:35px; border-radius:150px;"  
					      src="{{ $conversation->teacher->user->pathAttachment() }}" alt="{{ $conversation->teacher->user->name }}"
					    >
					</div>
					<div class="col-md-5">
						<h3 class="text-left">{{ $conversation->teacher->user->name }} {{ $conversation->teacher->user->lastName }}</h3>
					</div>
				</div>
				<message :messages="messages" :conversation_id="{{ $conversation->id }}"></message>
				<sent-message v-on:messagesent="addMessage" :user="{{ auth()->user() }}" :conversation_id="{{ $conversation->id }}"></sent-message>
			</div>
			<div class="col-md-5">
				@if($course)
					<div align="right">
						<a class="btn btn-outline-secondary" href="{{ route('profile.profile', [$course->course_id, $conversation->teacher->user->slug]) }}"><i class="fa fa-reply"></i> {{ __("Volver") }}</a>
					</div>
					<br>
				@endif
				<div class="card">
					<div class="card-header" align="center" style="background-color: rgb(112, 41, 155); color: #ffffff">{{ __("Conversaciones") }}</div>
				  	<ul class="list-group list-group-flush">
				  		@include('partials.conversations.student')
				  	</ul>
				</div>
			</div>
		</div> 
	</div>
@endsection