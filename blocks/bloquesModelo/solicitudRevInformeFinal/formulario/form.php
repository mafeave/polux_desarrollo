<?php

namespace bloquesModelo\solicitudRevInformeFinal\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSesion;
	function __construct($lenguaje, $formulario, $sql) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
		
		$this->miSql = $sql;
		$this->miSesion = \Sesion::singleton ();
	}
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		
		// ---------------- SECCION: Parámetros Globales del Formulario ----------------------------------
		/**
		 * Atributos que deben ser aplicados a todos los controles de este formulario.
		 * Se utiliza un arreglo
		 * independiente debido a que los atributos individuales se reinician cada vez que se declara un campo.
		 *
		 * Si se utiliza esta técnica es necesario realizar un mezcla entre este arreglo y el específico en cada control:
		 * $atributos= array_merge($atributos,$atributosGlobales);
		 */
		$atributosGlobales ['campoSeguro'] = 'true';
		$_REQUEST ['tiempo'] = time ();
		
		$conexion = 'estructura';
		$esteRecurso = $this->miConfigurador->fabricaConexiones->getRecursoDB ( $conexion );
		
		$usuario = $this->miSesion->getSesionUsuarioId ();
		
		// -------------------------------------------------------------------------------------------------
		
		// ---------------- SECCION: Parámetros Generales del Formulario ----------------------------------
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = '';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ['estilo'] = '';
		$atributos ['marco'] = true;
		$tab = 1;
		// ---------------- FIN SECCION: de Parámetros Generales del Formulario ----------------------------
		
		// ----------------INICIAR EL FORMULARIO ------------------------------------------------------------
		$atributos ['tipoEtiqueta'] = 'inicio';
		echo $this->miFormulario->formulario ( $atributos );
		
		// ---------------- SECCION: Controles del Formulario -----------------------------------------------

		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarRol", $usuario );
		$matrizRol = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		$rol = $matrizRol [0] [0];
		$acceso = false;
		$mostrar = true;
		
		$docente = $_REQUEST['usuario'];
		
		//Buscar Informes Finales asignados al docente
		$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarSolicitudes", $docente );
		$matrizInformes = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		//var_dump($matrizInformes);
		
		?>
		<br></br>
