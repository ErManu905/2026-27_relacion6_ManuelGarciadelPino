<?php
// Muestra el formulario para modificar un mueble.
// Los datos se reciben desde el controlador.
function vistaModificar(array $datos, string $tipo, int $indice): void
{
    inicioCabecera("Modificar mueble");
    finCabecera();

    inicioCuerpo("Modificar mueble", "Inicio > Modificar mueble");
?>

    <h2>Modificar mueble</h2>

    <p>Modifica los datos del mueble seleccionado.</p>

    <form action="modificar.php" method="post">

        <!-- Conservamos el índice del mueble que se está modificando. -->
        <input type="hidden" name="indice" value="<?php echo $indice; ?>">

        <p>
            <label for="nombre">Nombre:</label><br>
            <input type="text" id="nombre" name="nombre" maxlength="40" required
                   value="<?php echo htmlspecialchars((string)($datos['nombre'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label for="fabricante">Fabricante:</label><br>
            <input type="text" id="fabricante" name="fabricante" maxlength="30"
                   value="<?php echo htmlspecialchars((string)($datos['fabricante'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label for="pais">País:</label><br>
            <input type="text" id="pais" name="pais" maxlength="20"
                   value="<?php echo htmlspecialchars((string)($datos['pais'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label for="anio">Año de fabricación:</label><br>
            <input type="number" id="anio" name="anio" min="2020" max="<?php echo date('Y'); ?>"
                   value="<?php echo htmlspecialchars((string)($datos['anio'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label for="fechaIniVenta">Fecha de inicio de venta (dd/mm/aaaa):</label><br>
            <input type="text" id="fechaIniVenta" name="fechaIniVenta" placeholder="01/01/2020"
                   value="<?php echo htmlspecialchars((string)($datos['fechaIniVenta'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label for="fechaFinVenta">Fecha de fin de venta (dd/mm/aaaa):</label><br>
            <input type="text" id="fechaFinVenta" name="fechaFinVenta" placeholder="31/12/2040"
                   value="<?php echo htmlspecialchars((string)($datos['fechaFinVenta'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <p>
            <label for="precio">Precio (€):</label><br>
            <input type="number" id="precio" name="precio" min="30" step="0.01"
                   value="<?php echo htmlspecialchars((string)($datos['precio'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
        </p>

        <?php if ($tipo === "MuebleReciclado") { ?>
            <p>
                <label for="porcentajeReciclado">Porcentaje reciclado:</label><br>
                <input type="number" id="porcentajeReciclado" name="porcentajeReciclado"
                       min="0" max="100"
                       value="<?php echo htmlspecialchars((string)($datos['porcentajeReciclado'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            </p>
        <?php } ?>

        <?php if ($tipo === "MuebleTradicional") { ?>
            <p>
                <label for="peso">Peso (kg):</label><br>
                <input type="number" id="peso" name="peso" min="15" max="300" step="0.01"
                       value="<?php echo htmlspecialchars((string)($datos['peso'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            </p>

            <p>
                <label for="serie">Serie:</label><br>
                <input type="text" id="serie" name="serie"
                       value="<?php echo htmlspecialchars((string)($datos['serie'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>">
            </p>
        <?php } ?>

        <p>
            <button type="submit" name="modificar" value="1">Guardar cambios</button>
        </p>

    </form>

<?php
    finCuerpo();
}
?>