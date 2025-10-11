<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

/* -------- Funciones P10 -------- */
function matrizVaciaP10(): array {
    $ventas = [];
    for ($p = 1; $p <= 5; $p++) {
        $ventas[$p] = [];
        for ($v = 1; $v <= 4; $v++) {
            $ventas[$p][$v] = 0.0;
        }
    }
    return $ventas;
}

function acumularP10(array &$ventas, int $producto, int $vendedor, float $monto): void {
    $ventas[$producto][$vendedor] += $monto;
}

function totalesProductoP10(array $ventas): array {
    $out = [];
    for ($p = 1; $p <= 5; $p++) {
        $s = 0.0;
        foreach ($ventas[$p] as $m) $s += $m;
        $out[$p] = $s;
    }
    return $out;
}

function totalesVendedorP10(array $ventas): array {
    $out = [];
    for ($v = 1; $v <= 4; $v++) {
        $s = 0.0;
        for ($p = 1; $p <= 5; $p++) $s += $ventas[$p][$v];
        $out[$v] = $s;
    }
    return $out;
}

function granTotalP10(array $ventas): float {
    $t = 0.0;
    foreach ($ventas as $fila)
        foreach ($fila as $m) $t += $m;
    return $t;
}

/* -------- Control -------- */
$notas = $_POST['notas'] ?? '';
$v = [
    1 => [$_POST['v1Nombre'] ?? '', $_POST['v1Apellido'] ?? ''],
    2 => [$_POST['v2Nombre'] ?? '', $_POST['v2Apellido'] ?? ''],
    3 => [$_POST['v3Nombre'] ?? '', $_POST['v3Apellido'] ?? ''],
    4 => [$_POST['v4Nombre'] ?? '', $_POST['v4Apellido'] ?? ''],
];

