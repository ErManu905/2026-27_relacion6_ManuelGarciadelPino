<?php

// Cargamos la configuración, la plantilla y el controlador.
require_once dirname(__DIR__, 2) . '/cabecera.php';
require_once dirname(__DIR__) . '/plantillas/plantilla.php';
require_once __DIR__ . '/controlador.php';
require_once __DIR__ . '/vista_modificar.php';

// Obtenemos los cinco muebles.
$muebles = obtenerMuebles();

// Comprobamos que se ha recibido el índice del mueble.
if (!isset($_POST['indice'])) {
    paginaError('No se ha seleccionado ningún mueble.');
    exit;
}

// Comprobamos que el índice sea un entero.
$indice = filter_var($_POST['indice'], FILTER_VALIDATE_INT);

// Comprobamos que el mueble exista.
if ($indice === false || !isset($muebles[$indice])) {
    paginaError('El mueble seleccionado no existe.');
    exit;
}

// Obtenemos el mueble seleccionado.
$mueble = $muebles[$indice];

// Determinamos el tipo de mueble.
$tipo = get_class($mueble);

// Guardamos los datos actuales del mueble.
$datos = [
    'nombre' => $mueble->getNombre(),
    'fabricante' => $mueble->getFabricante(),
    'pais' => $mueble->getPais(),
    'anio' => $mueble->getAnio(),
    'fechaIniVenta' => $mueble->getFechaIniVenta(),
    'fechaFinVenta' => $mueble->getFechaFinVenta(),
    'precio' => $mueble->getPrecio()
];

// Guardamos las propiedades adicionales.
if ($mueble instanceof MuebleReciclado) {
    $datos['porcentajeReciclado'] = $mueble->getPorcentajeReciclado();
} else {
    $datos['peso'] = $mueble->getPeso();
    $datos['serie'] = $mueble->getSerie();
}

// Array para guardar los errores.
$errores = [];

// Al principio no hay ningún mueble modificado.
$muebleModificado = null;

