<?php
session_start();

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

$usuarios = require 'usuarios.php';

if (isset($usuarios[$usuario]) && $usuarios[$usuario]['pass'] === $password) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $usuarios[$usuario]['rol'];
    header('Location: ../panel.php');
    exit;
} else {
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'>";
    echo "<title>Acceso denegado</title></head><body class='bg-light'>";
    echo "<div class='container py-5'><div class='alert alert-danger'>";
    echo "❌ Usuario o contraseña incorrectos.</div>";
    echo "<a href='../index.php' class='btn btn-primary mt-3'>← Volver al login</a>";
    echo "</div></body></html>";
}
?>





