<?php
require_once "utils.php"; // Importamos la clase de utilidades
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Problema 4 - Suma de Pares e Impares</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <h2>Problema 4: Suma de los números pares e impares del 1 al 200</h2>

    <?php
    /**
     * Calcula la suma de números pares o impares en un rango.
     * 
     * @param int $inicio Inicio del rango (inclusive)
     * @param int $fin Fin del rango (inclusive)
     * @param bool $esPar true para pares, false para impares
     * @return int Suma resultante
     */
    function sumarNumeros($inicio, $fin, $esPar = true) {
        $suma = 0;
        for ($i = $inicio; $i <= $fin; $i++) {
            if ($esPar && $i % 2 == 0) {
                $suma += $i;
            } elseif (!$esPar && $i % 2 != 0) {
                $suma += $i;
            }
        }
        return $suma;
    }

    // Validamos el rango con Utils (aunque es fijo, mantenemos coherencia)
    $inicio = 1;
    $fin = 200;

    if (Utils::esNumero($inicio) && Utils::esNumero($fin) && $inicio < $fin) {
        $sumaPares = sumarNumeros($inicio, $fin, true);
        $sumaImpares = sumarNumeros($inicio, $fin, false);

        echo "<div class='resultado'>";
        echo "<h3>Resultados:</h3>";
        echo "<p><strong>Suma de números pares (1-200):</strong> $sumaPares</p>";
        echo "<p><strong>Suma de números impares (1-200):</strong> $sumaImpares</p>";
        echo "</div>";
    } else {
        echo "<p class='error'>Rango inválido. Verifica los valores.</p>";
    }

    // Enlace de navegación (función estática de la clase Utils)
    echo Utils::enlaceVolver("index.php");

    include("footer.php");
    ?>

</body>
</html>