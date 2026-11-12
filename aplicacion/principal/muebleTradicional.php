<?php
/**
 * Clase que representa un mueble tradicional.
 * Hereda de MuebleBase.
 */
final class MuebleTradicional extends MuebleBase
{
    // Peso del mueble.
    private float $_peso = 15.0;

    // Serie del mueble.
    private string $_serie = 'S01';

    // Constructor de MuebleTradicional.
    public function __construct(
        string $nombre,
        string $fabricante = 'FaMu:',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        ?string $fechaIniVenta = null,
        string $fechaFinVenta = '31/12/2040',
        float $precio = 30.0,
        float $peso = 15.0,
        string $serie = 'S01'
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

        // Establecemos el peso.
        if (!$this->setPeso($peso)) {
            $this->setPeso(15.0);
        }

        // Establecemos la serie.
        if (!$this->setSerie($serie)) {
            $this->setSerie('S01');
        }
    }

    // Devuelve el peso.
    public function getPeso(): float
    {
        return $this->_peso;
    }

    // Comprueba y establece el peso.
    public function setPeso(float $peso): bool
    {
        if ($peso < 15 || $peso > 300) {
            return false;
        }

        $this->_peso = $peso;

        return true;
    }

    // Devuelve la serie.
    public function getSerie(): string
    {
        return $this->_serie;
    }

    // Establece la serie.
    public function setSerie(string $serie): bool
    {
        $this->_serie = $serie;

        return true;
    }

    // Indica las propiedades adicionales de esta clase.
    public function damePropiedadesAdicionales(): array
    {
        return ['Peso', 'Serie'];
    }

    // Añade el peso y la serie a la conversión a cadena.
    public function __toString(): string
    {
        return parent::__toString()
            . ', peso: ' . $this->_peso
            . ', serie: ' . $this->_serie;
    }
}