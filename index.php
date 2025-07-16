<?php
session_start();
$preusuario = $_GET['rol'] ?? '';
$logueado = isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login al sistema de coches</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">

    <!-- ✅ Mensaje si ya hay sesión -->
    <?php if ($logueado): ?>
      <div class="alert alert-info text-center mb-4">
        Ya estás logueado como <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong> (<?= $_SESSION['rol'] ?>).  
        <a href="panel.php" class="btn btn-sm btn-outline-success ms-2">Ir al panel</a>
        <a href="sesiones/logout.php" class="btn btn-sm btn-outline-danger ms-2">Cerrar sesión</a>
      </div>
    <?php endif; ?>

    <h1 class="text-center mb-4">Acceso al sistema 🚗</h1>

    <!-- ✅ Botones para autocompletar login -->
    <div class="text-center mb-5">
      <p>Selecciona tu rol para comenzar:</p>
      <a href="index.php?rol=admin" class="btn btn-danger me-2">👑 Administrador</a>
      <a href="index.php?rol=empleado1" class="btn btn-warning me-2">🔧 Empleado</a>
      <a href="index.php?rol=visitante" class="btn btn-secondary">👤 Visitante</a>
    </div>

    <!-- ✅ Formulario de login -->
    <div class="card mx-auto" style="max-width: 500px;">
      <div class="card-header bg-primary text-white">Login</div>
      <div class="card-body">
        <form method="POST" action="sesiones/validar_login.php">
          <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($preusuario) ?>" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Entrar</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>





