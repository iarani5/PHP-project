<?php
	include ("config.php");
	include ("php/arrays.php");
	include ("php/funciones.php");
	$abuscar="WHERE ";
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/estilos.css" />
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Hammersmith+One' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Six+Caps' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Julius+Sans+One' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="">
		<title>REDMASCOTERA</title>
		<script src="slider/sliderengine/jquery.js"></script>
		<script src="slider/sliderengine/amazingslider.js"></script>
		<link rel="stylesheet" type="text/css" href="slider/sliderengine/amazingslider-1.css">
		<script src="slider/sliderengine/initslider-1.js"></script>

	</head>
	<body>
		<header>
		<h1><a href='index.php?'>REDMASCOTERA</a></h1>
			<?php
				if(isset($_SESSION["s_nombre"])&&isset($_SESSION['s_nivel'])){echo "<p id='usr'>".$_SESSION['s_nivel'].": ".$_SESSION['s_nombre']."</p>";} 
			?>
		</header>
		<main>
	<?php
	echo "<div id='submenu'>
	<a id='btn_buscador' href='index.php?boton=buscador'></a>";
			echo "<ul id='buscador'>";
			if(isset($_SESSION["s_nivel"])){
					if($_SESSION["s_nivel"]=='admin'){
						echo "<li><a href='index.php?boton=home&amp;ac=Estadisticas'>ESTADISTICAS</a></li>";
					}
			}
			echo "<li><a href='index.php?boton=info'>INFO</a></li>";
				if(isset($_SESSION["s_nivel"])){
					if($_SESSION["s_nivel"]=='admin'){
						echo "<li><a href='index.php?boton=home&amp;ac=Usuarios'>USUARIOS</a></li>";
					}
					echo "<li><a href='index.php?boton=home&amp;ac=Publicaciones'>MIS PUBLICACIÓNES</a></li>";	
					echo "<li><a href='index.php?boton=Publicar'>PUBLICAR</a></li>";	
					if($_SESSION['s_nivel']=='usuario'){echo "<li><a href='index.php?boton=Perfil'>PERFIL</a></li>";}	
					echo "<li><a href='adm_/usuarios.logout.php'>LOGOUT</a></li>";
				}
				else{
					echo "<li><a href='index.php?boton=Login'>LOGIN</a></li>";
					echo "<li><a href='index.php?boton=Registro'>REGISTRO</a></li>";
				}
			echo "</ul></div>";
			if(isset($_GET['rta'])&&$_GET['rta']=='ok'){
				echo "<p id='tope'>Sus datos se han actualizado con éxito</p>";
			}
			if(isset($_GET['boton'])&&control($_GET['boton'])){
				$i=$_GET['boton'];
				switch($i){
					case 'home':
						if(isset($_SESSION['logueado'])){
							include('adm_/home.php');	
						}
						else{
							echo "<p id='tope'>No tenes permiso para ingresar en esta sección.</p>";
							include('php/contenidos/cont_index.php');
						}
					break;
					case 'Publicar':
						if(isset($_SESSION['logueado'])){
							include('adm_/publicar.php');	
						}
						else{
							echo "<p id='tope'>No tenes permiso para ingresar en esta sección.</p>";
							include('php/contenidos/cont_index.php');
						}
					break;
					case 'info':	
						include('php/contenidos/cont_info.php');
					break;
					case 'Gatos': case 'Perros': case "buscador":
						include('php/contenidos/cont_index.php');
						include('php/contenidos/cont_listado.php');
					break;
					case 'Login': case 'Registro':	case 'Perfil':
						include('php/contenidos/cont_index.php');
						if($_GET['boton']=='Perfil'){
							$i='Editar mi informacion';
						}
						echo "<div id='registro'><div><div id='cerrar' onclick='cerrar_menu();'>CERRAR</div><h2>$i</h2>";
						if($i=='Login'){
							if(isset($_GET['rta_login'])){
										switch($_GET['rta_login']){
											case 'ok':
												echo "<p>Felicitaciones, ya estas registrado! Inicia sesión para realizar una publicación.</p>";
											break;
										}
							}
							if( isset($_GET['estado'] ) ){
								echo "<p>Mail o contraseña incorrecta.</p>";
							}
							echo "<form action='adm_/usuarios.login.php' method='post' name='login' id='login'>
									<label>Mail :</label>
									<input  name='mail' type='text'>
									<label>Contraseña :</label>
									<input name='cont' type='password'>";
						}
						else
						{	
							if($i!='Registro'&&$_SESSION['s_nivel']=='usuario'){
								$c1="SELECT 
								* 
								FROM usuario 
								WHERE usuario.MAIL='$_SESSION[s_mail]' LIMIT 1";
								$res = mysqli_query($cnx,$c1);
								while($a = mysqli_fetch_assoc($res)){
									$_SESSION['e_nombre']=$a['NOMBRE'];
									$_SESSION['e_apellido']=$a['APELLIDO'];
									$_SESSION['e_tel']=$a['TELEFONO'];
									$_SESSION['editar']=true;
								}
							}
								if(isset($_GET['rta'])&&control($_GET['rta'])){
										switch($_GET['rta']){
											case 'contrasenia':
												echo "<p>Contraseña no valida.</p>";
											break;
											case 'Nombre':
											case 'Apellido':
											case 'Nombre de usuario':
											case 'Telefono':
											case 'Mail':
												echo "<p>".$_GET['rta']." no valido.</p>";
											break;
											case 'error':
												echo "<p>Se produjo un error, verifique sus datos y vuelva a intentarlo.</p>";
											break;
											default:
												echo "<p id='tope'>El contenido ".$_GET['rta']." no exsiste en esta web.</p>";
											break;
										}
							}
							echo "<form action='adm_/usuarios.registro.php' method='post' name='reg' id='login'> 		
									<div><label>Nombre :</label>
									<input id='nombre' name='nombre' type='text' ";
									if($i!='Registro'){
										if(isset($_SESSION["e_nombre"])){
											echo "value='".$_SESSION["e_nombre"]."'";
										}
									}
									else{
										if(isset($_SESSION["r_nombre"])){
											echo "value='".$_SESSION["r_nombre"]."'";
										}
									}
									echo "></div>
									<div><label>Apellido :</label>
									<input id='apellido' name='apellido' type='text' ";
									if($i!='Registro'){
										if(isset($_SESSION["e_apellido"])){
											echo "value='".$_SESSION["e_apellido"]."'";
										}
									}
									else{
										if(isset($_SESSION["r_apellido"])){
											echo "value='".$_SESSION["r_apellido"]."'";
										}
									}
									echo "></div>";
									if($i=='Registro'){
										echo "<div><label>Mail :</label>
									<input id='mail' name='mail' type='email' ";
									if(isset($_SESSION["r_mail"])){echo "value='".$_SESSION["r_mail"]."'";} 
									echo "></div>";
									}
									echo "<div><label>Contraseña :</label>
									<input id='contrasenia' name='contrasenia' type='password'></div>";
									if($i!='Registro'){
										echo "<div><label>Nueva contraseña :</label>
										<input id='contrasenia2' name='contrasenia2' type='password'></div>";
									}
									echo "<div><label>Telefono:</label>
									<input id='tel' name='tel' type='text' ";
									if($i!='Registro'){
										if(isset($_SESSION["e_tel"])){
											echo "value='".$_SESSION["e_tel"]."'";
										}
									}
									else{
										if(isset($_SESSION["r_tel"])){
											echo "value='".$_SESSION["r_tel"]."'";
										}
									}
									echo "></div>";
									
						}
						echo "<button name='submit' type='submit'>Enviar</button>
							</form></div></div>";
					break;
					default:
						include('php/contenidos/cont_index.php');
						echo "<p id='tope'>El contenido <mark>$_GET[boton]</mark> no exsiste en esta web.</p>";
						
					break;
				}
			}
			else{
				include('php/contenidos/cont_index.php');
			}
		?>
		</main>
		<footer></footer>
		<script>
			function tn(p,e,n){
				if(!isNaN(n)){
					return p.getElementsByTagName(e)[n];
				}
				return p.getElementsByTagName(e);
			}
			function id(e){
				return document.getElementById(e);
			}
			function ce(e){
				return document.createElement(e);
			}
			function ac(p,e){
				return p.appendChild(e);
			}
			function rc(p,e){
				return p.removeChild(e);
			}
			function txt(s){
				return document.createTextNode(s);
			}
			function opacidad(t){
				t.style.opacity='0.1';
				setTimeout(function () {
				t.style.opacity='1';
				}, 200);
			}
	function texto(val){
		var exp=/^[a-zaeiou\s]{3,35}$/i;
		return exp.test( val);
	}
	function fecha_f(val){
		var exp=/^(0?[1-9]|1[0-9]|2[0-9]|3[0-1])(\/)(0?[1-9]|1[0-2])(\/)(199[6-9]|20[0-1][0-9])$/;
		return exp.test(val);
	}
	function foto_f(val){
		var exp=/^.+(.jpe?g)$/i;
		return exp.test(val); 
	}
	function email_f(val){
		var exp=/^([a-zA-Z\d\-\.]{3,25}@[a-z]{3,15}\.[a-z]{2,4})?$/;
		return exp.test( val);
	}
	function cont(val){
		var exp=/^([a-zA-Z\d_#,;~@%&\\\!\$\^\*\(\)\-\+\=\{\}\[\]\:\'\\<\>\.\?\|]{3,15})?$/;
		return exp.test( val);
	}
	function telefono(val){
		var exp=/^[\d\s\-]{8,15}$/;
		return exp.test(val);
	}
	function validar(e){
				switch(e.name){
								case 'nombre': case 'apellido': case 'nombre_animal': case 'pelo': case 'raza':  case 'localidad':  case 'barrio':  case 'calles':
									if(!texto(e.value)){
										if(!e.value==''){
											var tx=txt('Solo puede poseer letras y espacios. Mínimo 3 caracteres, máximo 35.');				
										}
									}
								break;
								case 'fecha': case 'fecha_m':
									if(!fecha_f(e.value)){
										if(!e.value==''){
											var tx=txt('La fecha debe ser válida. Separada por barra (/)');
										}
									}
								break;
								case 'foto':
									if(!foto_f(e.value)){
										if(!e.value==''){
											var tx=txt('El formato debe ser JPG');
										}
									}
								break;
								case 'mail':
									if(!email_f(e.value)){
										var tx=txt('El email es inválido.');
									}
								break;
								case 'contrasenia': case 'contrasenia2':
									if(!cont(e.value)){
										var tx=txt('Mínimo 3 caracteres, máximo 15. Sin espacios.');
									}
								break;
								case 'tel': case 'telefono':
									if(!telefono(e.value)){
										var tx=txt('Deben ser numeros. Mínimo 8, máximo 15.');
									}
								break;
							}
							if(tx){
								e.style.border='solid red 1px';
								var p=tn(e.parentNode,'p',0);
								if(p==undefined){
									p=ce('p');
									ac(p,tx);
									p.style.display="inline-block";
									p.style.margin="1.1em 0 0 .2em";
									p.style.position="absolute";
									p.style.background="red";
									p.style.borderRadius="5px";
									p.style.padding=".2em";
									p.id="valid";
									p.style.fontFamily="monospace";
									opacidad(p);
									ac(e.parentNode,p);
								}
							}
							else{
								e.style.border='1px solid #aaa';
								var p=tn(e.parentNode,'p',0);
								if(p!=undefined){
									rc(p.parentNode,p);
								}
							}
			}
			function cerrar_menu(){
				var ul=document.getElementById('cerrar');
				if(ul!=undefined){
					rc(ul.parentNode.parentNode.parentNode,ul.parentNode.parentNode);
				}
				ban1=0;
			}
			var h=document.getElementById('registro');
			if(h!=undefined){
				h2=h.getElementsByTagName('div')[0].getElementsByTagName('h2')[0];
				if(h2.innerHTML.substring(0,1)=='L'){
					h2.parentNode.style.background="url('img/iconos/casa.png') no-repeat 80% 40% #bb97bb";
				}
				else{
					var form=document.getElementById('login');
					if(form.name=='reg'){
						form.style.marginLeft='50%';
						h2.parentNode.style.background="url('img/iconos/collar.png') no-repeat 20% 50% rgb(127, 199, 175)";
						var inputs=[];
						var nombre=id('nombre');
						inputs.push(nombre);
						var apellido=id('apellido');
						inputs.push(apellido);
						var tel=id('tel');
						inputs.push(tel);
						var email=id('mail');
						inputs.push(email);
						var clave=id('contrasenia');
						var clave2=id('contrasenia2');
						inputs.push(clave2);
						inputs.push(clave);
						for(var i=0;i<inputs.length;i++){
							if(inputs[i]!=null){
									console.log(inputs[i]);
								inputs[i].onblur=function(){
										validar(this);
								}
							}
						}
						form.onsubmit=function(){
							for(var i=0;i<inputs.length;i++){
								if(inputs[i]!=null){
									if(!(inputs[i].id=="contrasenia2"&&inputs[i].value==""||inputs[i].id=="contrasenia"&&inputs[i].value=="")){
										inputs[i].validar(this);
									}
								}
							}
						}
						}
					}
				}
				var tope=document.getElementById("tope");
				if(tope!=null){
					var p = document.createElement('p');
					p.style.display='inline-block';
					p.style.bottom='0px';
					p.style.cssFloat='right';
					p.style.left='10px';
					p.style.position=' fixed';
					p.style.color='black';
/* 					p.style.background='rgba';
 */					p.style.padding='.5em';
					var tx=document.createTextNode('9');
					p.appendChild(tx);
					tope.appendChild(p);
					var contador = setInterval( 
					function(){
						p.innerHTML--;	
						if(p.innerHTML<=0){
							clearTimeout(contador);
							if(tope.parentNode!=null){
								if(tope.parentNode.length!=0){
									tope.parentNode.removeChild(tope);
									p.parentNode.removeChild(p);
									tope.length=0;
								}
							}
						}
					},
					1000);
				}
				var cerrar2=id("cerrar2");
				if(cerrar2!=undefined&&cerrar2!=null){
					cerrar2.cerrar_buscador=function(){
						rc(cerrar2.parentNode.parentNode,cerrar2.parentNode);
					}
				}
			var listado=document.getElementById("cont_listado");
			if(listado!=undefined){
				var tope=id("tope");
				if(tope!=undefined){
					ac(listado.parentNode,tope);
					rc(listado.parentNode,listado);
				}
			var h2=listado.getElementsByTagName("h2")[0];
			var ch=listado.getElementsByTagName("div");
			if(!ch.length&&h2!=undefined){
				var p=document.createElement("p");
				if(h2.innerHTML.substring(0,1)=='R'){
					var tx=txt("No se encontraron resultados.");
					p.style.color="white";
				}
				else{
					var tx=txt("No hay contenido");
				}
				p.appendChild(tx);
				p.style.background="none";
				p.style.fontSize="1.5em";
				p.style.paddingTop="4em";
				listado.appendChild(p);
			}
			if(h2!=undefined){
				if(h2.innerHTML.substring(0,1)=='G'){
					//h2.parentNode.style.backgroundColor='rgba(255,228,115,0.9)';
					if(!ch.length){
						listado.style.background="url(img/iconos/gato_fondo.png) no-repeat  66% 30% ";
					}
				}
				else if(h2.innerHTML.substring(0,1)=='R'){
					h2.style.color='white';
					//h2.parentNode.style.backgroundColor='rgba(125,98,78,0.9)';
				}
				else{
					//h2.parentNode.style.backgroundColor='rgba(126,233,181,0.9)';
					if(!ch.length){
						listado.style.background="url(img/iconos/perro_fondo.png) no-repeat 35% 30%";
					}
				}
			}
			else{				
				listado.parentNode.removeChild(listado);
			}
	}
				
var as=id('cont_index');
if(as!=undefined){
	as=tn(id("cont_index"),"a");
}
if(as!=undefined){
for(var i=0;i<as.length;i++){
	as[i].onclick=function(){
		var menu=tn(id('rta'),'nav',0);
		if(menu!=undefined){
			rc(menu.parentNode,menu);
		} 
		var ul=ce('ul');	
		var nav=ce('nav');	
		var li=ce('li');
		var a=ce('a');
		var tx=txt('TODOS');
		a.href='index.php?boton='+this.innerHTML;
		opacidad(a);
		ac(a,tx);
		ac(li,a);
		ac(ul,li);
		tx=txt('EN ADOPCIÓN');
		li=ce('li');
		a=ce('a');
		a.href='index.php?boton='+this.innerHTML+'&cat=Adopcion';
		opacidad(a);
		ac(a,tx);
		ac(li,a);
		ac(ul,li);
		li=ce('li');
		a=ce('a');
		tx=txt('ENCONTRADOS');
		a.href='index.php?boton='+this.innerHTML+'&cat=Encontrados';
		opacidad(a);
		ac(a,tx);
		ac(li,a);
		ac(ul,li);
		li=ce('li');
		a=ce('a');
		tx=txt('PERDIDOS');
		a.href='index.php?boton='+this.innerHTML+'&cat=Perdidos';
		opacidad(a);
		ac(a,tx);
		ac(li,a);
		ac(ul,li);
		ac(id('rta'),nav);
		ac(nav,ul);
		if(this.innerHTML=='Perros'){
			ul.style.borderRight='.4em solid #7ee9b5';
			ul.style.paddingRight='.2em';
			ul.style.textAlign='right';
		}else{
			ul.style.borderLeft='.4em solid #b0a3b5';
			ul.style.textAlign='left';
			ul.style.paddingLeft='.2em';
		}
	}
}
}
var img=id("modal");
var body=tn(tn(document,"body",0),"main",0);
if(img!=undefined){
	img=tn(img,"img",0);
	img.style.cursor="pointer";
	if(img!=undefined){
		img.onclick=function(){
			var img_grande=ce("img");
			var pa=tn(id("modal"),"div",0);
			var clon=pa;
			rc(pa.parentNode,pa);
			var mod=ce("div");
			ac(id("modal"),mod);
			
			img_grande.src=this.src.substring(0,this.src.length-9)+'.jpg';
			img_grande.alt=this.alt;
			img_grande.style.boxShadow="5px 5px 20px white, -5px -5px 20px white";
			id("modal").style.background="rgba(0,0,0,0.9)";
			mod.style.background="none";
			mod.style.border="none";
			mod.style.boxShadow="none";
			mod.style.textAlign="center";
			var h6=ce("h6");
			var tx=txt(img_grande.alt);
			ac(h6,tx);
			var x=ce("div");
			x.id="cerrar";
			var tx=txt("X");
			ac(x,tx);
			ac(mod,x);
			ac(mod,h6);
			ac(mod,img_grande);
			x.onclick=function(){
				rc(id("modal"),mod);
				ac(id("modal"),clon);
				id("modal").style.background="none";
			}
			
		}
	}
}
		</script>
	</body>
</html>
