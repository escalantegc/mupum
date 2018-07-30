<?php
require_once('dao.php');
class ci_consumo_por_ticket extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{

		try{
			$this->cn()->guardar_dr_consumo_ticket();
			if (!toba::notificacion()->verificar_mensajes())
			{
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			}
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El consumo por ticket  esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_consumo_ticket'))
			{
				toba::notificacion()->agregar("El consumo del ticket ya esta registrado.",'info');
				
			}  else {

				toba::notificacion()->agregar($mensaje_log,'error');
			}
			
		}
		$this->cn()->resetear_dr_consumo_ticket();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_consumo_ticket();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__planilla()
	{
		$this->set_pantalla('pant_planilla');
	}


	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_consumos_ticket($this->s__where);
		}else{
			$datos = dao::get_listado_consumos_ticket();
		}
		
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_consumo_ticket($seleccion);
		$this->cn()->set_cursor_dt_consumo_ticket($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_consumo_ticket($seleccion);
		$this->cn()->eliminar_dt_consumo_ticket($seleccion);
		try{
			$this->cn()->guardar_dr_parametros();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El consumo del bono esta siendo referenciado, no puede eliminarlo",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_parametros();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__where = $filtro->get_sql_where();
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
		if ($this->cn()->hay_cursor_dt_consumo_ticket())
		{
			$datos = $this->cn()->get_dt_consumo_ticket();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_consumo_ticket())
		{
			$this->cn()->set_dt_consumo_ticket($datos);
		} else {
			$this->cn()->agregar_dt_consumo_ticket($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_consumo_ticket ------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_consumo_ticket(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_detalle_consumo_ticket();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_detalle_consumo_ticket__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_consumo_ticket($datos);
	}


	//-----------------------------------------------------------------------------------
	//---- frm_ml_cabecera --------------------------------------------------------------
	//-----------------------------------------------------------------------------------
	function evt__frm_ml_cabecera__modificacion($datos)
	{
		$this->cn()->procesar_dt_consumo_ticket($datos);
	}


}
?>