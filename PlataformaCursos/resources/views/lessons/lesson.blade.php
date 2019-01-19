@extends('layouts.app')

<style type="text/css">
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
        href="{{ route('courses.course_details', $lesson->course->slug) }}"
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
  @include('partials.lessons.lesson_tabs')
  @include('partials.lessons.modal')
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
    event.target.playVideo();
  }
  // 5. The API calls this function when the player's state changes.
  //    The function indicates that when playing a video (state=1),
  //    the player should play for six seconds and then stop.
  var done = false;
  function onPlayerStateChange(event) {
    if(event.data == YT.PlayerState.ENDED){
    	$('#appModal').modal('show');
    }
  }
  function stopVideo() {
    player.stopVideo();
  }
</script>
@endpush