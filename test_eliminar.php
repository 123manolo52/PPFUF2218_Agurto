<?php
// test_eliminar.php — diagnóstico con sesión activa

session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'administrador') {
    echo "<div style='padding:1rem; background-color:#f8d7da; color:#842029; border:1px solid #f5c2c7;'>
            🚫 <strong>Acceso denegado:</strong> Solo el administrador puede usar esta herramienta.
          </div>";
    exit;
}

$matricula = isset($_GET['matricula']) ? trim($_GET['matricula']) : '';
$xmlPath = 'files/coches.xml';

echo "<div style='padding:1rem;'>";

if (!$matricula) {
    echo "<div style='background-color:#fff3cd; color:#664d03; border:1px solid #ffeeba; padding:1rem;'>
            ⚠️ <strong>Matrícula no proporcionada.</strong>
          </div>";
    exit;
}

if (!file_exists($xmlPath)) {
    echo "<div style='background-color:#f8d7da; color:#842029; border:1px solid #f5c2c7; padding:1rem;'>
            ❌ <strong>Error:</strong> No se encontró el archivo XML.
          </div>";
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

if ($found) {
    if ($xml->asXML($xmlPath)) {
        echo "<div style='background-color:#d1e7dd; color:#0f5132; border:1px solid #badbcc; padding:1rem;'>
                ✅ <strong>Matrícula '$matricula'</strong> eliminada correctamente del XML.
              </div>";
    } else {
        echo "<div style='background-color:#f8d7da; color:#842029; border:1px solid #f5c2c7; padding:1rem;'>
                ❌ <strong>Eliminación fallida:</strong> No se pudo guardar el XML.
              </div>";
    }
} else {
    echo "<div style='background-color:#fff3cd; color:#664d03; border:1px solid #ffeeba; padding:1rem;'>
            🚫 <strong>No se encontró la matrícula '$matricula'</strong> en el archivo.
          </div>";
}

echo "</div>";
?>

