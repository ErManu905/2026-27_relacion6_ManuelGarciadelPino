<?php
// Cargamos la configuración y la plantilla.
require_once dirname(__DIR__, 2) . '/cabecera.php';
require_once dirname(__DIR__) . '/plantillas/plantilla.php';

// Cargamos la vista.
require_once __DIR__ . '/vista_pruebas.php';

// Mostramos la página de pruebas.
vistaPruebas();
?>