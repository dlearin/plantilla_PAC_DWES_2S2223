<?php 

	include "conexion.php";

	function tipoUsuario($nombre, $correo){

		$conexionBBDD=crearConexion();

		/**
		 * creamos una operacion preparada PDO para evitar problemas de SQL inject
		 * Así mismo y por convención de uso de statements en estas operaciones preparadas
		 * la variable será $stmt
		 * También, en la consulta, usaremos marcadores de posición para, posteriormente
		 * pasarle los datos de cada usuario
		*/

		$stmt = $conexionBBDD -> prepare("SELECT * FROM user WHERE full_name = ? AND email = ?");

		/**
		 * 	posteriormente, por medio de una función bind_param vinculamos las variables 
		 * con la consulta por medio de los parametros de posicion ? indicados
		 * antes y usamos una s por cada variable para indicar que son string

		 */

		$stmt->bind_param("ss", $nombre, $correo);

		//ejecutamos la consulta SQL y recuperamos el resultado por medio de get_result

		$stmt->execute();
		$resultado=$stmt->get_result();

		/**
		 * Evaluamos el resultado para ver si el usuario está registrado o no
		 * por medio de evaluar el numero de filas de usuario. Si tiene menos de 0
		 * no existe
		 */

		 if($resultado->num_rows>0){

			$usuario = $resultado -> fetch_assoc();
			if($usuario["id"] == "3"){
				return "superadmin";
			}else if ($usuario["enabled"]=="1"){
				return "autorizado";
			} else{
				return "registrado";
			}

		 } else {
			return "no registrado";
		 }


	}

/**
 * Para realizar esta funcion he decidido hacerlo simplemente con una funcion comparativa
 * si los datos nombre y correo se ajustan con los predefinidos, será true, en caso
 */
	function esSuperadmin($nombre, $correo){

		function esSuperadmin($nombre, $correo) {
			$superadmin_nombre = "Jack Blue";
			$superadmin_correo = "jack@blue.com";
		  
			if ($nombre == $superadmin_nombre && $correo == $superadmin_correo) {
			  
			  return true;
			} else {
			  return false;
			}
		  }
}


	function getPermisos() {
		
			if (isset($_COOKIE['tipoUser']) && $_COOKIE['tipoUser'] === 'autorizado') {
				return true;
			} else {
				return false;
			}
		}	


	function cambiarPermisos() {
		// Completar...	
	}


	function getCategorias() {
		// Completar...	
	}


	function getListaUsuarios() {
		// Completar...	
	}


	function getProducto($ID) {
	}


	function getProductos($orden) {
		// Completar...	
	}


	function anadirProducto($name, $cost, $price, $category_id) {
		$sql = "INSERT INTO product (name, cost, price, category_id) VALUES ('$name', '$cost', '$price', '$category_id')";
		$conexion = crearConexion();
		$resultado = $conexion->query($sql);
		return $resultado;
	}


	function borrarProducto($id) {
		return "DELETE FROM product WHERE id = '$id'";
		
}


	function editarProducto($id, $name, $cost, $price, $category_id) {
		$sql = "UPDATE product SET name = '$name', cost = '$cost', price = '$price', category_id = '$category_id' WHERE id = '$id'";
		$conexion = crearConexion();
		$resultado = $conexion->query($sql);
		return $resultado;	
	}

?>