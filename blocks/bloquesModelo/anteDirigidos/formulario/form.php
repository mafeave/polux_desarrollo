<?php

namespace bloquesModelo\anteDirigidos\formulario;

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
		// var_dump($_REQUEST);
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
		$matrizAnteproyectos = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
		
		// var_dump($matrizItems);
		// var_dump($matrizItems[0]);
		
		$rol = $matrizAnteproyectos [0] [0];
		$acceso = false;
		$mostrar = true;
		// echo $rol;
		// var_dump($_REQUEST);
		
		if (($rol == "Coordinador") || ($rol == "Docente" ) ) {
			$acceso = true;
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "consultarCodigo", $_REQUEST ["usuario"] );
			$matrizCodigo = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			$_REQUEST ["variable"] = $matrizCodigo [0] [0];
		}
		
		if (($rol == 'Administrador General') || ($rol == 'Desarrollo y Pruebas')) {
			// $_REQUEST ["variable"] = '321456789';
			$acceso = true;
		}
		
		if (isset ( $_REQUEST ["variable"] )) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAnteproyecto", $_REQUEST ["variable"] );
		} else {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarAnteproyecto", "0" );
		}
		$matrizAnteproyectos = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
// 		var_dump ( $matrizAnteproyectos );
		
		if (isset ( $_REQUEST ['variable'] )) {
			$atributos ['cadena_sql'] = $this->miSql->getCadenaSql ( "buscarDocente", $_REQUEST ["variable"] );
			$matrizNombre = $esteRecurso->ejecutarAcceso ( $atributos ['cadena_sql'], "busqueda" );
			$atributos ['mensaje'] = 'Anteproyectos dirigidos por ' . $matrizNombre [0] [0] . "";
		} else {
			$atributos ['mensaje'] = 'Anteproyectos dirigidos ';
		}
		$atributos ['tamanno'] = 'Enorme';
		$atributos ['linea'] = 'true';
		echo $this->miFormulario->campoMensaje ( $atributos );
		
		if ($matrizAnteproyectos && $acceso) {
			
			for($i = 0; $i < count ( $matrizAnteproyectos ); $i ++) {
				$anteproyecto = $matrizAnteproyectos [$i] ['anteproyecto'];
				
				// ////////////////Hidden////////////
				$esteCampo = 'antpSolicitudes';
				$atributos ["id"] = $esteCampo;
				$atributos ["tipo"] = "hidden";
				$atributos ['estilo'] = '';
				$atributos ['validar'] = '';
				$atributos ["obligatorio"] = true;
				$atributos ['marco'] = true;
				$atributos ["etiqueta"] = "";
				$atributos ['valor'] = count ( $matrizAnteproyectos );
				
				$atributos = array_merge ( $atributos, $atributosGlobales );
				echo $this->miFormulario->campoCuadroTexto ( $atributos );
				unset ( $atributos );
				// ////////////////////////////////////////
				
				$titulo = $matrizAnteproyectos[$i]['titulo'];
				if ($titulo == strtoupper($titulo)) {
					$titulo = substr($titulo, 0, 45) . "...";
				}
				if (strlen ($titulo) > 60) {
					$titulo = substr($titulo, 0, 55) . "...";
				}
				
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
				$atributos['mensaje'] = $matrizAnteproyectos[$i]['fecha'];
				echo $this->miFormulario->division("inicio", $atributos);
				echo $this->miFormulario->division("fin");
				unset($atributos);
				
				$atributos['id'] = "d";
				$atributos['estilo'] = "clearboth";
				echo $this->miFormulario->division("inicio", $atributos);
				echo $this->miFormulario->division("fin");
				unset($atributos);
				
				echo $this->miFormulario->division("fin");
				
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
				
				?>
		<p class="caja-numero" id="cajanum<?php echo $i ?>"><?php echo 'No. '. $matrizAnteproyectos[$i]['anteproyecto']?></p>
			</div>
			<div class="caja-info" style="float: left">
				<table style="border: 0; width: 100%">
					<tbody>
						<tr>
							<td><b>Titulo:</b></td>
							<td><?php echo $titulo ?></td>
						</tr>
						<tr>
							<td><b>Modalidad:</b></td>
							<td><?php echo $matrizAnteproyectos[$i]['modalidad'] ?></td>
						</tr>
						<tr>
							<td><b>Estado:</b></td>
							<td><?php echo $matrizAnteproyectos[$i]['estado'] ?></td>
						</tr>
					</tbody>
				</table>
				<p></p>

			</div>
										<?php
				
				$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
				$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
				
// 				$variableVer = "action=" . $esteBloque ["nombre"];
				$variableVer = "pagina=verAnteproyecto";
				$variableVer .= "&usuario=" . $_REQUEST ['usuario'];
				$variableVer .= "&anteproyecto=" . $matrizAnteproyectos [$i] ['anteproyecto'];
				if (isset ( $docente )) {
					$variableVer .= "&docente=" . $docente;
				}
				$variableVer .= "&rol=" . $rol;
				
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
				
				?>
									</div>
	</div>
</div>

<?
			}
		} else {
			$mostrar = false;
			$pag = $this->miConfigurador->fabricaConexiones->crypto->codificar ( "pagina=indexPolux" );
			?>
<div class="canvas-contenido">
	<div class="area-msg corner margen-interna ">
		<div class="icono-msg info"></div>
		<div class="content-msg info corner">
			<div class="title-msg info">Informacion</div>
			<div style="padding: 5px 0px;">
				<div>
					<contenido> No existen anteproyectos actualmente registrados para
					dirigir.
					<div style="text-align: right"
						onclick="window.location = 'index.php?data=<?php echo $pag?>';">
						<input
							class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only"
							type="submit" tabindex="1" value="Ir al inicio" role="button"
							aria-disabled="false">
					</div>
					</contenido>
				</div>
			</div>
		</div>
		<div class="clearboth"></div>
	</div>
</div>
<?php
		}
		
		// ------------------- SECCION: Paso de variables ------------------------------------------------
		
		/**
		 * En algunas ocasiones es útil pasar variables entre las diferentes páginas.
		 * SARA permite realizar esto a través de tres
		 * mecanismos:
		 * (a). Registrando las variables como variables de sesión. Estarán disponibles durante toda la sesión de usuario. Requiere acceso a
		 * la base de datos.
		 * (b). Incluirlas de manera codificada como campos de los formularios. Para ello se utiliza un campo especial denominado
		 * formsara, cuyo valor será una cadena codificada que contiene las variables.
		 * (c) a través de campos ocultos en los formularios. (deprecated)
		 */
		
		// En este formulario se utiliza el mecanismo (b) para pasar las siguientes variables:
		
		// Paso 1: crear el listado de variables
		
		$valorCodificado = "action=" . $esteBloque ["nombre"];
		$valorCodificado .= "&pagina=" . $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		$valorCodificado .= "&usuario=" . $usuario;
		$valorCodificado .= "&bloque=" . $esteBloque ['nombre'];
		$valorCodificado .= "&bloqueGrupo=" . $esteBloque ["grupo"];
		$valorCodificado .= "&opcion=ver";
		/**
		 * SARA permite que los nombres de los campos sean dinámicos.
		 * Para ello utiliza la hora en que es creado el formulario para
		 * codificar el nombre de cada campo.
		 */
		$valorCodificado .= "&campoSeguro=" . $_REQUEST ['tiempo'];
		// Paso 2: codificar la cadena resultante
		$valorCodificado = $this->miConfigurador->fabricaConexiones->crypto->codificar ( $valorCodificado );
		
		$atributos ["id"] = "formSaraData"; // No cambiar este nombre
		$atributos ["tipo"] = "hidden";
		$atributos ['estilo'] = '';
		$atributos ["obligatorio"] = false;
		$atributos ['marco'] = true;
		$atributos ["etiqueta"] = "";
		$atributos ["valor"] = $valorCodificado;
		echo $this->miFormulario->campoCuadroTexto ( $atributos );
		unset ( $atributos );
		
		// ----------------FIN SECCION: Paso de variables -------------------------------------------------
		
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