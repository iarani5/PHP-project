<?php
require('../config.php');
require('../php/funciones.php');
$ban=0;
if($_FILES['foto']['name']&&foto_f($_FILES['foto']['name'])){
	$titulo = time( );
}
else{
	header("Location: ../index.php?boton=Publicar&rta2=Foto");
}
if(isset($_POST['estado'])){
	if(isset($_POST['especie'])){
		if(isset($_POST['sexo'])){
			if(isset($_POST['edad'])){
				if(isset($_POST['raza'])&&texto($_POST['raza'])){
					$_POST["raza"]=control($_POST['raza']);
					if(isset($_POST['tamanio'])){
						if(isset($_POST['ojos'])){
							if(isset($_POST['pelo'])&&texto($_POST['pelo'])){
								$_POST["pelo"]=control($_POST['pelo']);
								if(isset($_POST['nombre_animal'])&&texto($_POST['nombre_animal'])){
									$_POST["nombre_animal"]=control($_POST['nombre_animal']);
									if(isset($_POST['descripcion'])&&!empty($_POST['descripcion'])){
										$_POST["descripcion"]=control($_POST['descripcion']);
										if(isset($_POST['provincia'])){
											if(isset($_POST['localidad'])&&texto($_POST['localidad'])){
												$_POST["localidad"]=control($_POST['localidad']);
												if(isset($_POST['barrio'])&&texto($_POST['barrio'])){
													$_POST["barrio"]=control($_POST['barrio']);
													if(isset($_POST['nombre'])&&texto($_POST['nombre'])){
														$_POST["nombre"]=control($_POST['nombre']);
														if(isset($_POST['telefono'])&&telefono($_POST['telefono'])){
															$_POST["telefono"]=control($_POST['telefono']);
															if(isset($_POST['mail'])&&email_f($_POST['mail'])){
																$_POST["mail"]=control($_POST['mail']);
																$ban=1;
															}
															else{
																header("Location: ../index.php?boton=Publicar&rta2=Mail");
															}
														}
														else{
															header("Location: ../index.php?boton=Publicar&rta2=Telefono");
														}
													}
													else{
														header("Location: ../index.php?boton=Publicar&rta2=Nombre");
													}
												}
												else{
													header("Location: ../index.php?boton=Publicar&rta2=Barrio");
												}
											}
											else{
												header("Location: ../index.php?boton=Publicar&rta2=Localidad");
											}
										}
									}
									else{
										header("Location: ../index.php?boton=Publicar&rta2=Descripcion");
									}
								}
								else{
									header("Location: ../index.php?boton=Publicar&rta2=animal");
								}
							}
							else{
								header("Location: ../index.php?boton=Publicar&rta2=pelo");
							}
						}
					}
				}
				else{
					header("Location: ../index.php?boton=Publicar&rta2=Raza");
				}
			}
		}
	}
}
if(isset($_POST['fecha_m'])&&$_POST["fecha_m"]!=""&&control($_POST['fecha_m'])){
	if(!fecha_f($_POST['fecha_m'])){
		header("Location: ../index.php?boton=Publicar&rta2=Fecha");
	}
	else{
		$fecha=control($_POST["fecha_m"]);
	}
}
else{
	$fecha="";
}
if(isset($_POST['calles'])&&texto($_POST["calles"])){
	$calles=control($_POST['calles']);
}
else{
	$calles='';
}
	
