<?php
require_once "utils.php"; // Clase de utilidades compartida
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Problema 3 - Múltiplos de 4</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <h2>Problema 3: Imprimir los N primeros múltiplos de 4</h2>

    <form method="post" class="formulario">
        <p>Introduce un número entero positivo (N):</p>
        <input type="number" name="numero" min="1" required placeholder="Ej: 10">
        <br>
        <input type="submit" name="calcular" value="Mostrar múltiplos">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {

        // Limpiamos y validamos el valor recibido
        $entrada = Utils::limpiar($_POST['numero']);

        // Validación: debe ser un número entero positivo
        if (Utils::esNumero($entrada) && Utils::esPositivo($entrada)) {
            $n = (int)$entrada;

            // Control de desbordamiento (por ejemplo, si el usuario pone un número muy grande)
            if ($n > 0 && $n <= 100000) { // límite razonable para evitar sobrecarga
                echo "<div class='resultado'>";
                echo "<h3>Los $n primeros múltiplos de 4:</h3>";
                echo "<ul class='lista-multiplos'>";

                for ($i = 1; $i <= $n; $i++) {
                    $multiplo = 4 * $i;
                    echo "<li>4 × $i = $multiplo</li>";
                }

                echo "</ul>";
                echo "</div>";
            } else {
                echo "<p class='error'>El número es demasiado grande. Intenta con un valor menor o igual a 100,000.</p>";
            }
        } else {
            echo "<p class='error'>Por favor ingresa un número entero positivo válido.</p>";
        }
    }

    // Enlace para volver al menú principal (desde la clase Utils)
    echo Utils::enlaceVolver("index.php");

    include("footer.php");
    ?>

</body>
</html>
