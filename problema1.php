<?php
// --- Función de navegación ---
function enlaceVolver($url) {
    return "<p><a href='$url' class='btn-volver'>⬅ Volver al menú</a></p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Problema 1 - Cálculos Estadísticos</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <h2>Problema 1: Cálculo de Media, Desviación Estándar, Mínimo y Máximo</h2>

    <form method="post" class="formulario">
        <p>Introduce 5 números positivos:</p>

        <div class="campos-entrada">

            <?php for ($i = 1; $i <= 5; $i++): ?>
                <input type="number" name="num[]" min="1" required placeholder="Num <?php echo $i; ?>"><br>
            <?php endfor; ?>

         </div>
        <input type="submit" value="Calcular">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $numeros = $_POST['num'];

        // Filtrar solo positivos
        $numeros = array_filter($numeros, fn($n) => $n > 0);

        if (count($numeros) == 5) {
            $media = array_sum($numeros) / count($numeros);

            // Desviación estándar
            $sumatoria = 0;
            foreach ($numeros as $n) {
                $sumatoria += pow($n - $media, 2);
            }
            $desviacion = sqrt($sumatoria / count($numeros));

            $minimo = min($numeros);
            $maximo = max($numeros);

            echo "<div class='resultado'>";
            echo "<h3>Resultados:</h3>";
            echo "<p><strong>Media:</strong> " . round($media, 2) . "</p>";
            echo "<p><strong>Desviación estándar:</strong> " . round($desviacion, 2) . "</p>";
            echo "<p><strong>Mínimo:</strong> $minimo</p>";
            echo "<p><strong>Máximo:</strong> $maximo</p>";
            echo "</div>";
        } else {
            echo "<p class='error'>Por favor, ingresa 5 números positivos válidos.</p>";
        }
    }

    // Enlace de navegación al menú
    echo enlaceVolver("index.php");

    include("footer.php");
    ?>

</body>
</html>