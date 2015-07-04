<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Copas</title>

	{!! HTML::style('css/normalize.css') !!}
	{!! HTML::style('css/estilos.less', array('rel' => 'stylesheet/less')) !!}

	{!! HTML::script('js/jquery-1.11.1.min.js') !!}
	{!! HTML::script('js/jquery.validate.min.js') !!}
	{!! HTML::script('js/localization/messages_es.js') !!}
	{!! HTML::script('js/scripts.js') !!}


	<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.1/less.min.js"></script>
</head>
<body id="@yield('page')">
	<div id="main">
		@yield('content')
	</div>
</body>
</html>