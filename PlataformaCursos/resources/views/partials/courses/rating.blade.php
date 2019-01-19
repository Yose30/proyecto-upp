<div>
	<ul class="list-inline">
		<li class="list-inline-item"><i class="fa fa-star{{ $rating >= 1 ? ' yellow' : ''}}"></i></li>
		<li class="list-inline-item"><i class="fa fa-star{{ $rating >= 2 ? ' yellow' : ''}}"></i></li>
		<li class="list-inline-item"><i class="fa fa-star{{ $rating >= 3 ? ' yellow' : ''}}"></i></li>
		<li class="list-inline-item"><i class="fa fa-star{{ $rating >= 4 ? ' yellow' : ''}}"></i></li>
		<li class="list-inline-item"><i class="fa fa-star{{ $rating >= 5 ? ' yellow' : ''}}"></i></li>
		<!--fa fa-star es para mostrar el raiting en estrellas
			Si el rating esta en cero no se mostrara nada-->
	</ul>
</div>