if($ban){
if(!isset($_SESSION['epublic'])||isset($_SESSION['epublic'])&&$_SESSION['epublic']==false){
	if(!($_FILES['foto']['name']&&foto_f($_FILES['foto']['name']))){
		$titulo="";
	}
	$c = <<<SQL
		INSERT INTO publicacion 
		SET 
		DESCRIPCION='$_POST[descripcion]',
		ESTADO='$_POST[estado]',
		FECHA_M='$_POST[fecha_m]',
		SEXO='$_POST[sexo]',
		UBICACION='$calles',
		TELEFONO='$_POST[telefono]',
		MAIL='$_POST[mail]',
		NOMBRE_ANIMAL='$_POST[nombre_animal]',
		NOMBRE_HUMANO='$_POST[nombre]',
		TAMANIO='$_POST[tamanio]',
		EDAD='$_POST[edad]',
		LOCALIDAD='$_POST[localidad]',
		BARRIO='$_POST[barrio]',
		FKPROVINCIA='$_POST[provincia]',
		RAZA='$_POST[raza]',
		COLOR='$_POST[pelo]',
		ESPECIE='$_POST[especie]',
		FKOJOS='$_POST[ojos]',
		RUTA_IMG='$titulo'
SQL;
		mysqli_query($cnx, $c);
		$f = mysqli_insert_id( $cnx ); 
		$rta = $f == 0 ? 'error': 'ok';
		if($rta=='error'){
			header("Location: ../index.php?boton=Publicar&rta2=$rta");
		}
		$id='SELECT ID FROM publicacion ORDER BY publicacion.ID DESC LIMIT 1';
		$rta = mysqli_query($cnx, $id);
		$a=array();
		while($b = mysqli_fetch_assoc($rta)){
			array_push($a,$b['ID']);
		}
		$id="SELECT ID FROM usuario WHERE usuario.MAIL='$_SESSION[s_mail]'";
		$rta = mysqli_query($cnx, $id);
		$c=array();
		while($b = mysqli_fetch_assoc($rta)){
			array_push($c,$b['ID']);
		}
		$c2="INSERT INTO publican SET publican.BORRADO='no', FECHA_A=NOW() , FKNOMBRE='$c[0]' , FKPUBLICACION='$a[0]' ";
		mysqli_query($cnx, $c2);
		$f = mysqli_insert_id( $cnx ); 
		if($_FILES['foto']['name']&&foto_f($_FILES['foto']['name'])){
			$_FILES["foto"]["name"]=control($_FILES["foto"]["name"]);
			mkdir("../publicaciones/$titulo");
			$temp=$_FILES['foto']['tmp_name'];
			move_uploaded_file($temp, "../publicaciones/$titulo/$titulo.jpg"); 
		$rta = $f == 0 ? 'error': 'ok_pub';
		$_SESSION['epublic']=false;
		$name="../publicaciones/$titulo/$titulo-mini.jpg";
			header('Content-Type: image/jpeg');
			$img=imagecreatefromjpeg("../publicaciones/$titulo/$titulo.jpg");
			$alto = imagesy($img);
			$ancho = imagesx($img);
			$alto_n = 250;
			$ancho_n = round($alto_n*$ancho/$alto);	
			$duplicado = imagecreatetruecolor($ancho_n, $alto_n);
			imagecopyresampled( $duplicado, $img, 0,0,0,0, $ancho_n, $alto_n, $ancho, $alto );
			imagejpeg($duplicado,$name,100);
			imagedestroy($duplicado);
			imagedestroy($img);
		header("Location: ../index.php?boton=Publicar&rta2=$rta");
		}
}
else{
		$elnom="SELECT publican.FKPUBLICACION FROM
 publicacion, usuario JOIN publican ON usuario.ID=publican.FKNOMBRE WHERE usuario.MAIL='$_SESSION[s_mail]' AND publicacion.ID=publican.FKPUBLICACION GROUP BY publican.FKPUBLICACION";
		//echo $elnom;
		$f=mysqli_query($cnx, $elnom);
		$uncont=0;
		while($e = mysqli_fetch_assoc($f)){
			if($e["FKPUBLICACION"]==$_SESSION["epublic"]){
				$uncont=1;
			}
		}
		if(!$uncont){
			header("Location: ../index.php?boton=Publicar&rta2=no");
		}
		else{
		$c = "UPDATE publicacion, publican 
		SET 
		DESCRIPCION='$_POST[descripcion]',
		ESTADO='$_POST[estado]',
		FECHA_M='$_POST[fecha_m]',
		SEXO='$_POST[sexo]',
		UBICACION='$calles',
		TELEFONO='$_POST[telefono]',
		MAIL='$_POST[mail]',
		NOMBRE_ANIMAL='$_POST[nombre_animal]',
		NOMBRE_HUMANO='$_POST[nombre]',
		TAMANIO='$_POST[tamanio]',
		EDAD='$_POST[edad]',
		LOCALIDAD='$_POST[localidad]',
		BARRIO='$_POST[barrio]',
		FKPROVINCIA='$_POST[provincia]',
		RAZA='$_POST[raza]',
		COLOR='$_POST[pelo]',
		ESPECIE='$_POST[especie]',
		FKOJOS='$_POST[ojos]' ";
	    if($_FILES["foto"]["size"]>0){
			$titulo=time();
			mkdir("../publicaciones/$titulo");
			$temp=$_FILES['foto']['tmp_name'];
			move_uploaded_file($temp, "../publicaciones/$titulo/$titulo.jpg"); 
			$name="../publicaciones/$titulo/$titulo-mini.jpg";
			header('Content-Type: image/jpeg');
			$img=imagecreatefromjpeg("../publicaciones/$titulo/$titulo.jpg");
			$alto = imagesy($img);
			$ancho = imagesx($img);
			$alto_n = 250;
			$ancho_n = round($alto_n*$ancho/$alto);	
			$duplicado = imagecreatetruecolor($ancho_n, $alto_n);
			imagecopyresampled( $duplicado, $img, 0,0,0,0, $ancho_n, $alto_n, $ancho, $alto );
			imagejpeg($duplicado,$name,100);
			imagedestroy($duplicado);
			imagedestroy($img);
			$c=$c.", RUTA_IMG='$titulo'";
		}
		if(isset($_POST['calles'])&&texto($_POST["calles"])){
			$calles=control($_POST['calles']);
			$c=$c.", UBICACION='$calles' ";
		}
		if(isset($_POST['fecha_m'])&&fecha_f($_POST["fecha_m"])){
			$fecha=control($_POST['fecha_m']);
			$c=$c.", FECHA_M='$fecha' ";
		}
		$elnom="SELECT ID FROM usuario WHERE usuario.MAIL='$_SESSION[s_mail]'";
		$f=mysqli_query($cnx, $elnom);
		$elid = mysqli_fetch_assoc($f);
		$elid=$elid["ID"];
		$c=$c." WHERE publicacion.ID=$_SESSION[epublic] AND publican.FKPUBLICACION=publicacion.ID";
		$_SESSION['epublic']=false;
			mysqli_query($cnx, $c);
			$f = mysqli_affected_rows( $cnx );
			$rta = $f == -1 ? 'error': 'realizado';
			if($rta=="realizado"){
				header("Location: ../index.php?boton=Publicar&rta2=update");
			}
			else{
				header("Location: ../index.php?boton=Publicar&rta2=error");
			}
		}
}
}

?>