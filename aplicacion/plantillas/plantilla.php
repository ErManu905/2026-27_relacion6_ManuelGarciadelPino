<?php
// Muestra una página de error.
function paginaError(string $mensaje): void
{
    http_response_code(404);

    inicioCabecera("TIENDA");
    finCabecera();

    inicioCuerpo("ERROR", "Inicio > Error");

    echo "<br />\n";
    echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
    echo "<br />\n";
    echo "<br />\n";

    echo "<a href='" . RUTABASE . "/index.php'>Ir a la pagina principal</a>\n";

    finCuerpo();
}

// Inicia la cabecera HTML.
function inicioCabecera(string $titulo): void
{
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title><?php echo $titulo ?></title>
        <meta name="description" content="">
        <meta name="author" content="Administrador">

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css"
              href="<?php echo RUTABASE; ?>/css/estilos.css">

<?php
}

// Finaliza la cabecera HTML.
function finCabecera(): void
{
?>
    </head>
<?php
}

// Inicia el cuerpo de la página y muestra el menú y la ubicación.
function inicioCuerpo(string $cabecera, string $ubicacion = "Inicio"): void
{
?>
    <body>
        <div id="documento">

            <header>
                <h1 id="titulo"><?php echo htmlspecialchars($cabecera, ENT_QUOTES, 'UTF-8'); ?></h1>
            </header>

            <div id="barraLogin">
            </div>

            <div id="barraMenu">
                <ul>
                    <li><a href="<?php echo RUTABASE; ?>/index.php">Inicio</a></li>
                </ul>
            </div>

            <div id="barraUbicacion">
                <?php echo htmlspecialchars($ubicacion, ENT_QUOTES, 'UTF-8'); ?>
            </div>

            <div>
<?php
}

// Finaliza el cuerpo de la página.
function finCuerpo(): void
{
?>
                <br />
                <br />
            </div>

            <footer>
                <hr width="90%" />
                <div>
                    &copy; Copyright Tienda - Relación 6
                </div>
            </footer>

        </div>
    </body>
</html>
<?php
}