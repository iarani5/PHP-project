<?php 
include( '../config.php' );
if(isset($_GET['id'])){
	$_GET["id"]=intval($_GET["id"]);
	$con="UPDATE usuario SET usuario.BORRADO='si' WHERE usuario.ID='".$_GET['id']."'";
	mysqli_query($cnx, $con);
	$cant=mysqli_affected_rows($cnx);
	$rta=$cant == 0 ? 'error': 'borrado';
	header("Location: ../index.php?boton=home&ca=Usuarios&rta=$rta");
}
else{
	header("Location: ../index.php?boton=home&ac=Usuarios&rta=error");
}
?>