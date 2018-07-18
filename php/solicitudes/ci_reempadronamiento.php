<?php
require_once('dao.php');
class ci_reempadronamiento extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		try{
			$this->cn()->guardar_dr_reempadronamiento();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El reempadronamiento esta siendo referenciado, no puede eliminarla",'error');
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_reempadronamiento'))
			{
				toba::notificacion()->agregar("La reempadronamiento ya esa registrado. ",'info');
			} 
			
		}
		$this->cn()->resetear_dr_reempadronamiento();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_reempadronamiento();
		$this->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_reempadronamiento($this->s__where);
		}else{
			$datos = dao::get_listado_reempadronamiento();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_reempadronamiento($seleccion);
		$this->cn()->set_cursor_dt_reempadronamiento($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_solicitudes -----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_solicitudes(mupum_ei_cuadro $cuadro)
	{
		$datos = dao::get_listado_solicitudes_reempadronamientos();
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_solicitudes__notificar($datos)
	{
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro_solicitudes_enviadas --------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro_solicitudes_enviadas(mupum_ei_cuadro $cuadro)
	{
	
		$datos = dao::get_listado_solicitudes_reempadronamientos_enviadas();
		$cuadro->set_datos($datos);
	}

	function evt__cuadro_solicitudes_enviadas__notificar($seleccion)
	{
		ei_arbol($seleccion);
	}
	function evt__cuadro_solicitudes__enviar($datos)
	{
		ei_arbol($datos);
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
		if ($this->cn()->hay_cursor_dt_reempadronamiento())
		{
			$datos = $this->cn()->get_dt_reempadronamiento();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_reempadronamiento())
		{
			$this->cn()->set_dt_reempadronamiento($datos);
		} else {
			$this->cn()->agregar_dt_reempadronamiento($datos);
		}
	}



	//-----------------------------------------------------------------------------------
	//---- frm_solicitudes --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_solicitudes(mupum_ei_formulario $form)
	{
	}

	function evt__frm_solicitudes__notificar($datos)
	{
		$idafiliaciones =  explode(",", $datos['idafiliacion']);
		$reempadronamiento =  $this->cn()->get_dt_reempadronamiento();
		foreach ($idafiliaciones as $idafiliacion) 
		{
			$condicion['idafiliacion'] = $idafiliacion['idafiliacion'] ;
			$condicion['idreempadronamiento'] = $reempadronamiento['idreempadronamiento'] ;
			$this->cn()->set_cursor_dt_solicitud_reempadronamiento($condicion);
			$datos = $condicion;
			$datos['notificaciones'] += 1;
			$datos['fecha_notificacion'] = date('d-m-Y');
			$this->cn()->set_dt_solicitud_reempadronamiento($datos);
		}
		
	}



}
?>