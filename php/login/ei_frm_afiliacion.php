<?php
class ei_frm_afiliacion extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fecha_solicitud__procesar = function(es_inicial)
		{
			var hoy = new Date();
			var mes = hoy.getMonth()+1;
			var dia = hoy.getDate();
			var anio = hoy.getFullYear();
			fecha = dia + '/' + mes + '/' + anio;

			this.ef('fecha_solicitud').set_estado(fecha);
		}
		";
	}

}

?>