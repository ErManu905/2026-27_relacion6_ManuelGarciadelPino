<?php
/**
 * Clase que almacena características dinámicas.
 * Permite recorrerlas mediante foreach.
 */
class Caracteristicas implements IteratorAggregate
{
    // Array donde guardamos las características.
    private array $_caracteristicas = [];

    // Indica si se ha añadido ULTIMA.
    private bool $_ultima = false;

    // Añade o modifica una característica.
    public function __set(string $nombre, mixed $valor): void
    {
        // Comprobamos si la característica ya existe.
        $existe = array_key_exists($nombre, $this->_caracteristicas);

        // Si se ha añadido ULTIMA, no permitimos nuevas características.
        if ($this->_ultima && !$existe) {
            throw new Exception('No se pueden añadir más características.');
        }

        // Guardamos la característica.
        $this->_caracteristicas[$nombre] = $valor;

        // Si la característica es ULTIMA, bloqueamos las nuevas.
        if ($nombre === 'ULTIMA') {
            $this->_ultima = true;
        }
    }

    // Devuelve el valor de una característica.
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

    // Permite recorrer las características con foreach.
    public function getIterator(): Traversable
    {
        // Invertimos el orden de las características.
        $caracteristicas = array_reverse($this->_caracteristicas, true);

        return new ArrayIterator($caracteristicas);
    }

    // Convierte todas las características en una cadena.
    public function __toString(): string
    {
        $resultado = [];

        foreach ($this as $nombre => $valor) {

            // Convertimos los valores booleanos en texto.
            if (is_bool($valor)) {
                if ($valor) {
                    $valor = 'true';
                } else {
                    $valor = 'false';
                }
            }

            // Convertimos los valores nulos en texto.
            elseif ($valor === null) {
                $valor = 'null';
            }

            // Convertimos arrays y objetos en cadenas.
            elseif (is_array($valor) || is_object($valor)) {
                $valor = json_encode($valor, JSON_UNESCAPED_UNICODE);
            }

            // Convertimos los demás valores a cadena.
            else {
                $valor = (string) $valor;
            }

            // Añadimos el nombre y el valor al resultado.
            $resultado[] = $nombre . ':' . $valor;
        }

        // Separamos las características con punto y coma.
        return implode(';', $resultado);
    }
}