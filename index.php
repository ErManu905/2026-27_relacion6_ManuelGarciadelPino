<?php

// Cargamos la configuración y la plantilla.
include_once(__DIR__ . "/cabecera.php");

// Mostramos la cabecera.
inicioCabecera("Tienda Manolo");
cabecera();
finCabecera();

// Mostramos el contenido.
inicioCuerpo("Tienda Manolo");
cuerpo();
finCuerpo();


// -------------------------------------------------
// VISTAS
// -------------------------------------------------

// Vista de la cabecera.
function cabecera(): void
{
}

// Vista del contenido.
function cuerpo(): void
{
?>

    <br /><br />

    <h2>Actividades</h2>

    <p>
        <a href="./aplicacion/principal/index.php">
            Acceder a la Relación 6 - Tienda
        </a>
    </p>

<?php
}

?>