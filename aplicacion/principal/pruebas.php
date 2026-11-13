<?php

// Cargamos la configuración y la plantilla.
require_once dirname(__DIR__, 2) . '/cabecera.php';
require_once dirname(__DIR__) . '/plantillas/plantilla.php';

// Cargamos la vista.
require_once __DIR__ . '/vista_pruebas.php';

// Creamos un mueble de cada tipo.
$muebleReciclado = new MuebleReciclado('SILLA DE PRUEBA');
$muebleTradicional = new MuebleTradicional('MESA DE PRUEBA');

// Array donde guardaremos los resultados.
$pruebas = [];

// -------------------------------------------------
// PRUEBAS DE MUEBLEBASE
// -------------------------------------------------

// Comprobamos el nombre.
$resultado = $muebleReciclado->getNombre() === 'SILLA DE PRUEBA';

$pruebas[] = [
    'nombre' => 'Constructor y getNombre()',
    'resultado' => $resultado
];

// Probamos establecer un nombre correcto.
$resultado = $muebleReciclado->setNombre('SILLA NUEVA');

// Probamos establecer un nombre incorrecto.
$nombreIncorrecto = !$muebleReciclado->setNombre('');

// Comprobamos que se conserva el nombre anterior.
$nombreSeMantiene = $muebleReciclado->getNombre() === 'SILLA NUEVA';

$pruebas[] = [
    'nombre' => 'setNombre()',
    'resultado' => $resultado && $nombreIncorrecto && $nombreSeMantiene
];

// Probamos el fabricante.
$resultado = $muebleReciclado->setFabricante('Muebles Prueba');

$fabricanteCorrecto = $muebleReciclado->getFabricante() === 'FaMu:Muebles Prueba';

$pruebas[] = [
    'nombre' => 'setFabricante() y getFabricante()',
    'resultado' => $resultado && $fabricanteCorrecto
];

// Probamos el país.
$resultado = $muebleReciclado->setPais('PORTUGAL');

$paisCorrecto = $muebleReciclado->getPais() === 'PORTUGAL';

$paisIncorrecto = !$muebleReciclado->setPais(str_repeat('A', 21));

$pruebas[] = [
    'nombre' => 'setPais() y getPais()',
    'resultado' => $resultado && $paisCorrecto && $paisIncorrecto
];

// Probamos la fecha inicial.
$resultado = $muebleReciclado->setFechaIniVenta('01/03/2024');

// Probamos el año.
$anioCorrecto = $muebleReciclado->setAnio(2024);

// Comprobamos que el año futuro se rechaza.
$anioIncorrecto = !$muebleReciclado->setAnio((int) date('Y') + 1);

$pruebas[] = [
    'nombre' => 'setAnio() y setFechaIniVenta()',
    'resultado' => $resultado && $anioCorrecto && $anioIncorrecto
];

// Probamos la fecha final.
$resultado = $muebleReciclado->setFechaFinVenta('31/12/2040');

// Probamos una fecha final anterior a la inicial.
$fechaIncorrecta = !$muebleReciclado->setFechaFinVenta('01/01/2024');

$pruebas[] = [
    'nombre' => 'setFechaFinVenta()',
    'resultado' => $resultado && $fechaIncorrecta
];

// Probamos el precio.
$resultado = $muebleReciclado->setPrecio(100.0);

$precioCorrecto = $muebleReciclado->getPrecio() === 100.0;

$precioIncorrecto = !$muebleReciclado->setPrecio(20.0);

$pruebas[] = [
    'nombre' => 'setPrecio() y getPrecio()',
    'resultado' => $resultado && $precioCorrecto && $precioIncorrecto
];

// Probamos puedeCrear().
$numeroDisponible = 0;

$resultado = MuebleBase::puedeCrear($numeroDisponible);

$pruebas[] = [
    'nombre' => 'puedeCrear()',
    'resultado' => $resultado && $numeroDisponible > 0
];

// Probamos damePropiedadesAdicionales().
$propiedades = $muebleReciclado->damePropiedadesAdicionales();

$resultado = $propiedades === ['PorcentajeReciclado'];

$pruebas[] = [
    'nombre' => 'damePropiedadesAdicionales()',
    'resultado' => $resultado
];

// Probamos __toString().
$resultado = strpos((string) $muebleReciclado, 'SILLA NUEVA') !== false;

$pruebas[] = [
    'nombre' => '__toString()',
    'resultado' => $resultado
];

// Comprobamos que no se pueden acceder a propiedades directamente.
$accesoBloqueado = false;

try {
    $valor = $muebleReciclado->propiedadInventada;
} catch (Exception $error) {
    $accesoBloqueado = true;
}

$pruebas[] = [
    'nombre' => 'Bloqueo de propiedades directas',
    'resultado' => $accesoBloqueado
];

// -------------------------------------------------
// PRUEBAS DE MUEBLERECICLADO
// -------------------------------------------------

// Comprobamos el valor por defecto.
$resultado = $muebleReciclado->getPorcentajeReciclado() === 10;

