<?php 
require( '../config.php' );
require( '../php/funciones.php' );

$i=0;

if(!$_SESSION['editar']==true){		

if(isset($_POST['nombre'])){
	$nombre = control($_POST['nombre']);
	$_SESSION["r_nombre"]=$nombre;
	if(!texto($nombre)){
		header("Location: ../index.php?boton=Registro&rta=Nombre");
	}
	else{
		$i++;
	}
		if(isset($_POST["apellido"])){
			$apellido = control($_POST['apellido']);
			$_SESSION["r_apellido"]=$apellido;
			if(!texto($apellido)){
				header("Location: ../index.php?boton=Registro&rta=Apellido");
			}
			else{
				$i++;
			}
			if(isset($_POST["mail"])){
				$mail = control($_POST['mail']);
				$_SESSION["r_mail"]=$mail;
				if(!email_f($mail)){
					header("Location: ../index.php?boton=Registro&rta=Mail");
				}
				else{
					$i++;
				}
					if(isset($_POST["contrasenia"])){
						$cont = control($_POST['contrasenia']);
						if(!cont($cont)){
							header("Location: ../index.php?boton=Registro&rta=contrasenia");
						}
						else{
							$i++;
						}
						if(isset($_POST["tel"])){
							$tel = control($_POST['tel']);
							$_SESSION["r_tel"]=$tel;
							if(!telefono($tel)){
								header("Location: ../index.php?boton=Registro&rta=Telefono");
							}
							else{
								$i++;
							}

						}
					}
				}
			}
		}
if($i==5){
$cn=control(md5($cont));
$c = "INSERT INTO usuario SET CONTRASENIA='$cn', BORRADO='no', NOMBRE='$nombre', APELLIDO='$apellido', MAIL='$mail', TELEFONO='$tel' , NIVEL='usuario' ";
mysqli_query($cnx, $c);
$id = mysqli_insert_id( $cnx );
$rta = $id == 0 ? 'error': 'ok';
	if($rta!='ok'){
		header("Location: ../index.php?boton=Registro&rta_login=$rta");
	}
	else{
		header("Location: ../index.php?boton=Login&rta_login=$rta");
	}
}
}
else{
	
if(isset($_POST['nombre'])){
	$nombre = control($_POST['nombre']);
	if(!texto($nombre)){
		header("Location: ../index.php?boton=Registro&rta=Nombre");
	}
	if(isset($_POST["apellido"])){
		$apellido = control($_POST['apellido']);
		if(!texto($apellido)){
			header("Location: ../index.php?boton=Registro&rta=Apellido");
		}
	if(isset($_POST["tel"])){
		$tel = control($_POST['tel']);
		if(!telefono($tel)){
			header("Location: ../index.php?boton=Registro&rta=Telefono");
		}
	if(isset($_POST["contrasenia"])){
		$_POST["contrasenia"]=control($_POST["contrasenia"]);
		$c2="SELECT CONTRASENIA FROM usuario WHERE usuario.MAIL='$_SESSION[s_mail]'";	
		$rt=mysqli_query($cnx, $c2);
		$f = mysqli_fetch_assoc( $rt );
		$c = "UPDATE 
		usuario 
		SET NOMBRE='$nombre', 
		APELLIDO='$apellido', 
		TELEFONO='$tel' ";
		if($f["CONTRASENIA"]==md5($_POST["contrasenia"])){
			$contrasenia=$_POST["contrasenia"];
			if(isset($_POST["contrasenia"])&&$_POST["contrasenia"]!=""&&isset($_POST["contrasenia2"])&&$_POST["contrasenia2"]!=""){
				$cont=control(md5($_POST["contrasenia2"]));
				$c=$c.", CONTRASENIA='$cont' ";
			}
		}
	}
	
	}
	}
}
$c=$c."WHERE usuario.MAIL='$_SESSION[s_mail]'";
echo $c;
mysqli_query($cnx, $c);
$f = mysqli_affected_rows( $cnx );
$rta = $f == -1 ? 'error': 'ok';
$_SESSION['editar']=false;
$_SESSION["e_nombre"]=$nombre;
$_SESSION["e_apellido"]=$apellido;
$_SESSION["e_tel"]=$tel;
if($rta=='ok'){
		$_SESSION['s_nombre']=$nombre.' '.$apellido;
		$_SESSION['s_nivel']='usuario';
		header("Location: ../index.php?rta=$rta");	
}
}
?>