// Comprobamos si se ha enviado el formulario de modificación.
if (isset($_POST['accion']) && $_POST['accion'] === 'guardar') {

    // Recogemos los datos del formulario.
    // Comprobamos que sean cadenas para evitar errores.
    $campos = [
        'nombre',
        'fabricante',
        'pais',
        'anio',
        'fechaIniVenta',
        'fechaFinVenta',
        'precio',
        'porcentajeReciclado',
        'peso',
        'serie'
    ];

    foreach ($campos as $campo) {
        if (isset($_POST[$campo]) && is_string($_POST[$campo])) {
            $datos[$campo] = trim($_POST[$campo]);
        }
    }

    // -------------------------------------------------
    // VALIDACIÓN MEDIANTE LOS MÉTODOS SET
    // -------------------------------------------------

    // Creamos una instancia auxiliar del mismo tipo.
    // Así no modificamos el mueble original mientras validamos.
    $auxiliar = clone $mueble;

    // Comprobamos el nombre.
    if (!$auxiliar->setNombre($datos['nombre'])) {
        $errores[] = 'El nombre no puede estar vacío y no puede superar los 40 caracteres.';
    }

    // Comprobamos el fabricante.
    if (!$auxiliar->setFabricante($datos['fabricante'])) {
        $errores[] = 'El fabricante no es válido.';
    }

    // Comprobamos el país.
    if (!$auxiliar->setPais($datos['pais'])) {
        $errores[] = 'El país no puede superar los 20 caracteres.';
    }

    // Comprobamos las propiedades adicionales.
    if ($mueble instanceof MuebleReciclado) {

        $porcentaje = filter_var(
            $datos['porcentajeReciclado'],
            FILTER_VALIDATE_INT
        );

        if ($porcentaje === false) {
            $errores[] = 'El porcentaje reciclado debe ser un entero.';
        } elseif (!$auxiliar->setPorcentajeReciclado($porcentaje)) {
            $errores[] = 'El porcentaje reciclado debe estar entre 0 y 100.';
        }

    } else {

        // Comprobamos el peso.
        if (!is_numeric($datos['peso'])) {
            $errores[] = 'El peso debe ser un número.';
        } elseif (!$auxiliar->setPeso((float) $datos['peso'])) {
            $errores[] = 'El peso debe estar entre 15 y 300.';
        }

        // Establecemos la serie.
        if (!$auxiliar->setSerie($datos['serie'])) {
            $errores[] = 'La serie no es válida.';
        }
    }

    // -------------------------------------------------
    // VALIDACIÓN MEDIANTE CONDICIONES
    // -------------------------------------------------

    // Comprobamos el año.
    $anio = filter_var($datos['anio'], FILTER_VALIDATE_INT);

    if ($anio === false) {
        $errores[] = 'El año debe ser un número entero.';
    } elseif ($anio < 2020 || $anio > (int) date('Y')) {
        $errores[] = 'El año debe estar entre 2020 y el año actual.';
    }

    // Comprobamos que las fechas sean correctas.
    $fechaInicio = DateTime::createFromFormat(
        '!d/m/Y',
        $datos['fechaIniVenta']
    );

    $fechaFinal = DateTime::createFromFormat(
        '!d/m/Y',
        $datos['fechaFinVenta']
    );

    // Comprobamos la fecha inicial.
    $fechaInicioCorrecta = false;

    if (
        $fechaInicio !== false &&
        $fechaInicio->format('d/m/Y') === $datos['fechaIniVenta']
    ) {
        $fechaInicioCorrecta = true;
    }

    if (!$fechaInicioCorrecta) {
        $errores[] = 'La fecha inicial no tiene un formato válido. Usa dd/mm/aaaa.';
    }

    // Comprobamos la fecha final.
    $fechaFinalCorrecta = false;

    if (
        $fechaFinal !== false &&
        $fechaFinal->format('d/m/Y') === $datos['fechaFinVenta']
    ) {
        $fechaFinalCorrecta = true;
    }

    if (!$fechaFinalCorrecta) {
        $errores[] = 'La fecha final no tiene un formato válido. Usa dd/mm/aaaa.';
    }

    // La fecha inicial no puede ser anterior al año de fabricación.
    if ($anio !== false && $fechaInicioCorrecta) {

        $fechaMinima = DateTime::createFromFormat(
            '!d/m/Y',
            '01/01/' . $anio
        );

        if ($fechaInicio < $fechaMinima) {
            $errores[] = 'La fecha inicial no puede ser anterior al año de fabricación.';
        }
    }

    // La fecha final no puede ser anterior a la inicial.
    if ($fechaInicioCorrecta && $fechaFinalCorrecta) {

        if ($fechaFinal < $fechaInicio) {
            $errores[] = 'La fecha final no puede ser anterior a la fecha inicial.';
        }
    }

    // Comprobamos el precio.
    $precio = str_replace(',', '.', $datos['precio']);

    if (!is_numeric($precio)) {
        $errores[] = 'El precio debe ser un número.';
    } elseif ((float) $precio < 30) {
        $errores[] = 'El precio no puede ser inferior a 30.';
    }

    // -------------------------------------------------
    // ACTUALIZACIÓN DEL MUEBLE
    // -------------------------------------------------

    // Solo actualizamos si no hay errores.
    if (count($errores) === 0) {

        // Obtenemos el año y las fechas anteriores.
        $anioAnterior = $mueble->getAnio();

        $fechaInicioAnterior = DateTime::createFromFormat(
            '!d/m/Y',
            $mueble->getFechaIniVenta()
        );

        // Si el nuevo año es menor o igual al anterior,
        // podemos establecerlo antes de cambiar las fechas.
        if ($anio <= $anioAnterior) {
            if (!$auxiliar->setAnio($anio)) {
                $errores[] = 'No se ha podido establecer el año.';
            }
        }

        // Comprobamos si la nueva fecha final es anterior
        // a la fecha inicial que tenía el mueble.
        if ($fechaFinal < $fechaInicioAnterior) {

            // Primero cambiamos la fecha inicial.
            if (!$auxiliar->setFechaIniVenta($datos['fechaIniVenta'])) {
                $errores[] = 'No se ha podido establecer la fecha inicial.';
            }

            // Si el nuevo año es mayor, lo cambiamos ahora.
            if ($anio > $anioAnterior) {
                if (!$auxiliar->setAnio($anio)) {
                    $errores[] = 'No se ha podido establecer el año.';
                }
            }

            // Finalmente cambiamos la fecha final.
            if (!$auxiliar->setFechaFinVenta($datos['fechaFinVenta'])) {
                $errores[] = 'No se ha podido establecer la fecha final.';
            }

        } else {

            // Primero cambiamos la fecha final.
            if (!$auxiliar->setFechaFinVenta($datos['fechaFinVenta'])) {
                $errores[] = 'No se ha podido establecer la fecha final.';
            }

            // Después cambiamos la fecha inicial.
            if (!$auxiliar->setFechaIniVenta($datos['fechaIniVenta'])) {
                $errores[] = 'No se ha podido establecer la fecha inicial.';
            }

            // Si el nuevo año es mayor, lo cambiamos ahora.
            if ($anio > $anioAnterior) {
                if (!$auxiliar->setAnio($anio)) {
                    $errores[] = 'No se ha podido establecer el año.';
                }
            }
        }

        // Establecemos el precio.
        if (!$auxiliar->setPrecio((float) $precio)) {
            $errores[] = 'No se ha podido establecer el precio.';
        }

        // Si no han aparecido errores, guardamos el mueble actualizado.
        if (count($errores) === 0) {

            $muebles[$indice] = $auxiliar;

            $muebleModificado = $auxiliar;

            // Actualizamos los datos que se mostrarán en el resumen.
            $datos['nombre'] = $auxiliar->getNombre();
            $datos['fabricante'] = $auxiliar->getFabricante();
            $datos['pais'] = $auxiliar->getPais();
            $datos['anio'] = $auxiliar->getAnio();
            $datos['fechaIniVenta'] = $auxiliar->getFechaIniVenta();
            $datos['fechaFinVenta'] = $auxiliar->getFechaFinVenta();
            $datos['precio'] = $auxiliar->getPrecio();
        }
    }
}

// Mostramos el formulario o el resumen.
vistaModificar($datos, $tipo, $indice, $errores, $muebleModificado);

?>