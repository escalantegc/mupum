<?php
require_once('dao.php');
class ci_solicitudes_bolsita extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_bolsita();
			if (!toba::notificacion()->verificar_mensajes())
			{
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			}
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
		 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_solicitud_bolsita'))
			{
				toba::notificacion()->agregar("Solo puede realizar una solicitud de bolsita escolar por a&#241;o por familiar.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_bolsita();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_bolsita();
		$this->set_pantalla('pant_inicial');
	}
	function evt__nuevo()
	{
		$cantidad = dao::get_cantida_configuracion_bolsita_vigentes();
		if ($cantidad>0)
		{
			$this->set_pantalla('pant_edicion');	
		} else{
			toba::notificacion()->agregar("Por el momento no se encuentran disponibles las solicitudes de bolsita.",'info');
		}
		
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_familiares ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_familiares(mupum_ei_cuadro $cuadro)
	{
		$datos = dao::get_listado_familia_menores_edad();
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_solicitudes -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_solicitudes(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_solicitudes_bolsita_escolar($this->s__where);
		}else{
			$datos = dao::get_listado_solicitudes_bolsita_escolar();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_solicitudes__seleccion($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->set_cursor_dt_solicitud_bolsita($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro_solicitudes__borrar($seleccion)
	{
		$this->cn()->cargar_dt_solicitud_bolsita($seleccion);
		$this->cn()->eliminar_dt_solicitud_bolsita($seleccion);
		try{
			$this->cn()->guardar_dr_bolsita();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La categoria estado esta siendo referenciada, no puede eliminarla",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_bolsita();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_bolsita())
		{
			$datos = $this->cn()->get_dt_solicitud_bolsita();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_solicitud_bolsita())
		{
			$this->cn()->set_dt_solicitud_bolsita($datos);
		} else {
			$datos['fecha_solicitud'] = date('Y-m-j');
			$this->cn()->agregar_dt_solicitud_bolsita($datos);
		}
	}

	

}
?>