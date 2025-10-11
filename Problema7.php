<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

/* -------- Funciones P7 -------- */
function calcularPromedioP7(array $valores): float {
    return array_sum($valores) / max(1, count($valores));
}

function calcularDesviacionEstandarP7(array $valores): float {
    $media = calcularPromedioP7($valores);
    $suma = 0.0;
    foreach ($valores as $valor) {
        $suma += ($valor - $media) ** 2;
    }
    return sqrt($suma / max(1, count($valores))); // Poblacional
}

function obtenerMinimoP7(array $valores): float {
    return (float) min($valores);
}

function obtenerMaximoP7(array $valores): float {
    return (float) max($valores);
}

/* -------- Control -------- */
$cantidad = $_POST['cantidad'] ?? '';
$notas = $_POST['notas'] ?? [];
$errores = [];
$resultados = [];
$notasValidas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fase']) && $_POST['fase'] === 'generar') {
    if ($cantidad === '' || Utils::esPositivo($cantidad) === false) {
        $errores[] = 'La cantidad debe ser un entero positivo.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['fase'])) {
    if ($cantidad === '' || Utils::esPositivo($cantidad) === false) {
        $errores[] = 'La cantidad debe ser un entero positivo.';
    } else {
        for ($i = 0; $i < (int)$cantidad; $i++) {
            $nota = $notas[$i] ?? '';
            if ($nota === '' || !Utils::esFloat((string)$nota)) {
                $errores[] = 'La nota #' . ($i + 1) . ' no es válida.';
            } else {
                $valor = (float) str_replace(',', '.', (string)$nota);
                if (!Utils::rangoFloat($valor, 0.0, 100.0)) {
                    $errores[] = 'La nota #' . ($i + 1) . ' debe estar entre 0 y 100.';
                } else {
                    $notasValidas[] = $valor;
                }
            }
        }

        if (empty($errores) && count($notasValidas) !== (int)$cantidad) {
            $errores[] = 'Debe completar todas las notas.';
        }

        if (empty($errores)) {
            $resultados = [
                'Promedio'            => calcularPromedioP7($notasValidas),
                'Desviación estándar' => calcularDesviacionEstandarP7($notasValidas),
                'Mínima'              => obtenerMinimoP7($notasValidas),
                'Máxima'              => obtenerMaximoP7($notasValidas),
            ];
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Problema 7 — Estadística</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="problem">

  <h2>Problema 7 — Calculadora de Datos Estadísticos</h2>

  <form method="post" class="formulario" novalidate>
    <label>Cantidad de notas
      <input type="number" name="cantidad" min="1" value="<?= Utils::limpiar((string)$cantidad) ?>">
    </label>
    <input type="submit" name="fase" value="generar">
  </form>

  <?php if ($errores && empty($resultados)): ?>
    <div class="error">
      <?php foreach ($errores as $error): ?>
        <div><?= Utils::limpiar($error) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ($cantidad && (!$resultados || $errores)): ?>
    <form method="post" class="formulario" style="margin-top:10px">
      <input type="hidden" name="cantidad" value="<?= (int)$cantidad ?>">
      <?php for ($i = 0; $i < (int)$cantidad; $i++): ?>
        <label>Nota <?= $i + 1 ?>
          <input type="number" step="0.01" min="0" max="100" name="notas[]" required>
        </label>
      <?php endfor; ?>
      <input type="submit" value="Calcular">
    </form>
  <?php endif; ?>

  <?php if ($resultados): ?>
    <div class="resultado">
      <h3>Resultados</h3>
      <?php foreach ($resultados as $clave => $valor): ?>
        <p><strong><?= Utils::limpiar($clave) ?>:</strong> <?= Utils::numero($valor) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?= Utils::enlaceVolver('index.php') ?>
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>

