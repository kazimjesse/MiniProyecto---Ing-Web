<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';
require_once __DIR__ . '/matematicas.php'; // 🔹 CAMBIO: se importa la nueva clase

/* -------- Control -------- */
$valores = $_POST['valores'] ?? [];
$errores = [];
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (empty($valores)) {
    $errores[] = 'Ingrese al menos un número.';
  } else {
    $validos = [];
    foreach ($valores as $i => $v) {
      if (!Utils::esFloat((string)$v)) {
        $errores[] = "El valor #".($i+1)." no es válido.";
      } else {
        $validos[] = (float) str_replace(',', '.', (string)$v);
      }
    }

    if (empty($errores) && $validos) {
      // 🔹 CAMBIO: usamos la clase Matematicas en lugar de funciones locales
      $resultados = [
        'Promedio' => Matematicas::promedio($validos),
        'Desviación estándar' => Matematicas::desviacionEstandar($validos),
        'Mínimo' => Matematicas::minimo($validos),
        'Máximo' => Matematicas::maximo($validos),
      ];
    }
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Problema 1 — Estadística Básica</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="problem">

  <h2>Problema 1 — Estadística Básica</h2>

  <form method="post" class="formulario">
    <label>Ingrese valores separados (hasta 5)
      <input type="number" name="valores[]" step="0.01" required>
      <input type="number" name="valores[]" step="0.01">
      <input type="number" name="valores[]" step="0.01">
      <input type="number" name="valores[]" step="0.01">
      <input type="number" name="valores[]" step="0.01">
    </label>
    <input type="submit" value="Calcular">
  </form>

  <?php if ($errores): ?>
    <div class="error"><?php foreach($errores as $e) echo '<div>'.Utils::limpiar($e).'</div>'; ?></div>
  <?php endif; ?>

  <?php if ($resultados): ?>
    <div class="resultado">
      <h3>Resultados</h3>
      <?php foreach($resultados as $k => $v): ?>
        <p><strong><?= Utils::limpiar($k) ?>:</strong> <?= Utils::numero($v, 2) ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?= Utils::enlaceVolver('index.php') ?>
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>