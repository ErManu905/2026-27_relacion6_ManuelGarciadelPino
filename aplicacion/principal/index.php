<?php

// Cargamos la configuración y la plantilla.
require_once dirname(__DIR__, 2) . '/cabecera.php';
require_once dirname(__DIR__) . '/plantillas/plantilla.php';

// Cargamos el controlador y la vista.
require_once __DIR__ . '/controlador.php';
require_once __DIR__ . '/vista_index.php';

// Obtenemos los cinco muebles.
$muebles = obtenerMuebles();

// Inicialmente no hay ningún mueble seleccionado.
$muebleSeleccionado = null;
$indiceSeleccionado = null;

// Comprobamos si se ha enviado el formulario.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Comprobamos que se ha pulsado Mostrar Mueble.
    if (isset($_POST['accion']) && $_POST['accion'] === 'mostrar') {

        // Comprobamos que se ha recibido un índice.
        if (isset($_POST['indice'])) {

            $indice = (int) $_POST['indice'];

            // Comprobamos que el mueble existe.
            if (isset($muebles[$indice])) {

                $muebleSeleccionado = $muebles[$indice];
                $indiceSeleccionado = $indice;
            }
        }
    }
}

// Mostramos la página principal.
vistaIndex($muebles, $muebleSeleccionado, $indiceSeleccionado);

?>