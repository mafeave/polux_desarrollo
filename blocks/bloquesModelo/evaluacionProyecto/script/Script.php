<?php
/**
 * Importante: Este script es invocado desde la clase ArmadorPagina. La información del bloque se encuentra
 * en el arreglo $esteBloque. Esto también aplica para todos los archivos que se incluyan.
 */
$indice = 0;
$funcion [$indice ++] = "jquery-1.11.0.min.js";
$funcion [$indice ++] = "jqueryui.js";
$funcion [$indice ++] = "jquery.validationEngine.js";
$funcion [$indice ++] = "jquery.validationEngine-es.js";
$funcion [$indice ++] = "jquery-te.js";
$funcion [$indice ++] = "select2.js";
$funcion[$indice ++]="modernizr.custom.js";
$funcion[$indice ++]="jquery.dlmenu.js";
//$funcion[$indice ++]="bootstrap.min.js";

$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" );

if ($esteBloque ["grupo"] == "") {
	$rutaBloque .= "/blocks/" . $esteBloque ["nombre"];
} else {
	$rutaBloque .= "/blocks/" . $esteBloque ["grupo"] . "/" . $esteBloque ["nombre"];
}

$_REQUEST['tiempo']=time();

foreach ( $funcion as $clave => $nombre ) {
	if (! isset ( $embebido [$clave] )) {
		echo "\n<script type='text/javascript' src='" . $rutaBloque . "/script/" . $nombre . "'>\n</script>\n";
	} else {
		echo "\n<script type='text/javascript'>";
		include ($nombre);
		echo "\n</script>\n";
	}
}

?>
