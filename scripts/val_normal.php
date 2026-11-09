<?php
namespace VALNORMAL;

/**
 * Comprueba que una variable contiene un entero dentro de un rango.
 *
 * @param int $var Variable que se comprobará.
 * @param int $min Valor mínimo permitido.
 * @param int $max Valor máximo permitido.
 * @param int $defecto Valor que se asignará si no es correcto.
 * @return bool
 */
function validaEntero(int &$var, int $min, int $max, int $defecto): bool
{
    if ($var < $min || $var > $max) {
        $var = $defecto;
        return false;
    }

    return true;
}


/**
 * Comprueba que una variable contiene un número real dentro de un rango.
 *
 * @param float $var Variable que se comprobará.
 * @param float $min Valor mínimo permitido.
 * @param float $max Valor máximo permitido.
 * @param float $defecto Valor que se asignará si no es correcto.
 * @return bool
 */
function validaReal(float &$var, float $min, float $max, float $defecto): bool
{
    if (!is_finite($var) || $var < $min || $var > $max) {
        $var = $defecto;
        return false;
    }

    return true;
}


/**
 * Comprueba y sanea una fecha con formato dd/mm/aaaa.
 *
 * @param string $var Fecha que se comprobará.
 * @param string $defecto Fecha por defecto.
 * @return bool
 */
function validaFecha(string &$var, string $defecto): bool
{
    // Comprobamos que tenga el formato día/mes/año.
    if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $var, $partes)) {

        $dia = (int) $partes[1];
        $mes = (int) $partes[2];
        $anio = (int) $partes[3];

        // Comprobamos que la fecha exista.
        if (checkdate($mes, $dia, $anio)) {

            // Convertimos la fecha a dos cifras para día y mes.
            $var = sprintf('%02d/%02d/%04d', $dia, $mes, $anio);

            return true;
        }
    }

    $var = $defecto;

    return false;
}


/**
 * Comprueba y sanea una hora con formato hh:mm:ss.
 *
 * @param string $var Hora que se comprobará.
 * @param string $defecto Hora por defecto.
 * @return bool
 */
function validaHora(string &$var, string $defecto): bool
{
    // Comprobamos que tenga el formato hora:minutos:segundos.
    if (preg_match('/^(\d{1,2}):(\d{1,2}):(\d{1,2})$/', $var, $partes)) {

        $hora = (int) $partes[1];
        $minutos = (int) $partes[2];
        $segundos = (int) $partes[3];

        // Comprobamos los límites de cada elemento.
        if ($hora >= 0 && $hora <= 23 &&
            $minutos >= 0 && $minutos <= 59 &&
            $segundos >= 0 && $segundos <= 59) {

            // Convertimos todos los elementos a dos cifras.
            $var = sprintf('%02d:%02d:%02d', $hora, $minutos, $segundos);

            return true;
        }
    }

    $var = $defecto;

    return false;
}


/**
 * Comprueba que una variable contiene un email válido.
 *
 * @param string $var Email que se comprobará.
 * @param string $defecto Email por defecto.
 * @return bool
 */
function validaEmail(string &$var, string $defecto): bool
{
    // Eliminamos espacios al principio y al final.
    $var = trim($var);

    // Comprobamos el formato del correo electrónico.
    if (preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $var)) {
        return true;
    }

    $var = $defecto;

    return false;
}


/**
 * Comprueba que una cadena no supere una longitud máxima.
 *
 * @param string $var Cadena que se comprobará.
 * @param int $longitud Longitud máxima permitida.
 * @param string $defecto Cadena por defecto.
 * @return bool
 */
function validaCadena(string &$var, int $longitud, string $defecto): bool
{
    if (mb_strlen($var, 'UTF-8') <= $longitud) {
        return true;
    }

    $var = $defecto;

    return false;
}


/**
 * Comprueba que una cadena cumple una expresión regular.
 *
 * @param string $var Cadena que se comprobará.
 * @param string $expresion Expresión regular.
 * @param string $defecto Valor por defecto.
 * @return bool
 */
function validaExpresion(string &$var, string $expresion, string $defecto): bool
{
    if (preg_match($expresion, $var) === 1) {
        return true;
    }

    $var = $defecto;

    return false;
}


/**
 * Comprueba que un valor pertenece a un array.
 *
 * @param mixed $var Valor que se comprobará.
 * @param array $posibles Array de valores o claves permitidos.
 * @param int $tipo 1 para valores y 2 para claves.
 * @return bool
 */
function validaRango(mixed $var, array $posibles, int $tipo = 1): bool
{
    if ($tipo === 1) {

        // Comprobamos si el valor está dentro del array.
        return in_array($var, $posibles, true);

    } elseif ($tipo === 2) {

        // Comprobamos si el valor es una de las claves.
        return array_key_exists($var, $posibles);
    }

    return false;
}
?>