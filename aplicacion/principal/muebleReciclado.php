<?php
/**
 * Clase que representa un mueble reciclado.
 * Hereda de MuebleBase.
 */
final class MuebleReciclado extends MuebleBase
{
    // Porcentaje de material reciclado.
    private int $_porcentajeReciclado = 10;

    // Constructor de MuebleReciclado.
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
        // Llamamos al constructor de MuebleBase.
        parent::__construct(
            $nombre,
            $fabricante,
            $pais,
            $anio,
            $fechaIniVenta,
            $fechaFinVenta,
            $precio
        );

        // Establecemos el porcentaje reciclado.
        if (!$this->setPorcentajeReciclado($porcentajeReciclado)) {
            $this->setPorcentajeReciclado(10);
        }
    }

    // Devuelve el porcentaje reciclado.
    public function getPorcentajeReciclado(): int
    {
        return $this->_porcentajeReciclado;
    }

    // Comprueba y establece el porcentaje reciclado.
    public function setPorcentajeReciclado(int $porcentaje): bool
    {
        if ($porcentaje < 0 || $porcentaje > 100) {
            return false;
        }

        $this->_porcentajeReciclado = $porcentaje;

        return true;
    }

    // Indica las propiedades adicionales de esta clase.
    public function damePropiedadesAdicionales(): array
    {
        return ['PorcentajeReciclado'];
    }

    // Añade el porcentaje reciclado a la conversión a cadena.
    public function __toString(): string
    {
        return parent::__toString()
            . ', porcentaje reciclado: ' . $this->_porcentajeReciclado . '%';
    }
}