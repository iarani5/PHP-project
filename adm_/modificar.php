<?php
include( '../config.php' );
if(isset($_GET['c'])){
	$_GET["c"]=control($_GET["c"]);
	if($_GET['c']=='u'&&$_SESSION["s_nivel"]=="admin"){
		if(isset($_GET['id'])){
			$_GET["id"]=intval($_GET["id"]);
			if(isset($_GET['q'])){
				$_GET["q"]=control($_GET["q"]);
				if($_GET['q']=='restaurar'||$_GET['q']=='eliminar'){
					if($_GET['q']=='restaurar'){$a='no';}
					else{$a='si';}
						$con="UPDATE usuario SET usuario.BORRADO='$a' WHERE usuario.ID='".$_GET['id']."'";
				}
				else if($_GET['q']=='eliminarf'){
					$con2="SELECT ID FROM publican WHERE publican.FKNOMBRE='$_GET[id]'";
					$cant=mysqli_query($cnx, $con2);
					while($b = mysqli_fetch_assoc($cant)){
						$con3="DELETE FROM publican WHERE publican.ID='$b[ID]'";
						mysqli_query($cnx, $con3);
					}
					$con = "DELETE FROM usuario WHERE ID='$_GET[id]'";
				}
				else if($_GET['q']=='nivel'){
					$con2="SELECT NIVEL, MAIL FROM usuario WHERE usuario.ID='$_GET[id]' LIMIT 1";
					$cant=mysqli_query($cnx, $con2);
					while($b = mysqli_fetch_assoc($cant)){
						if($b["NIVEL"]=="admin"){
							$a="usuario";
						}
						else{
							$a="admin";
						}
						if($b["MAIL"]!=$_SESSION["s_mail"]){
							$con="UPDATE usuario SET usuario.NIVEL='$a' WHERE usuario.ID='".$_GET['id']."'";
						}
						else{
							$con=" ";
							$iguales=1;
						}
					}
				}
				else if($_GET['q']=='activo'){
					$con2="SELECT ACTIVO, MAIL FROM usuario WHERE usuario.ID='$_GET[id]' LIMIT 1";
					$cant=mysqli_query($cnx, $con2);
					while($b = mysqli_fetch_assoc($cant)){
						if($b["ACTIVO"]=="si"){
							$a="no";
						}
						else{
							$a="si";
						}
						if($b["MAIL"]!=$_SESSION["s_mail"]){
							$con="UPDATE usuario SET usuario.ACTIVO='$a' WHERE usuario.ID='".$_GET['id']."' LIMIT 1";
						}
						else{
							$con=" ";
							$iguales=1;
						}
					}
				}
				mysqli_query($cnx, $con);
				$cant=mysqli_affected_rows($cnx);
				$rta=$cant == 0 ? 'error': 'ok';
				if($iguales!=undefined&&$iguales){
					$rta="error";
				}
				if($_GET['q']=='eliminarf'){
					header("Location: ../index.php?boton=home&ac=Usuarios&bo=papelera&modificacion=$rta");
				}
				else{
					header("Location: ../index.php?boton=home&ac=Usuarios&modificacion=$rta");
				}
			}
		}
	}
	if($_GET['c']=='p'&&isset($_SESSION["logueado"])){
		if(isset($_GET['id'])){
			$_GET["id"]=intval($_GET["id"]);
			if(isset($_GET['q'])){
				if($_GET['q']== 'restaurar'||$_GET['q']=='eliminar'){
					if($_GET['q']=='restaurar'){
						$c1="UPDATE publican SET publican.BORRADO='no' WHERE publican.ID='$_GET[id]'";
						mysqli_query($cnx, $c1);
						$cant=mysqli_affected_rows($cnx);
						$rta=$cant == 0 ? 'error': 'ok';
					}
					else if($_GET['q']=='eliminar'){
						$c1="UPDATE publican SET publican.BORRADO='si' WHERE publican.ID='$_GET[id]'";
						mysqli_query($cnx, $c1);
						$cant=mysqli_affected_rows($cnx);
						$rta=$cant == 0 ? 'error': 'ok';
					}
				}
				else if($_GET['q']=='eliminarf'){
					mysqli_query($cnx, $con);
					$cant=mysqli_affected_rows($cnx);
					$rta=$cant == 0 ? 'error': 'ok';
					$c1="SELECT ID FROM publican WHERE publican.FKPUBLICACION='$_GET[id]' LIMIT 1";
					$cant=mysqli_query($cnx, $c1);
					while($b = mysqli_fetch_assoc($cant)){
						$c2="DELETE FROM publican WHERE publican.ID='$b[ID]'";
						mysqli_query($cnx, $c2);
						$c3="DELETE FROM publicacion WHERE publicacion.ID='$_GET[id]'";
						mysqli_query($cnx, $c3);
						$fin=mysqli_affected_rows($cnx);
						$rta=$fin == 0 ? 'error': 'ok';
					}
						header("Location: ../index.php?boton=home&ac=Publicaciones&bo=papelera&modificacion=$rta");
				}
				header("Location: ../index.php?boton=home&ac=Publicaciones&modificacion=$rta");
			}
		}
	}
}
else{
	header("Location: ../index.php?boton=home&rta=error");
}
?>