<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

/* -------- Funciones P6 -------- */
function p6_calcularDistribucion(float $presupuesto): array {
  return [
    'Ginecología'   => $presupuesto * 0.40,
    'Traumatología' => $presupuesto * 0.35,
    'Pediatría'     => $presupuesto * 0.25,
  ];
}

/* -------- Control -------- */
$presupuesto = $_POST['budget'] ?? '';
$errores = [];
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($presupuesto === '' || !Utils::esFloat((string)$presupuesto) || (float)str_replace(',','.',(string)$presupuesto) <= 0) {
    $errores[] = 'Ingrese un presupuesto válido (positivo).';
  } else {
    $pres = (float) str_replace(',', '.', (string)$presupuesto);
    $resultados = p6_calcularDistribucion($pres);
  }
}

/* Datos para la gráfica (si hay resultados) */
$p6_labels = [];
$p6_montos = [];
$p6_porcent = [];
if ($resultados) {
  $p6_labels  = array_keys($resultados);
  $p6_montos  = array_values($resultados);
  $total      = array_sum($p6_montos);
  foreach ($p6_montos as $m) {
    $p6_porcent[] = $total > 0 ? round(($m / $total) * 100, 2) : 0;
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Problema 6 — Presupuesto Hospitalario</title>
  <link rel="stylesheet" href="css/estilos.css">
  <!-- Chart.js (CDN) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="problem">
  <h2>Problema 6 — Presupuesto Hospitalario</h2>

  <form method="post" class="formulario">
    <label>Presupuesto (USD)
      <input type="number" step="0.01" name="budget" value="<?= Utils::limpiar((string)$presupuesto) ?>" required>
    </label>
    <input type="submit" value="Calcular">
  </form>

  <?php if ($errores): ?>
    <div class="error"><?php foreach ($errores as $e) echo '<div>'.Utils::limpiar($e).'</div>'; ?></div>
  <?php endif; ?>

  <?php if ($resultados): ?>
    <div class="resultado">
      <h3>Distribución</h3>
      <div class="table-wrap">
        <table class="tabla">
          <thead><tr><th>Área</th><th>Porcentaje</th><th>Monto</th></tr></thead>
          <tbody>
            <tr><td>Ginecología</td><td>40%</td><td><?= Utils::dinero($resultados['Ginecología']) ?></td></tr>
            <tr><td>Traumatología</td><td>35%</td><td><?= Utils::dinero($resultados['Traumatología']) ?></td></tr>
            <tr><td>Pediatría</td><td>25%</td><td><?= Utils::dinero($resultados['Pediatría']) ?></td></tr>
          </tbody>
          <tfoot><tr><th>Total</th><th>100%</th><th><?= Utils::dinero(array_sum($resultados)) ?></th></tr></tfoot>
        </table>
      </div>

      <!-- Gráfica -->
      <div class="grafico">
        <canvas id="p6Chart"></canvas>
      </div>
    </div>

    <script>
      // Datos desde PHP
      const p6Labels   = <?= json_encode($p6_labels, JSON_UNESCAPED_UNICODE) ?>;
      const p6Montos   = <?= json_encode($p6_montos) ?>;   // valores en dinero
      const p6Porc     = <?= json_encode($p6_porcent) ?>;  // porcentajes

      const ctx = document.getElementById('p6Chart');
      if (ctx) {
        new Chart(ctx, {
          type: 'pie',   // Cambia a 'bar' si prefieres barras
          data: {
            labels: p6Labels,
            datasets: [{
              data: p6Montos,         // usa montos reales; si prefieres %, cambia a p6Porc
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            plugins: {
              title: {
                display: true,
                text: 'Distribución del presupuesto'
              },
              tooltip: {
                callbacks: {
                  // tooltip muestra: Área — $monto (xx.xx%)
                  label: (ctx) => {
                    const monto = ctx.raw ?? 0;
                    const total = p6Montos.reduce((a,b)=>a+b,0);
                    const pct = total > 0 ? (monto/total)*100 : 0;
                    return `${ctx.label}: $${monto.toLocaleString(undefined,{minimumFractionDigits:2, maximumFractionDigits:2})} (${pct.toFixed(2)}%)`;
                  }
                }
              },
              legend: { position: 'bottom' }
            }
          }
        });
      }
    </script>
  <?php endif; ?>

  <?= Utils::enlaceVolver('index.php') ?>
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
