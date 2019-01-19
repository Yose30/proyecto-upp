@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-1" align="right">
					<img 
				      style="width:35px; height:35px; border-radius:150px;"  
				      src="{{ $conversation->user->pathAttachment() }}" alt="{{ $conversation->user->name }}"
				    >
				</div>
				<div class="col-md-5">
					<h3 class="text-left">{{ $conversation->user->name }} {{ $conversation->user->lastName }}</h3>
				</div>
			</div>
			<message :messages="messages" :conversation_id="{{ $conversation->id }}"></message>
			<sent-message v-on:messagesent="addMessage" :user="{{ auth()->user() }}" :conversation_id="{{ $conversation->id }}">
			</sent-message> 
		</div>
		<div class="col-md-5">
			@if($course)
				<div align="right">
					<a class="btn btn-outline-secondary" href="{{ route('teacher.courses.enrolled_students', $course->course_id) }}"><i class="fa fa-reply"></i> {{ __("Volver") }}</a>
				</div>
			@endif
			<br>
			<div class="card">
				<div class="card-header" align="center" style="background-color: rgb(112, 41, 155); color: #ffffff">{{ __("Conversaciones") }}</div>
				<ul class="list-group list-group-flush">
			  		@include('partials.conversations.teacher')
			  	</ul>
				</div>
			</div>
		</div>
	</div>
@endsection