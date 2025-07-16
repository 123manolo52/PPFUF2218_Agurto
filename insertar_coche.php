<?php
session_start();

// Protección por rol
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['rol'], ['administrador', 'empleado'])) {
    header('Location: index.php');
    exit;
}

$xmlPath = 'files/coches.xml';
$xsdPath = 'files/coches.xsd';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = strtoupper(trim($_POST['matricula'] ?? ''));
    $marca     = trim($_POST['marca'] ?? '');
    $modelo    = trim($_POST['modelo'] ?? '');
    $puertas   = trim($_POST['puertas'] ?? '');
    $color     = trim($_POST['color'] ?? '');
    $precio    = trim($_POST['precio'] ?? '');
    $venta     = trim($_POST['venta'] ?? '');

    // Cargar XML
    if (!file_exists($xmlPath)) {
        echo "<div class='container py-5'><div class='alert alert-danger'>❌ No se encontró el archivo XML.</div></div>";
        exit;
    }

    $xml = simplexml_load_file($xmlPath);

    // Verificar matrícula duplicada
    foreach ($xml->coche as $coche) {
        if ((string)$coche['matricula'] === $matricula) {
            echo "<div class='container py-5'><div class='alert alert-warning'>❌ Matrícula duplicada.</div>";
            echo "<a href='panel.php' class='btn btn-secondary mt-3'>← Volver al panel</a></div>";
            exit;
        }
    }

    // Añadir coche
    $nuevo = $xml->addChild('coche');
    $nuevo->addAttribute('matricula', $matricula);
    $nuevo->addChild('marca', $marca);
    $nuevo->addChild('modelo', $modelo);
    $nuevo->addChild('puertas', $puertas);
    $nuevo->addChild('color', $color);
    $precioElem = $nuevo->addChild('precio', $precio);
    $precioElem->addAttribute('venta', $venta);

    // Validar con XSD
    $tempPath = 'files/temp_coches.xml';
    $xml->asXML($tempPath);

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->load($tempPath);

    if ($dom->schemaValidate($xsdPath)) {
        // Guardar XML final
        $xml->asXML($xmlPath);
        unlink($tempPath);
        header("Location: panel.php?msg=insertado");
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

