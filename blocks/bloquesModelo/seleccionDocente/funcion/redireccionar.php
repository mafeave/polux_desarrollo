<?php

namespace bloquesModelo\seleccionDocente\funcion;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("index.php");
	exit ();
}
class redireccion {
	public static function redireccionar($opcion, $valor = "") {
		$miConfigurador = \Configurador::singleton ();
		$miPaginaActual = $miConfigurador->getVariableConfiguracion ( "pagina" );
		
		$variable = "pagina=" . $opcion;
		$variable .= '&variable=' . $_REQUEST ["docente"];
		$variable .= '&usuario=' . $_REQUEST ["usuario"];
		
		foreach ( $_REQUEST as $clave => $valor ) {
			unset ( $_REQUEST [$clave] );
		}
		
		$url = $miConfigurador->configuracion ["host"] . $miConfigurador->configuracion ["site"] . "/index.php?";
		
		$enlace = $miConfigurador->configuracion ['enlace'];
		var_dump ( $variable );
		var_dump ( $_REQUEST );
		$variable = $miConfigurador->fabricaConexiones->crypto->codificar ( $variable );
		$_REQUEST [$enlace] = $enlace . '=' . $variable;
		$redireccion = $url . $_REQUEST [$enlace];
		
		// echo $redireccion;
		echo "<script>location.replace('" . $redireccion . "')</script>";
		
		return true;
	}
}
?>