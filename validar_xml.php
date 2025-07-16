<?php
function validarXML($rutaXML = 'files/coches.xml', $rutaXSD = 'files/esquema.xsd') {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument();
    $doc->load($rutaXML);

    if (!$doc->schemaValidate($rutaXSD)) {
        echo "<div class='alert alert-danger'>❌ El archivo XML no cumple con el esquema definido.</div>";
        foreach (libxml_get_errors() as $error) {
            echo "<pre>" . $error->message . "</pre>";
        }
        libxml_clear_errors();
        exit;
    }
}
?>
