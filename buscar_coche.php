<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header('Location: index.php');
    exit;
}

$xmlPath = 'files/coches.xml';
$coches = [];

if (file_exists($xmlPath)) {
    $xml = simplexml_load_file($xmlPath);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tipo = $_POST['tipo'] ?? '';
        $valor = strtolower(trim($_POST['valor'] ?? ''));

        foreach ($xml->coche as $coche) {
            $campo = ($tipo === 'matricula') ? (string)$coche['matricula'] : strtolower((string)$coche->$tipo);
            if (strpos($campo, $valor) !== false) {
                $coches[] = $coche;
            }
        }
    }
} else {
    die("<div class='alert alert-danger'>❌ No se encontró el archivo XML.</div>");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Buscar coche</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
  <h2 class="mb-4">🔍 Buscar coche</h2>

  <form method="POST" class="row g-3 mb-4">
    <div class="col-md-4">
      <label class="form-label">Buscar por:</label>
      <select name="tipo" class="form-select" required>
        <option value="">Seleccione campo...</option>
        <option value="matricula">Matrícula</option>
        <option value="marca">Marca</option>
        <option value="modelo">Modelo</option>
        <option value="color">Color</option>
        <option value="precio">Precio</option>
        <option value="puertas">Puertas</option>
        <option value="venta">Tipo de venta</option>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Valor a buscar:</label>
      <input type="text" name="valor" class="form-control" required>
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100">Buscar</button>
    </div>
  </form>

  <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <h5>Resultados encontrados: <?= count($coches) ?></h5>
    <?php if ($coches): ?>
    <table class="table table-bordered table-striped mt-3">
      <thead class="table-dark">
        <tr>
          <th>Matrícula</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Puertas</th>
          <th>Color</th>
          <th>Precio</th>
          <th>Venta</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($coches as $coche): ?>
        <tr>
          <td><?= $coche['matricula'] ?></td>
          <td><?= $coche->marca ?></td>
          <td><?= $coche->modelo ?></td>
          <td><?= $coche->puertas ?></td>
          <td><?= $coche->color ?></td>
          <td><?= $coche->precio ?>€</td>
          <td><?= $coche->precio['venta'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="alert alert-warning mt-3">⚠️ No se encontraron coches que coincidan.</div>
    <?php endif; ?>
  <?php endif; ?>

  <a href="panel.php" class="btn btn-secondary mt-4">← Volver al panel</a>
</div>
</body>
</html>

