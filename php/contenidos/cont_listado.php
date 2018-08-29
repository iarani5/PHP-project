<div id='cont_listado'>
<?php

if(isset($_GET["cat"])&&!($_GET['cat']=='Adopcion'||$_GET['cat']=='Encontrados'||$_GET['cat']=='Perdidos')){
	echo "<p id='tope'>El contenido <mark>$_GET[cat]</mark> no exsiste en esta web</p>";
}
$link="";
foreach($_GET as $i=>$j){
	$link.=$i."=".$j."&amp;";
}
$link=substr($link,0,-5);
$abuscar="WHERE ";
if(isset($_GET["estado_pub"])&&$_GET["estado_pub"]!="todo"){
		$abuscar=$abuscar."publicacion.ESTADO='".control($_GET["estado_pub"])."' AND ";
	}
	if(isset($_GET["especie"])&&$_GET["especie"]!="todo"){
		$abuscar=$abuscar."publicacion.ESPECIE='".control($_GET["especie"])."' AND ";
	}
	if(isset($_GET["sexo"])&&$_GET["sexo"]!="todo"){
		$abuscar=$abuscar."publicacion.SEXO='".control($_GET["sexo"])."' AND ";
	}
	if(isset($_GET["edad"])&&$_GET["edad"]!="todo"){
		$abuscar=$abuscar."publicacion.EDAD='".control($_GET["edad"])."' AND ";
	}
	if(isset($_GET["tamanio"])&&$_GET["tamanio"]!="todo"){
		$abuscar=$abuscar."publicacion.TAMANIO='".control($_GET["tamanio"])."' AND ";
	}
	
	if(isset($_GET["nombre_animal"])&&$_GET["nombre_animal"]!=""){
			$abuscar=$abuscar."publicacion.NOMBRE_ANIMAL LIKE '%".control($_GET["nombre_animal"])."%' AND ";
	}
	if(isset($_GET["raza"])&&$_GET["raza"]!=""){
			$abuscar=$abuscar."publicacion.RAZA LIKE '%".control($_GET["raza"])."%' AND ";
	}
	if(isset($_GET["pelo"])&&$_GET["pelo"]!=""){
		$abuscar=$abuscar."publicacion.COLOR LIKE '%".control($_GET["pelo"])."%' AND ";
	}
	if(isset($_GET["descripcion"])&&$_GET["descripcion"]!=""){
		$abuscar=$abuscar."publicacion.DESCRIPCION LIKE '%".control($_GET["descripcion"])."%' AND ";
	}
	/*if(isset($_GET["provincia"])){
		$abuscar.="PROVINCIA LIKE='%$_GET[provincia]%' AND ";
	}*/
	if(isset($_GET["localidad"])&&$_GET["localidad"]!=""){
		$abuscar=$abuscar."publicacion.LOCALIDAD LIKE '%".control($_GET["localidad"])."%' AND ";
	}
	if(isset($_GET["barrio"])&&$_GET["barrio"]!=""){
		$abuscar=$abuscar."publicacion.BARRIO LIKE '%".control($_GET["barrio"])."%' AND ";
	}
	if(isset($_GET["calles"])&&$_GET["calles"]!=""){
		$abuscar=$abuscar."publicacion.UBICACION LIKE '%".control($_GET["calles"])."%' AND ";
	}
	if(isset($_GET["fecha_m"])&&$_GET["fecha_m"]!=""){
		$abuscar=$abuscar."publicacion.FECHA_M LIKE '%".control($_GET["fecha_m"])."%' AND ";
	}
	if(isset($_GET["provincia"])&&$_GET["provincia"]!=""&&$_GET["provincia"]!="todo"){
		$abuscar=$abuscar." publicacion.FKPROVINCIA='".intval($_GET["provincia"])."' AND ";
	}
	if(isset($_GET["ojos"])&&$_GET["ojos"]!=""&&$_GET["ojos"]!="todo"){
		$abuscar=$abuscar." publicacion.FKOJOS='".intval($_GET["ojos"])."' AND ";
	}
	$cantidad = 6;
	if(isset($_GET['boton'])||$abuscar!="WHERE "){
		if(isset($_GET['boton'])&&($_GET['boton']=='Gatos'||$_GET['boton']=='Perros')){
			$btn=substr($_GET["boton"],0,-1);
			$titulo=$_GET["boton"];
			$busqueda2="AND publicacion.ESPECIE='$btn '";
		}
		else if(isset($_GET["boton"])&&$_GET["boton"]=="buscador"){
			$titulo="";
		}
		else if($abuscar!="WHERE "){
			$abuscar = substr($abuscar, 0, -4);
			$titulo="Resultados de busqueda";
		}
		
			if(isset($_GET['cat'])&&($_GET['cat']=='Adopcion'||$_GET['cat']=='Encontrados'||$_GET['cat']=='Perdidos')||$abuscar!="WHERE "){
				if(isset($_GET["cat"])){
					if($_GET["cat"]!='Adopcion'){
						$cat=substr($_GET["cat"],0,-1);
					}
					else{
						$cat=$_GET["cat"];
					}
					$busqueda2.=" AND publicacion.ESTADO='$cat' ";
				}
			}
				$pagina = isset($_GET['pag'])? $_GET['pag']:1;
				if($abuscar!="WHERE "){
					$cap="";
					if(isset($_GET["ojos"])&&!isset($_GET["ojos"])){
						$cap=" ojos, ";
						$cap2=" AND ojos.ID=publicacion.FKOJOS ";
					}
					if(isset($_GET["provincia"])&&!isset($_GET["provincia"])){
						$cap=" provincia, ";
						$cap2=" AND provincia.ID=publicacion.FKPROVINCIA ";
					}
					if(isset($_GET["provincia"])&&isset($_GET["ojos"])){
						$cap=" provincia, ojos,";
						$cap2=" AND provincia.ID=publicacion.FKPROVINCIA AND ojos.ID=publicacion.FKOJOS ";	
					}
					if(!isset($_GET["provincia"])&&!isset($_GET["ojos"])){
						$cap="";
						$cap2="";
					}
					$pa="SELECT COUNT(publicacion.ID) AS TOTAL FROM $cap publican JOIN publicacion $abuscar AND publican.FKPUBLICACION=publicacion.ID AND publican.BORRADO='no' $cap2";
				}
				else{
					if(!isset($busqueda2)){$busqueda2="";}
					$pa = "SELECT COUNT(publicacion.ID) AS TOTAL FROM publican JOIN publicacion WHERE publican.FKPUBLICACION=publicacion.ID $busqueda2 AND publican.BORRADO='no'";
				}
				$f = mysqli_query($cnx, $pa);
				$a = mysqli_fetch_assoc($f);
				$registros = $a['TOTAL'];
				$paginas = ceil($registros/$cantidad);
				if( $pagina > $paginas ){
					$pagina = $paginas;
				}
				$inicio = $cantidad * ($pagina-1);
				if( $inicio < 0 ){ $inicio = 0; }
				if(isset($_GET["cat"])){
					$c=control($_GET['cat']);
					if($c=='Adopcion'){$c='en Adopción';}
					if($c=='Perdido'){$c='Perdidos';}
					if($c=='Encontrado'){$c='Encontrados';}
				}
				else{
					$c="";
				}
				echo "<h2>$titulo $c</h2>";
					if(isset($_GET["publi"])){
						$num_publi=control($_GET["publi"]);
							$c4="SELECT 
								publicacion.BARRIO,
								publicacion.COLOR,
								publicacion.DESCRIPCION,
								publicacion.EDAD,
								publicacion.ESPECIE,
								publicacion.ESTADO,
								publicacion.FECHA_M,
								provincia.PROVINCIA,
								ojos.OJOS,
								publicacion.LOCALIDAD,
								publicacion.MAIL,
								publicacion.NOMBRE_ANIMAL,
								publicacion.NOMBRE_HUMANO,
								publicacion.RAZA,
								publicacion.SEXO,
								publicacion.RUTA_IMG,
								publicacion.TAMANIO,
								publicacion.TELEFONO,
								publicacion.UBICACION AS CALLES,
								usuario.MAIL,
								DATE_FORMAT(publican.FECHA_A,'%d/%m/%Y') AS FECHA_ALTA
							FROM 
								publicacion, 
								publican,
								ojos,
								provincia,
								usuario
							WHERE publicacion.ID='$num_publi' AND usuario.ID=publican.FKNOMBRE AND publican.BORRADO='no' AND provincia.ID=publicacion.FKPROVINCIA 
							group by publicacion.ID ";
							$res = mysqli_query($cnx,$c4);
							$an =  mysqli_affected_rows($cnx);
							if(!$an){
								echo "<p id='tope'>La publicacion <mark>$_GET[publi]</mark> no existe en esta web</p>";
							}
							while($b = mysqli_fetch_assoc($res)){
								print_f( "<div id='modal'><div><div id='cerrar' onclick='cerrar_menu();'>CERRAR</div>
									<h4>FECHA DE ALTA: $b[FECHA_ALTA]<br>Nombre: $b[NOMBRE_ANIMAL]</h4>
									<figure><picture><img src='publicaciones/$b[RUTA_IMG]/$b[RUTA_IMG]-mini.jpg' alt='$b[NOMBRE_ANIMAL]' onclick='ampliar_foto();'/></picture></figure>
									<div class='sub'><h5>Datos de la mascota</h5>
									<ul>
										<li>ESTADO: $b[ESTADO]</li>
										<li>ESPECIE: $b[ESPECIE]</li>
										<li>SEXO: $b[SEXO]</li>
										<li>COLOR DE PELO: $b[COLOR]</li>
										<li>COLOR DE OJOS: $b[OJOS]</li>
										<li>TAMAÑO: $b[TAMANIO]</li>
										<li>EDAD: $b[EDAD]</li>
										<li>RAZA: $b[RAZA]</li>
										<li>DESCRIPCIÓN: $b[DESCRIPCION]</li>");
										if($b["FECHA_M"]!=''){
											if($b["ESTADO"]=="Encontrado"||$b["ESTADO"]=="Perdido"){
												$agre=" $b[ESTADO]:";
											}
											else{
												$agre=" Nacimiento:";
											}
											echo "<li>FECHA$agre $b[FECHA_M]</li>";
										}
										if($b["CALLES"]!=""){
											print_f("<li>CALLES: $b[CALLES]</li>");
										}
									print_f( "</ul></div>
									<div class='sub'><h5>Datos de contacto</h5>
									<ul>
										<li>LOCALIDAD: $b[LOCALIDAD]</li>
										<li>BARRIO: $b[BARRIO]</li>");
										
										
										print_f("<li>MAIL: $b[MAIL]</li>
										<li>NOMBRE: $b[NOMBRE_HUMANO]</li>
										<li>TELEFONO: $b[TELEFONO]</li>
									</ul></div>
								</div>
								</div>");
							}
					}
					if(isset($_GET["boton"])&&$_GET["boton"]!="buscador"){
						$paracon="where publican.FKNOMBRE=usuario.ID AND publicacion.ESPECIE='$btn' ";
						if(isset($_GET["cat"])){
							if($_GET["cat"]=="Perdidos"||$_GET["cat"]=="Encontrados"){
								$_GET["cat"]=substr($_GET["cat"],0,-1);
							}
							$paracon.="  AND publicacion.ESTADO='$_GET[cat]'";
						}
					}
					else if(isset($_GET["boton"])&&$_GET["boton"]=="buscador"){
						$paracon="";
					}
					else if($abuscar!="WHERE "){
						$paracon=$abuscar;
					}
					$con="SELECT 
						DATE_FORMAT(publican.FECHA_A,'%d/%m/%Y') AS FECHA,
						publicacion.NOMBRE_ANIMAL,
						publicacion.ESTADO,
						CONCAT(publicacion.LOCALIDAD,' / ',publicacion.BARRIO) AS DIREC,
						publicacion.NOMBRE_HUMANO,
						publicacion.RUTA_IMG,
						publicacion.MAIL,
						publicacion.TELEFONO,
						publicacion.ID
						FROM 
						usuario,
						publican JOIN publicacion ON publican.FKPUBLICACION=publicacion.ID
						$paracon AND publican.BORRADO='no'
						GROUP BY publican.ID 
						LIMIT $inicio, $cantidad";
					$res = mysqli_query($cnx,$con);
					while($a = mysqli_fetch_assoc($res)){
						if($abuscar=="WHERE "){
							if(isset($_GET["cat"])){
								if($_GET["cat"]=="Perdido"||$_GET["cat"]=="Encontrado"){
									$_GET["cat"]=$_GET["cat"]."s";
									$link="boton=$_GET[boton]&amp;cat=$_GET[cat]";
								}
								else if($_GET["cat"]=="Adopcion"){
									$link="boton=$_GET[boton]&amp;cat=$_GET[cat]";
								}
							}
							else{
								$link="boton=$_GET[boton]";
							}
						}
						print_f("
							<div class='listar_publicacion'>
								<h3>Fecha Alta:$a[FECHA]<br>Estado: $a[ESTADO]</h3>
								<div><img src='publicaciones/$a[RUTA_IMG]/$a[RUTA_IMG]-mini.jpg' alt='$a[NOMBRE_ANIMAL]'/></div>
								<ul>
									<li>NOMBRE: $a[NOMBRE_ANIMAL]</li>
									<li>$a[DIREC]</li>
									<li>CONTACTO: $a[NOMBRE_HUMANO]</li>
									<li>MAIL: $a[MAIL]</li>
									<li>TELEFONO: $a[TELEFONO]</li>
								</ul>
								<a href='index.php?$link&amp;");
								if(isset($_GET["pag"])){
									echo "pag=$_GET[pag]&amp;";
								}
						print_f("publi=$a[ID]'>VER PUBLICACIÓN</a>
							</div>");
					}	
					if( $paginas > 1 ){
						echo "<div id='pag'>";
							if( $pagina > 1 ){
								$anterior = $pagina-1;
								if($abuscar!="WHERE "){
									echo "<a href='index.php?$link&amp;pag=$anterior'><< ANTERIOR</a> ";
								}
								else{
									echo "<a href='index.php?$link&amp;pag=$anterior'><< ANTERIOR</a> ";
								}
							}
							for( $i = 1; $i <= $paginas; $i++){
								$css = ($i==$pagina)? 'style="color: white"':'';
								if($abuscar!="WHERE "){
									echo "<a href='index.php?$link&amp;pag=$i' $css>$i</a> ";
								}
								else{
									echo "<a href='index.php?$link&amp;pag=$i' $css>$i</a> ";
								}
							}
							if( $pagina < $paginas ){
								$siguiente = $pagina+1;
								if($abuscar!="WHERE "){
									echo "<a href='index.php?$link&amp;pag=$siguiente'>SIGUIENTE >></a> ";
								}
								else{
									echo "<a href='index.php?$link&amp;pag=$siguiente'>SIGUIENTE >></a> ";
								}
							}
						echo "</div>";
						if(isset($_GET["pag"])&&($_GET["pag"] > $paginas || !intval($_GET["pag"]))){
							echo "<div><p id='lapag'>Pagina no encontrada.</p></div>";
						}
					}
	}
	?>
	</div>