<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

/* -------- Funciones P8 (Hemisferio Sur) -------- */
function p8_img(string $est): string {
  switch ($est) {
    case 'primavera': return 'https://images.unsplash.com/photo-1452570053594-1b985d6ea890?q=80&w=1200&auto=format&fit=crop';
    case 'verano'   : return 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1200&auto=format&fit=crop';
    case 'otono'    : return 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?q=80&w=1200&auto=format&fit=crop';
    default         : return 'https://images.unsplash.com/photo-1482192505345-5655af888cc4?q=80&w=1200&auto=format&fit=crop';
  }
}
function p8_determinar_estacion(string $iso): array {
  $t = strtotime($iso);
  $m = (int)date('n',$t); $d = (int)date('j',$t); $mmdd = $m*100 + $d;
  if     ($mmdd >= 921 && $mmdd <= 1220) return ['Invierno', p8_img('invierno')];
  elseif ($mmdd >= 1221 || $mmdd <= 320) return ['Verano',    p8_img('verano')];
  elseif ($mmdd >= 321  && $mmdd <= 620) return ['Primavera',     p8_img('primavera')];
  else                                    return ['Otoño',  p8_img('otono')];
}

/* -------- Control -------- */
$fecha = $_POST['fecha'] ?? '';
$errores = [];
$salida = null;

if ($_SERVER['REQUEST_METHOD']==='POST') {
  if ($fecha === '' || !Utils::fechaISO($fecha)) {
    $errores[] = 'Seleccione una fecha válida.';
  } else {
    [$nom, $img] = p8_determinar_estacion($fecha);
    $salida = ['fecha' => Utils::fechaDM($fecha), 'nombre' => $nom, 'img' => $img];
  }
}
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Problema 8 — Estación del Año</title>
  <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="problem">

  <h2>Problema 8 — Estación del Año</h2>

  <form method="post" class="formulario" novalidate>
    <label>Fecha
      <input type="date" name="fecha" value="<?= Utils::limpiar((string)$fecha) ?>">
    </label>
    <input type="submit" value="Mostrar">
  </form>

  <?php if ($errores): ?>
    <div class="error"><?php foreach($errores as $e) echo '<div>'.Utils::limpiar($e).'</div>'; ?></div>
  <?php endif; ?>

  <?php if ($salida): ?>
    <div class="resultado">
      <h3>Resultado</h3>
      <p><strong>Fecha:</strong> <?= $salida['fecha'] ?></p>
      <p><strong>Estación:</strong> <?= Utils::limpiar($salida['nombre']) ?></p>
      <div class="grafico">
        <img src="<?= Utils::limpiar($salida['img']) ?>" alt="Imagen de <?= Utils::limpiar($salida['nombre']) ?>" style="max-width:100%;border-radius:12px">
      </div>
    </div>
  <?php endif; ?>

  <?= Utils::enlaceVolver('index.php') ?>
  <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
