<?php
/**
 * Esta clase fue y será generada automáticamente. NO EDITAR A MANO.
 * @ignore
 */
class mupum_autoload 
{
	static function existe_clase($nombre)
	{
		return isset(self::$clases[$nombre]);
	}

	static function cargar($nombre)
	{
		if (self::existe_clase($nombre)) { 
			 require_once(dirname(__FILE__) .'/'. self::$clases[$nombre]); 
		}
	}

	static protected $clases = array(
		'dao' => 'dao.php',
		'mupum_ci' => 'extension_toba/componentes/mupum_ci.php',
		'mupum_cn' => 'extension_toba/componentes/mupum_cn.php',
		'mupum_datos_relacion' => 'extension_toba/componentes/mupum_datos_relacion.php',
		'mupum_datos_tabla' => 'extension_toba/componentes/mupum_datos_tabla.php',
		'mupum_ei_arbol' => 'extension_toba/componentes/mupum_ei_arbol.php',
		'mupum_ei_archivos' => 'extension_toba/componentes/mupum_ei_archivos.php',
		'mupum_ei_calendario' => 'extension_toba/componentes/mupum_ei_calendario.php',
		'mupum_ei_codigo' => 'extension_toba/componentes/mupum_ei_codigo.php',
		'mupum_ei_cuadro' => 'extension_toba/componentes/mupum_ei_cuadro.php',
		'mupum_ei_esquema' => 'extension_toba/componentes/mupum_ei_esquema.php',
		'mupum_ei_filtro' => 'extension_toba/componentes/mupum_ei_filtro.php',
		'mupum_ei_firma' => 'extension_toba/componentes/mupum_ei_firma.php',
		'mupum_ei_formulario' => 'extension_toba/componentes/mupum_ei_formulario.php',
		'mupum_ei_formulario_ml' => 'extension_toba/componentes/mupum_ei_formulario_ml.php',
		'mupum_ei_grafico' => 'extension_toba/componentes/mupum_ei_grafico.php',
		'mupum_ei_mapa' => 'extension_toba/componentes/mupum_ei_mapa.php',
		'mupum_servicio_web' => 'extension_toba/componentes/mupum_servicio_web.php',
		'mupum_comando' => 'extension_toba/mupum_comando.php',
		'mupum_modelo' => 'extension_toba/mupum_modelo.php',
		'ci_login' => 'login/ci_login.php',
		'cuadro_autologin' => 'login/cuadro_autologin.php',
		'pant_login' => 'login/pant_login.php',
		'mupum_autoload' => 'mupum_autoload.php',
		'ci_estado_civil' => 'parametros/ci_estado_civil.php',
		'ci_tipo_documento' => 'parametros/ci_tipo_documento.php',
		'ci_tipo_socio' => 'parametros/ci_tipo_socio.php',
		'cn_parametros' => 'parametros/cn_parametros.php',
		'ei_frm_estado_civil' => 'parametros/ei_frm_estado_civil.php',
		'ei_frm_tipo_documento' => 'parametros/ei_frm_tipo_documento.php',
		'ei_frm_tipo_socio' => 'parametros/ei_frm_tipo_socio.php',
	);
}
?>