<?php
session_start();

// Solo administrador o empleado puede modificar
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['administrador', 'empleado'])) {
    header('Location: index.php');
    exit;
}

$xmlPath = 'files/coches.xml';
$xsdPath = 'files/coches.xsd';
$matricula = $_GET['matricula'] ?? '';

// Cargar coche existente
if (!file_exists($xmlPath)) {
    die("❌ No se encontró el archivo XML.");
}
$xml = simplexml_load_file($xmlPath);
$cocheActual = null;
foreach ($xml->coche as $coche) {
    if ((string)$coche['matricula'] === $matricula) {
        $cocheActual = $coche;
        break;
    }
}
if (!$cocheActual) {
    echo "<div class='container py-5'><div class='alert alert-danger'>❌ Matrícula no encontrada.</div>";
    echo "<a href='panel.php' class='btn btn-secondary mt-3'>← Volver al panel</a></div>";
    exit;
}

// Si se envía el formulario, modificar los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $marca   = trim($_POST['marca'] ?? '');
    $modelo  = trim($_POST['modelo'] ?? '');
    $puertas = trim($_POST['puertas'] ?? '');
    $color   = trim($_POST['color'] ?? '');
    $precio  = trim($_POST['precio'] ?? '');
    $venta   = trim($_POST['venta'] ?? '');

    // Actualizar datos
    $cocheActual->marca = $marca;
    $cocheActual->modelo = $modelo;
    $cocheActual->puertas = $puertas;
    $cocheActual->color = $color;
    $cocheActual->precio = $precio;
    $cocheActual->precio['venta'] = $venta;

    // Validar con XSD
    $tempPath = 'files/temp_modificado.xml';
    $xml->asXML($tempPath);

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->load($tempPath);

    if ($dom->schemaValidate($xsdPath)) {
        $xml->asXML($xmlPath);
        unlink($tempPath);
        header("Location: panel.php?msg=modificado");
        exit;
    } else {
        echo "<div class='container py-5'><div class='alert alert-danger'><strong>Error de validación XML:</strong><ul>";
        foreach (libxml_get_errors() as $error) {
            echo "<li>" . htmlspecialchars($error->message) . "</li>";
        }
        echo "</ul></div><a href='panel.php' class='btn btn-secondary'>← Volver al panel</a></div>";
        libxml_clear_errors();
        unlink($tempPath);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Modificar coche</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">Modificar coche: <?= htmlspecialchars($matricula) ?></h2>
    <form method="POST" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Marca</label>
        <input type="text" name="marca" class="form-control" value="<?= $cocheActual->marca ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Modelo</label>
        <input type="text" name="modelo" class="form-control" value="<?= $cocheActual->modelo ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Puertas</label>
        <input type="number" name="puertas" min="2" max="5" class="form-control" value="<?= $cocheActual->puertas ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Color</label>
        <input type="text" name="color" class="form-control" value="<?= $cocheActual->color ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Precio (€)</label>
        <input type="number" name="precio" class="form-control" value="<?= $cocheActual->precio ?>" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Tipo de venta</label>
        <select name="venta" class="form-select" required>
          <option value="nuevo" <?= ($cocheActual->precio['venta'] == 'nuevo') ? 'selected' : '' ?>>Nuevo</option>
          <option value="ocasión" <?= ($cocheActual->precio['venta'] == 'ocasión') ? 'selected' : '' ?>>Ocasión</option>
          <option value="segunda mano" <?= ($cocheActual->precio['venta'] == 'segunda mano') ? 'selected' : '' ?>>Segunda mano</option>
        </select>
      </div>
      <div class="col-12">
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="panel.php" class="btn btn-secondary ms-2">← Volver</a>
      </div>
    </form>
  </div>
</body>
</html>



