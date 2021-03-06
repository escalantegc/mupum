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
		'ci_cabecera' => 'configuracion/ci_cabecera.php',
		'ci_configuracion' => 'configuracion/ci_configuracion.php',
		'cn_configuracion' => 'configuracion/cn_configuracion.php',
		'ci_consumo_bono' => 'consumos/ci_consumo_bono.php',
		'ci_consumo_financiado' => 'consumos/ci_consumo_financiado.php',
		'ci_consumo_por_ticket' => 'consumos/ci_consumo_por_ticket.php',
		'ci_solicitar_ayuda_economica' => 'consumos/ci_solicitar_ayuda_economica.php',
		'ci_solicitar_ayuda_economica_mutual' => 'consumos/ci_solicitar_ayuda_economica_mutual.php',
		'cn_consumos' => 'consumos/cn_consumos.php',
		'ei_frm_cabecera_consumo_ticket_gral' => 'consumos/ei_frm_cabecera_consumo_ticket_gral.php',
		'ei_frm_consumo_bono' => 'consumos/ei_frm_consumo_bono.php',
		'ei_frm_consumo_edicion' => 'consumos/ei_frm_consumo_edicion.php',
		'ei_frm_consumo_financiado' => 'consumos/ei_frm_consumo_financiado.php',
		'ei_frm_consumo_ticket' => 'consumos/ei_frm_consumo_ticket.php',
		'ei_frm_ml_cabecera' => 'consumos/ei_frm_ml_cabecera.php',
		'ei_frm_ml_detalle_ayuda' => 'consumos/ei_frm_ml_detalle_ayuda.php',
		'ei_frm_ml_detalle_consumo' => 'consumos/ei_frm_ml_detalle_consumo.php',
		'ei_frm_ml_detalle_pago_bono' => 'consumos/ei_frm_ml_detalle_pago_bono.php',
		'ei_frm_ml_detalle_pago_ticket' => 'consumos/ei_frm_ml_detalle_pago_ticket.php',
		'ei_frm_ml_nros_bonos' => 'consumos/ei_frm_ml_nros_bonos.php',
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
		'ci_legajo' => 'listados/ci_legajo.php',
		'ci_novedades_familia' => 'listados/ci_novedades_familia.php',
		'ei_filtro_legajo' => 'listados/ei_filtro_legajo.php',
		'ci_login' => 'login/ci_login.php',
		'cn_registro' => 'login/cn_registro.php',
		'cuadro_autologin' => 'login/cuadro_autologin.php',
		'ei_frm_afiliacion' => 'login/ei_frm_afiliacion.php',
		'ei_frm_persona' => 'login/ei_frm_persona.php',
		'ei_frm_persona_externa' => 'login/ei_frm_persona_externa.php',
		'pant_login' => 'login/pant_login.php',
		'mupum_autoload' => 'mupum_autoload.php',
		'ci_categoria_comercio' => 'parametros/ci_categoria_comercio.php',
		'ci_categoria_estado' => 'parametros/ci_categoria_estado.php',
		'ci_categoria_motivo' => 'parametros/ci_categoria_motivo.php',
		'ci_claustro' => 'parametros/ci_claustro.php',
		'ci_comercio' => 'parametros/ci_comercio.php',
		'ci_concepto_pago' => 'parametros/ci_concepto_pago.php',
		'ci_configuracion_bolsitas' => 'parametros/ci_configuracion_bolsitas.php',
		'ci_configuracion_colonia' => 'parametros/ci_configuracion_colonia.php',
		'ci_configuracion_convenios' => 'parametros/ci_configuracion_convenios.php',
		'ci_estado' => 'parametros/ci_estado.php',
		'ci_estado_civil' => 'parametros/ci_estado_civil.php',
		'ci_forma_pago' => 'parametros/ci_forma_pago.php',
		'ci_instalacion' => 'parametros/ci_instalacion.php',
		'ci_localidad' => 'parametros/ci_localidad.php',
		'ci_motivo' => 'parametros/ci_motivo.php',
		'ci_motivo_por_tipo_socio' => 'parametros/ci_motivo_por_tipo_socio.php',
		'ci_nivel' => 'parametros/ci_nivel.php',
		'ci_pais' => 'parametros/ci_pais.php',
		'ci_parentesco' => 'parametros/ci_parentesco.php',
		'ci_provincia' => 'parametros/ci_provincia.php',
		'ci_talonario_bonos' => 'parametros/ci_talonario_bonos.php',
		'ci_tipo_documento' => 'parametros/ci_tipo_documento.php',
		'ci_tipo_socio' => 'parametros/ci_tipo_socio.php',
		'ci_tipo_subsidio' => 'parametros/ci_tipo_subsidio.php',
		'ci_tipo_telefono' => 'parametros/ci_tipo_telefono.php',
		'ci_unidad_academica' => 'parametros/ci_unidad_academica.php',
		'cn_parametros' => 'parametros/cn_parametros.php',
		'ei_frm_categoria_comercio' => 'parametros/ei_frm_categoria_comercio.php',
		'ei_frm_categoria_estado' => 'parametros/ei_frm_categoria_estado.php',
		'ei_frm_categoria_motivo' => 'parametros/ei_frm_categoria_motivo.php',
		'ei_frm_claustro' => 'parametros/ei_frm_claustro.php',
		'ei_frm_comercio' => 'parametros/ei_frm_comercio.php',
		'ei_frm_concepto' => 'parametros/ei_frm_concepto.php',
		'ei_frm_configuracion_bolsita' => 'parametros/ei_frm_configuracion_bolsita.php',
		'ei_frm_configuracion_colonia' => 'parametros/ei_frm_configuracion_colonia.php',
		'ei_frm_convenio' => 'parametros/ei_frm_convenio.php',
		'ei_frm_estado' => 'parametros/ei_frm_estado.php',
		'ei_frm_estado_civil' => 'parametros/ei_frm_estado_civil.php',
		'ei_frm_forma_pago' => 'parametros/ei_frm_forma_pago.php',
		'ei_frm_instalacion' => 'parametros/ei_frm_instalacion.php',
		'ei_frm_localidad' => 'parametros/ei_frm_localidad.php',
		'ei_frm_ml_comercios_por_convenios' => 'parametros/ei_frm_ml_comercios_por_convenios.php',
		'ei_frm_motivo' => 'parametros/ei_frm_motivo.php',
		'ei_frm_nivel' => 'parametros/ei_frm_nivel.php',
		'ei_frm_pais' => 'parametros/ei_frm_pais.php',
		'ei_frm_parentesco' => 'parametros/ei_frm_parentesco.php',
		'ei_frm_provincia' => 'parametros/ei_frm_provincia.php',
		'ei_frm_talonario_bono' => 'parametros/ei_frm_talonario_bono.php',
		'ei_frm_tipo_documento' => 'parametros/ei_frm_tipo_documento.php',
		'ei_frm_tipo_socio' => 'parametros/ei_frm_tipo_socio.php',
		'ei_frm_tipo_subsidio' => 'parametros/ei_frm_tipo_subsidio.php',
		'ei_frm_tipo_telefono' => 'parametros/ei_frm_tipo_telefono.php',
		'ei_frm_unidad_academica' => 'parametros/ei_frm_unidad_academica.php',
		'ci_afiliacion' => 'socio/ci_afiliacion.php',
		'ci_seleccion_afiliado' => 'socio/ci_seleccion_afiliado.php',
		'ci_seleccion_socio' => 'socio/ci_seleccion_socio.php',
		'ci_seleccionar_persona' => 'socio/ci_seleccionar_persona.php',
		'ci_socios_pestanias' => 'socio/ci_socios_pestanias.php',
		'ci_socios_principal' => 'socio/ci_socios_principal.php',
		'cn_socio' => 'socio/cn_socio.php',
		'e_frm_socio' => 'socio/e_frm_socio.php',
		'ei_cuadro_afiliacion' => 'socio/ei_cuadro_afiliacion.php',
		'ei_frm_ml_familia' => 'socio/ei_frm_ml_familia.php',
		'ei_frm_persona_popup' => 'socio/ei_frm_persona_popup.php',
		'ei_frm_solicitud_reempadronamiento' => 'socio/ei_frm_solicitud_reempadronamiento.php',
		'pant_afiliacion' => 'socio/pant_afiliacion.php',
		'ci_administracion_colonos' => 'solicitudes/ci_administracion_colonos.php',
		'ci_administrar_bolsitas' => 'solicitudes/ci_administrar_bolsitas.php',
		'ci_administrar_bonos_colaboracion' => 'solicitudes/ci_administrar_bonos_colaboracion.php',
		'ci_administrar_mis_reservas' => 'solicitudes/ci_administrar_mis_reservas.php',
		'ci_administrar_reserva' => 'solicitudes/ci_administrar_reserva.php',
		'ci_administrar_solicitudes_subsidios' => 'solicitudes/ci_administrar_solicitudes_subsidios.php',
		'ci_configurar_bono_colaboracion' => 'solicitudes/ci_configurar_bono_colaboracion.php',
		'ci_inscripcion_colonos' => 'solicitudes/ci_inscripcion_colonos.php',
		'ci_mis_solicitudes_subsidio' => 'solicitudes/ci_mis_solicitudes_subsidio.php',
		'ci_reempadronamiento' => 'solicitudes/ci_reempadronamiento.php',
		'ci_seleccion_persona_externa' => 'solicitudes/ci_seleccion_persona_externa.php',
		'ci_solicitud_afiliacion' => 'solicitudes/ci_solicitud_afiliacion.php',
		'ci_solicitud_reserva' => 'solicitudes/ci_solicitud_reserva.php',
		'ci_solicitudes_bolsita' => 'solicitudes/ci_solicitudes_bolsita.php',
		'cn_soliciudes' => 'solicitudes/cn_soliciudes.php',
		'ei_calendario' => 'solicitudes/ei_calendario.php',
		'ei_cuadro_administrar_afiliacion' => 'solicitudes/ei_cuadro_administrar_afiliacion.php',
		'ei_cuadro_administrar_reserva' => 'solicitudes/ei_cuadro_administrar_reserva.php',
		'ei_cuadro_administrar_solicitudes_subsidio' => 'solicitudes/ei_cuadro_administrar_solicitudes_subsidio.php',
		'ei_cuadro_cancelar_afiliacion' => 'solicitudes/ei_cuadro_cancelar_afiliacion.php',
		'ei_cuadro_mis_reservas' => 'solicitudes/ei_cuadro_mis_reservas.php',
		'ei_cuadro_solicitudes' => 'solicitudes/ei_cuadro_solicitudes.php',
		'ei_cuadro_solicitudes_bolsita' => 'solicitudes/ei_cuadro_solicitudes_bolsita.php',
		'ei_cuadro_solicitudes_reempad_enviadas' => 'solicitudes/ei_cuadro_solicitudes_reempad_enviadas.php',
		'ei_cuadro_solicitudes_subsidio' => 'solicitudes/ei_cuadro_solicitudes_subsidio.php',
		'ei_frm_administrar_afiliacion' => 'solicitudes/ei_frm_administrar_afiliacion.php',
		'ei_frm_ayuda_economica' => 'solicitudes/ei_frm_ayuda_economica.php',
		'ei_frm_bono_colaboracion' => 'solicitudes/ei_frm_bono_colaboracion.php',
		'ei_frm_detalle_pago' => 'solicitudes/ei_frm_detalle_pago.php',
		'ei_frm_inscripcion_colonia' => 'solicitudes/ei_frm_inscripcion_colonia.php',
		'ei_frm_ml_aumento_descuento' => 'solicitudes/ei_frm_ml_aumento_descuento.php',
		'ei_frm_reempadronamiento' => 'solicitudes/ei_frm_reempadronamiento.php',
		'ei_frm_solicitud_bolista' => 'solicitudes/ei_frm_solicitud_bolista.php',
		'ei_frm_solicitud_reserva' => 'solicitudes/ei_frm_solicitud_reserva.php',
		'ei_frm_solicitud_subsidio' => 'solicitudes/ei_frm_solicitud_subsidio.php',
		'mupum_tp_logon' => 'tipo_pagina/mupum_tp_logon.php',
		'ci_administrar_usuarios' => 'usuario/ci_administrar_usuarios.php',
		'ci_cambiar_clave' => 'usuario/ci_cambiar_clave.php',
		'ei_cuadro_usuario' => 'usuario/ei_cuadro_usuario.php',
	);
}
?>