<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Bootstrap 101 Template</title>
	<!-- Bootstrap -->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet">
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/theme.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<!-- Fixed navbar -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Menú</a>
		</div>
			<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			<li><a href="#">Inicio</a></li>
			<li><a onClick=loadDoc()>Dominios</a></li>
			<li><a onClick=loadDoc4()>Clasificación</a></li>
			<li><a onClick=loadDoc1()>Gráficas </a></li>
			<li><a href="#">Histórico</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuración<span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
				<li class="dropdown-header">Histórico</li>
				<li><a href="#">Busqueda</a></li>
				<li><a href="#">Configuración</a></li>
				<li><a href="#">Nada</a></li>
 				<li><a href="#">Nada</a></li>
				<li class="divider"></li>
				<li class="dropdown-header">No</li>
				<li><a href="#">No</a></li>
				<li><a href="#">No</a></li>
				</ul>
			</li>
			</ul>
<!--Esta es la parte derecha para busqueda e ingreso -->
<form class="navbar-form navbar-right" role="form" action="stats.php" methd="post">
<input type="text" placeholder="Buscar" class="form-control" name="ip">
<button type="submit" formmethod="post">Buscar</button>
</form>
<!--FIN DE LA PARTE DERECHA -->
		</div>
		</div>
	</nav>
<div class="container theme-showcase" role="main" id="sbody">
<div class="page-header" id="mbody">
<h1>Deface monitor</h1>
<h2>Plan de becarios en seguridad informatica</h2>
</div>
</div>

<script src="js/defmon.js"> </script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="https://getbootstrap.com/docs/3.3/assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://getbootstrap.com/docs/3.3/dist/js/bootstrap.min.js"></script>
<script src="https://getbootstrap.com/docs/3.3/assets/js/docs.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="https://getbootstrap.com/docs/3.3/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
