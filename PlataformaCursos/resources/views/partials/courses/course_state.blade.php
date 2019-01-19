<div align="right">
  @foreach($course->students as $cs)
    @if($cs->pivot->student_id == $type_id)
      @if($cs->pivot->situacion == \App\Course::CURSANDO)
        <span class="badge" style="background-color: green; color: white;">
          {{ __("Cursando") }}
        </span>
      @else
        <span class="badge" style="background-color: black; color: white;">
          {{ __("Cursada") }}
        </span>
      @endif
    @endif 
  @endforeach
</div>