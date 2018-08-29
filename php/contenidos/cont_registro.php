<div id='registro'>
<div>
<?php
	if(isset($_GET['boton'])){
		$bt=$_GET['boton'];
		if($bt=='Login'||$bt=='Registro'){
			echo "<h2>$bt</h2>";
			if($bt=='Login'){
				echo "<form action='php/login.php' method='post' name='login' id='login'>
						<label>Nombre de Usuario :</label>
						<input id='usuario' name='usuario' type='text'>
						<label>Contraseña :</label>
						<input id='cont' name='password' type='password'>";
			}
			else{
				echo "<form action='php/login.php' method='post' name='reg' id='login'> 		
						<div><label>Nombre :</label>
						<input id='nombre' name='nombre' type='text'></div>
						<div><label>Apellido :</label>
						<input id='nombre' name='nombre' type='text'></div>
						<div><label>Mail :</label>
						<input id='mail' name='mail' type='email'></div>
						<div><label>Nombre de Usuario:</label>
						<input id='nombre_usuario' name='nombre_usuario' type='text'></div>
						<div><label>Contraseña :</label>
						<input id='contrasenia' name='contrasenia' type='password'></div>
						<div><label>Telefono:</label>
						<input id='telefono' name='telefono' type='text'></div>";
			}
			echo "<button name='submit' type='submit'>Enviar</button>
				</form>";
		}
	}
?>
</div>
</section>
		<script>
			var h2=document.getElementsByTagName('h2')[0];
			if(h2.innerHTML.substring(0,1)=='L'){
				h2.parentNode.style.background="url('img/iconos/casa.png') no-repeat 80% 40% #B25567";
			}
			else{
				var form=document.getElementById('login');
				if(form.name=='reg'){
					form.style.marginLeft='50%';
					h2.parentNode.style.background="url('img/iconos/collar.png') no-repeat 10% 40% #009666";
				}
			}
		</script>