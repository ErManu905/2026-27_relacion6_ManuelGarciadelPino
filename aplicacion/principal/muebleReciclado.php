<?php

// Clase que representa un mueble reciclado.
final class MuebleReciclado extends MuebleBase
{
    // Porcentaje de material reciclado.
    private int $_porcentajeReciclado = 10;

    // Constructor.
    public function __construct(
        string $nombre,
        string $fabricante = 'FaMu:',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        ?string $fechaIniVenta = null,
        string $fechaFinVenta = '31/12/2040',
        float $precio = 30.0,
        int $porcentajeReciclado = 10
    ) {
        // Ejecutamos el constructor de la clase padre.
        parent::__construct(
            $nombre,
            $fabricante,
            $pais,
            $anio,
            $fechaIniVenta,
            $fechaFinVenta,
            $precio
        );

        // Establecemos el porcentaje.
        if (!$this->setPorcentajeReciclado($porcentajeReciclado)) {
            $this->setPorcentajeReciclado(10);
        }
    }

    // Devuelve el porcentaje reciclado.
    public function getPorcentajeReciclado(): int
    {
        return $this->_porcentajeReciclado;
    }

    // Establece el porcentaje reciclado.
    public function setPorcentajeReciclado(int $porcentaje): bool
    {
        if ($porcentaje < 0 || $porcentaje > 100) {
            return false;
        }

        $this->_porcentajeReciclado = $porcentaje;

        return true;
    }

    // Devuelve las propiedades adicionales.
    public function damePropiedadesAdicionales(): array
    {
        return ['PorcentajeReciclado'];
    }

    // Añade el porcentaje a la conversión a cadena.
    public function __toString(): string
    {
        return parent::__toString()
            . ', porcentaje reciclado: ' . $this->_porcentajeReciclado . '%';
    }
}