<?php

// Muestra los resultados de las pruebas.
function vistaPruebas(array $pruebas, int $correctas): void
{
    inicioCabecera('Pruebas');
    finCabecera();

    inicioCuerpo('Pruebas', 'Inicio > Pruebas');

    echo "<h2>Pruebas de las clases</h2>\n";

    echo "<p>Pruebas correctas: " . $correctas . " de " . count($pruebas) . "</p>\n";

    echo "<table>\n";

    echo "<tr>\n";
    echo "<th>Prueba</th>\n";
    echo "<th>Resultado</th>\n";
    echo "</tr>\n";

    // Mostramos todas las pruebas.
    foreach ($pruebas as $prueba) {

        echo "<tr>\n";

        echo "<td>";
        echo htmlspecialchars($prueba['nombre'], ENT_QUOTES, 'UTF-8');
        echo "</td>\n";

        echo "<td>";

        if ($prueba['resultado']) {
            echo "Correcta";
        } else {
            echo "Incorrecta";
        }

        echo "</td>\n";

        echo "</tr>\n";
    }

    echo "</table>\n";

    echo "<br />\n";

    echo "<a href='" . RUTABASE . "/aplicacion/principal/index.php'>";
    echo "Volver al inicio";
    echo "</a>\n";

    finCuerpo();
}

?>