<?php

// Esta clase almacena las características adicionales
class Caracteristicas implements IteratorAggregate
{
    // En este array se guardan las características
    private array $_caracteristicas = [];

    // Esta función indica si se ha agregado la última característica
    private bool $_ultima = false;

    // Esta función añade o modifica una característica.
    public function __set(string $nombre, mixed $valor): void
    {
        // Comprobamos si la característica ya existe.
        $existe = array_key_exists($nombre, $this->_caracteristicas);

        // Si es la última, no permitimos añadir nuevas.
        if ($this->_ultima && !$existe) {
            throw new Exception('No se pueden añadir más características.');
        }

        // Se guarda la característica
        $this->_caracteristicas[$nombre] = $valor;

        // Impedimos que se agregen más si se añade la última
        if ($nombre === 'ULTIMA') {
            $this->_ultima = true;
        }
    }

    // Devuelve una característica.
    public function __get(string $nombre): mixed
    {
        if (!array_key_exists($nombre, $this->_caracteristicas)) {
            throw new Exception('La característica no existe.');
        }

        return $this->_caracteristicas[$nombre];
    }

    // Comprueba si existe una característica.
    public function __isset(string $nombre): bool
    {
        return array_key_exists($nombre, $this->_caracteristicas);
    }

    // Permite utilizar foreach.
    public function getIterator(): Traversable
    {
        // Devolvemos las características en orden inverso.
        $caracteristicas = array_reverse($this->_caracteristicas, true);

        return new ArrayIterator($caracteristicas);
    }

    // Convierte las características en una cadena.
    public function __toString(): string
    {
        $resultado = [];

        foreach ($this as $nombre => $valor) {

            // Si el valor es una cadena, lo dejamos como está.
            if (is_string($valor)) {
                $valorTexto = $valor;
            }

            // Si es booleano, mostramos true o false.
            elseif (is_bool($valor)) {
                if ($valor) {
                    $valorTexto = 'true';
                } else {
                    $valorTexto = 'false';
                }
            }

            // Si es null, mostramos null.
            elseif ($valor === null) {
                $valorTexto = 'null';
            }

            // Si es un número, lo convertimos en cadena.
            elseif (is_numeric($valor)) {
                $valorTexto = (string) $valor;
            }

            // Para arrays u objetos utilizamos JSON.
            else {
                $valorTexto = json_encode($valor, JSON_UNESCAPED_UNICODE);

                if ($valorTexto === false) {
                    $valorTexto = '';
                }
            }

            // Añadimos el nombre y el valor.
            $resultado[] = $nombre . ':' . $valorTexto;
        }

        // Separamos las características con punto y coma.
        return implode(';', $resultado);
    }
}