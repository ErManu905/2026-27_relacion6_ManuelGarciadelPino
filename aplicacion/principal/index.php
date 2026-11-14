<?php

// Se carga la cabecera y plantilla
require_once dirname(__DIR__, 2) . '/cabecera.php';
require_once dirname(__DIR__) . '/plantillas/plantilla.php';

// Se carga el controlador y vista
require_once __DIR__ . '/controlador.php';
require_once __DIR__ . '/vista_index.php';

// Se obtienen los muebles
$muebles = obtenerMuebles();

$muebleSeleccionado = null;
$indiceSeleccionado = null;

// Se comprueba si el formulario se recibió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Se comprueba si hemos seleccionado la opción de mostrar mueble
    if (isset($_POST['accion']) && $_POST['accion'] === 'mostrar') {

        // Se comprueba que el indice se cargue correctamente
        if (isset($_POST['indice'])) {

            $indice = (int) $_POST['indice'];

            // Se comprueba que el mueble existe
            if (isset($muebles[$indice])) {

                $muebleSeleccionado = $muebles[$indice];
                $indiceSeleccionado = $indice;
            }
        }
    }
}

// Se muestra la página principal
vistaIndex($muebles, $muebleSeleccionado, $indiceSeleccionado);

?>