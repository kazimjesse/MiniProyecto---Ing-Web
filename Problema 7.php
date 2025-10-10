<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

/* -------- Funciones P7 -------- */
function p7_promedio(array $xs): float {
  return array_sum($xs) / max(1, count($xs));
}
function p7_desviacionEstandar(array $xs): float {
  $mu = p7_promedio($xs);
  $s = 0.0; foreach ($xs as $x) { $s += ($x - $mu) ** 2; }
  return sqrt($s / max(1, count($xs))); // poblacional
}
function p7_min(array $xs): float { return (float)min($xs); }
function p7_max(array $xs): float { return (float)max($xs); }

/* -------- Control -------- */
$cantidad = $_POST['cantidad'] ?? '';
$notas = $_POST['notas'] ?? [];
$errores = [];
$res = [];
$notasValidas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fase']) && $_POST['fase']==='generar') {
  if ($cantidad === '' || Utils::esPositivo($cantidad) === false) {
    $errores[] = 'La cantidad debe ser un entero positivo.';
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['fase'])) {
  if ($cantidad === '' || Utils::esPositivo($cantidad) === false) {
    $errores[] = 'La cantidad debe ser un entero positivo.';
  } else {
    for ($i=0; $i<(int)$cantidad; $i++) {
      $n = $notas[$i] ?? '';
      if ($n === '' || !Utils::esFloat((string)$n)) {
        $errores[] = 'La nota #'.($i+1).' no es válida.';
      } else {
        $v = (float) str_replace(',', '.', (string)$n);
        if (!Utils::rangoFloat($v, 0.0, 100.0)) $errores[] = 'La nota #'.($i+1).' debe estar entre 0 y 100.';
        else $notasValidas[] = $v;
      }
    }
    if (empty($errores) && count($notasValidas) !== (int)$cantidad) $errores[] = 'Debe completar todas las notas.';
    if (empty($errores)) {
      $res = [
        'Promedio'            => p7_promedio($notasValidas),
        'Desviación estándar' => p7_desviacionEstandar($notasValidas),
        'Mínima'              => p7_min($notasValidas),
        'Máxima'              => p7_max($notasValidas),
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

  <?php if ($errores && empty($res)): ?>
    <div class="error"><?php foreach($errores as $e) echo '<div>'.Utils::limpiar($e).'</div>'; ?></div>
  <?php endif; ?>

  <?php if ($cantidad && (!$res || $errores)): ?>
    <form method="post" class="formulario" style="margin-top:10px">
      <input type="hidden" name="cantidad" value="<?= (int)$cantidad ?>">
      <?php for ($i=0; $i<(int)$cantidad; $i++): ?>
        <label>Nota <?= $i+1 ?>
          <input type="number" step="0.01" min="0" max="100" name="notas[]" required>
        </label>
      <?php endfor; ?>
      <input type="submit" value="Calcular">
    </form>
  <?php endif; ?>

  <?php if ($res): ?>
    <div class="resultado">
      <h3>Resultados</h3>
      <?php foreach ($res as $k=>$v): ?>
        <p><strong><?= Utils::limpiar($k) ?>:</strong> <?= Utils::numero($v) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?= Utils::enlaceVolver('index.php') ?>
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
