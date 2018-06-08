<div class="container" class="text-center" class="pagination-centered" class="list-group">
<a href="#" class="list-group-item active"><div class="row"><div class="col-xs-6" class="pagination-centered" class="text-center">Direccion</div><div class="col-xs-6" class="text-center">IP</div></div></a>

<?php
$dbconn = pg_connect("host=localhost dbname=defmon user=mont password=hola123") or die('No se ha podido conectar: ' . pg_last_error());
$query = "SELECT count(*),s.nombre FROM servicio s,recurso r, recser rs where r.recid = rs.recid and s.servid = rs.servid group by s.nombre";

$consulta = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
while($arr = pg_fetch_row($consulta)) {
	$id=$arr[1];
	$ip=$arr[0];
?>
<a class="list-group-item" class="container">
<div class="row">
<div class="col-xs-6" class="text-center"><?php echo "$id"?></div>
<div class="col-xs-6" class="text-center"><?php echo "$ip"?></div>
</div>
</a>
<?php }
pg_close($dbconn)
?>
</div>
</a>

<div class="container" class="text-center" class="pagination-centered" class="list-group">
<a href="#" class="list-group-item active"><div class="row"><div class="col-xs-6" class="pagination-centered" class="text-center">Direccion</div><div class="col-xs-6" class="text-center">IP</div></div></a>

<?php
$dbconn = pg_connect("host=localhost dbname=defmon user=mont password=hola123") or die('No se ha podido conectar: ' . pg_last_error());
$query = "SELECT count(*),s.cms FROM servicio s,recurso r, recser rs where r.recid = rs.recid and s.servid = rs.servid and s.cms is not null group by s.cms";

$consulta = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
while($arr = pg_fetch_row($consulta)) {
	$id=$arr[1];
	$ip=$arr[0];
?>
<a class="list-group-item" class="container">
<div class="row">
<div class="col-xs-6" class="text-center"><?php echo "$id"?></div>
<div class="col-xs-6" class="text-center"><?php echo "$ip"?></div>
</div>
</a>
<?php }
pg_close($dbconn)
?>
</div>
</a>
