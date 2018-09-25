<?php
require_once('dao.php');
class ci_administrar_reserva extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		
		try{
			$this->cn()->guardar_dr_reserva();
			if (!toba::notificacion()->verificar_mensajes())
			{
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			}
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El estado civil esta siendo referenciado, no puede eliminarlo",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_reserva'))
			{
				toba::notificacion()->agregar("El estado civil ya esta registrado.",'info');
			} 
			
		}
		$this->cn()->resetear_dr_reserva();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_reserva();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_reserva_mes_en_curso($this->s__where);
		}else{
			$datos = dao::get_listado_reserva_mes_en_curso();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_reserva($seleccion);
		$this->cn()->set_cursor_dt_reserva($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__cancelar($seleccion)
	{
		$this->cn()->cargar_dr_reserva($seleccion);
		$this->cn()->set_cursor_dt_reserva($seleccion);
		$this->set_pantalla('pant_cancelar');

	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_historial -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_historial(ei_cuadro_administrar_reserva $cuadro)
	{
		$cuadro->colapsar();
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_reserva_historial($this->s__where);
		}else{
			$datos = dao::get_listado_reserva_historial();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_historial__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_reserva($seleccion);
		$this->cn()->set_cursor_dt_reserva($seleccion);
		$this->set_pantalla('pant_edicion');
	}
	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__where=$filtro->get_sql_where();
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_reserva())
		{
			$datos = $this->cn()->get_dt_reserva();

			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_reserva())
		{
			$this->cn()->set_dt_reserva($datos);

		} else {
			$this->cn()->agregar_dt_reserva($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_detalle_pago -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_detalle_pago(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_detalle_pago();
		$form_ml->set_datos($datos);

	}

	function evt__frm_detalle_pago__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_pago($datos);
	}

	function get_estados_segun_categoria()
	{
		return dao::get_listado_estado('RESERVA');

	}		

	function get_estado_cancelada_segun_categoria()
	{
		return dao::get_listado_estado_cancelado_reserva('RESERVA');

	}	

	
	function get_motivos_segun_categoria($idafiliacion)
	{
		$where  = ' afiliacion.idafiliacion = '.$idafiliacion; 
		return dao::get_motivo_por_tipo_socio($where);
	}




	//-----------------------------------------------------------------------------------
	//---- frm_cancelar -----------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_cancelar(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_reserva())
		{
			$datos = $this->cn()->get_dt_reserva();
			
			$form->set_datos($datos);
		}
	}

	function evt__frm_cancelar__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_reserva())
		{
			toba::notificacion()->agregar("La reserva ha sido cancelada, la fecha queda liberada para futuras reservas.",'info');

			$this->cn()->set_dt_reserva($datos);
		} else {
			$this->cn()->agregar_dt_reserva($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_modificacion_monto --------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_modificacion_monto(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_detalle_modificacion_monto();
		$form_ml->set_datos($datos);

	}

	function evt__frm_ml_detalle_modificacion_monto__modificacion($datos)
	{
		$this->cn()->procesar_detalle_modificacion_monto($datos);
	}



}
?>