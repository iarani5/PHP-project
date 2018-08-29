<?php 
	check( );
?> 
<div id='home'>
	<h2>Panel de control</h2>
	<?php
	if(isset($_GET['modificacion'])){
		$_GET["modificacion"]=control($_GET["modificacion"]);
				if($_GET['modificacion']=='ok'){
					echo "<p id='tope'>Operación realizada con éxito.</p>";
				}
				else if($_GET['modificacion']=='error'){
					echo "<p id='tope'>Algo salió mal. Vuelva a intentarlo más tarde.</p>";
				}
				else{
					echo "<p id='tope'>El contenido <mark>$_GET[modificacion]</mark> no existe en esta web";
				}
	}
	if( isset($_GET['ac'] ) ){
		$_GET["ac"]=control($_GET["ac"]);
		if( $_GET['ac'] == 'Usuarios' && $_SESSION['s_nivel'] == 'admin'){ 
			if(isset($_GET["bo"])){
				$_GET["bo"]=control($_GET["bo"]);
			}
			if(isset($_GET['bo'])&&$_GET['bo']=='papelera'){
				echo "<h3>Usuarios: Papelera</h3>";
				$borrar='si';
				$th="<th>RESTAURAR</th><th>ELIMINAR</th>";
			}
			else{
				echo "<h3>Usuarios</h3>";
				$borrar='no';
				$th="<th>CAMBIAR NIVEL</th><th>BANNEADO</th><th>ELIMINAR</th>";
			}
					$con = "SELECT * FROM usuario WHERE usuario.BORRADO='$borrar' ORDER BY NOMBRE, APELLIDO";
					$rta = mysqli_query($cnx, $con);
					if($rta){
						echo "<table border='1'>
						<thead><tr><th>NOMBRE</th><th>APELLIDO</th><th>MAIL</th><th>TELEFONO</th><th>NIVEL</th>$th</tr></thead><tbody>";
						while( $fin = mysqli_fetch_assoc($rta) ){
							echo "<tr>";
							echo "	<td>$fin[NOMBRE]</td>";
							echo "	<td>$fin[APELLIDO]</td>";
							echo "	<td>$fin[MAIL]</td>";
							echo "	<td>$fin[TELEFONO]</td>";
							echo "	<td>$fin[NIVEL]</td>";
							if($borrar=='si'){
								echo "<td><a href='adm_/modificar.php?c=u&amp;id=$fin[ID]&amp;q=restaurar' id='restaurar'>RESTAURAR</a></td>";
								echo "<td><a href='adm_/modificar.php?c=u&amp;id=$fin[ID]&amp;q=eliminarf' id='delete'>DELETE</a></td>";
							}
							else{
								echo "<td><a href='adm_/modificar.php?c=u&amp;id=$fin[ID]&amp;q=nivel'  id='cambiar_nivel'>CAMBIAR</a></td>";
								if($fin["ACTIVO"]=="si"){
									echo "<td><a href='adm_/modificar.php?c=u&amp;id=$fin[ID]&amp;q=activo'  id='on'>ESTADO</a></td>";
								}
								else{
									echo "<td><a href='adm_/modificar.php?c=u&amp;id=$fin[ID]&amp;q=activo'  id='off'>ESTADO</a></td>";
								}
								echo "<td><a href='adm_/modificar.php?c=u&amp;id=$fin[ID]&amp;q=eliminar' id='delete'>DELETE</a></td>";
							}
							echo "</tr>";
						}
						echo "</tbody></table>";
						if($borrar=='no'){
							echo "<div id='papelera'><a href='index.php?boton=home&amp;ac=Usuarios&amp;bo=papelera'>Papelera</a></div>";
						}
						else if($borrar=="si"){
							echo "<a id='return' href='index.php?boton=home&amp;ac=Usuarios'>RETURN</a>";
						}					
					}
		}
		else if( $_GET['ac'] == 'Estadisticas' && $_SESSION['s_nivel'] == 'admin'){
			echo "<h3>Estadísticas</h3>";
			echo "<img src='adm_/estadisticas.php' alt='grafico'/>";
		}
		else if($_GET['ac'] == 'Publicaciones' && $_SESSION['s_nivel'] == 'admin'||$_GET['ac'] == 'Publicaciones' && $_SESSION['s_nivel'] == 'usuario'){
			echo "<h3>Publicaciónes";
			if(isset($_GET["bo"])&&$_GET['bo']=='papelera'){
				echo ": Papelera";
				$borrar='si';
				$th="<th>VER</th><th>RESTAURAR</th><th>ELIMINAR</th>";
			}
			else{
				$borrar='no';
				$th="<th>VER</th><th>EDITAR</th><th>ELIMINAR</th>";
			}
			echo "</h3>";
			if(isset($_GET['ver'])){
				$_GET["ver"]=intval($_GET["ver"]);
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
							WHERE publicacion.ID=$_GET[ver] AND usuario.ID=publican.FKNOMBRE AND provincia.ID=publicacion.FKPROVINCIA
							group by publicacion.ID";
							$res = mysqli_query($cnx,$c4);
							while($b = mysqli_fetch_assoc($res)){
								if($b['CALLES']==''){
									$b['CALLES']='SIN ESPECIFICAR';
								}
								echo "<div id='modal'><div>
									<h4>FECHA DE ALTA: $b[FECHA_ALTA]<br>Nombre: $b[NOMBRE_ANIMAL]</h4><div id='cerrar' onclick='cerrar_menu();'>CERRAR</div>
									<figure><picture><img src='publicaciones/$b[RUTA_IMG]/$b[RUTA_IMG]-mini.jpg' alt='$b[NOMBRE_ANIMAL]'/></picture></figure>
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
										<li>DESCRIPCIÓN: $b[DESCRIPCION]</li>
										<li>FECHA:$b[FECHA_M]</li>
									</ul></div>
									<div class='sub'><h5>Datos de contacto</h5>
									<ul>
										<li>LOCALIDAD: $b[LOCALIDAD]</li>
										<li>BARRIO: $b[BARRIO]</li>
										<li>CALLES: $b[CALLES]</li>
										
										<li>MAIL: $b[MAIL]</li>
										<li>NOMBRE: $b[NOMBRE_HUMANO]</li>
										<li>TELEFONO: $b[TELEFONO]</li>
									</ul></div>
								</div>
								</div>";
							}
					}
			if(!isset($_GET["bo"])){
					$con = "SELECT *
					FROM publican JOIN usuario ON usuario.ID = publican.FKNOMBRE 
					WHERE publican.BORRADO='no' AND usuario.MAIL='$_SESSION[s_mail]'
					GROUP BY publican.FKPUBLICACION 
					ORDER BY FECHA_A";
			}
			else if(isset($_GET["bo"])&&$_GET['bo']=='papelera'){
				$con = "SELECT *
					FROM publican JOIN usuario ON usuario.ID = publican.FKNOMBRE 
					WHERE publican.BORRADO='si' AND usuario.MAIL='$_SESSION[s_mail]'
					GROUP BY publican.FKPUBLICACION 
					ORDER BY FECHA_A";
			}
					$rta = mysqli_query($cnx, $con);
					if($rta){
						echo "<table border='1'><thead><tr><th>FECHA ALTA</th>";
						if( $_SESSION['s_nivel'] == 'admin'){
							echo "<th>MAIL</th><th>NOMBRE</th><th>APELLIDO</th>";
						}
						echo "$th</tr></thead><tbody>";
						while( $fin = mysqli_fetch_assoc($rta) ){
							echo "<tr>";
							$fecha=list($anio, $mes, $dia) = preg_split('[-]', $fin["FECHA_A"]);
							$fecha=$dia."/".$mes."/".$anio;
							echo "	<td>$fecha</td>";
							if($_SESSION['s_nivel'] == 'admin'){
								echo "	<td>$fin[MAIL]</td>";
								echo "	<td>$fin[NOMBRE]</td>";
								echo "	<td>$fin[APELLIDO]</td>";
							}
							if($borrar=='si'){
								echo "<td><a href='index.php?boton=home&amp;ac=Publicaciones&amp;bo=papelera&amp;ver=$fin[FKPUBLICACION]' id='ver'>VER</a></td>";
								echo "<td><a href='adm_/modificar.php?c=p&amp;id=$fin[FKPUBLICACION]&amp;q=restaurar' id='restaurar'>RESTAURAR</a></td>";
								echo "<td><a href='adm_/modificar.php?c=p&amp;id=$fin[FKPUBLICACION]&amp;q=eliminarf' id='delete'>DELETE</a></td>";
							}
							else{
								echo "<td><a href='index.php?boton=home&amp;ac=Publicaciones&amp;ver=$fin[FKPUBLICACION]' id='ver'>VER</a></td>";
								echo "<td><a href='index.php?boton=Publicar&amp;edit=$fin[FKPUBLICACION]' id='edit'>EDITAR</a></td>";
								echo "<td><a href='adm_/modificar.php?c=p&amp;id=$fin[FKPUBLICACION]&amp;q=eliminar' id='delete'>DELETE</a></td>";
							}
							echo "</tr>";
						}
						echo "</tbody></table>";
						if($borrar=='no'){
							echo "<div id='papelera'><a href='index.php?boton=home&amp;ac=Publicaciones&amp;bo=papelera'>Papelera</a></div>";
						}
						else if($borrar=="si"){
							echo "<a id='return' href='index.php?boton=home&amp;ac=Publicaciones'>RETURN</a>";
						}
					}
		}
		else if($_GET['ac'] == 'Publicar' && $_SESSION['s_nivel'] == 'admin'){
			include('adm_/publicar.php');
		}
		else{
			echo "<p id='tope'>El contenido <mark>".$_GET['ac']."</mark> no exsiste en esta Web.";
			if($_SESSION['s_nivel']=='admin'){
				echo "<h3>Estadísticas</h3>";
				echo "<img src='adm_/estadisticas.php' alt='grafico'/>";
			}
		}
	}
	else{
		if($_SESSION['s_nivel'] == 'admin'){
			echo "<h3>Estadísticas</h3>";
			echo "<img src='adm_/estadisticas.php' alt='grafico'/>";
		}
	}
	?>

</div>

<script>
var tbody=document.getElementsByTagName("tbody")[0];
if(tbody!=undefined){
	var th=document.getElementsByTagName("thead")[0].getElementsByTagName("tr")[0].getElementsByTagName("th");
	var tr=document.getElementsByTagName("tr");

	if(tr.length==1){
		var tr2=document.createElement("tr");
		var td=document.createElement("td");
		var tx=document.createTextNode("Vacío");
		td.appendChild(tx);
		td.colSpan=th.length;
		tr2.appendChild(td);
		tr2.style.height="6em";
		tbody.appendChild(tr2);
	}
}
</script>
