<?php
class ci_socios_pestanias extends mupum_ci
{

	function get_cn()
	{
		return $this->controlador->cn();
	}
	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf()
	{
		if ($this->get_cn()->hay_cursor_dt_persona())
		{
			$datos = $this->get_cn()->get_dt_persona_sin_blob();
			$titulo = $datos['apellido'].', ' .$datos['nombres'] ; 
			$titulo = '&nbsp;<font color= #fffcfc ><strong>Afiliado: ' . $titulo.'</strong></font></br>' .
			   		  '&nbsp;<font color= #fffcfc ><strong>  Legajo: ' . $datos['legajo'].'</strong></font></br>' ;         
            $this->set_titulo($titulo);
		}
	
	}
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		
		try{
				$this->get_cn()->guardar_dr_socio();
				toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
				
			} catch( toba_error_db $error){
			$sql_state= $error->get_sqlstate();
			
			if($sql_state=='db_23503')
			{
				toba::notificacion()->agregar("La persona esta siendo referenciado, no puede eliminarlo",'error');
				
			} 

			$mensaje_log= $error->get_mensaje_log();
			if(strstr($mensaje_log,'idx_documento'))
			{
				toba::notificacion()->agregar("La persona ya esta registrada.",'info');
				
			} 		

			if(strstr($mensaje_log,'idx_legajo'))
			{
				toba::notificacion()->agregar("El socio ya esta registrado.",'info');
				
			} 		

			if(strstr($mensaje_log,'idx_afiliacion'))
			{
				toba::notificacion()->agregar("El socio no puede tener mas de una afiliacion activa.",'info');
				
			} 
			if ($this->get_cn()->hay_cursor_dt_afiliacion())
			{
				$this->get_cn()->resetear_cursor_dt_afiliacion();

			}
			
		}
		
	}

	function evt__cancelar()
	{
		$this->get_cn()->resetear_dr_socio();
		$this->controlador()->set_pantalla('pant_inicial');
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if ($this->get_cn()->hay_cursor_dt_persona())
		{
			$datos = $this->get_cn()->get_dt_persona();
		
			$form->set_datos($datos);
		}
	}

	function evt__frm__modificacion($datos)
	{
		if ($this->get_cn()->hay_cursor_dt_persona())
		{
			$this->get_cn()->set_dt_persona($datos);
		} else {
			$this->get_cn()->agregar_dt_persona($datos);
		}
	}


	//-----------------------------------------------------------------------------------
	//---- frm_ml_familia ---------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_familia(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->get_cn()->get_dt_familia();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_familia__modificacion($datos)
	{
		
		$this->get_cn()->procesar_dt_familia($datos);
	}	

	//-----------------------------------------------------------------------------------
	//---- frm_ml_telefonos -------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_ml_telefonos(mupum_ei_formulario_ml $form_ml)
	{
		$datos = $this->get_cn()->get_dt_telefono_por_persona();
		$form_ml->set_datos($datos);
	}

	function evt__frm_ml_telefonos__modificacion($datos)
	{
		$this->get_cn()->procesar_dt_telefono_por_persona($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		$persona = $this->get_cn()->get_dt_persona();
		$where = ' persona.idpersona ='.$persona['idpersona'];
		$datos = dao::get_listado_reserva($where);
		if (isset($datos))
		{
			$cuadro->set_datos($datos);
		}
	}

	//-----------------------------------------------------------------------------------
	//---- frm_solicitud_reempadronamiento ----------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_solicitud_reempadronamiento(mupum_ei_formulario $form)
	{
		if ($this->get_cn()->hay_cursor_dt_persona())
		{
			$datos = $this->get_cn()->get_dt_persona();
			$dato = dao::get_solicitud_reempadronamiento_no_atenida($datos['idpersona']);
			
			if ($dato != null)
			{
				$solicitud['idreempadronamiento'] = $dato[0]['idreempadronamiento'];
				$solicitud['idafiliacion'] = $dato[0]['idafiliacion'];
				$this->cn()->set_cursor_dt_solicitud_reempadronamiento($solicitud);			
				$datos = $this->cn()->get_dt_solicitud_reempadronamiento();			
				$form->set_datos($datos);
			} 
			
		}
	}

	function evt__frm_solicitud_reempadronamiento__modificacion($datos)
	{
		$this->cn()->set_dt_solicitud_reempadronamiento($datos);
	}

	function conf__pant_datos_personales(toba_ei_pantalla $pantalla)
	{
		if ($this->get_cn()->hay_cursor_dt_persona())
		{
			$datos = $this->get_cn()->get_dt_persona_sin_blob();
			$dato = dao::get_solicitud_reempadronamiento_no_atenida($datos['idpersona']);
			
			if ($dato!=null)
			{
				if ($dato[0]['notificaciones']==0)
				{
					$pantalla->eliminar_dep('frm_solicitud_reempadronamiento');	
				}
			} else {
				$pantalla->eliminar_dep('frm_solicitud_reempadronamiento');	
			}
		}	
	}
}
?>