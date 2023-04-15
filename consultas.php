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


	function esSuperadmin($nombre, $correo){

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
		// Completar...	
	}


	function getProductos($orden) {
		// Completar...	
	}


	function anadirProducto($nombre, $coste, $precio, $categoria) {
		// Completar...	
	}


	function borrarProducto($id) {
		// Completar...	
	}


	function editarProducto($id, $nombre, $coste, $precio, $categoria) {
		// Completar...	
	}

?>