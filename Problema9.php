<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

/* -------- Función P9 -------- */
function potenciasP9(int $n, int $lim = 15): array {
    $out = [];
    for ($i = 1; $i <= $lim; $i++) {
        $out[$i] = $n ** $i;
    }
    return $out;
}

/* -------- Control -------- */
$numero = $_POST['numero'] ?? '';
$errores = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($numero === '' || Utils::esPositivo($numero) === false) {
        $errores[] = 'Ingrese un entero positivo.';
    } else {
        $n = (int)$numero;
        if (!Utils::rangoInt($n, 1, 9)) {
            $errores[] = 'El número debe estar entre 1 y 9.';
        } else {
            $data = potenciasP9($n, 15);
        }
    }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Problema 9 — Potencias</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="problem">

  <h2>Problema 9 — 15 primeras potencias</h2>

  <form method="post" class="formulario">
    <label>Número (1–9)
      <input type="number" name="numero" min="1" max="9" value="<?= Utils::limpiar((string)$numero) ?>" required>
    </label>
    <input type="submit" value="Generar">
  </form>

  <?php if ($errores): ?>
    <div class="error">
      <?php foreach ($errores as $e): ?>
        <div><?= Utils::limpiar($e) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ($data): ?>
    <div class="resultado">
      <h3>Resultados</h3>
      <div class="table-wrap">
        <table class="tabla">
          <thead>
            <tr><th>Exponente</th><th>Resultado</th></tr>
          </thead>
          <tbody>
            <?php foreach ($data as $exp => $val): ?>
              <tr><td><?= $exp ?></td><td><?= Utils::numero($val, 0) ?></td></tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>

  <?= Utils::enlaceVolver('index.php') ?>
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>

