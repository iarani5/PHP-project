<?php 
include( '../config.php' );

	$mail = control($_POST['mail']);
	$cont = control(md5($_POST['cont']));

	$con = "SELECT * FROM usuario WHERE MAIL='$mail' AND CONTRASENIA='$cont' AND ACTIVO='si' LIMIT 1";
	$rta = mysqli_query($cnx, $con);
	$fin = mysqli_fetch_assoc($rta);

	if( $fin ){
		$_SESSION['s_nivel'] = $fin['NIVEL'];
		$_SESSION['s_mail'] = $mail;
		$_SESSION['s_tel'] = $fin['TELEFONO'];
		$_SESSION['s_nombre'] = $fin['NOMBRE'].' '.$fin['APELLIDO'];
		$_SESSION['logueado'] = true;
		if($fin['NIVEL']=='admin'){
			header("Location: ../index.php?boton=home");
		}
		else{
			header("Location: ../index.php");
		}
	}

else{
	header("Location: ../index.php?boton=Login&estado=login");
}


?>