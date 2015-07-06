@extends('layouts.master')
@section('page', 'upload')

@section('content')
	<h1>ESCOGE EL TEMA DE TU DISEÑO</h1>
	<div class="content">
		<div class="col col-55">
			<h2 class="title"></h2>
			<img src="images/LabelAll.png" alt="">
			<div class="wrap">
				<div class="col col-50">
					<a href="images/ejemploLabel.jpg" target="_blank"><div class="descargaBtn"></div></a>
				</div>
				<div class="col col-50">
					{!! Form::open(array('url' => 'upload', 'id' => 'uploadLabelForm', 'method' => 'post', 'files' => true)) !!}
						<div class="uploadBtn"></div>
						<input id="uploadLabel" type="file" name="label" class="hidden">
						<input type="text" name="idUser" class="hidden" value="{{ $userID }}">
					{!! Form::close() !!}
				</div>
			</div>
		</div>
		<div class="col col-45">
			<div class="info">
				<ol>
					<li>
						<div class="text">&nbsp;&nbsp; Riqueza y naturaleza colombiana</div>
					</li>
					<li>
						<div class="text">&nbsp;&nbsp; Arquitectura y belleza de nuestras ciudades</div>
					</li>
					<li>
						<div class="text">&nbsp;&nbsp; Mundo del vino</div>
					</li>
					<li>
						<div class="text">&nbsp;&nbsp; Sansón: pócimas, mitos y leyendas</div>
					</li>
				</ol>
			</div>
		</div>	
	</div>
@endsection