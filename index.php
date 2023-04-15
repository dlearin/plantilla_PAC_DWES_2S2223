<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Index.php</title>
</head>
<body>
	<?php
	
		include "consultas.php";

		/**
		 * Primero será necesario comprobar si ya se han introducido los datos, en cuyo
		 * caso se pasará a recogerlos en variables, cotejar que teipo de usuario es
		 * y enviar la página resultante. En caso de no existir los valores, se ofrecerá
		 * el formulario para ingresar los datos
		 */

		//Primero, comprobación de envio de formulario

		if(isset($_POST["nombreUser"]) && isset($_POST["mail"])){

			//Una vez se ha comprobado que los datos ya existen, se convertirán en variables especificas

			$nombre=$_POST["nombreUser"];
			$correo = $_POST["mail"];

			//una vez recogidas las variables, se comprobará si existe dicho usuario

			$tipoUser = tipoUsuario($nombre, $correo);

			//Tras recogerla, se evaluará el tipo de usuario y la página resultante

			if($tipoUser == "superadmin"){

				setcookie("tipoUser","superadmin");

				echo "<h1> Bienvenid@ a la página, $nombre </h1>" ;

				echo "<p>Como superAdmin, puede acceder a la siguiente página <a href='usuarios.php'>usuarios.php</a></p>";
				
			}
			else if($tipoUser == "autorizado")
			{
				setcookie("tipoUser", "autorizado");
	
				echo "<h1> Bienvenid@ a la página, $nombre </h1>" ;
				echo "<p> Dando clic en el siguiente enlace podrá acceder a la página solicitada 
				<a href='articulos.php'>articulos.php</a>
					</p>";

			}
			else if($tipoUser == "registrado")
			{
				echo "<h1>Bienvenid@ a la página, $nombre  </h1>";
				echo "<p>No dispone de permisos de acceso</p>";
			}
			else
			{
				echo "<h1>No se encuentra usted registrado</h1>";
			}

		}
		else
		{
			//Mostrar formulario

			echo "<h1> Formulario de acceso </h1>";
			echo "<form action='index.php' method='post'>";
			echo "<label for='nombreUser'> Nombre de usuario: </label>";
			echo "<input type='text' name='nombreUser' id='nombreUser'>";
			echo "<br>";
			echo "<label for='mail'> Email de usuario: </label>";
			echo "<input type='text' name='mail' id='mail'>";
			echo "<input type='submit' value='acceso'>";
			echo "</form>";
		}

	?>
	
	
</body>
</html>