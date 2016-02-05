<?php

namespace bloquesModelo\iniciarProyecto;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}

include_once ("core/manager/Configurador.class.php");
include_once ("core/connection/Sql.class.php");

/**
 * IMPORTANTE: Se recomienda que no se borren registros.
 * Utilizar mecanismos para - independiente del motor de bases de datos,
 * poder realizar rollbacks gestionados por el aplicativo.
 */
class Sql extends \Sql {
	var $miConfigurador;
	function getCadenaSql($tipo, $variable = '') {
		
		/**
		 * 1.
		 * Revisar las variables para evitar SQL Injection
		 */
		$prefijo = $this->miConfigurador->getVariableConfiguracion ( "prefijo" );
		$idSesion = $this->miConfigurador->getVariableConfiguracion ( "id_sesion" );
		
		switch ($tipo) {
			
			/**
			 * Clausulas específicas
			 */
			case 'insertarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'actualizarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarRegistro' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'id_pagina as PAGINA, ';
				$cadenaSql .= 'nombre as NOMBRE, ';
				$cadenaSql .= 'descripcion as DESCRIPCION,';
				$cadenaSql .= 'modulo as MODULO,';
				$cadenaSql .= 'nivel as NIVEL,';
				$cadenaSql .= 'parametro as PARAMETRO ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'nombre=\'' . $_REQUEST ['nombrePagina'] . '\' ';
				break;
			
			case 'borrarRegistro' :
				$cadenaSql = 'INSERT INTO ';
				$cadenaSql .= $prefijo . 'pagina ';
				$cadenaSql .= '( ';
				$cadenaSql .= 'nombre,';
				$cadenaSql .= 'descripcion,';
				$cadenaSql .= 'modulo,';
				$cadenaSql .= 'nivel,';
				$cadenaSql .= 'parametro';
				$cadenaSql .= ') ';
				$cadenaSql .= 'VALUES ';
				$cadenaSql .= '( ';
				$cadenaSql .= '\'' . $_REQUEST ['nombrePagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['descripcionPagina'] . '\', ';
				$cadenaSql .= '\'' . $_REQUEST ['moduloPagina'] . '\', ';
				$cadenaSql .= $_REQUEST ['nivelPagina'] . ', ';
				$cadenaSql .= '\'' . $_REQUEST ['parametroPagina'] . '\'';
				$cadenaSql .= ') ';
				break;
			
			case 'buscarProyecto' :
				
				$cadenaSql = 'SELECT ';
				$cadenaSql .= 'proy_proy, ';
				$cadenaSql .= 'proy_titu, ';
				$cadenaSql .= 'proy_descri, ';
				$cadenaSql .= 'estproy_estd, ';
				$cadenaSql .= 'nombre || \' \' || apellido AS nombre, ';
				$cadenaSql .= 'dproy_vers, ';
				$cadenaSql .= 'proy_moda, ';
				$cadenaSql .= 'proy_pcur, ';
				$cadenaSql .= 'proy_dir_int, ';
				$cadenaSql .= 'acantp_acono ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.pry_tproy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.pry_testpry ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'proy_proy=estproy_proy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.pry_tdproy ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'dproy_proy=proy_proy ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.ge_testd ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'estproy_proy=estd_estd ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'polux_usuario ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'estd_us=id_usuario ';
				$cadenaSql .= 'JOIN ';
				$cadenaSql .= 'trabajosdegrado.pry_tacproy ';
				$cadenaSql .= 'ON ';
				$cadenaSql .= 'proy_proy=acproy_proy ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'proy_proy=\'' . $variable . '\' ';
				// echo $cadenaSql;
				break;
			
			case 'actualizarAnteproyecto' :
				$cadenaSql = "UPDATE ";
				$cadenaSql .= "trabajosdegrado.ant_tantp ";
				$cadenaSql .= "SET ";
				$cadenaSql .= "antp_eantp='PROYECTO' ";
				$cadenaSql .= "WHERE ";
				$cadenaSql .= "antp_antp='" . $variable . "'";
				break;
			
			case 'guardarProyecto' :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.pry_tproy ";
				$cadenaSql .= "( ";
				$cadenaSql .= "proy_antp, ";
				$cadenaSql .= "proy_moda, ";
				$cadenaSql .= "proy_pcur, ";
				$cadenaSql .= "proy_titu, ";
				$cadenaSql .= "proy_fcrea, ";
				$cadenaSql .= "proy_descri, ";
				$cadenaSql .= "proy_obser, ";
				$cadenaSql .= "proy_eproy, ";
				$cadenaSql .= "proy_duracion, ";
				$cadenaSql .= "proy_dir_int ";
				$cadenaSql .= ") ";
				$cadenaSql .= "VALUES ";
				$cadenaSql .= "( ";
				$cadenaSql .= "'" . $variable ['ante'] . "', ";
				$cadenaSql .= "'" . $variable ['modalidad'] . "', ";
				$cadenaSql .= "'" . $variable ['programa'] . "', ";
				$cadenaSql .= "'" . $variable ['titulo'] . "', ";
				$cadenaSql .= "'" . $variable ['proy_fcrea'] . "', ";
				$cadenaSql .= "'" . $variable ['descripcion'] . "', ";
				$cadenaSql .= "'" . $variable ['comentario'] . "', ";
				$cadenaSql .= "'" . $variable ['estado'] . "', ";
				$cadenaSql .= "'" . $variable ['duracion'] . "', ";
				$cadenaSql .= "'" . $variable ['director'] . "'";
				$cadenaSql .= ") ";
				$cadenaSql .= "RETURNING proy_proy;";
				break;
			
			case 'registrarHistorial' :
				
				$cadenaSql = " INSERT INTO trabajosdegrado.pry_thproy ( ";
				$cadenaSql .= "hproy_proy, hproy_eproy, hproy_fasig, ";
				$cadenaSql .= "hproy_obser, hproy_usua) ";
				$cadenaSql .= " VALUES (";
				// anteproyecto: buscar valor de la secuencia actual
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'last_value ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado."PRY_SPRY"), ';
				
				$cadenaSql .= "'" . $variable ['estado'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['observaciones'] . "', ";
				// Usuario que ha iniciado sesi�n
				$cadenaSql .= " '" . $variable ['usuario'] . "' ";
				$cadenaSql .= ") ";
				// var_dump ( $cadenaSql );
				break;
			
			case "registrarAnexo" :
				$hash = "funcion hash";
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.pry_tdapy ( ";
				$cadenaSql .= "dapy_proy, ";
				$cadenaSql .= "dapy_tdapy, ";
				$cadenaSql .= "dapy_falm, ";
				$cadenaSql .= "dapy_usua, ";
				$cadenaSql .= "dapy_url, ";
				$cadenaSql .= "dapy_hash, ";
				$cadenaSql .= "dapy_bytes, ";
				$cadenaSql .= "dapy_nombre, ";
				$cadenaSql .= "dapy_extension) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= '(SELECT ';
				$cadenaSql .= 'last_value ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado."PRY_SPRY"), ';
				$cadenaSql .= "'ACTA', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "', ";
				$cadenaSql .= "'" . $variable ['destino'] . "', ";
				$cadenaSql .= "'" . $hash . "', ";
				$cadenaSql .= "'" . $variable ['tamano'] . "', ";
				$cadenaSql .= "'" . $variable ['nombre'] . "', ";
				$cadenaSql .= "'" . $variable ['tipo'] . "' ";
				$cadenaSql .= ") ";
				$cadenaSql .= "RETURNING dapy_dapy;";
				// var_dump ( $cadenaSql );
				break;
			
			case "registrarDocumento" :
				$cadenaSql = "INSERT INTO ";
				$cadenaSql .= "trabajosdegrado.pry_tdproy ( ";
				$cadenaSql .= "dproy_vers, ";
				$cadenaSql .= "dproy_observ, ";
				$cadenaSql .= "dproy_falm, ";
				$cadenaSql .= "dproy_usua, ";
				$cadenaSql .= "dproy_proy, ";
				$cadenaSql .= "dproy_url, ";
				$cadenaSql .= "dproy_hash, ";
				$cadenaSql .= "dproy_bytes, ";
				$cadenaSql .= "dproy_nombre, ";
				$cadenaSql .= "dproy_extension) ";
				$cadenaSql .= "VALUES ( ";
				$cadenaSql .= "" . $variable ['version'] . ", ";
				$cadenaSql .= "'" . $variable ['observacion'] . "', ";
				$cadenaSql .= "'" . $variable ['fecha'] . "', ";
				$cadenaSql .= "'" . $variable ['usuario'] . "', ";
				$cadenaSql .= "" . $variable ['proyecto'] . ", ";
				$cadenaSql .= "'" . $variable ['url'] . "', ";
				$cadenaSql .= "'" . $variable ['hash'] . "', ";
				$cadenaSql .= "'" . $variable ['bytes'] . "', ";
				$cadenaSql .= "'" . $variable ['nombre'] . "', ";
				$cadenaSql .= "'" . $variable ['extension'] . "' ";
				$cadenaSql .= ") ";
				var_dump ( $cadenaSql );
				break;
			
			case 'registrarEstudiantes' :
				// obtener codigos por separado
				$cadenaSql = "";
				
				for($i = 0; $i < count ( $variable ); $i ++) {
					$cadena = " INSERT INTO trabajosdegrado.pry_testpry ( ";
					$cadena .= "estproy_estd, estproy_proy) ";
					$cadena .= " VALUES (" . $variable [$i] . ", ";
					// anteproyecto: buscar valor de la secuencia actual
					$cadena .= '(SELECT ';
					$cadena .= 'last_value ';
					$cadena .= 'FROM ';
					$cadena .= 'trabajosdegrado."PRY_SPRY") ); ';
					$cadenaSql = $cadenaSql . $cadena;
					var_dump ( $cadenaSql );
				}
				
				break;
			
			case 'registrarTematicas' :
				$cadenaSql = "";
				
				for($i = 0; $i < count ( $variable ); $i ++) {
					
					$cadena = " INSERT INTO trabajosdegrado.pry_tacproy ( ";
					$cadena .= "acproy_acono, acproy_proy) ";
					$cadena .= " VALUES (" . $variable [$i] . ", ";
					// anteproyecto: buscar valor de la secuencia actual
					$cadena .= '(SELECT ';
					$cadena .= 'last_value ';
					$cadena .= 'FROM ';
					$cadena .= 'trabajosdegrado."PRY_SPRY") ); ';
					$cadenaSql = $cadenaSql . $cadena;
				}
				// var_dump ( $cadenaSql );
				break;
			
			case 'obtenerID' :
				$cadenaSql = 'SELECT last_value FROM trabajosdegrado."PRY_SPRY"';
				break;
			
			case 'buscarDocumento' :
				$cadenaSql = 'SELECT * ';
				$cadenaSql .= 'FROM ';
				$cadenaSql .= 'trabajosdegrado.ant_tdantp ';
				$cadenaSql .= 'WHERE ';
				$cadenaSql .= 'dantp_antp=\'' . $variable . '\' ';
				var_dump ( $cadenaSql );
				break;
		}
		
		return $cadenaSql;
	}
}
?>
