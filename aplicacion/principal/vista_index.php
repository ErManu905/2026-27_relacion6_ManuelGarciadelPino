<?php

// Muestra la página principal de la tienda.
function vistaIndex(
    array $muebles,
    ?MuebleBase $muebleSeleccionado,
    ?int $indiceSeleccionado
): void {

    inicioCabecera('Tienda de muebles');
    finCabecera();

    inicioCuerpo('Tienda de muebles', 'Inicio');

    echo "<h2>Listado de muebles</h2>\n";

    // Mostramos todos los muebles en una tabla.
    echo "<table>\n";

    echo "<tr>\n";
    echo "<th>Índice</th>\n";
    echo "<th>Tipo</th>\n";
    echo "<th>Nombre</th>\n";
    echo "<th>Fabricante</th>\n";
    echo "<th>País</th>\n";
    echo "<th>Año</th>\n";
    echo "<th>Precio</th>\n";
    echo "</tr>\n";

    foreach ($muebles as $indice => $mueble) {

        echo "<tr>\n";

        echo "<td>" . $indice . "</td>\n";

        echo "<td>";
        echo htmlspecialchars(get_class($mueble), ENT_QUOTES, 'UTF-8');
        echo "</td>\n";

        echo "<td>";
        echo htmlspecialchars($mueble->getNombre(), ENT_QUOTES, 'UTF-8');
        echo "</td>\n";

        echo "<td>";
        echo htmlspecialchars($mueble->getFabricante(), ENT_QUOTES, 'UTF-8');
        echo "</td>\n";

        echo "<td>";
        echo htmlspecialchars($mueble->getPais(), ENT_QUOTES, 'UTF-8');
        echo "</td>\n";

        echo "<td>" . $mueble->getAnio() . "</td>\n";

        echo "<td>";
        echo number_format($mueble->getPrecio(), 2, ',', '.') . " €";
        echo "</td>\n";

        echo "</tr>\n";
    }

    echo "</table>\n";

    // Formulario para seleccionar un mueble.
    echo "<h2>Seleccionar mueble</h2>\n";

    echo "<form method='post' action='index.php'>\n";

    echo "<label for='indice'>Mueble:</label>\n";

    echo "<select name='indice' id='indice' required>\n";

    echo "<option value=''>Selecciona un mueble</option>\n";

    foreach ($muebles as $indice => $mueble) {

        $seleccionado = '';

        // Mantenemos seleccionado el mueble que se estaba consultando.
        if ($indiceSeleccionado === $indice) {
            $seleccionado = 'selected';
        }

        $texto = $indice . ' - ' . get_class($mueble) . ' - ' . $mueble->getNombre();

        echo "<option value='" . $indice . "' " . $seleccionado . ">";

        echo htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');

        echo "</option>\n";
    }

    echo "</select>\n";

    echo "<br /><br />\n";

    // Botón para mostrar las propiedades del mueble.
    echo "<button type='submit' name='accion' value='mostrar'>";
    echo "Mostrar Mueble";
    echo "</button>\n";

    // Botón para abrir la página de modificación en otra pestaña.
    echo "<button type='submit' name='accion' value='modificar' ";
    echo "formaction='modificar.php' formtarget='_blank'>";
    echo "Modificar Mueble";
    echo "</button>\n";

    echo "</form>\n";

    // Mostramos las propiedades si se ha seleccionado un mueble.
    if ($muebleSeleccionado !== null) {

        echo "<h2>Datos del mueble seleccionado</h2>\n";

        // Propiedades de MuebleBase.
        echo "<p><strong>Nombre:</strong> ";
        echo htmlspecialchars($muebleSeleccionado->getNombre(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>Fabricante:</strong> ";
        echo htmlspecialchars($muebleSeleccionado->getFabricante(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>País:</strong> ";
        echo htmlspecialchars($muebleSeleccionado->getPais(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>Año:</strong> ";
        echo $muebleSeleccionado->getAnio();
        echo "</p>\n";

        echo "<p><strong>Fecha inicial de venta:</strong> ";
        echo htmlspecialchars($muebleSeleccionado->getFechaIniVenta(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>Fecha final de venta:</strong> ";
        echo htmlspecialchars($muebleSeleccionado->getFechaFinVenta(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>Precio:</strong> ";
        echo number_format($muebleSeleccionado->getPrecio(), 2, ',', '.') . " €";
        echo "</p>\n";

        // Obtenemos las propiedades adicionales del tipo de mueble.
        $propiedades = $muebleSeleccionado->damePropiedadesAdicionales();


        // Mostramos las propiedades adicionales.
        echo "<h3>Propiedades adicionales</h3>\n";

        // Comprobamos si es un mueble reciclado.
        if ($muebleSeleccionado instanceof MuebleReciclado) {

            echo "<p><strong>Porcentaje reciclado:</strong> ";
            echo $muebleSeleccionado->getPorcentajeReciclado() . "%";
            echo "</p>\n";
        }

        // Comprobamos si es un mueble tradicional.
        elseif ($muebleSeleccionado instanceof MuebleTradicional) {

            echo "<p><strong>Peso:</strong> ";
            echo $muebleSeleccionado->getPeso() . " kg";
            echo "</p>\n";

            echo "<p><strong>Serie:</strong> ";
            echo htmlspecialchars(
                $muebleSeleccionado->getSerie(),
                ENT_QUOTES,
                'UTF-8'
            );
            echo "</p>\n";
        }


        // Mostramos las características adicionales.
        echo "<h3>Características</h3>\n";

        $caracteristicas = $muebleSeleccionado->getCaracteristicas();

        foreach ($caracteristicas as $nombre => $valor) {

            // Convertimos los valores booleanos en texto.
            if (is_bool($valor)) {

                if ($valor) {
                    $valor = 'true';
                } else {
                    $valor = 'false';
                }
            }

            // Mostramos cada característica.
            echo "<p><strong>";
            echo htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
            echo ":</strong> ";

            echo htmlspecialchars(print_r($valor, true), ENT_QUOTES, 'UTF-8');

            echo "</p>\n";
        }
    }

    finCuerpo();
}