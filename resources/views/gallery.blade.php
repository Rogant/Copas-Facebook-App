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
					<p class="name"></p>
					<div class="countBox"></div>
				</div>
			@endforeach
		</div>
	</div>
@endsection