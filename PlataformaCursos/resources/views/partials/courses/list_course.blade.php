<h3>{{ $title_level }}</h3>
<div class="row">
    @foreach($all_courses->where('level_id', $level) as $course)
        <div class="col-md-3" style="display: flex;">
            <!--Tiene acceso al curso solo por estar dentro de la vista home-->
            @include('partials.courses.card_course')
        </div>
    @endforeach
</div>