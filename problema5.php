<?php
require_once "utils.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Problema 5 - Clasificación por Edad</title>
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <h2>Problema 5: Clasificar edades y generar estadísticas</h2>

    <form method="post" class="formulario">
        <p>Introduce la edad de 5 personas:</p>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <input type="number" name="edad<?= $i ?>" min="0" max="120" required placeholder="Edad <?= $i ?>"><br>
        <?php endfor; ?>
        <br>
        <input type="submit" name="procesar" value="Procesar edades">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["procesar"])) {
        $edades = [];
        $categorias = [
            "Niño" => 0,
            "Adolescente" => 0,
            "Adulto" => 0,
            "Adulto Mayor" => 0
        ];

        // Validación y clasificación
        for ($i = 1; $i <= 5; $i++) {
            $entrada = Utils::limpiar($_POST["edad$i"]);
            if (Utils::esNumero($entrada) && Utils::esPositivo($entrada)) {
                $edad = (int)$entrada;
                $edades[] = $edad;

                // Clasificación con operador ternario anidado
                $categoria = ($edad <= 12) ? "Niño" :
                            (($edad <= 17) ? "Adolescente" :
                            (($edad <= 64) ? "Adulto" : "Adulto Mayor"));
                
                $categorias[$categoria]++;
            } else {
                echo "<p class='error'>Edad $i inválida. Debe ser un número positivo.</p>";
                exit;
            }
        }

        // Mostrar resultados
        echo "<div class='resultado'>";
        echo "<h3>Clasificación de las edades ingresadas:</h3>";
        echo "<ul>";
        foreach ($edades as $edad) {
            $categoria = ($edad <= 12) ? "Niño" :
                        (($edad <= 17) ? "Adolescente" :
                        (($edad <= 64) ? "Adulto" : "Adulto Mayor"));
            echo "<li>Edad $edad → <strong>$categoria</strong></li>";
        }
        echo "</ul>";

        // Estadísticas: edades repetidas
        $repetidas = array_filter(array_count_values($edades), fn($v) => $v > 1);
        if (!empty($repetidas)) {
            echo "<h4>📊 Edades repetidas:</h4>";
            foreach ($repetidas as $edad => $cantidad) {
                echo "<p>Edad $edad se repite $cantidad veces.</p>";
            }
        } else {
            echo "<p>No hay edades repetidas.</p>";
        }
        echo "</div>";

        // Datos para gráfica
        $labels = json_encode(array_keys($categorias));
        $data = json_encode(array_values($categorias));
    ?>

    <div class="grafico">
        <h3>Distribución por Categoría</h3>
        <canvas id="graficaEdades" width="400" height="200"></canvas>
        <script>
            const ctx = document.getElementById('graficaEdades').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?= $labels ?>,
                    datasets: [{
                        label: 'Cantidad de Personas',
                        data: <?= $data ?>,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(75, 192, 192, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        </script>
    </div>

    <?php
    }
    echo Utils::enlaceVolver("index.php");
    include("footer.php");
    ?>

</body>
</html>