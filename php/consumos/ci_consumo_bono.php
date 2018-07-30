<?php
require_once('dao.php');
class ci_consumo_bono extends mupum_ci
{
	protected $s__idtalonario;
	protected $s__cantidad;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		
		try{
			$this->cn()->guardar_dr_consumo_bono();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El consumo del bono  esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_consumo'))
			{
				toba::notificacion()->agregar("El consumo del bono esta registrado.",'info');
				
			} 
			
		}
		$this->cn()->resetear_dr_consumo_bono();
		$this->set_pantalla('pant_inicial');
	
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_consumo_bono();
		$this->set_pantalla('pant_inicial');
		unset($this->s__cantidad);
		unset($this->s__idtalonario);
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_alta');
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_consumos_bono($this->s__where);
		}else{
			$datos = dao::get_listado_consumos_bono();
		}
		
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_consumo_bono_propio($seleccion);
		$this->cn()->set_cursor_dt_consumo_bono_propio($seleccion);
		$this->set_pantalla('pant_edicion');
	}


	function evt__cuadro__borrar($seleccion)
	{
		/*$this->cn()->cargar_dr_consumo_bono_propio($seleccion);
		$this->cn()->eliminar_dt_consumo_bono_propio($seleccion);
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
		$this->set_pantalla('pant_inicial');*/
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
		if ($this->cn()->hay_cursor_dt_consumo_bono())
		{
			$datos = $this->cn()->get_dt_consumo_bono();
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		
		if ($this->cn()->hay_cursor_dt_consumo_bono())
		{
			$this->cn()->set_dt_consumo_bono($datos);
		} else {
			//--$this->s__idtalonario = $datos['idtalonario_bono'];
			//--$this->s__cantidad= $datos['cantidad_bonos'];
			$this->cn()->agregar_dt_consumo_bono($datos);
		}
		$numeros = array();
		foreach ($datos['nro_bono'] as $bono) 
		{
			$id['nro_bono'] = $bono;
			$id['idtalonario_bono'] = $datos['idtalonario_bono'];
			

			$this->cn()->cargar_dt_talonario_nros_bonos($id);
			$this->cn()->set_cursor_dt_talonario_nros_bono($id);
			$numero['nro_bono'] = $bono;
			$numero['idtalonario_bono'] = $datos['idtalonario_bono'];
			$numero['idafiliacion'] = $datos['idafiliacion'];
			$numero['disponible'] ='f';
			$this->cn()->set_dt_talonario_nros_bono($numero);
			$this->cn()->resetear_cursor_dt_talonario_nros_bono();
			try{
				$this->cn()->guardar_dr_consumo_bono();
			
			} catch( toba_error_db $error){
			$mensaje_log= $error->get_mensaje_log();
				if(strstr($mensaje_log,'idx_consumo'))
				{
					toba::notificacion()->agregar("El consumo del bono esta registrado.",'info');
					
				} 
			
			}
			$this->cn()->resetear_dt_talonario_nros_bono();
			$id = null;
			$numero = null;

		}

		
	
		
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_nros_bonos ------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_nros_bonos(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_talonario_nros_bonos_propio();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_nros_bonos__modificacion($datos)
	{
		$this->cn()->procesar_dt_talonario_nros_bono_propio($datos);
	}


	//-----------------------------------------------------------------------------------
	//---- frm_edicion ------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_edicion(ei_frm_consumo_bono $form)
	{
		if ($this->cn()->hay_cursor_dt_consumo_bono_propio())
		{

			$datos = $this->cn()->get_dt_consumo_bono_propio();
			$consumo = dao::get_listado_consumos_bono('consumo_bonos.idconsumo_bono ='.$datos['idconsumo_bono']);
			$datos['total'] = $consumo[0]['total'];
			$form->set_datos($datos);
		}
	}

	function evt__frm_edicion__modificacion($datos)
	{

		if ($this->cn()->hay_cursor_dt_consumo_bono_propio())
		{
			$this->cn()->set_dt_consumo_bono_propio($datos);
		} else {
			//--$this->s__idtalonario = $datos['idtalonario_bono'];
			//--$this->s__cantidad= $datos['cantidad_bonos'];
			$this->cn()->agregar_dt_consumo_bono_propio($datos);
		}
	}

}
?>