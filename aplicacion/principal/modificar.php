<?php
// Cargamos la configuración general y la plantilla del proyecto.
require_once dirname(__DIR__, 2) . '/cabecera.php';
require_once dirname(__DIR__) . '/plantillas/plantilla.php';

// Mostramos la página de modificación.
inicioCabecera('Modificar mueble');
finCabecera();

inicioCuerpo('Modificar mueble', 'Inicio > Modificar mueble');
?>

<h2>Modificar mueble</h2>
<p>El formulario de modificación se incorporará cuando estén creadas las clases y el array de muebles.</p>

<?php
finCuerpo();
?>