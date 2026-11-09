<?php
// Mostramos la página principal de la tienda.
function vistaIndex(array $datos): void
{
    inicioCabecera($datos["titulo"]);
    finCabecera();

    inicioCuerpo($datos["titulo"], "Inicio");

    echo "<h2>Bienvenido</h2>\n";
    echo "<p>" . htmlspecialchars($datos["mensaje"], ENT_QUOTES, 'UTF-8') . "</p>\n";

    echo "<p>Aplicación de gestión de muebles.</p>\n";

    finCuerpo();
}
?>