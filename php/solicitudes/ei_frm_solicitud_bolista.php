<?php
class ei_frm_solicitud_bolista extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
			
		
		//---- Validacion de EFs -----------------------------------
		
		{$this->objeto_js}.evt__edad__validar = function()
		{
			minima = this.ef('minima').get_estado();
			maxima = this.ef('maxima').get_estado();
			edad = this.ef('edad').get_estado();
			if (minima!='')
			{	
				if (edad < minima)
				{
					this.ef('edad').set_error('La edad del familiar no respeta la minima permitida por el nivel seleccionado.');
					return false;
				} else {
					return true;
				}
				
			}
			if (maxima!='')
			{
				if (edad > maxima)
				{
					this.ef('edad').set_error('La edad del familiar no respeta la maxima permitida por el nivel seleccionado.');
					return false;
				} else {
					return true;		
				}
			}
		}
		";
	}



}
?>