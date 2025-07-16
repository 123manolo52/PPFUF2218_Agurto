<?php
session_start();
if (!isset($_SESSION['usuario']) || !isset($_SESSION['rol'])) {
    header('Location: index.php');
    exit;
}

$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rol'];
$xmlPath = 'files/coches.xml';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de gestión de coches</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
    <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
      <path d="M8.982 1.566a1.13..."/>
    </symbol>
  </svg>
</head>
<body class="bg-light">
  <div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Bienvenido, <?= htmlspecialchars($usuario) ?> <span class="badge bg-info text-dark">Rol: <?= $rol ?></span></h2>
      <a href="sesiones/logout.php" class="btn btn-outline-danger">Cerrar sesión</a>
    </div>

    <!-- Mensajes visuales -->
    <?php if (isset($_GET['msg'])): ?>
      <?php if ($_GET['msg'] === 'insertado'): ?>
        <div class="alert alert-success">✅ Coche insertado correctamente.</div>
      <?php elseif ($_GET['msg'] === 'modificado'): ?>
        <div class="alert alert-info">✏️ Coche modificado correctamente.</div>
      <?php elseif ($_GET['msg'] === 'eliminado'): ?>
        <div class="alert alert-warning">🗑️ Coche eliminado correctamente.</div>
      <?php elseif ($_GET['msg'] === 'no_encontrado'): ?>
        <div class="alert alert-danger">⚠️ Matrícula no encontrada. No se pudo eliminar.</div>
      <?php elseif ($_GET['msg'] === 'error_guardado'): ?>
        <div class="alert alert-danger">⚠️ Error al guardar el XML después de eliminar.</div>
      <?php endif; ?>
    <?php endif; ?>

    <!-- Tabla de coches -->
    <?php if (file_exists($xmlPath)) {
      $xml = simplexml_load_file($xmlPath);
    ?>
    <table id="tabla-coches" class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Matrícula</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Puertas</th>
          <th>Color</th>
          <th>Precio</th>
          <th>Venta</th>
          <?php if ($rol !== 'visitante'): ?>
            <th>Acciones</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($xml->coche as $coche): ?>
        <tr>
          <td><?= $coche['matricula'] ?></td>
          <td><?= $coche->marca ?></td>
          <td><?= $coche->modelo ?></td>
          <td><?= $coche->puertas ?></td>
          <td><?= $coche->color ?></td>
          <td><?= $coche->precio ?>€</td>
          <td><?= $coche->precio['venta'] ?></td>
          <?php if ($rol !== 'visitante'): ?>
            <td>
              <?php if ($rol === 'administrador' || $rol === 'empleado'): ?>
                <a href="modificar_coche.php?matricula=<?= $coche['matricula'] ?>" class="btn btn-sm btn-warning">Modificar</a>
              <?php endif; ?>
              <?php if ($rol === 'administrador'): ?>
                <form method="POST" action="eliminar_coche.php" style="display:inline;">
                  <input type="hidden" name="matricula" value="<?= trim((string)$coche['matricula']) ?>">
                  <button type="submit" class="btn btn-sm btn-danger"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar el coche con matrícula <?= trim((string)$coche['matricula']) ?>?')">
                    Eliminar
                  </button>
                </form>
              <?php endif; ?>
            </td>
          <?php endif; ?>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php } else { ?>
      <div class="alert alert-danger d-flex align-items-center mt-5" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Error">
          <use xlink:href="#exclamation-triangle-fill"/>
        </svg>
        <div><strong>Error:</strong> No se encontró el archivo XML.</div>
      </div>
    <?php } ?>

    <!-- Formulario de inserción -->
    <?php if ($rol === 'administrador' || $rol === 'empleado'): ?>
    <div class="card mt-5">
      <div class="card-header bg-primary text-white">Insertar nuevo coche</div>
      <div class="card-body">
        <form method="POST" action="insertar_coche.php" class="row g-3">
          <div class="col-md-6"><label>Matrícula</label><input type="text" name="matricula" class="form-control" required></div>
          <div class="col-md-6"><label>Marca</label><input type="text" name="marca" class="form-control" required></div>
          <div class="col-md-6"><label>Modelo</label><input type="text" name="modelo" class="form-control" required></div>
          <div class="col-md-6"><label>Puertas</label><input type="number" name="puertas" min="2" max="5" class="form-control" required></div>
          <div class="col-md-6"><label>Color</label><input type="text" name="color" class="form-control" required></div>
          <div class="col-md-6"><label>Precio (€)</label><input type="number" name="precio" class="form-control" required></div>
          <div class="col-md-6">
            <label>Tipo de venta</label>
            <select name="venta" class="form-select" required>
              <option value="">Seleccione...</option>
              <option value="nuevo">Nuevo</option>
              <option value="ocasión">Ocasión</option>
              <option value="segunda mano">Segunda mano</option>
            </select>
          </div>
          <div class="col-12"><button type="submit" class="btn btn-success">Insertar coche</button></div>
        </form>
      </div>
    </div>
    <?php endif; ?>

    <!-- Buscador -->
    <div class="mt-5">
      <a href="buscar_coche.php" class="btn btn-outline-secondary">🔍 Buscar coche</a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#tabla-coches').DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        }
      });
    });
  </script>
</body>
</html>








