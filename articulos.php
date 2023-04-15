<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Articulos</title>
</head>
<body>
<h1>Lista de artículos</h1>

	<?php 

		include "funciones.php";

		/**
		 * 	Por motivos de seguridad, he decidido incluir nuevamente la comprobación del tipo de usuario
		 * por lo que comprobamos si el usuario tiene los permisos suficientes
		 */
		if (!isset($_COOKIE['tipoUser']) || $_COOKIE['tipoUser'] !== 'autorizado') {
			echo "Disculpe, pero no cuenta con permisos suficientes para ver esta página.";
			//emplearé exit() para que no se ejecute nada más del código dado que el usuario no dispone de permisos
			exit();
		}
		
		/*
		* Incluimos el archivo de conexión a la base de datos. Usaré include_once para que únicamente se incluya una vez, evitando así problemas de multiples ejecuciones 
		*/ 

		include_once 'conexion.php';
		
		// Una vez obtenido acceso de usuario, definimos una variable de selección global de elementos de la bbdd

		$bbdd = "SELECT * FROM product";

		//dado que deseamos ordenar las columnas si el usuario lo requiere, añadiermos una clausula if para poder realizar dicha ordenación según sea demandado por una orden get

		if (isset($_GET['orden'])) {
			$orden = $_GET['orden'];
			$bbdd .= " ORDER BY $orden ASC";
		}

		//una vez realizado, procederemos a conectar con la bbdd

		$conexion=crearConexion();

		//almacenaremos la consulta global de la variable bbdd definida antes en una variable resultado

		$resultado = $conexion->query($bbdd);

		/**
		 * 	definiremos una variable management como false por defecto, la cual cambiará a true cuando se tenga los permisos
		 * Posteriormente definiremos un condicional para evaluar los permisos y cambiar management a true si se disponen de los
		 * permisos
		 */

		$management = false;

		if($_COOKIE['tipoUser'] == 'autorizado'){
			$management = true;
		}

		// Siguiendo las instrucciones dadas en la pac, es necesario incorporar la opción de "añadir item" para aquellos usuarios autorizados.
		
		if ($management) {
			
			echo "<a href='formArticulos.php?accion=anadir'>Añadir producto</a>";

		}
		?>

		<table class="table">
			<thead>
				<tr>
					<th><a href="articulos.php?orden=id">ID</a></th>
					<th><a href="articulos.php?orden=name">Nombre</a></th>
					<th><a href="articulos.php?orden=cost">Coste</a></th>
					<th><a href="articulos.php?orden=price">Precio</a></th>
					<th><a href="articulos.php?orden=category_id">Categoría</a></th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// Mostramos los productos en la tabla
				while ($producto = $resultado->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $producto['id'] . "</td>";
					echo "<td>" . $producto['name'] . "</td>";
					echo "<td>" . $producto['cost'] . "</td>";
					echo "<td>" . $producto['price'] . "</td>";
					echo "<td>" . $producto['category_id'] . "</td>";
					echo "<td>";
					//dado que deseamos incorporar la opción de editar un articulo si eres management, incorporamos dicha opción por medio de pasar el ide del objeto seleccionado a la página formArticulos.php
					if ($management) {
						echo "<a href='formArticulos.php?id=" . $producto['id'] . "&accion=modificar''>Editar</a> ";
						echo "<a href='formArticulos.php?id=" . $producto['id'] . "&accion=borrar'>Borrar</a>";
					}
					echo "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
			</table>		


</body>
</html>