<?php 
define("RUTABASE", "");
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO","desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO=="produccion")
    error_reporting(0);
    else 
        error_reporting(E_ALL);  

spl_autoload_register(function (string $nombreClase): void {

    $archivo = __DIR__ . '/aplicacion/clases/curso2026/' . $nombreClase . '.php';

    if (is_file($archivo)) {
        require_once $archivo;
    }
});

require_once __DIR__ . "/aplicacion/plantillas/plantilla.php";