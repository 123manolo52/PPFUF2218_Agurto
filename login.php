<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    $xmlPath = 'files/usuarios.xml';
    if (file_exists($xmlPath)) {
        $xml = simplexml_load_file($xmlPath);
        foreach ($xml->usuario as $u) {
            if ((string)$u->nombre === $usuario && (string)$u->password === $clave) {
                $_SESSION['usuario'] = $usuario;
                $_SESSION['rol'] = (string)$u->rol;
                header('Location: panel.php');
                exit;
            }
        }
    }
    $error = "❌ Usuario o contraseña incorrectos.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acceso al sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h2 class="mb-4">🔐 Iniciar sesión</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Usuario:</label>
      <input type="text" name="usuario" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Contraseña:</label>
      <input type="password" name="clave" class="form-control" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Entrar</button>
    </div>
  </form>
</div>
</body>
</html>
