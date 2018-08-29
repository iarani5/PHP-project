<div id='publicar'>
<?php
if(isset($_SESSION['epublic'])){
	$tit="EDITAR";
}
else{
	$tit="NUEVA";
}
echo "<h2>$tit PUBLICACIÓN</h2>";

	if(isset($_GET['rta2'])){
		$_GET["rta2"]=control($_GET["rta2"]);
		switch($_GET['rta2']){
			case 'incompleto':
				echo "Formulario incompleto. Todos los datos son necesarios.";
			break;
			case 'Raza':
			case 'Mail':
			case 'Telefono':
			case 'Fecha':
			case 'Barrio':
			case 'Localidad':
			case 'Descripcion':
			case 'Nombre':
			case "Foto":
			case 'animal':
			case 'pelo':
				if($_GET["rta2"]=='Nombre'){
					$_GET["rta2"]="Nombre de persona";
				}
				else if($_GET["rta2"]=='animal'){
					$_GET["rta2"]="Nombre de animal";
				}
				else if($_GET["rta2"]=='pelo'){
					$_GET["rta2"]="Color de pelo";
				}
				if($_GET["rta2"]=='Raza'||$_GET["rta2"]=='Fecha'||$_GET["rta2"]=='Localidad'||$_GET["rta2"]=='Descripcion'||$_GET["rta2"]=='Foto'){
					echo "<p id='tope'><mark>$_GET[rta2]</mark> no válida.</p>";
				}
				else{
					echo "<p id='tope'><mark>$_GET[rta2]</mark> no válido.</p>";
				}
			break;
			case 'error':
				echo "<p id='tope'>UPS! Algo salio mal, vuelva a intentarlo más tarde.</p>";
			break;
			case 'ok_pub':
				echo"<p id='tope'>Su publicación fue creada exitosamente.</p>";
			break;
			case 'update':
				echo"<p id='tope'>Datos actualizados con éxito.</p>";
			break;
			case 'no':
				echo"<p id='tope'>No tenes permiso para editar publicaciones agenas.</p>";
			break;
			default:
				echo "<p id='tope'>El contenido <mark>$_GET[rta2]</mark> no existe en esta web.</p>";
			break;
		}
	}
	if(isset($_GET['edit'])){
		$_GET["edit"]=intval($_GET["edit"]);
		$c="SELECT 
			 *,
			 ojos.OJOS AS OJOSC,
			 provincia.PROVINCIA AS PROV
			FROM
			ojos,
			provincia,
			publicacion JOIN publican ON publican.FKPUBLICACION=publicacion.ID
			WHERE publicacion.ID='$_GET[edit]' AND ojos.ID=publicacion.FKOJOS AND provincia.ID=publicacion.FKPROVINCIA
			GROUP BY publicacion.id ";
		$res = mysqli_query($cnx,$c);
		while($a = mysqli_fetch_assoc($res)){
			$_SESSION['ae_estado']=$a['ESTADO'];
			$_SESSION['ae_especie']=$a['ESPECIE'];
			$_SESSION['ae_sexo']=$a['SEXO'];
			$_SESSION['ae_edad']=$a['EDAD'];
			$_SESSION['ae_tamanio']=$a['TAMANIO'];
			$_SESSION['ae_ojos']=$a['OJOSC'];
			$_SESSION['ae_nombrea']=$a['NOMBRE_ANIMAL'];
			$_SESSION['ae_color']=$a['COLOR'];
			$_SESSION['ae_raza']=$a['RAZA'];
			$_SESSION['ae_foto']=$a['RUTA_IMG'].".jpg";
			$_SESSION['ae_descrip']=$a['DESCRIPCION'];
			$_SESSION['ae_prov']=$a['PROV'];
			$_SESSION['ae_localidad']=$a['LOCALIDAD'];
			$_SESSION['ae_barrio']=$a['BARRIO'];
			$_SESSION['ae_ubicacion']=$a['UBICACION'];
			$_SESSION['ae_fecha']=$a['FECHA_M'];
			$_SESSION['ae_nombreh']=$a['NOMBRE_HUMANO'];
			$_SESSION['ae_tel']=$a['TELEFONO'];
			$_SESSION['ae_mail']=$a['MAIL'];
			$_SESSION['epublic']=$_GET['edit'];
		}
	}
	else{
		$_SESSION['ae_estado']='';
			$_SESSION['ae_especie']='';
			$_SESSION['ae_sexo']='';
			$_SESSION['ae_edad']='';
			$_SESSION['ae_tamanio']='';
			$_SESSION['ae_ojos']='';
			$_SESSION['ae_nombrea']='';
			$_SESSION['ae_color']='';
			$_SESSION['ae_raza']='';
			$_SESSION['ae_foto']='';
			$_SESSION['ae_descrip']='';
			$_SESSION['ae_prov']='';
			$_SESSION['ae_localidad']='';
			$_SESSION['ae_barrio']='';
			$_SESSION['ae_ubicacion']='';
			$_SESSION['ae_fecha']='';
			$_SESSION['ae_nombreh']='';
			$_SESSION['ae_tel']='';
			$_SESSION['ae_mail']='';
			$_SESSION['epublic']=null;
	}
