<?php

namespace bloquesModelo\bannerUsuario\formulario;

if (! isset ( $GLOBALS ["autorizado"] )) {
	include ("../index.php");
	exit ();
}
class Formulario {
	var $miConfigurador;
	var $lenguaje;
	var $miFormulario;
	var $miSql;
	function __construct($lenguaje, $formulario) {
		$this->miConfigurador = \Configurador::singleton ();
		
		$this->miConfigurador->fabricaConexiones->setRecursoDB ( 'principal' );
		
		$this->lenguaje = $lenguaje;
		
		$this->miFormulario = $formulario;
	}
	function formulario() {
		
		/**
		 * IMPORTANTE: Este formulario está utilizando jquery.
		 * Por tanto en el archivo ready.php se delaran algunas funciones js
		 * que lo complementan.
		 */
		
		// Rescatar los datos de este bloque
		$esteBloque = $this->miConfigurador->getVariableConfiguracion ( "esteBloque" );
		$miPaginaActual = $this->miConfigurador->getVariableConfiguracion ( 'pagina' );
		
		$directorio = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/index.php?";
		$directorio .= $this->miConfigurador->getVariableConfiguracion ( "enlace" );
		
		$rutaBloque = $this->miConfigurador->getVariableConfiguracion ( "host" );
		$rutaBloque .= $this->miConfigurador->getVariableConfiguracion ( "site" ) . "/blocks/";
		$rutaBloque .= $esteBloque ['grupo'] . '/' . $esteBloque ['nombre'];
		
		$esteCampo = $esteBloque ['nombre'];
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		
		// Si no se coloca, entonces toma el valor predeterminado 'application/x-www-form-urlencoded'
		$atributos ['tipoFormulario'] = 'multipart/form-data';
		
		// Si no se coloca, entonces toma el valor predeterminado 'POST'
		$atributos ['metodo'] = 'POST';
		
		// Si no se coloca, entonces toma el valor predeterminado 'index.php' (Recomendado)
		$atributos ['action'] = 'index.php';
		$atributos ['titulo'] = $this->lenguaje->getCadena ( $esteCampo );
		
		// Si no se coloca, entonces toma el valor predeterminado.
		$atributos ["estilo"] = "animated fadeInDown";
		$atributos ['marco'] = true;
		$tab = 1;
		
		$atributos ["id"] = "banner";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		$atributos ["id"] = "bannerImagen";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		// ---------------- CONTROL: Imagen --------------------------------------------------------
		$esteCampo = 'bannerSuperior';
		$atributos ['id'] = $esteCampo;
		$atributos ['nombre'] = $esteCampo;
		$atributos ['estiloMarco'] = '';
		$atributos ["imagen"] = $rutaBloque . "/imagen/polux-titulo.png";
		$atributos ['alto'] = 106;
		$atributos ['ancho'] = 800;
		$atributos ["borde"] = 0;
		$atributos ['tabIndex'] = $tab ++;
		echo $this->miFormulario->campoImagen ( $atributos );
		unset ( $atributos );
		
		$atributos ["id"] = "bannerDatos";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		// ---------------- CONTROL: Campo de Texto Funcionario--------------------------------------------------------
		
		$esteCampo = 'usuario';
		$atributos ["id"] = $esteCampo;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['columnas'] = 1;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['texto'] = 'Usuario: '; // Aqui se deberealizar la consulta para mostrar el usuario del sistema.
		$atributos ['tabIndex'] = $tab ++;
		echo $this->miFormulario->campoTexto ( $atributos );
		unset ( $atributos );
		
		// --------------------FIN CONTROL: Campo de Texto Funcionario--------------------------------------------------------
		
		// ---------------- CONTROL: Campo de Texto Funcionario--------------------------------------------------------
		
		$esteCampo = 'email';
		$atributos ["id"] = $esteCampo;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['columnas'] = 1;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['texto'] = 'E-mail:'; // Aqui se deberealizar la consulta para mostrar el usuario del sistema.
		$atributos ['tabIndex'] = $tab ++;
		echo $this->miFormulario->campoTexto ( $atributos );
		unset ( $atributos );
		
		// --------------------FIN CONTROL: Campo de Texto Funcionario--------------------------------------------------------
		
		$atributos ["id"] = "bannerFecha";
		echo $this->miFormulario->division ( "inicio", $atributos );
		unset ( $atributos );
		
		// ---------------- CONTROL: Campo de Texto Fecha--------------------------------------------------------
		$esteCampo = 'campoHora';
		$atributos ["id"] = $esteCampo;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['columnas'] = 1;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['texto'] = '';
		$atributos ['tabIndex'] = $tab ++;
		echo $this->miFormulario->campoTexto ( $atributos );
		unset ( $atributos );
		
		// --------------------FIN CONTROL: Campo de Texto Fecha--------------------------------------------------------
		
		echo $this->miFormulario->division ( "fin" );
		
		// ---------------- CONTROL: Campo de Texto Hora--------------------------------------------------------
		$esteCampo = 'bienvenido';
		$atributos ["id"] = $esteCampo;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['columnas'] = 1;
		$atributos ["estilo"] = $esteCampo;
		$atributos ['texto'] = 'Bienvenido(a): ';
		$atributos ['tabIndex'] = $tab ++;
		echo $this->miFormulario->campoTexto ( $atributos );
		unset ( $atributos );
		
		// --------------------FIN CONTROL: Campo de Texto Hora--------------------------------------------------------
		
		echo $this->miFormulario->division ( "fin" );
		
		echo $this->miFormulario->division ( "fin" );
		// Aplica atributos globales al control
		
		// --------------------FIN CONTROL: Imagen--------------------------------------------------------
		
		echo $this->miFormulario->division ( "fin" );
		
		// --------------------FIN CONTROL: Imagen--------------------------------------------------------
		
		echo $this->miFormulario->division ( "fin" );
	}
}

$miFormulario = new Formulario ( $this->lenguaje, $this->miFormulario );

$miFormulario->formulario ();

?>