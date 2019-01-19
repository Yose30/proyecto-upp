<style type="text/css">
    .img-rounded {
    width:70px;
    height:70px;
    border-radius:150px;
}
</style>
<div class="align-content-center">
    <div class="col-12 pt-0 mt-4">
        <h3>{{ __("Opiniones del curso") }}</h3><hr />
    </div>
    <div class="container-fluid">
        <div class="row">
            @if($course->reviews_count != 0)
                @foreach($users as $user)
                    @foreach($course->reviews->where('user_id', $user->id) as $review)
                        <div class="col-md-8 offset-2 listing-block">
                            <div class="media">
                                <img
                                    class="img-rounded"
                                    src="{{ $review->user->pathAttachment() }}"
                                    alt="{{ $review->user->name }}" 
                                    style=" width:70px;height:70px;border-radius:150px;"
                                />
                                <div class="media-body pl-3">
                                    <b>{{ $review->user->name }} {{ $review->user->lastName }}</b>
                                    <br>
                                    @if($review->comentario)
                                        {{ $review->comentario }}
                                    @endif
                                    <br>
                                    {{ $review->created_at->format('d/m/Y') }}
                                    @include('partials.courses.rating', ['rating' => $review->rating])
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @else
                <div class="alert alert-dark"><i class="fa fa-info-circle"></i> {{ __("Sin opiniones aun") }}</div>
            @endif
        </div>
    </div>
</div>