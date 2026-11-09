<?php
// Cargamos la configuración y la plantilla.
require_once __DIR__ . "/../../cabecera.php";
require_once __DIR__ . "/../plantillas/plantilla.php";

// Cargamos el controlador y la vista.
require_once __DIR__ . "/controlador.php";
require_once __DIR__ . "/vista_index.php";

// Obtenemos los datos que se mostrarán.
$datos = obtenerDatosIndex();

// Mostramos la página principal.
vistaIndex($datos);
?>