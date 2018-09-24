<?php
require_once('dao.php');
class ci_gastos_infraestructura extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		

		try{
			$this->cn()->guardar_dr_gastos();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
			
			
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			$mensaje_log= $error->get_mensaje_log();
			/*if(strstr($mensaje_log,'idx_consumo_convenio'))
			{
				toba::notificacion()->agregar("El consumo del ticket ya esta registrado.",'info');
				
			}  */
			
			toba::notificacion()->agregar($mensaje_log,'error');
			
			
		}
		$this->cn()->resetear_dr_gastos();
		$this->set_pantalla('pant_inicial');
	}

	function evt__cancelar()
	{
			$this->cn()->resetear_dr_gastos();
		$this->set_pantalla('pant_inicial');
	}

	function evt__nuevo()
	{
		$this->set_pantalla('pant_edicion');

	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_gasto_infraestructura($this->s__where);
			
		} else {
			$datos = dao::get_listado_gasto_infraestructura();
		}
		$cuadro->set_datos($datos);
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->cn()->cargar_dr_gastos($seleccion);
		$this->cn()->set_cursor_dt_gasto_infraestructura($seleccion);
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__borrar($seleccion)
	{
		$this->cn()->cargar_dr_gastos($seleccion);
		$this->cn()->eliminar_dt_gasto_infraestructura($seleccion);
		try{
			$this->cn()->guardar_dr_gastos();
				toba::notificacion()->agregar("Los datos se han borrado correctamente",'info');
		} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("El gasto de infraestructura esta siendo referenciado, no puede eliminarlo",'error');
				
			} 		
		}
		$this->cn()->resetear_dr_gastos();
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
	//---- frm_gasto --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_gasto(mupum_ei_formulario $form)
	{
		if ($this->cn()->hay_cursor_dt_gasto_infraestructura())
		{
			$datos = $this->cn()->get_dt_gasto_infraestructura();
			$form->set_datos($datos);
		}
	}

	function evt__frm_gasto__modificacion($datos)
	{
		if ($this->cn()->hay_cursor_dt_gasto_infraestructura())
		{
			$this->cn()->set_dt_gasto_infraestructura($datos);
		} else {
			$this->cn()->agregar_dt_gasto_infraestructura($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_ml_detalle_pago ----------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_detalle_pago(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->cn()->get_dt_detalle_pago();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_detalle_pago__modificacion($datos)
	{
		$this->cn()->procesar_dt_detalle_pago($datos);
	}


	function ajax__requiere_nro_comprobante($idfp, toba_ajax_respuesta $respuesta)
	{
		if ($idfp[1]!='nopar')
		{
			$fp = dao::get_listado_forma_pago('idforma_pago = '.$idfp[1]);	
		} else {
			$fp[0]['requiere_nro_comprobante']= 0;
		}
		
		
		$forma_pago['requiere'] = 'no';
		$forma_pago['fila'] = $idfp[2];
		if ($fp[0]['requiere_nro_comprobante']==1)
		{
			$forma_pago['requiere'] = 'si';
		}
		
		$respuesta->set($forma_pago);	
	}	

	function ajax__es_pago_proveedor($idconcepto, toba_ajax_respuesta $respuesta)
	{
		$fp = dao::get_listado_concepto('idconcepto = '.$idconcepto);
		
		$forma_pago['es'] = 'no';

		if ($fp[0]['proveedor']==1)
		{
			$forma_pago['es'] = 'si';
		}
		$respuesta->set($forma_pago);	
	}
}

?>