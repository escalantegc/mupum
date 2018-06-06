<?php
class ei_frm_solicitud_reserva extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		$fecha = $this->controlador()->get_fecha_seleccionada();
		echo "
		//---- Procesamiento de EFs --------------------------------
		var fecha = $fecha;
		{$this->objeto_js}.evt__fecha__procesar = function(es_inicial)
		{
			
			if (es_inicial) {
				if (fecha!= null) {
					this.ef('fecha').set_estado(fecha);
					
				}
			}
		}
		";
	}

}
?>