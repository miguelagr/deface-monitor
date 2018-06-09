<?php
echo $_POST['ip'];
$dbconn = pg_connect("host=localhost dbname=monitoreo user=root password=hola123") or die('No se ha podido conectar: ' . pg_last_error());
$query = "SELECT count(*),s.nombre FROM servicio s,domser ds, dominio d where d.iddominio = ds.iddominio and s.idservicio = ds.idservicio group by s.nombre";

$consulta = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
while($arr = pg_fetch_row($consulta)) {
	$id=$arr[1];
	$ip=$arr[0];
?>
<div><?php echo $id;
echo ",$ip"?></div>


<?php }
pg_close($dbconn)
?>
