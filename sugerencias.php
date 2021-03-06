<?php

/**
 * Función consultarLibros.
 * @author Miguel Proba Estévez
 * 
 * Esta función devuelve una lista de todos los libros de la tabla libro, según la letra 
 * especificada que esté contenido en el título del mismo.
 * @param $letra que indica la letra que debe incluirse en el campo título de la tabla..
 * @return $lista_libros, array que contiene todos los libros de la tabla libro.
 */
function consultarLibro($letra)
{
    @$mysqli = new mysqli("localhost:3306", "admin_root", "4l5e7_xA", "admin_libros");

    if (!$mysqli->connect_errno) {
		
        $mysqli->set_charset("utf8");

        $sql = "SELECT
       				autor.nombre,
       				autor.apellidos,
       				autor.nacionalidad,
       				libro.titulo,
       				libro.f_publicacion
				FROM autor
				JOIN libro ON autor.id = libro.id_autor
				WHERE autor.nombre 
				LIKE '%$letra%' 
				ORDER BY autor.nombre;";

        $resultado = $mysqli->query($sql);
		
        if ($resultado->num_rows > 0 && !$mysqli->error) {
			
            while ($fila = $resultado->fetch_assoc()) {
				
				$lista_libros[] = array("nombre" => $fila["nombre"],"apellidos" => $fila["apellidos"], "nacionalidad" => $fila["nacionalidad"],
											  "titulo" => $fila["titulo"], "f_publicacion" => $fila["f_publicacion"]);
            }
			return $lista_libros;
            $resultado->free();
            $resultado->close();
        }
     
    } else {
        echo "Error de conexion con la base de datos.";
    }
}

// Se obtiene el parámetro GET de la URL
$q = $_REQUEST["q"];
$sugerencias = "";

/* Se comprueba que el parámetro no está vacío. De ser así se pasa a minúsculas y
se recorre el array recibido de la consulta obteniendo los datos del título según
la condición pasada por parámetro. */
if ($q !== "") {
    $q = strtolower($q);
    $datos = consultarLibro($q);
    foreach ($datos as $dato) {
        if (stristr($dato["nombre"], $q)) {
            $sugerencias .= "<li><b>".$dato["titulo"]."</b> (".$dato["f_publicacion"].") - " .$dato["nombre"]." ".$dato["apellidos"]." (".$dato["nacionalidad"].")</li><br>";
        }
    }
}

/* Se muestra un mensaje si no se han encontrado coincidencias, si no se muestran
los resultados obtenidos. */
echo $sugerencias === "" ? "No se encuentran sugerencias" : $sugerencias;