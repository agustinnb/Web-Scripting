<?php


if (isset($_GET['id'])){
	$id=$_GET['id'];
	$con=mysqli_connect("SERVER","USER","PASSWORD","DB");
	mysqli_query($con,"UPDATE table SET suscripto=0 WHERE id=$id");
	echo "Listo! Te desuscribiste!";
	
}

?>
