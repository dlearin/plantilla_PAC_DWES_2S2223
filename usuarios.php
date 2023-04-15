<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Usuarios</title>
</head>
<body>

	<?php 

		include "funciones.php";
		// Comprobar si el usuario tiene permisos suficientes
		if (!isset($_COOKIE["tipoUser"]) || $_COOKIE["tipoUser"] !== "superadmin") {
			echo "No tienes permisos para acceder a esta página.";
			exit;
		}
		
		// Conexión a la base de datos
		$host = "localhost";
		$user = "root";
		$pass = "";
		$baseDatos = "pac_dwes";

		$conexion = mysqli_connect($host, $user, $pass, $baseDatos);
		
		// Comprobar conexión a la base de datos
		if (!$conexion) {
			die("Error de conexión: " . mysqli_connect_error());
		}

		// Obtener los permisos actuales de la base de datos
		$query = "SELECT enabled FROM user WHERE id = 1";
		$resultado = mysqli_query($conexion, $query);
		$permisos = mysqli_fetch_assoc($resultado)["enabled"];

		// Actualizar los permisos al hacer click en el botón
		if (isset($_POST["actualizar_permisos"])) {
			$nuevos_permisos = $permisos == 1 ? 0 : 1;
			$query = "UPDATE user SET enabled = $nuevos_permisos WHERE id = 1";
			mysqli_query($conexion, $query);
			$permisos = $nuevos_permisos;
		}

		// Obtener todos los usuarios registrados en la base de datos
		$query = "SELECT full_name, email, enabled FROM user";
		$resultado = mysqli_query($conexion, $query);

		?>

  
<h1>Usuarios</h1>
    <p>Permisos actuales: <?php echo $permisos == 1 ? "Autorizado" : "No autorizado"; ?></p>
    <form method="POST">
        <button name="actualizar_permisos">Actualizar permisos</button>
    </form>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Autorizado</th>
        </tr>
        <?php while ($usuario = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $usuario["full_name"]; ?></td>
                <td><?php echo $usuario["email"]; ?></td>
                <td><++?php echo $usuario["enabled"] == 1 ? "<strong>Autorizado</strong>" : "No autorizado"; ?></td>
            </tr>
        <?php } ?>
    </table>
    <br>
    <a href="index.php">Volver a la página principal</a>
</body>
<?php
// Cerrar conexión a la base de datos
mysqli_close($conexion);
?>
</html>