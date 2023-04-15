<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulario de artículos</title>
</head>
<body>

	<?php 

		include "funciones.php";
		// Comprobamos si el usuario tiene los permisos suficientes
		if (!isset($_COOKIE['tipoUser']) || $_COOKIE['tipoUser'] !== 'autorizado') {
			echo "No tiene permisos para acceder a esta página.";
			exit();
		}

		// Incluimos el archivo de conexión a la base de datos
		include_once 'conexion.php';

		// Definimos las variables
		$id = '';
		$name = '';
		$cost = '';
		$price = '';
		$category_id = '';
		$accion = $_GET['accion'];
		$articulo_borrado = false;
		$articulo_modificado = false;
		$articulo_anadido = false;


		
		
				// Obtenemos la acción a realizar
				$accion = $_GET['accion'];

				// Verificamos si se recibió el ID por GET
				if (isset($_GET['id'])) {
					$id = $_GET['id'];

					// Obtenemos los datos del producto
					$sql = "SELECT * FROM product WHERE id = '$id'";
					$conexion = crearConexion();
					$resultado = $conexion->query($sql);
					$producto = $resultado->fetch_assoc();
					$name = $producto['name'];
					$cost = $producto['cost'];
					$price = $producto['price'];
					$category_id = $producto['category_id'];
				}

				// Verificamos si se recibió el formulario por POST
				
				if ($_SERVER['REQUEST_METHOD'] === 'POST') {
					// Obtenemos los datos enviados por el formulario
					$id = $_POST['id'];
					$name = $_POST['name'];
					$cost = $_POST['cost'];
					$price = $_POST['price'];
					$category_id = $_POST['category_id'];

					// Verificamos si se está modificando, agregando o borrando un nuevo articulo


					switch ($accion) {

						// Agregando nuevo articulo

						case 'anadir':
						
						$resultado = anadirProducto($name, $cost, $price, $category_id);
						$mensaje = "El articulo se ha añadido correctamente.";
						$articulo_anadido = true;
						break;						


						// Modificando articulo existente

						case 'modificar':
				
						$resultado = editarProducto($id, $name, $cost, $price, $category_id);
						$mensaje = "El articulo se ha modificado correctamente.";
						$articulo_modificado = true;
						break;

						// Borrando articulo

						case 'borrar':

						$sql = borrarProducto($id);
						$mensaje = "El articulo se ha borrado correctamente.";
						$articulo_borrado = true;
						break;
					} 

					

					if ($articulo_borrado) {
						// Mostramos mensaje de confirmación y salimos del script
						echo "<p>$mensaje</p>";
						echo "<a href='articulos.php'>Volver a la página articulos</a>";
						exit();
					}		
					if ($articulo_modificado) {
						// Mostramos mensaje de confirmación y salimos del script
						echo "<p>$mensaje</p>";
						echo "<a href='articulos.php'>Volver a la página articulos</a>";
						exit();
					}		
					if ($articulo_anadido) {
						// Mostramos mensaje de confirmación y salimos del script
						echo "<p>$mensaje</p>";
						echo "<a href='articulos.php'>Volver a la página articulos</a>";
						exit();
					}				
				}

				
				/**
				 * A continuación mostraremos la tabla dependiendo si hemos recibido la opción de borrar/modificar o añadir
				 */
					
				 //articulo a borrar
				if (isset($_GET['accion']) && $_GET['accion'] === 'borrar') {

					if($articulo_borrado){
						echo "<p>$mensaje</p>";

					} else {
					// Obtenemos los datos del producto
					$sql = "SELECT * FROM product WHERE id = '$id'";
					$conexion = crearConexion();
					$resultado = $conexion->query($sql);
					$producto = $resultado->fetch_assoc();

					// a CONTINUACIÓN se muestra el formulario 
					echo "<h2>¿Está seguro que desea eliminar el siguiente articulo?</h2>";
					echo "<form method='post'>";
					echo "<input type='hidden' name='id' value='$id'>";
					echo "<label>ID:</label><input type='text' name='id' value='" . $producto['id'] . "' disabled><br>";
					echo "<label>Nombre:</label><input type='text' name='name' value='" . $producto['name'] . "' disabled><br>";
					echo "<label>Costo:</label><input type='number' name='cost' value='$cost'><br>";
					echo "<label>Precio:</label><input type='number' name='price' value='$price'><br>";
					echo "<label>Categoría:</label><input type='text' name='category_id' value='$category_id'><br>";
					echo "<input type='submit' value='Borrar articulo'>";
					echo "</form>";
				}
			}

			//articulo a modificar

				if (isset($_GET['accion']) && $_GET['accion'] === 'modificar') {

					if($articulo_modificado){
						echo "<p>$mensaje</p>";

					} else {
					// Obtenemos los datos del producto
					$sql = "SELECT * FROM product WHERE id = '$id'";
					$conexion = crearConexion();
					$resultado = $conexion->query($sql);
					$producto = $resultado->fetch_assoc();

					// a CONTINUACIÓN se muestra el formulario 
					echo "<h2>¿Está seguro que desea modificar el siguiente articulo?</h2>";
					echo "<form method='post'>";
					echo "<input type='hidden' name='id' value='$id'>";
					echo "<label>ID:</label><input type='text' name='id' value='$id'><br>";
					echo "<label>Nombre:</label><input type='text' name='name' value='$name'><br>";
					echo "<label>Costo:</label><input type='number' name='cost' value='$cost'><br>";
					echo "<label>Precio:</label><input type='number' name='price' value='$price'><br>";
					echo "<label>Categoría:</label><input type='text' name='category_id' value='$category_id'><br>";
					echo "<input type='submit' value='Guardar'>";
					echo "</form>";
				}
			}

			//articulo a añadir
			
			if (isset($_GET['accion']) && $_GET['accion'] === 'anadir') {

				if($articulo_anadido){
					echo "<p>$mensaje</p>";

				} else {
				// Obtenemos los datos del producto
				$sql = "SELECT * FROM product WHERE id = '$id'";
				$conexion = crearConexion();
				$resultado = $conexion->query($sql);
				$producto = $resultado->fetch_assoc();

				// a CONTINUACIÓN se muestra el formulario 
				echo "<h2>¿Está seguro que desea añadir el siguiente articulo?</h2>";
				echo "<form method='post'>";
				echo "<input type='hidden' name='id' value='$id'>";
				echo "<label>ID:</label><input type='text' name='id' value='$id'><br>";
				echo "<label>Nombre:</label><input type='text' name='name' value='$name'><br>";
				echo "<label>Costo:</label><input type='number' name='cost' value='$cost'><br>";
				echo "<label>Precio:</label><input type='number' name='price' value='$price'><br>";
				echo "<label>Categoría:</label><input type='text' name='category_id' value='$category_id'><br>";
				echo "<input type='submit' value='Guardar'>";
				echo "</form>";
			}
		}

 	
	?>

	
</body>
</html>