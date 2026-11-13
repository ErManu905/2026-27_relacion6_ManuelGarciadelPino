<?php

// Muestra el formulario de modificación y el resultado.
function vistaModificar(
    array $datos,
    string $tipo,
    int $indice,
    array $errores,
    ?MuebleBase $muebleModificado
): void {

    inicioCabecera('Modificar mueble');
    finCabecera();

    inicioCuerpo('Modificar mueble', 'Inicio > Modificar mueble');

    echo "<h2>Modificar mueble</h2>\n";

    // Si existe un mueble modificado, mostramos el resumen.
    if ($muebleModificado !== null) {

        echo "<p>El mueble se ha modificado correctamente.</p>\n";

        echo "<h3>Resumen de los datos</h3>\n";

        echo "<p><strong>Nombre:</strong> ";
        echo htmlspecialchars($muebleModificado->getNombre(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>Fabricante:</strong> ";
        echo htmlspecialchars($muebleModificado->getFabricante(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>País:</strong> ";
        echo htmlspecialchars($muebleModificado->getPais(), ENT_QUOTES, 'UTF-8');
        echo "</p>\n";

        echo "<p><strong>Año:</strong> ";
        echo $muebleModificado->getAnio();
        echo "</p>\n";

        echo "<p><strong>Fecha inicial de venta:</strong> ";
        echo $muebleModificado->getFechaIniVenta();
        echo "</p>\n";

        echo "<p><strong>Fecha final de venta:</strong> ";
        echo $muebleModificado->getFechaFinVenta();
        echo "</p>\n";

        echo "<p><strong>Precio:</strong> ";
        echo number_format($muebleModificado->getPrecio(), 2, ',', '.') . " €";
        echo "</p>\n";


        // Mostramos las propiedades adicionales.
        if ($muebleModificado instanceof MuebleReciclado) {

            echo "<p><strong>Porcentaje reciclado:</strong> ";
            echo $muebleModificado->getPorcentajeReciclado() . "%";
            echo "</p>\n";
        } elseif ($muebleModificado instanceof MuebleTradicional) {

            echo "<p><strong>Peso:</strong> ";
            echo $muebleModificado->getPeso() . " kg";
            echo "</p>\n";

            echo "<p><strong>Serie:</strong> ";
            echo htmlspecialchars(
                $muebleModificado->getSerie(),
                ENT_QUOTES,
                'UTF-8'
            );
            echo "</p>\n";
        }


        // Enlace para regresar a la página principal.
        echo "<br />\n";
        echo "<a href='" . RUTABASE . "/aplicacion/principal/index.php'>";
        echo "Volver al inicio";
        echo "</a>\n";
    } else {

        // Si hay errores, los mostramos antes del formulario.
        if (count($errores) > 0) {

            echo "<h3>Se han encontrado los siguientes errores:</h3>\n";

            echo "<ul>\n";

            foreach ($errores as $error) {
                echo "<li>";
                echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
                echo "</li>\n";
            }

            echo "</ul>\n";
        }

        // Formulario de modificación.
        echo "<form method='post' action='modificar.php'>\n";

        // Guardamos el índice del mueble.
        echo "<input type='hidden' name='indice' value='" . $indice . "'>\n";

        // Nombre.
        echo "<p>\n";
        echo "<label for='nombre'>Nombre:</label>\n";
        echo "<input type='text' id='nombre' name='nombre' maxlength='40' required ";
        echo "value='" . htmlspecialchars((string) $datos['nombre'], ENT_QUOTES, 'UTF-8') . "'>\n";
        echo "</p>\n";

        // Fabricante.
        echo "<p>\n";
        echo "<label for='fabricante'>Fabricante:</label>\n";
        echo "<input type='text' id='fabricante' name='fabricante' ";
        echo "value='" . htmlspecialchars((string) $datos['fabricante'], ENT_QUOTES, 'UTF-8') . "'>\n";
        echo "</p>\n";

        // País.
        echo "<p>\n";
        echo "<label for='pais'>País:</label>\n";
        echo "<input type='text' id='pais' name='pais' maxlength='20' ";
        echo "value='" . htmlspecialchars((string) $datos['pais'], ENT_QUOTES, 'UTF-8') . "'>\n";
        echo "</p>\n";

        // Año.
        echo "<p>\n";
        echo "<label for='anio'>Año de fabricación:</label>\n";
        echo "<input type='number' id='anio' name='anio' min='2020' ";
        echo "max='" . date('Y') . "' required ";
        echo "value='" . htmlspecialchars((string) $datos['anio'], ENT_QUOTES, 'UTF-8') . "'>\n";
        echo "</p>\n";

        // Fecha inicial.
        echo "<p>\n";
        echo "<label for='fechaIniVenta'>Fecha inicial de venta (dd/mm/aaaa):</label>\n";
        echo "<input type='text' id='fechaIniVenta' name='fechaIniVenta' required ";
        echo "value='" . htmlspecialchars((string) $datos['fechaIniVenta'], ENT_QUOTES, 'UTF-8') . "'>\n";
        echo "</p>\n";

        // Fecha final.
        echo "<p>\n";
        echo "<label for='fechaFinVenta'>Fecha final de venta (dd/mm/aaaa):</label>\n";
        echo "<input type='text' id='fechaFinVenta' name='fechaFinVenta' required ";
        echo "value='" . htmlspecialchars((string) $datos['fechaFinVenta'], ENT_QUOTES, 'UTF-8') . "'>\n";
        echo "</p>\n";

        // Precio.
        echo "<p>\n";
        echo "<label for='precio'>Precio:</label>\n";
        echo "<input type='number' id='precio' name='precio' min='30' step='0.01' required ";
        echo "value='" . htmlspecialchars((string) $datos['precio'], ENT_QUOTES, 'UTF-8') . "'>\n";
        echo "</p>\n";

        // Campos adicionales del mueble reciclado.
        if ($tipo === 'MuebleReciclado') {

            echo "<p>\n";
            echo "<label for='porcentajeReciclado'>Porcentaje reciclado:</label>\n";
            echo "<input type='number' id='porcentajeReciclado' ";
            echo "name='porcentajeReciclado' min='0' max='100' required ";
            echo "value='" . htmlspecialchars((string) $datos['porcentajeReciclado'], ENT_QUOTES, 'UTF-8') . "'>\n";
            echo "</p>\n";
        }

        // Campos adicionales del mueble tradicional.
        elseif ($tipo === 'MuebleTradicional') {

            echo "<p>\n";
            echo "<label for='peso'>Peso:</label>\n";
            echo "<input type='number' id='peso' name='peso' min='15' max='300' ";
            echo "step='0.01' required ";
            echo "value='" . htmlspecialchars((string) $datos['peso'], ENT_QUOTES, 'UTF-8') . "'>\n";
            echo "</p>\n";

            echo "<p>\n";
            echo "<label for='serie'>Serie:</label>\n";
            echo "<input type='text' id='serie' name='serie' required ";
            echo "value='" . htmlspecialchars((string) $datos['serie'], ENT_QUOTES, 'UTF-8') . "'>\n";
            echo "</p>\n";
        }

        // Botón para enviar los datos.
        echo "<button type='submit' name='accion' value='guardar'>";
        echo "Guardar cambios";
        echo "</button>\n";

        echo "</form>\n";

        echo "<br />\n";

        echo "<a href='" . RUTABASE . "/aplicacion/principal/index.php'>";
        echo "Volver al inicio";
        echo "</a>\n";
    }

    finCuerpo();
}
