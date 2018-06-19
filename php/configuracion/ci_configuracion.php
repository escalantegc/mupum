<?php
class ci_configuracion extends mupum_ci
{
		//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf()
	{
		$this->cn()->cargar_dt_configuracion();
	}

	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
		
		try{
			$this->cn()->guardar_dr_configuracion();
			toba::notificacion()->agregar("Los datos se han guardado correctamente",'info');
		} catch( toba_error_db $error) 
		{
			$mensaje = $error->get_mensaje();
			toba::notificacion()->agregar($mensaje,'error');
			
		}
		$this->cn()->resetear_dr_configuracion();
	}

	function evt__cancelar()
	{
		$this->cn()->resetear_dr_configuracion();
	}

	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		$datos = $this->cn()->get_dt_configuracion();
		$form->set_datos($datos);
	}

	function evt__frm__modificacion($datos)
	{
		$this->cn()->set_dt_configuracion($datos);
	}

}

?>