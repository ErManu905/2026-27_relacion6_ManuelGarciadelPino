<?php

// Obtiene los datos de la página principal.
function obtenerDatosIndex(): array
{
    $datos = [
        'titulo' => 'TIENDA DE MUEBLES',
        'mensaje' => 'Bienvenido a nuestra tienda de muebles.'
    ];

    return $datos;
}

// Crea los cinco muebles de la aplicación.
function obtenerMuebles(): array
{
    // Array de muebles.
    $muebles = [];

    // Mueble 1: reciclado.
    $muebles[1] = new MuebleReciclado(
        'SILLA ECO',
        'Muebles Ecologicos',
        'ESPAÑA',
        2022,
        '01/02/2022',
        '31/12/2040',
        85.50,
        80
    );

    $muebles[1]->anadirCaracteristicas(
        'color', 'verde',
        'material', 'madera reciclada'
    );

    // Mueble 2: tradicional.
    $muebles[2] = new MuebleTradicional(
        'MESA DE ROBLE',
        'Carpinteria Artesana',
        'ESPAÑA',
        2021,
        '15/03/2021',
        '31/12/2040',
        180.00,
        35.5,
        'T01'
    );

    $muebles[2]->anadirCaracteristicas(
        'color', 'marron',
        'acabado', 'barnizado'
    );

    // Mueble 3: reciclado.
    $muebles[3] = new MuebleReciclado(
        'ESTANTERIA RECICLADA',
        'EcoHogar',
        'PORTUGAL',
        2023,
        '01/05/2023',
        '31/12/2040',
        120.00,
        65
    );

    $muebles[3]->anadirCaracteristicas(
        'color', 'blanco',
        'material', 'plastico reciclado'
    );

    // Mueble 4: tradicional.
    $muebles[4] = new MuebleTradicional(
        'SILLA CLASICA',
        'Muebles del Sur',
        'ESPAÑA',
        2020,
        '01/01/2020',
        '31/12/2040',
        95.50,
        18.5,
        'T02'
    );

    $muebles[4]->anadirCaracteristicas(
        'color', 'marron',
        'material', 'roble'
    );

    // Mueble 5: reciclado.
    $muebles[5] = new MuebleReciclado(
        'MESA AUXILIAR ECO',
        'Madera Viva',
        'ESPAÑA',
        2024,
        '01/06/2024',
        '31/12/2040',
        75.00,
        90
    );

    $muebles[5]->anadirCaracteristicas(
        'color', 'natural',
        'material', 'madera recuperada'
    );

    // Devolvemos el array.
    return $muebles;
}

?>