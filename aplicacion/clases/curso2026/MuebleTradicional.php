<?php

// Clase para muebles tradicionales
final class MuebleTradicional extends MuebleBase
{
    // Peso del mueble.
    private float $_peso = 15.0;

    // Serie del mueble.
    private string $_serie = 'S01';

    // Constructor.
    public function __construct(
        string $nombre,
        string $fabricante = 'FaMu:',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        ?string $fechaIniVenta = null,
        string $fechaFinVenta = '31/12/2040',
        float $precio = 30.0,
        float $peso = 15.0,
        string $serie = 'S01',
        int $material = 10
    ) {
        // Constructor sobre la clase padre
        parent::__construct(
            $nombre,
            $fabricante,
            $pais,
            $anio,
            $fechaIniVenta,
            $fechaFinVenta,
            $precio,
            $material
        );

        // Se establece el peso.
        if (!$this->setPeso($peso)) {
            $this->setPeso(15.0);
        }

        // Se establece la serie.
        $this->setSerie($serie);
    }

    // Se devuelve el peso.
    public function getPeso(): float
    {
        return $this->_peso;
    }

    // Se establece el peso.
    public function setPeso(float $peso): bool
    {
        if ($peso < 15 || $peso > 300) {
            return false;
        }

        $this->_peso = $peso;

        return true;
    }

    // Se devuelve la serie.
    public function getSerie(): string
    {
        return $this->_serie;
    }

    // Se establece la serie.
    public function setSerie(string $serie): bool
    {
        $this->_serie = $serie;

        return true;
    }

    // Se devuelve las propiedades adicionales.
    public function PropiedadesAdicionales(): array
    {
        return ['Peso', 'Serie'];
    }

    // Se añade el peso y la serie a la conversión a cadena.
    public function __toString(): string
    {
        return parent::__toString()
            . ', peso: ' . $this->_peso
            . ', serie: ' . $this->_serie;
    }
}