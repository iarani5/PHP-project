<?php
	include("../config.php");

	$pa = "SELECT COUNT(ID) AS NIVEL_USUARIO FROM usuario WHERE usuario.NIVEL='usuario' AND usuario.BORRADO='no'";
	$f = mysqli_query($cnx, $pa);
	$a = mysqli_fetch_assoc($f);
	$a=$a["NIVEL_USUARIO"];
	
	$pa = "SELECT COUNT(ID) AS NIVEL_ADMIN FROM usuario WHERE usuario.NIVEL='admin' AND usuario.BORRADO='no'";
	$f = mysqli_query($cnx, $pa);
	$b = mysqli_fetch_assoc($f);
	$b=$b["NIVEL_ADMIN"];
	
	$pa = "SELECT COUNT(ID) AS CANTIDAD_PUBLICACIONES FROM publicacion";
	$f = mysqli_query($cnx, $pa);
	$c = mysqli_fetch_assoc($f);
	$c=$c["CANTIDAD_PUBLICACIONES"];
	
	$suma=$a+$b+$c;
	$as=round($a*100/$suma,2);
	$bs=round($b*100/$suma,2);
	$cs=round($c*100/$suma,2);
	
	$valores=array("Administradores"=>$b,"Usuarios"=>$a,"Publicaciones"=>$c);
	
	header( "Content-type: image/gif" );

	$img_w=500;
	$img_h=400;
	$img_margen=100;
	$origen=$img_h-150;
	
	$img=imagecreate($img_w,$img_h);
	$bg=imagecolorallocate($img,255,255,255);
	$letras=imagecolorallocate($img,0,0,0);
	$negro=imagecolorallocate($img,0,0,0);
	$rojo=imagecolorallocate($img,91,122,186);
	$sombra=imagecolorallocate($img,195,195,195);
	$gris=imagecolorallocate($img,255,255,255);
	
	$cant=count($valores);
	$dist=($img_w-($img_margen*2))/$cant;
	$max=max($valores);
	$min=min($valores);
	$escala=($origen-20)/$max;
	
	$f=8;
	$f_w=imagefontwidth($f);
	$f_h=imagefontheight($f);
	
	imageline($img,40,$origen-($max*$escala),$img_w-40,$origen-($max*$escala),$sombra);
	
	imageline($img,40,$origen-($min*$escala),$img_w-40,$origen-($min*$escala),$sombra);
	
	imagestring($img,$f,35-($f_w*strlen($max)),$origen-($max*$escala)-($f_h/2),$max,$gris);
	
	imagestring($img,$f,$img_w-35,$origen-($max*$escala)-($f_h/2),$max,$gris);
	
	imagestring($img,$f,35-($f_w*strlen($min)),$origen-($min*$escala)-($f_h/2),$min,$gris);
	
	imagestring($img,$f,$img_w-35,$origen-($min*$escala)-($f_h/2),$min,$gris);
	
	imagesetthickness($img,46);
	
	$barra=0;
	foreach($valores as $item =>$valor){
		$x=intval($img_margen+($dist/2)+($dist*$barra));
		$y=intval($origen-($valor*$escala));
		imageline($img,$x-6,$y+6,$x-6,$origen,$sombra);
		imageline($img,$x,$y,$x,$origen,$rojo);
		
		imagestringup($img,$f,$x-($f_h/2),$origen+5+(strlen($item)*$f_w),$item,$negro);
		imagestringup($img,$f,$x-($f_h/2),$origen-5,$valor,$letras);
		$barra++;
	}
	
	imagesetthickness($img,1);
	imageline($img,10,$origen,$img_w-10,$origen,$negro);
	imagegif($img);
	imagedestroy($img);
?>
