<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    header('Location: index.php');
    exit;
}

$matricula = isset($_POST['matricula']) ? trim($_POST['matricula']) : '';
$xmlPath = 'files/coches.xml';

if (!$matricula || !file_exists($xmlPath)) {
    header("Location: panel.php?msg=no_encontrado");
    exit;
}

$xml = simplexml_load_file($xmlPath);
$found = false;

foreach ($xml->coche as $i => $coche) {
    if (trim((string)$coche['matricula']) === $matricula) {
        unset($xml->coche[$i]);
        $found = true;
        break;
    }
}

if ($found && $xml->asXML($xmlPath)) {
    header("Location: panel.php?msg=eliminado");
    exit;
} else {
    header("Location: panel.php?msg=error_guardado");
    exit;
}
?>









