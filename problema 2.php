<?php
require_once "utils.php"; // Importamos la clase de utilidades (reutilizable en todos los problemas)
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Problema 2 - Suma del 1 al 1000</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <h2>Problema 2: Calcular la suma de los números del 1 al 1000</h2>

    <!-- Formulario simple: solo un botón para ejecutar la operación -->
    <form method="post" class="formulario">
        <p>Presiona el botón para calcular la suma:</p>
        <input type="submit" name="calcular" value="Calcular Suma">
    </form>

    <?php
    // Verificamos si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['calcular'])) {

        // Valores de inicio y fin definidos
        $inicio = 1;
        $fin = 1000;

        /**
         * Se valida que ambos sean positivos y que el rango sea correcto.
         * Aunque los valores son fijos, esto demuestra el uso de las funciones de validación.
         */
        if (Utils::esPositivo($inicio) && Utils::esPositivo($fin) && $fin > $inicio) {

            // Algoritmo de suma de 1 a 1000 usando un bucle for
            $suma = 0;
            for ($i = $inicio; $i <= $fin; $i++) {
                $suma += $i;
            }

            // Mostrar resultado formateado
            echo "<div class='resultado'>";
            echo "<h3>Resultado:</h3>";
            echo "<p>La suma de los números del <strong>$inicio</strong> al <strong>$fin</strong> es: <strong>$suma</strong></p>";
            echo "</div>";

        } else {
            // Si las validaciones fallan, mostramos un mensaje de error
            echo "<p class='error'>Error: valores fuera de rango o no válidos.</p>";
        }
    }

    // Enlace para volver al menú principal (desde función estática)
    echo Utils::enlaceVolver("index.php");

    include("footer.php");
    ?>

</body>
</html>
