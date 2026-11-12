<?php
// Cargamos la librería de validación.
require_once dirname(__DIR__, 3) . '/scripts/validacion.php';

/**
 * Clase abstracta que contiene las propiedades comunes de los muebles.
 */
abstract class MuebleBase
{
    // Número máximo de muebles que se pueden crear.
    public const MAXIMO_MUEBLES = 10;

    // Contador de muebles creados.
    private static int $mueblesCreados = 0;

    // Propiedades del mueble.
    private string $_nombre = '';
    private string $_fabricante = 'FaMu:';
    private string $_pais = 'ESPAÑA';
    private int $_anio = 2020;
    private string $_fechaIniVenta = '';
    private string $_fechaFinVenta = '';
    private float $_precio = 30.0;
    private Caracteristicas $_caracteristicas;

    /**
     * Constructor de MuebleBase.
     */
    public function __construct(
        string $nombre,
        string $fabricante = 'FaMu:',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        ?string $fechaIniVenta = null,
        string $fechaFinVenta = '31/12/2040',
        float $precio = 30.0
    ) {
        // Comprobamos si todavía se pueden crear muebles.
        $numero = 0;

        if (!self::puedeCrear($numero)) {
            throw new Exception('Se ha alcanzado el máximo de muebles.');
        }

        // El nombre es obligatorio.
        if (!$this->setNombre($nombre)) {
            throw new Exception('El nombre del mueble no es válido.');
        }

        $this->_caracteristicas = new Caracteristicas();

        // Establecemos el fabricante.
        if (!$this->setFabricante($fabricante)) {
            $this->setFabricante('FaMu:');
        }

        // Establecemos el país.
        if (!$this->setPais($pais)) {
            $this->setPais('ESPAÑA');
        }

        // Establecemos el año.
        if (!$this->setAnio($anio)) {
            $this->setAnio(2020);
        }

        // Si no se indica fecha inicial, usamos el 1 de enero del año.
        if ($fechaIniVenta === null) {
            $fechaIniVenta = '01/01/' . $this->_anio;
        }

        // Establecemos la fecha inicial.
        if (!$this->setFechaIniVenta($fechaIniVenta)) {
            $this->_fechaIniVenta = '01/01/' . $this->_anio;
        }

        // Establecemos la fecha final.
        if (!$this->setFechaFinVenta($fechaFinVenta)) {

            // Si falla, usamos el valor por defecto.
            $this->_fechaFinVenta = '31/12/2040';

            // Comprobamos que la fecha final no sea anterior a la inicial.
            $fechaInicio = DateTime::createFromFormat(
                '!d/m/Y',
                $this->_fechaIniVenta
            );

            $fechaFinal = DateTime::createFromFormat(
                '!d/m/Y',
                $this->_fechaFinVenta
            );

            // Si el valor por defecto no sirve, usamos la fecha inicial.
            if ($fechaInicio !== false && $fechaFinal !== false) {
                if ($fechaFinal < $fechaInicio) {
                    $this->_fechaFinVenta = $this->_fechaIniVenta;
                }
            }
        }

        // Establecemos el precio.
        if (!$this->setPrecio($precio)) {
            $this->setPrecio(30.0);
        }

        // Contamos el mueble cuando se ha creado correctamente.
        self::$mueblesCreados++;
    }

    // Devuelve el nombre.
    public function getNombre(): string
    {
        return $this->_nombre;
    }

    // Comprueba y establece el nombre.
    public function setNombre(string $nombre): bool
    {
        $nombre = trim($nombre);

        // El nombre no puede estar vacío.
        if ($nombre === '') {
            return false;
        }

        // Convertimos el nombre a mayúsculas.
        $nombre = mb_strtoupper($nombre, 'UTF-8');

        // Comprobamos que no supere los 40 caracteres.
        if (!validaCadena($nombre, 40, '')) {
            return false;
        }

        $this->_nombre = $nombre;

        return true;
    }

    // Devuelve el fabricante.
    public function getFabricante(): string
    {
        return $this->_fabricante;
    }

    // Comprueba y establece el fabricante.
    public function setFabricante(string $fabricante): bool
    {
        $fabricante = trim($fabricante);

        // Añadimos FaMu: si no aparece al principio.
        if (substr($fabricante, 0, 5) !== 'FaMu:') {
            $fabricante = 'FaMu:' . $fabricante;
        }

        // Recortamos el fabricante a 30 caracteres.
        $fabricante = mb_substr($fabricante, 0, 30, 'UTF-8');

        $this->_fabricante = $fabricante;

        return true;
    }

    // Devuelve el país.
    public function getPais(): string
    {
        return $this->_pais;
    }

    // Comprueba y establece el país.
    public function setPais(string $pais): bool
    {
        $pais = trim($pais);

        if (!validaCadena($pais, 20, 'ESPAÑA')) {
            return false;
        }

        $this->_pais = $pais;

        return true;
    }

    // Devuelve el año.
    public function getAnio(): int
    {
        return $this->_anio;
    }

