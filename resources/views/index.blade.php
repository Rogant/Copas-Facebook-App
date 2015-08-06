@extends('layouts.master')
@section('page', 'registro')

@section('content')
	<h1>PASOS PARA PARTICIPAR</h1>
	<div class="content">
		<div class="col col-50">
			<h2 class="title"></h2>
			{!! Form::open(array('url' => 'registro', 'id' => 'registrer', 'method' => 'post', 'files' => true)) !!}
				<input type="hidden" name="facebookID" value="{{ $userFacebookID }}">
				<div class="field"><input type="text" name="nombre" placeholder="Nombre completo" required></div>
				<div class="field"><input type="email" name="email" placeholder="Correo Electrónico" required></div>
				<div class="field"><input type="text" name="telefono" placeholder="Teléfono" required></div>
				<div class="field"><input type="text" name="cedula" placeholder="Cédula" required></div>
				<div class="field"><input type="text" name="ciudad" placeholder="Ciudad" required></div>
				<div class="field">
					<p>Sube la foto de tu Sansón</p>
					<input type="file" value="1" name="foto" required>
				</div>
				<div class="field">
					<div class="col col-50">
						<p class="legal"><input type="checkbox" name="terminos" required> *He leído y acepto los términos y condiciones.</p>
					</div>
					<div class="col col-50">
						<input type="submit" value="">
					</div>
				</div>
			{!! Form::close() !!}
		</div>
		<div class="col col-50">
			<div class="info">
				<ol>
					<li>
						<div class="text">&nbsp;&nbsp; Registra tus datos en el formulario</div>
					</li>
					<li>
						<div class="text">&nbsp;&nbsp; Elabora tu diseño</div>
					</li>
					<li>
						<div class="text">&nbsp;&nbsp; Invita a tus amigos a escoger tu diseño</div>
					</li>
					<li>
						<div class="text">&nbsp;&nbsp; Gana <b>$500.000</b></div>
					</li>
				</ol>
			</div>
		</div>	
	</div>
@endsection