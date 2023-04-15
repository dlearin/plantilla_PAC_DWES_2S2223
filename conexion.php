<?php 

	function crearConexion() {
		// Cambiar en el caso en que se monte la base de datos en otro lugar
		$host = "localhost";
		$user = "root";
		$pass = "";
		$baseDatos = "pac_dwes";

		$conexion = mysqli_connect($host, $user, $pass, $baseDatos);
    
    // Verificar si se pudo establecer la conexión
    if (!$conexion) {
        die("La conexión falló: " . mysqli_connect_error());
    }
    
    return $conexion;
}


function cerrarConexion($conexion) {
    mysqli_close($conexion);
}