    // Comprueba y establece el año.
    public function setAnio(int $anio): bool
    {
        // Comprobamos que el año esté entre 2020 y el actual.
        if (!validaEntero($anio, 2020, (int) date('Y'), 2020)) {
            return false;
        }

        // Si ya existe una fecha inicial, comprobamos que siga siendo válida.
        if ($this->_fechaIniVenta !== '') {

            $fechaInicio = DateTime::createFromFormat(
                '!d/m/Y',
                $this->_fechaIniVenta
            );

            $fechaMinima = DateTime::createFromFormat(
                '!d/m/Y',
                '01/01/' . $anio
            );

            if ($fechaInicio < $fechaMinima) {
                return false;
            }
        }

        $this->_anio = $anio;

        return true;
    }

    // Devuelve la fecha inicial de venta.
    public function getFechaIniVenta(): string
    {
        return $this->_fechaIniVenta;
    }

    // Comprueba y establece la fecha inicial.
    public function setFechaIniVenta(string $fecha): bool
    {
        // Comprobamos que sea una fecha válida.
        if (!validaFecha($fecha, '01/01/' . $this->_anio)) {
            return false;
        }

        $fechaNueva = DateTime::createFromFormat('!d/m/Y', $fecha);

        $fechaMinima = DateTime::createFromFormat(
            '!d/m/Y',
            '01/01/' . $this->_anio
        );

        // No puede ser anterior al 1 de enero del año de fabricación.
        if ($fechaNueva < $fechaMinima) {
            return false;
        }

        // Si ya existe una fecha final, no podemos superarla.
        if ($this->_fechaFinVenta !== '') {

            $fechaFinal = DateTime::createFromFormat(
                '!d/m/Y',
                $this->_fechaFinVenta
            );

            if ($fechaNueva > $fechaFinal) {
                return false;
            }
        }

        $this->_fechaIniVenta = $fecha;

        return true;
    }

    // Devuelve la fecha final de venta.
    public function getFechaFinVenta(): string
    {
        return $this->_fechaFinVenta;
    }

    // Comprueba y establece la fecha final.
    public function setFechaFinVenta(string $fecha): bool
    {
        if (!validaFecha($fecha, '31/12/2040')) {
            return false;
        }

        $fechaNueva = DateTime::createFromFormat('!d/m/Y', $fecha);

        // No puede ser anterior a la fecha inicial.
        if ($this->_fechaIniVenta !== '') {

            $fechaInicio = DateTime::createFromFormat(
                '!d/m/Y',
                $this->_fechaIniVenta
            );

            if ($fechaNueva < $fechaInicio) {
                return false;
            }
        }

        $this->_fechaFinVenta = $fecha;

        return true;
    }

    // Devuelve el precio.
    public function getPrecio(): float
    {
        return $this->_precio;
    }

    // Comprueba y establece el precio.
    public function setPrecio(float $precio): bool
    {
        if (!validaReal($precio, 30.0, PHP_FLOAT_MAX, 30.0)) {
            return false;
        }

        $this->_precio = $precio;

        return true;
    }

    // Las clases hijas deben indicar sus propiedades adicionales.
    abstract public function damePropiedadesAdicionales(): array;

    // Comprueba si todavía se pueden crear muebles.
    public static function puedeCrear(int &$numero): bool
    {
        $numero = self::MAXIMO_MUEBLES - self::$mueblesCreados;

        if ($numero > 0) {
            return true;
        }

        $numero = 0;

        return false;
    }

    // Convierte los datos del mueble en una cadena.
    public function __toString(): string
    {
        return 'MUEBLE de clase ' . get_class($this)
            . ' con nombre ' . $this->_nombre
            . ', fabricante ' . $this->_fabricante
            . ', fabricado en ' . $this->_pais
            . ' a partir del año ' . $this->_anio
            . ', vendido desde ' . $this->_fechaIniVenta
            . ' hasta ' . $this->_fechaFinVenta
            . ', precio ' . $this->_precio
            . ', características: ' . $this->_caracteristicas;
    }

    // Impedimos acceder directamente a las propiedades.
    public function __get(string $nombre): mixed
    {
        throw new Exception('No se permite acceder directamente a las propiedades.');
    }

    // Impedimos modificar directamente las propiedades.
    public function __set(string $nombre, mixed $valor): void
    {
        throw new Exception('No se permite modificar directamente las propiedades.');
    }

    // Impedimos comprobar propiedades directamente.
    public function __isset(string $nombre): bool
    {
        return false;
    }

    // Impedimos eliminar propiedades directamente.
    public function __unset(string $nombre): void
    {
        throw new Exception('No se permite eliminar directamente las propiedades.');
    }

    // Añade características al mueble.
public function anadirCaracteristicas(mixed ...$datos): void
{
    // Obtenemos el número de argumentos recibidos.
    $total = count($datos);

    // Si hay un número impar, descartamos el último argumento.
    if ($total % 2 != 0) {
        $total--;
    }

    // Recorremos los argumentos de dos en dos.
    for ($i = 0; $i < $total; $i += 2) {

        $nombre = $datos[$i];
        $valor = $datos[$i + 1];

        // El nombre de la característica debe ser una cadena.
        if (!is_string($nombre)) {
            throw new InvalidArgumentException('El nombre debe ser una cadena.');
        }

        // Guardamos la característica.
        $this->_caracteristicas->$nombre = $valor;
    }
}
// Devuelve el objeto de características.
public function getCaracteristicas(): Caracteristicas
{
    return $this->_caracteristicas;
}
}