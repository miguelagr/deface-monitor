<div class="container" class="text-center" class="pagination-centered" class="list-group">
<a href="#" class="list-group-item active"><div class="row"><div class="col-xs-6" class="pagination-centered" class="text-center">Direccion</div><div class="col-xs-6" class="text-center">IP</div></div></a>
<?php
$dbconn = pg_connect("host=localhost dbname=defmon user=mont password=hola123") or die('No se ha podido conectar: ' . pg_last_error());
$query = "SELECT url,ipstring FROM recurso r,ip i where r.ipid = i.ipid ORDER BY ipstring";
$consulta = pg_query($query) or die('La consulta fallo: ' . pg_last_error());
while($arr = pg_fetch_row($consulta)) {
	$id=$arr[0];
	$ip=$arr[1];
?>
<a class="list-group-item" class="container">
<div class="row">
<form class="col-xs-6" action="stats.php" method="POST">
<input type="submit" value="<?php echo $id;?>" class="form-control" name="ip">
</form>
<div class="col-xs-6" class="text-center"><?php echo "$ip"?></div>
</div>
</a>
<?php }
pg_close($dbconn)
?>
</div>

<script src="defmon.js"> </script>

