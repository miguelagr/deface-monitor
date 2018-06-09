<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>Graficos</title>
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



<!--charts-->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
</head>
<body id="mainbody">

<div class="container theme-showcase" role="main" id="sbody">
<div class="container">
<div  class="text-center">
<form action="index.php" method="post">
<button type="submit" class="btn btn-lg btn-default" class="text-center" class="pagination-centered">Regresar</button>
</form>
</div>

</div>
<?php
$dbconn = pg_connect("host=localhost dbname=defmon user=mont password=hola123") or die('No se ha podido conectar: ' . pg_last_error());
?>

<div style="margin: 0 auto;" id="top5" style="width:600px;height:500px;"></div>

<script>
Highcharts.chart('top5', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 5 CMS\'s mas usados'
    },
    xAxis: {
    	type: 'category'

    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'CMS',
<?php echo "data: [";
$query = "SELECT count(*),cms FROM servicio s,recser rs, recurso r  where r.recid = rs.recid and s.servid = rs.servid and cms is not null group by cms order by count(*) desc limit 5";
$cmss = pg_query($query) or die('La consulta fallo: ' . pg_last_error()); 
$arr = pg_fetch_row($cmss);
do{
	echo "['$arr[1]',$arr[0]],";
} while($arr = pg_fetch_row($cmss));

echo "]" ;?>
    }]
});
</script>



<div class="container">
<div style="margin: 0 auto;" class="text-center"  id="graph" style="width:600px;height:500px;"></div>
</div>
<script>
Highcharts.chart('graph', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Distribucion de Gestores de contenido'
    },
    xAxis: {
    	type: 'category'

    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'CMS',
<?php echo "data: [";
$query = "SELECT count(*),cms FROM servicio s,recser rs, recurso r  where r.recid = rs.recid and s.servid = rs.servid and cms is not null group by cms";
$cmss = pg_query($query) or die('La consulta fallo: ' . pg_last_error()); 
$arr = pg_fetch_row($cmss);
do{
	echo "['$arr[1]',$arr[0]],";
} while($arr = pg_fetch_row($cmss));

echo "]" ;?>
    }]
});
</script>


<div style="margin: 0 auto;" id="Cont" style="width:600px;height:500px;"></div>

<script>
Highcharts.chart('Cont', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tipos de contenidos'
    },
    xAxis: {
    	type: 'category'

    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'CMS',
<?php echo "data: [";
$query = "SELECT count(*),s.nombre FROM servicio s,recser rs, recurso r  where r.recid = rs.recid and s.servid = rs.servid group by s.nombre";
$cmss = pg_query($query) or die('La consulta fallo: ' . pg_last_error()); 
$arr = pg_fetch_row($cmss);
do{
	echo "['$arr[1]',$arr[0]],";
} while($arr = pg_fetch_row($cmss));

echo "]" ;?>
    }]
});
</script>


<div style="margin: 0 auto;" id="top5cont" style="width:600px;height:500px;"></div>

<script>
Highcharts.chart('top5cont', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Top 5 tipo de contenido'
    },
    xAxis: {
    	type: 'category'

    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'CMS',
<?php echo "data: [";
$query = "SELECT count(*),s.nombre FROM servicio s,recser rs, recurso r  where r.recid = rs.recid and s.servid = rs.servid  group by s.nombre order by count(*) desc limit 5";
$cmss = pg_query($query) or die('La consulta fallo: ' . pg_last_error()); 
$arr = pg_fetch_row($cmss);
do{
	echo "['$arr[1]',$arr[0]],";
} while($arr = pg_fetch_row($cmss));

echo "]" ;?>
    }]
});
</script>

<?php pg_close($dbconn) ?>
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