?>
<form action='adm_/publicar.upload.php' method='post' enctype="multipart/form-data">
		<fieldset><legend>DATOS SOBRE EL ANIMAL</legend>
			<div class='chico' id='estado'><span>ESTADO</span>
			<select name='estado'>
					<option value='Adopcion' <?php if(isset($_SESSION['ae_estado'])&&$_SESSION['ae_estado']=='Adopcion'){echo "selected";}?>>En Adopción</option>
					<option value='Encontrado' <?php if(isset($_SESSION['ae_estado'])&&$_SESSION['ae_estado']=='Encontrado'){echo "selected";}?>>Encontrado</option>
					<option value='Perdido' <?php if(isset($_SESSION['ae_estado'])&&$_SESSION['ae_estado']=='Perdido'){echo "selected";}?>>Perdido</option>
			</select>
			</div>
			
			<div class='chico'  id='especie'><span>ESPECIE</span><select name='especie'>
				<option value='Perro' <?php if(isset($_SESSION['ae_especie'])&&$_SESSION['ae_especie']=='Perro'){echo "selected";}?>>Perro</option>
				<option value='Gato' <?php if(isset($_SESSION['ae_especie'])&&$_SESSION['ae_especie']=='Gato'){echo "selected";}?>>Gato</option>
			</select></div>
			
			<div class='chico'><span>SEXO</span><select name='sexo'>
				<option value='Hembra' <?php if(isset($_SESSION['ae_sexo'])&&$_SESSION['ae_sexo']=='Hembra'){echo "selected";}?>>Hembra</option>
				<option value='Macho' <?php if(isset($_SESSION['ae_sexo'])&&$_SESSION['ae_sexo']=='Macho'){echo "selected";}?>>Macho</option>
				<option value='No lo se' <?php if(isset($_SESSION['ae_sexo'])&&$_SESSION['ae_sexo']=='No lo se'){echo "selected";}?>>No lo se</option>
			</select></div>
			
			<div class='chico'><span>EDAD</span><select name='edad'>
				<option value='Bebe' <?php if(isset($_SESSION['ae_edad'])&&$_SESSION['ae_edad']=='Bebe'){echo "selected";}?>>Bebe</option>
				<option value='Joven' <?php if(isset($_SESSION['ae_edad'])&&$_SESSION['ae_edad']=='Joven'){echo "selected";}?>>Joven</option>
				<option value='Adulto' <?php if(isset($_SESSION['ae_edad'])&&$_SESSION['ae_edad']=='Adulto'){echo "selected";}?>>Adulto</option>
				<option value='Viejito' <?php if(isset($_SESSION['ae_edad'])&&$_SESSION['ae_edad']=='Viejito'){echo "selected";}?>>Viejito</option>
			</select></div>
			
			<div class='chico'><span>TAMAÑO</span><select name='tamanio'>
				<option value='Chico' <?php if(isset($_SESSION['ae_tamanio'])&&$_SESSION['ae_tamanio']=='Chico'){echo "selected";}?>>Chico</option>
				<option value='Mediano' <?php if(isset($_SESSION['ae_tamanio'])&&$_SESSION['ae_tamanio']=='Mediano'){echo "selected";}?>>Mediano</option>
				<option value='Grande'<?php if(isset($_SESSION['ae_tamanio'])&&$_SESSION['ae_tamanio']=='Grande'){echo "selected";}?>>Grande</option>
			</select></div>

			<div class='chico'><span>COLOR DE OJOS</span><select name='ojos'>
				<?php
					$con="SELECT * FROM ojos";
					$res = mysqli_query($cnx,$con);
					while($a = mysqli_fetch_assoc($res)){
						echo "<option value='$a[ID]' ";
						if(isset($_SESSION['ae_ojos'])&&$_SESSION['ae_ojos']=='$a[OJOS]'){echo "selected";}
						echo ">$a[OJOS]</option>";
					}
				?>
			</select></div>
			<?php
			echo '<div><span>NOMBRE*</span><input id="nombre_animal" type="text" name="nombre_animal" ';
				if(isset($_SESSION['ae_nombrea'])){ echo " value='$_SESSION[ae_nombrea]' ";}
				echo "/>";?>
			</div>
			<div class='maschico'><span>COLOR DE PELO*</span><input type='text' id="pelo" name='pelo' <?php if(isset($_SESSION['ae_color'])){ echo " value='$_SESSION[ae_color]'";}?>></div>
			<div class='maschico'><span>RAZA*</span><input type="text" id='raza' name="raza" <?php if(isset($_SESSION['ae_raza'])){ echo " value='$_SESSION[ae_raza]'";}?>/></div>
			
			<div><span>FOTO (.jpg)*</span><input type="file" name="foto" id="foto" accept="image/jpeg,image/jpg" <?php if(isset($_SESSION['ae_foto'])){ echo " placeholder='$_SESSION[ae_foto]'";}?>/></div>
			
			<div id='text'><span>DESCRIPCIÓN*</span><textarea name='descripcion' id='descripcion' cols="23" rows="6" ><?php if(isset($_SESSION['ae_descrip'])){ echo $_SESSION['ae_descrip'];}?></textarea></div>
		</fieldset>
		
	<div>
		<fieldset><legend>UBICACIÓN DEL ANIMAL</legend>
			<div><span>PROVINCIA</span><select id='prov' name='provincia'>
				<?php
					$con="SELECT * FROM provincia";
					$res = mysqli_query($cnx,$con);
					while($a = mysqli_fetch_assoc($res)){
						print_f( "<option value='$a[ID]'");
						if(isset($_SESSION['ae_prov'])&&$_SESSION['ae_prov']=='$a[PROVINCIA]'){echo "selected";}
						print_f( ">$a[PROVINCIA]</option>");
					}
				?>
			</select></div>
			
			<div><span>LOCALIDAD*</span>
			<input type="text" name="localidad" id='localidad' <?php if(isset($_SESSION['ae_localidad'])){ echo " value='$_SESSION[ae_localidad]'";}?>/></div>
			
			<div><span>BARRIO*</span>
			<input type="text" name="barrio" id='barrio' <?php if(isset($_SESSION['ae_barrio'])){ echo " value='$_SESSION[ae_barrio]'";}?>/>
			</div>
				
			<div id='hidden'><span>VISTO EN INTERSECCIÓN DE CALLES</span>
			<input type="text" name="calles" id="calles" <?php if(isset($_SESSION['ae_ubicacion'])){ echo " value='$_SESSION[ae_ubicacion]'";}?>/>
			</div>
			<div>
			<span>FECHA DE NACIMIENTO</span>
			<input type="text" placeholder="dd/mm/aaaa" name="fecha_m" id="fecha_m" <?php if(isset($_SESSION['ae_fecha'])){ echo " value='$_SESSION[ae_fecha]'";}?>/></div>
		</fieldset>
			
		<fieldset><legend>DATOS DE CONTACTO</legend>
		<div><span>NOMBRE*</span>
			<input type="text" name="nombre" id='nombre'
			<?php 
				if(isset($_SESSION['ae_nombreh'])&&$_SESSION['ae_nombreh']!=''){
					echo " value='$_SESSION[ae_nombreh]'";
					}
				else{
					if(isset($_SESSION['s_nombre'])){
						echo " value='$_SESSION[s_nombre]'";
					}
				}
			?>
			/></div>
		<div><span>TELEFONO*</span>
			<input type="text" name="telefono" id='telefono' <?php if(isset($_SESSION['ae_tel'])&&$_SESSION['ae_tel']!=''){ echo " value='$_SESSION[ae_tel]'";}else{if(isset($_SESSION['s_tel'])){echo " value='$_SESSION[s_tel]'";}} ?>/></div>
			<div><span>MAIL*</span><input type="email" name="mail" id='mail'
			<?php if(isset($_SESSION['ae_mail'])&&$_SESSION['ae_mail']!=''){ echo " value='$_SESSION[ae_mail]'";}else{if(isset($_SESSION['s_mail'])){echo " value='$_SESSION[s_mail]'";}} ?>
			/></div></fieldset>		
	</div>
		<input type="submit" value="Enviar" id="envio"/>
