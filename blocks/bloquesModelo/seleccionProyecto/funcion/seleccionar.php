<?php

namespace bloquesModelo\seleccionProyecto\funcion;

use bloquesModelo\seleccionProyecto\funcion\redireccionar;

include_once ('redireccionar.php');
class Seleccionar {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miFuncion;
	var $miSql;
	var $conexion;
	function __construct($lenguaje, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		$this->lenguaje = $lenguaje;
		$this->miSql = $sql;
		// $this->miFuncion = $funcion;
	}
	function procesarFormulario() {
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "raizDocumento" ) . "/blocks/bloquesModelo/";
		$rutaBloque .= $esteBloque ['nombre'];
		
		$host = $this->miConfigurador->getVariableConfiguracion ( "host" ) . $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/bloquesModelo/registrarAnteproyecto/" . $esteBloque ['nombre'];
		
		// Aqu� va la l�gica de procesamiento
		
		switch ($_REQUEST ['pagina']) {
			case 'anteproyectoxProyecto' :
				redireccion::redireccionar ( 'anteproyecto' );
				exit ();
				break;
			case 'proyectosxPrograma' :
				redireccion::redireccionar ( 'proyecto' );
				exit ();
				break;
		}
	}
	function resetForm() {
		foreach ( $_REQUEST as $clave => $valor ) {
			
			if ($clave != 'pagina' && $clave != 'development' && $clave != 'jquery' && $clave != 'tiempo') {
				unset ( $_REQUEST [$clave] );
			}
		}
	}
}

$miProcesador = new Seleccionar ( $this->lenguaje, $this->sql );

$resultado = $miProcesador->procesarFormulario ();