$errores = [];
$rep = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (trim($notas) === '') $errores[] = 'Ingrese al menos una línea con el formato vendedor,producto,monto.';

    foreach ($v as $i => $par) {
        [$nom, $ape] = $par;
        if (($nom !== '' && !preg_match('/^[\p{L} ]*$/u', $nom)) ||
            ($ape !== '' && !preg_match('/^[\p{L} ]*$/u', $ape))) {
            $errores[] = "Nombre/apellido vendedor $i inválido.";
        }
    }

    if (empty($errores)) {
        $ventas = matrizVaciaP10();
        $lineas = preg_split('/\r\n|\r|\n/', trim($notas));
        foreach ($lineas as $idx => $linea) {
            if (trim($linea) === '') continue;
            $parts = preg_split('/[;,]/', $linea);
            if (count($parts) !== 3) {
                $errores[] = "Línea " . ($idx + 1) . ": use vendedor,producto,monto";
                continue;
            }

            [$vendStr, $prodStr, $montoStr] = array_map('trim', $parts);
            $montoStr = str_replace(',', '.', $montoStr);

            if (Utils::esPositivo($vendStr) === false || Utils::esPositivo($prodStr) === false) {
                $errores[] = 'Vendedor/producto deben ser enteros positivos.';
                continue;
            }

            $vend = (int)$vendStr;
            $prod = (int)$prodStr;

            if (!Utils::rangoInt($vend, 1, 4)) {
                $errores[] = 'Vendedor fuera de rango (1..4).';
                continue;
            }
            if (!Utils::rangoInt($prod, 1, 5)) {
                $errores[] = 'Producto fuera de rango (1..5).';
                continue;
            }
            if (!Utils::esFloat($montoStr)) {
                $errores[] = 'Monto inválido.';
                continue;
            }

            $monto = (float)$montoStr;
            if ($monto < 0) {
                $errores[] = 'Monto no puede ser negativo.';
                continue;
            }

            acumularP10($ventas, $prod, $vend, $monto);
        }

        if (empty($errores)) {
            $nombres = [];
            for ($i = 1; $i <= 4; $i++) {
                $etq = trim(($v[$i][0] ?? '') . ' ' . ($v[$i][1] ?? ''));
                $nombres[$i] = $etq !== '' ? $etq : "Vendedor $i";
            }

            $rep = [
                'matriz' => $ventas,
                'fila'   => totalesProductoP10($ventas),
                'col'    => totalesVendedorP10($ventas),
                'total'  => granTotalP10($ventas),
                'nombres'=> $nombres
            ];
        }
    }
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Problema 10 — Matriz de Ventas</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="problem">

  <h2>Problema 10 — Matriz de Ventas (Productos × Vendedores)</h2>

  <form method="post" class="formulario" novalidate>
    <label>Notas del mes (una por línea — <code>vendedor,producto,monto</code>)
      <textarea name="notas" rows="8" placeholder="1,1,1200&#10;2;5;230.75"><?= Utils::limpiar((string)$notas) ?></textarea>
    </label>

    <fieldset class="fieldset">
      <legend>Vendedores (opcional)</legend>
      <div class="lista-multiplos" style="display:grid;grid-template-columns:repeat(2,1fr);gap:10px">
        <label>V1 Nombre <input name="v1Nombre" value="<?= Utils::limpiar($v[1][0]) ?>"></label>
        <label>V1 Apellido <input name="v1Apellido" value="<?= Utils::limpiar($v[1][1]) ?>"></label>
        <label>V2 Nombre <input name="v2Nombre" value="<?= Utils::limpiar($v[2][0]) ?>"></label>
        <label>V2 Apellido <input name="v2Apellido" value="<?= Utils::limpiar($v[2][1]) ?>"></label>
        <label>V3 Nombre <input name="v3Nombre" value="<?= Utils::limpiar($v[3][0]) ?>"></label>
        <label>V3 Apellido <input name="v3Apellido" value="<?= Utils::limpiar($v[3][1]) ?>"></label>
        <label>V4 Nombre <input name="v4Nombre" value="<?= Utils::limpiar($v[4][0]) ?>"></label>
        <label>V4 Apellido <input name="v4Apellido" value="<?= Utils::limpiar($v[4][1]) ?>"></label>
      </div>
    </fieldset>

    <input type="submit" value="Procesar">
  </form>

  <?php if ($errores): ?>
    <div class="error"><?php foreach($errores as $e) echo '<div>'.Utils::limpiar($e).'</div>'; ?></div>
  <?php endif; ?>

  <?php if ($rep): ?>
    <div class="resultado">
      <h3>Resumen del último mes</h3>
      <div class="table-wrap">
        <table class="tabla">
          <thead>
            <tr>
              <th>Producto \ Vendedor</th>
              <?php for($vnd=1;$vnd<=4;$vnd++): ?>
                <th><?= Utils::limpiar($rep['nombres'][$vnd]) ?></th>
              <?php endfor; ?>
              <th>Total producto</th>
            </tr>
          </thead>
          <tbody>
            <?php for($p=1;$p<=5;$p++): ?>
              <tr>
                <th style="text-align:center; background:#f2edf9; color:#333">Producto <?= $p ?></th>
                <?php for($vnd=1;$vnd<=4;$vnd++): ?>
                  <td><?= Utils::dinero($rep['matriz'][$p][$vnd]) ?></td>
                <?php endfor; ?>
                <td><strong><?= Utils::dinero($rep['fila'][$p]) ?></strong></td>
              </tr>
            <?php endfor; ?>
          </tbody>
          <tfoot>
            <tr>
              <th>Total vendedor</th>
              <?php for($vnd=1;$vnd<=4;$vnd++): ?>
                <th><?= Utils::dinero($rep['col'][$vnd]) ?></th>
              <?php endfor; ?>
              <th><?= Utils::dinero($rep['total']) ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  <?php endif; ?>

  <?= Utils::enlaceVolver('index.php') ?>
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