</form>
</div>

<script>
    function oculto(){
		var hidden=document.getElementById('hidden');
		input=hidden.getElementsByTagName('input')[0];
		if(select.value=='Adopcion'){
			input.disabled=true;
		}
		else{
			input.disabled=false;
		}
	}
	var div=document.getElementById('estado');	
	var select=div.getElementsByTagName('select')[0];
	oculto();
	select.onchange=function(){
		var fecha=document.getElementById('fecha_m').previousSibling.previousSibling;
		if(this.value=='Adopcion'){
			fecha.innerHTML='FECHA DE NACIMIENTO';
			oculto();
		}
		else{
			fecha.innerHTML='FECHA '+this.value.toUpperCase();
			oculto();
		}
	}
	var inputs=document.getElementById("publicar").getElementsByTagName("input");
	var form=document.getElementById("publicar").getElementsByTagName("form")[0];
	for(var i=0;i<inputs.length;i++){
		if(inputs[i]!=null){
			inputs[i].onblur=function(){
				validar(this);
			}
			inputs[i].onmouseout=function(){
				var p=document.getElementById("valid");
				if(p!=undefined){
					p.parentNode.removeChild(p);
				}
			}
		}
	}
	form.onsubmit=function(){
		for(var i=0;i<inputs.length;i++){
			if(inputs[i]!=null){
				inputs[i].validar(this);
			}
		}
	}
</script>