// Establecemos un porcentaje correcto.
$resultado = $resultado && $muebleReciclado->setPorcentajeReciclado(75);

// Probamos un porcentaje incorrecto.
$porcentajeIncorrecto = !$muebleReciclado->setPorcentajeReciclado(101);

// Comprobamos que se mantiene el valor anterior.
$porcentajeSeMantiene = $muebleReciclado->getPorcentajeReciclado() === 75;

$pruebas[] = [
    'nombre' => 'setPorcentajeReciclado() y getPorcentajeReciclado()',
    'resultado' => $resultado && $porcentajeIncorrecto && $porcentajeSeMantiene
];

// -------------------------------------------------
// PRUEBAS DE MUEBLETRADICIONAL
// -------------------------------------------------

// Comprobamos el peso por defecto.
$resultado = $muebleTradicional->getPeso() === 15.0;

// Establecemos un peso correcto.
$resultado = $resultado && $muebleTradicional->setPeso(100.0);

// Probamos un peso incorrecto.
$pesoIncorrecto = !$muebleTradicional->setPeso(10.0);

$pruebas[] = [
    'nombre' => 'setPeso() y getPeso()',
    'resultado' => $resultado && $pesoIncorrecto &&
        $muebleTradicional->getPeso() === 100.0
];

// Comprobamos la serie.
$resultado = $muebleTradicional->getSerie() === 'S01';

$resultado = $resultado && $muebleTradicional->setSerie('S02');

$pruebas[] = [
    'nombre' => 'setSerie() y getSerie()',
    'resultado' => $resultado && $muebleTradicional->getSerie() === 'S02'
];

// -------------------------------------------------
// PRUEBAS DE CARACTERISTICAS
// -------------------------------------------------

// Creamos un objeto de características.
$caracteristicas = new Caracteristicas();

// Añadimos características.
$caracteristicas->color = 'verde';
$caracteristicas->material = 'madera';

// Comprobamos que se puede consultar una característica.
$resultado = $caracteristicas->color === 'verde';

// Comprobamos que podemos utilizar isset().
$resultado = $resultado && isset($caracteristicas->color);

// Comprobamos que no existe otra característica.
$resultado = $resultado && !isset($caracteristicas->precio);

// Comprobamos el recorrido inverso.
$orden = [];

foreach ($caracteristicas as $nombre => $valor) {
    $orden[] = $nombre;
}

$ordenCorrecto = $orden === ['material', 'color'];

$pruebas[] = [
    'nombre' => 'Características y foreach',
    'resultado' => $resultado && $ordenCorrecto
];

// Comprobamos la conversión a cadena.
$resultado = (string) $caracteristicas === 'material:madera;color:verde';

$pruebas[] = [
    'nombre' => 'Conversión de Caracteristicas a cadena',
    'resultado' => $resultado
];

// Añadimos ULTIMA.
$caracteristicas->ULTIMA = true;

// Modificamos una característica existente.
$caracteristicas->color = 'azul';

// Intentamos añadir una característica nueva.
$nuevaBloqueada = false;

try {
    $caracteristicas->precio = 100;
} catch (Exception $error) {
    $nuevaBloqueada = true;
}

$pruebas[] = [
    'nombre' => 'Funcionamiento de ULTIMA',
    'resultado' => $nuevaBloqueada &&
        $caracteristicas->color === 'azul'
];

// -------------------------------------------------
// PRUEBAS DE CARACTERISTICAS EN MUEBLEBASE
// -------------------------------------------------

// Añadimos dos características y un argumento sin pareja.
$muebleReciclado->anadirCaracteristicas(
    'color',
    'verde',
    'material',
    'madera',
    'sinPareja'
);

// Obtenemos las características del mueble.
$caracteristicasMueble = $muebleReciclado->getCaracteristicas();

// Comprobamos que devuelve un objeto Caracteristicas.
$resultado = $caracteristicasMueble instanceof Caracteristicas;

// Comprobamos que las características se han guardado.
$resultado = $resultado && $caracteristicasMueble->color === 'verde';

$resultado = $resultado && $caracteristicasMueble->material === 'madera';

// Comprobamos que se ha descartado el argumento sin pareja.
$resultado = $resultado && !isset($caracteristicasMueble->sinPareja);

// Comprobamos que aparecen en la conversión a cadena.
$resultado = $resultado &&
    strpos((string) $muebleReciclado, 'material:madera') !== false;

$pruebas[] = [
    'nombre' => 'anadirCaracteristicas() y getCaracteristicas()',
    'resultado' => $resultado
];

// -------------------------------------------------
// CONTAMOS LAS PRUEBAS CORRECTAS
// -------------------------------------------------

$correctas = 0;

foreach ($pruebas as $prueba) {

    if ($prueba['resultado']) {
        $correctas++;
    }
}

// Mostramos la vista.
require __DIR__ . '/vista_pruebas.php';

vistaPruebas($pruebas, $correctas);

?>