<?php
	
		if ($matrizInformes) {
			
		$atributos ['mensaje'] = 'Solicitudes Pendientes de Revisión de Informes Finales';
		$atributos ['tamanno'] = 'Enorme';
		$atributos ['linea'] = 'true';
		echo $this->miFormulario->campoMensaje ( $atributos );
		unset ( $atributos );
		
		for($i=0; $i<count($matrizInformes); $i++){
			$informe = $matrizInformes[$i]['informe'];
			
			//buscar informe final
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarInformes", $informe);
			$matriz = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			
			// ////////////////Hidden////////////
			$esteCampo = 'infSolicitudes';
			$atributos ["id"] = $esteCampo;
			$atributos ["tipo"] = "hidden";
			$atributos ['estilo'] = '';
			$atributos ['validar'] = '';
			$atributos ["obligatorio"] = true;
			$atributos ['marco'] = true;
			$atributos ["etiqueta"] = "";
			$atributos ['valor'] = count($matrizInformes);
				
			$atributos = array_merge ( $atributos, $atributosGlobales );
			echo $this->miFormulario->campoCuadroTexto ( $atributos );
			unset ( $atributos );
			// ////////////////////////////////////////
			
		/////////////////////////////////////////////////////////
		
			$atributos['id'] = "caja" . $i;
			$atributos['estilo'] = "bg-caja corner";
			$atributos['estiloEnLinea'] = "float: left";
			echo $this->miFormulario->division("inicio", $atributos);
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja corner";
			echo $this->miFormulario->division("inicio", $atributos);
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja-header";
			echo $this->miFormulario->division("inicio", $atributos);
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja-fecha";
			$atributos['estiloEnLinea'] = "float: left";
			$atributos['mensaje'] = $matrizInformes[$i]['fecha_creacion'];
			echo $this->miFormulario->division("inicio", $atributos);
			echo $this->miFormulario->division("fin");
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja-semaforo-gris";
			$atributos['estiloEnLinea'] = "float:right";
			echo $this->miFormulario->division("inicio", $atributos);
			echo $this->miFormulario->division("fin");
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja-semaforo-gris";
			$atributos['estiloEnLinea'] = "float:right";
			echo $this->miFormulario->division("inicio", $atributos);
			echo $this->miFormulario->division("fin");
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja-semaforo-verde";
			$atributos['estiloEnLinea'] = "float:right";
			echo $this->miFormulario->division("inicio", $atributos);
			echo $this->miFormulario->division("fin");
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "clearboth";
			echo $this->miFormulario->division("inicio", $atributos);
			echo $this->miFormulario->division("fin");
			unset($atributos);
			
		//	echo $this->miFormulario->division("fin");
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "";
			echo $this->miFormulario->division("inicio", $atributos);
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja-codigo";
			$atributos['estiloEnLinea'] = "float: left";
			echo $this->miFormulario->division("inicio", $atributos);
			unset($atributos);
			
			$atributos['id'] = "d";
			$atributos['estilo'] = "caja-icon-documento";
			echo $this->miFormulario->division("inicio", $atributos);
			echo $this->miFormulario->division("fin");
			unset($atributos);
			
			$atributos ['id'] = "cajanum" . $i;
			$atributos ['estilo'] = "caja-numero";
			$atributos ['mensaje'] = 'No. '. $matrizInformes[$i]['informe'];
			$atributos ['tipo_etiqueta'] = "p";
			echo $this->miFormulario->div_especifico("inicio", $atributos);
			echo $this->miFormulario->div_especifico("fin", $atributos);
			unset($atributos);
			
			
			echo $this->miFormulario->division ( "fin" );
			
			$atributos ['id'] = "d";
			$atributos ['estilo'] = "caja-info";
			$atributos ['estiloEnLinea'] = "";
			echo $this->miFormulario->division ( "inicio", $atributos );
			unset ( $atributos );
			
			$hoy = date ( "Y-m-d" );
			$dias	= (strtotime($hoy)-strtotime($matrizInformes[$i][8]))/86400;
			$dias 	= abs($dias);
			$dias = floor($dias);
			$mostrarDias=20-$dias."/20";
			
			$datos = array (
					"Solicitante" => $matrizInformes[$i] ['nombre'],
					"Informe" => "No. ".$matrizInformes [$i] ['informe'],
					"Estado" => $matrizInformes[$i] ['estado'],
					"Dias" => $mostrarDias
			);
			
			$atributos ['estilo'] = "border: 0; width: 100%";
			echo $this->miFormulario->crearTabla2 ( $atributos, $datos );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			
			$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
			$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
			
			// $variableVer = "action=" . $esteBloque ["nombre"];
			$variableVer = "pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
			$variableVer .= "&usuario=" . $_REQUEST ['usuario'];
			$variableVer .= "&informe=" . $matrizInformes [$i] ['informe'];
			if (isset ( $docente )) {
				$variableVer .= "&docente=" . $docente;
			}
			$variableVer .= "&rol=" . $rol;
			$variableVer .= "&opcion=ver";
			$variableVer .= "&solicitud=" . $matrizInformes[$i]['solicitud'];
			
			$variableVer = $this->miConfigurador->fabricaConexiones->crypto->codificar_url ( $variableVer, $directorio );
			
			// -------------Enlace-----------------------
			$esteCampo = "enlaceVer";
			$atributos ["id"] = $esteCampo;
			$atributos ['enlace'] = $variableVer;
			$atributos ['tabIndex'] = $esteCampo;
			$atributos ['redirLugar'] = true;
			$atributos ['estilo'] = 'color';
			$atributos ['enlaceTexto'] = $this->lenguaje->getCadena ( $esteCampo );
			;
			$atributos ['ancho'] = '25';
			$atributos ['alto'] = '25';
			echo $this->miFormulario->enlace ( $atributos );
			unset ( $atributos );
			
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
			echo $this->miFormulario->division ( "fin" );
			///////////////////////////
	
		}
	} else {

		$mostrar = false;
		$pag = $this->miConfigurador->fabricaConexiones->crypto->codificar ( "pagina=indexPolux" );
			
		$atributos ['id'] = "d";
		$atributos ['estilo'] = "canvas-contenido";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
			
		$atributos ['id'] = "d";
		$atributos ['estilo'] = "area-msg corner margen-interna";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
			
		$atributos ['id'] = "d";
		$atributos ['estilo'] = "icono-msg info";
		echo $this->miFormulario->division ( "inicio", $atributos );
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
			
		$atributos ['id'] = "d";
		$atributos ['estilo'] = "content-msg info corner";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
			
		$atributos ['id'] = "d";
		$atributos ['estilo'] = "title-msg info";
		$atributos ['mensaje'] = 'Información';
		echo $this->miFormulario->division ( "inicio", $atributos );
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
			
		$atributos ['id'] = "d";
		$atributos ['estilo'] = "";
		$atributos ['estiloEnLinea'] = "padding: 5px 0px;";
		echo $this->miFormulario->division ( "inicio", $atributos );
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
			
		$atributos ['id'] = "d";
		$atributos ['estilo'] = "";
		echo $this->miFormulario->division ( "inicio", $atributos );
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
			
		$atributos ['id'] = "c";
		$atributos ['estilo'] = "";
		$atributos ['mensaje'] = 'No existen solicitudes pendientes de revisión de Informes Finales.';
		$atributos ['tipo_etiqueta'] = "contenido";
		echo $this->miFormulario->div_especifico("inicio", $atributos);
		echo $this->miFormulario->division ( "fin" );
		unset($atributos);
			
		$atributos ['id'] = "d";
		$atributos ['onclick'] = "window.location = 'index.php?data=" . $pag;
		$atributos ['estilo'] = "";
		echo $this->miFormulario->division ( "inicio", $atributos );
		echo $this->miFormulario->division ( "fin" );
		unset ( $atributos );
		
		}
		
		
		// ---------------- FIN SECCION: Controles del Formulario -------------------------------------------
		
		// ----------------FINALIZAR EL FORMULARIO ----------------------------------------------------------
		// Se debe declarar el mismo atributo de marco con que se inició el formulario.
		$atributos ['marco'] = true;
		$atributos ['tipoEtiqueta'] = 'fin';
		echo $this->miFormulario->formulario ( $atributos );
		
		return true;
	}
	function mensaje() {
		
		// Si existe algun tipo de error en el login aparece el siguiente mensaje
		$mensaje = $this->miConfigurador->getVariableConfiguracion ( 'mostrarMensaje' );
		$this->miConfigurador->setVariableConfiguracion ( 'mostrarMensaje', null );
		
		if ($mensaje) {
			
			$tipoMensaje = $this->miConfigurador->getVariableConfiguracion ( 'tipoMensaje' );
			
			if ($tipoMensaje == 'json') {
				
				$atributos ['mensaje'] = $mensaje;
				$atributos ['json'] = true;
			} else {
				$atributos ['mensaje'] = $this->lenguaje->getCadena ( $mensaje );
			}
			// -------------Control texto-----------------------
			$esteCampo = 'divMensaje';
			$atributos ['id'] = $esteCampo;
			$atributos ["tamanno"] = '';
			$atributos ["estilo"] = 'information';
			$atributos ["etiqueta"] = '';
			$atributos ["columnas"] = ''; // El control ocupa 47% del tamaño del formulario
			echo $this->miFormulario->campoMensaje ( $atributos );
			unset ( $atributos );
		}
		
		return true;
	}
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario, $this->sql );

$miFormulario->formulario ();
$miFormulario->mensaje ();

?>