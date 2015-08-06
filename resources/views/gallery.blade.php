@extends('layouts.master')
@section('page', 'gallery')

@section('content')
	<h1>ESCOGE EL TEMA DE TU DISEÑO</h1>
	<div class="content">
		<div id="wrapGallery">
			@foreach ($labels as $label)
				<div class="label">
					<div class="imgWrap">
						<img src="uploads/labels/{{ $label->label }}" alt="">
					</div>
					<p class="name">{{ $label->nombre }}</p>
					<div class="countBox">
						<div class="col">
							<a href="javascript:;" class="votar" data-label="{{ $label->id }}">
								<img src="images/likeBtn.jpg" alt="">
							</a>
						</div>
						<div class="col num">
							{{ $label->votos }}
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection