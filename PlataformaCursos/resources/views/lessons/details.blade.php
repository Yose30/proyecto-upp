@extends('layouts.app')
<style>
    .jumbotron {background-color: #70299b}

    .embed-container {
	    position: relative;
	    padding-bottom: 56.25%;
	    height: 0;
	    overflow: hidden;
	  }
	  .embed-container iframe {
	    position: absolute;
	    top:0;
	    left: 0;
	    width: 100%;
	    height: 100%;
	  }
	  .file-rounded {
	      width:100px;
	      height:100px;
	      border-radius:150px;
	  }
	  #estilo-file{
	    width: 150px;
	    font-size: 20px;
	    color: #70299b;
	    position: relative;
	  } 
	  #file{
	    left: 0; top: 0; right: 0; bottom: 0; width: 100%; height: 100%; position: absolute; opacity: 0;
	  }
</style>
@section('jumbotron')
	<div 
	  class="jumbotron jumbotron-fluid" 
	  style="background-color: #70299b; color: #ffffff;">
	  <div class="container">
			<h1>
	      <a 
	        style="text-decoration: none; color: white;" 
	        href="{{ route('courses.lessons', $lesson->course->slug) }}"
	      >
	        {{ $lesson->course->nombre }}
	      </a>
	    </h1>
		 	<h3><i class="fa fa-caret-square-o-right"></i> {{ $lesson->titulo }}</h3>
		 	<div id="player"></div>
	    <a 
	      href="{{ url('/'.Config::get('chatter.routes.home').'/'.Config::get('chatter.routes.discussion').'/'.$lesson->course->slug.'/'.$lesson->slug ) }}" 
	      type="button" 
	      class="btn btn-light btn-lg btn-block"
	    >
	      <i class="fa fa-comments-o"></i> {{ __("Foro") }}
	    </a>
		</div>
	</div>
@endsection
@section('content')
	@include('partials.lessons.datos')
	<ul class="nav nav-tabs" id="myTab" role="tablist">
	  <li class="nav-item">
	    <a 
	      class="nav-link" 
	      id="material-tab" 
	      data-toggle="tab" 
	      href="#material" 
	      role="tab" 
	      aria-controls="material" 
	      aria-selected="false"
	    >
	      {{ __("Material de apoyo") }}
	    </a>
	  </li>
	  <li class="nav-item">
	    <a 
	      class="nav-link" 
	      id="my-material-tab" 
	      data-toggle="tab" 
	      href="#my-material" 
	      role="tab" 
	      aria-controls="my-material" 
	      aria-selected="false"
	    >
	      {{ __("Compartido por mí") }}
	    </a>
	  </li>
	  <li class="nav-item">
	    <a 
	      class="nav-link active" 
	      id="ques_ans-tab" 
	      data-toggle="tab" 
	      href="#ques_ans" 
	      role="tab" 
	      aria-controls="ques_ans" 
	      aria-selected="true"
	    >
	      {{ __("Preguntas y respuestas") }}
	    </a>
	  </li>
	</ul>
	<div class="tab-content" id="myTabContent">
	  <div 
	    class="tab-pane fade" 
	    id="material" 
	    role="tabpanel" 
	    aria-labelledby="material-tab"
	  >
	     @include('partials.lessons.list_files') 
	  </div>
	  <div 
	    class="tab-pane fade" 
	    id="my-material" 
	    role="tabpanel" 
	    aria-labelledby="my-material-tab"
	  >
	     @include('partials.lessons.share_files') 
	  </div>
	  <div 
	    class="tab-pane fade show active" 
	    id="ques_ans" 
	    role="tabpanel" 
	    aria-labelledby="ques_ans-tab"
	  >
	    @include('partials.lessons.questions_answers')  
	  </div>
	</div>
	<hr>
	
@endsection

@push('scripts')
<script>
  // 2. This code loads the IFrame Player API code asynchronously.
  var tag = document.createElement('script');
  tag.src = "https://www.youtube.com/iframe_api";
  var firstScriptTag = document.getElementsByTagName('script')[0];
  firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
  // 3. This function creates an <iframe> (and YouTube player)
  //    after the API code downloads.
  var player;
  function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
      height: '100%',
      width: '100%',
      videoId: '{{$lesson->link_video}}',
      playerVars: {
		    showinfo: 0,
		    fs: 0,
		    modestbranding: 1,
		    disablekb: 1,
		    rel: 0
      },
      events: {
        'onReady': onPlayerReady,
        'onStateChange': onPlayerStateChange
      }
    });
  }
  // 4. The API will call this function when the video player is ready.
  function onPlayerReady(event) {

  }
  // 5. The API calls this function when the player's state changes.
  //    The function indicates that when playing a video (state=1),
  //    the player should play for six seconds and then stop.
  var done = false;
  function onPlayerStateChange(event) {
    if(event.data == YT.PlayerState.ENDED){

    }
  }
  function stopVideo() {
    player.stopVideo();
  }
</script>
@endpush