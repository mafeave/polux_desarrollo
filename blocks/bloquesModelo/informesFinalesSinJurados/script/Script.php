<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */
$indice = 0;
$funcion [$indice ++] = "jquery.validationEngine.js";
$funcion [$indice ++] = "jquery.validationEngine-es.js";
$funcion [$indice ++] = "jquery.dataTables.js";
$funcion [$indice ++] = "jquery.dataTables.min.js";
$funcion [$indice ++] = "dataTables.jqueryui.min.js";
$funcion [$indice ++] = "select2.js";
$funcion [$indice ++] = "mobiscroll-1.5.js";
$funcion [$indice ++] = "mobiscroll-1.5.min.js";

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );

if ($esteBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $esteBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"];
}

$_REQUEST ['tiempo'] = time ();

foreach ( $funcion as $clave => $nombre ) {
	if (! isset ( $embebido [$clave] )) {
		echo "\n<script type='text/javascript' src='" . $rutaBloque . "/script/" . $nombre . "'>\n</script>\n";
	} else {
		echo "\n<script type='text/javascript'>";
		include ($nombre);
		echo "\n</script>\n";
	}
}
include ("ajax.php");
?>
