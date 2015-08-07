@extends('layouts.master')
@section('page', 'gallery')

@section('content')
	<h1>ESCOGE EL TEMA DE TU DISEÑO</h1>
	<div class="content">
		<div class="header">
			<div class="col">
				<a href="gallery?masVotados=true">
					<img src="images/masVotadosBtn.png">
				</a>
			</div>
			<div class="col">
				<form action="gallery" method="GET">
					<input type="text" name="nombre" id="search" placeholder="Buscar nombre">
				</form>
			</div>
		</div>
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
		<div id="pagination">
			<?php
				$labels->setPath('gallery');
				echo $labels->render();
			?>
		</div>
	</div>
	<div id="labelLb" class="hidden">
		<div class="label">
			<div class="imgWrap">
				<div class="vCenter">
					<img alt="">
				</div>
			</div>
			<div class="footer">
				<div class="col">
					<p class="name"></p>
				</div>
				<div class="col">
					<div class="countBox">
						<div class="col">
							<a href="javascript:;" class="votar" data-label="">
								<img src="images/likeBtn.jpg" alt="">
							</a>
						</div>
						<div class="col num"></div>
					</div>
				</div>				
			</div>
		</div>
	</div>
@endsection