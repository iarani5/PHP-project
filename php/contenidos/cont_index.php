
<?php
$abuscar="WHERE ";
	if(isset($_GET["estado_pub"])&&$_GET["estado_pub"]!="todo"){
		$abuscar=$abuscar."ESTADO='$_GET[estado_pub]' AND ";
	}
	if(isset($_GET["especie"])&&$_GET["especie"]!="todo"){
		$abuscar=$abuscar."ESPECIE='$_GET[especie]' AND ";
	}
	if(isset($_GET["sexo"])&&$_GET["sexo"]!="todo"){
		$abuscar=$abuscar."SEXO='$_GET[sexo]' AND ";
	}
	if(isset($_GET["edad"])&&$_GET["edad"]!="todo"){
		$abuscar=$abuscar."EDAD='$_GET[edad]' AND ";
	}
	if(isset($_GET["tamanio"])&&$_GET["tamanio"]!="todo"){
		$abuscar=$abuscar."TAMANIO='$_GET[tamanio]' AND ";
	}
	if(isset($_GET["ojos"])){
		$abuscar.="OJOS='$_GET[ojos]' AND ";
	}
	if(isset($_GET["nombre_animal"])&&$_GET["nombre_animal"]!=""){
			$abuscar=$abuscar."NOMBRE_ANIMAL LIKE '%$_GET[nombre_animal]%' AND ";
	}
	if(isset($_GET["raza"])&&$_GET["raza"]!=""){
			$abuscar=$abuscar."RAZA LIKE '%$_GET[raza]%' AND ";
	}
	if(isset($_GET["pelo"])&&$_GET["pelo"]!=""){
		$abuscar=$abuscar."COLOR LIKE '%$_GET[pelo]%' AND ";
	}
	if(isset($_GET["descripcion"])&&$_GET["descripcion"]!=""){
		$abuscar=$abuscar."DESCRIPCION LIKE '%$_GET[descripcion]%' AND ";
	}
	if(isset($_GET["provincia"])){
		$abuscar.="PROVINCIA LIKE='%$_GET[provincia]%' AND ";
	}
	if(isset($_GET["localidad"])&&$_GET["localidad"]!=""){
		$abuscar=$abuscar."LOCALIDAD LIKE '%$_GET[localidad]%' AND ";
	}
	if(isset($_GET["barrio"])&&$_GET["barrio"]!=""){
		$abuscar=$abuscar."BARRIO LIKE '%$_GET[barrio]%' AND ";
	}
	if(isset($_GET["calles"])&&$_GET["calles"]!=""){
		$abuscar=$abuscar."UBICACION LIKE '%$_GET[calles]%' AND ";
	}
	if(isset($_GET["fecha_m"])&&$_GET["fecha_m"]!=""){
		$abuscar=$abuscar."FECHA_M LIKE '%$_GET[fecha_m]%' AND ";
	}
	if($abuscar!="WHERE "){
		$abuscar = substr($abuscar, 0, -4);
	}
	if(isset($_GET["boton"])&&$_GET["boton"]=="buscador"){
							print_f( "<div id='buscado'>
							<div id='cerrar2' onclick='cerrar_buscador()'>X</div>
							<form action='index.php' method='get' name='elform'>
							<div class='chico' id='estado'><span>ESTADO</span>
							<select name='estado_pub'>
									<option value='todo' selected>Todo</option>
									<option value='Adopcion'>En Adopción</option>
									<option value='Encontrado'>Encontrado</option>
									<option value='Perdido'>Perdido</option>
							</select>
							</div>
							<div class='chico'  id='especie'><span>ESPECIE</span><select name='especie'>
								<option value='todo'>Todo</option>
								<option value='Perro'>Perro</option>
								<option value='Gato'>Gato</option>
							</select></div>
							<div class='chico'><span>SEXO</span><select name='sexo'>
								<option value='todo'>Todo</option>
								<option value='Hembra'>Hembra</option>
								<option value='Macho'>Macho</option>
								<option value='No lo se'>No lo se</option>
							</select></div>
							<div class='chico'><span>EDAD</span><select name='edad'>
								<option value='todo'>Todo</option>
								<option value='Bebe'>Bebe</option>
								<option value='Joven'>Joven</option>
								<option value='Adulto'>Adulto</option>
								<option value='Viejito'>Viejito</option>
							</select></div>
							<div class='chico'><span>TAMAÑO</span><select name='tamanio'>
								<option value='todo'>Todo</option>
								<option value='Chico'>Chico</option>
								<option value='Mediano'>Mediano</option>
								<option value='Grande'>Grande</option>
							</select></div>
					<div class='chico'><span>COLOR DE OJOS</span><select name='ojos'>");
							$con="SELECT * FROM ojos";
							$res = mysqli_query($cnx,$con);
								echo "<option value='todo'>Todo</option>";
							while($a = mysqli_fetch_assoc($res)){
								echo "<option value='$a[ID]'>$a[OJOS]</option>";
							}
					echo "</select></div>";
					print_f( '<div class="chico"><span>NOMBRE</span><input type="text" name="nombre_animal" placeholder="Nombre del animal"/>
					</div>
					<div class="chico"><span>COLOR DE PELO</span><input type=text" name="pelo" placeholder="Color de pelo"></div>
					<div class="chico"><span>RAZA</span><input type="text" name="raza" placeholder="Raza"/></div>			
					<div id="text" class="chico"><span>DESCRIPCIÓN</span><input type="text" name="descripcion" placeholder="Descripción de publicación"/></div>
					<div class="chico"><span>PROVINCIA</span><select id="prov" name="provincia">');
							$con="SELECT * FROM provincia";
								echo "<option value='todo'>Todo</option>";
							$res = mysqli_query($cnx,$con);
							while($a = mysqli_fetch_assoc($res)){
								print_f( "<option value='$a[ID]'>$a[PROVINCIA]</option>");
							}
								print_f("</select></div>
								<div class='chico'><span>LOCALIDAD</span>
								<input type='text' name='localidad' placeholder='Localidad'/></div>
								<div class='chico'><span>BARRIO</span>
								<input type='text' name='barrio' placeholder='Barrio'/></div><div class='chico'><span>VISTO EN LAS CALLES</span>
								<input type='text' name='calles' id='calles' placeholder='Visto en las calles'/></div>
								<div class='chico'>
								<span>FECHA DE PUBLICACION</span>
								<input type='text' placeholder='dd/mm/aaaa' name='fecha_m' id='fecha_m'/></div>

							<input type='submit' value='Buscar'/>
							</form>
							</div>");
	}
	?>
<div id='cont_index'>
<?php
	//if(!isset($_SESSION["s_nivel"])){echo "<p>Registrate para realizar una publicación.</p>";} 
?> 
		<a href='#' title='gatos' id='gato' >Gatos</a>
		<div id='rta'></div>
		<a href='#' title='perros' id='perro' >Perros</a>
</div>
<?php
	if($abuscar!="WHERE "){
		include('php/contenidos/cont_listado.php');
	}
?>