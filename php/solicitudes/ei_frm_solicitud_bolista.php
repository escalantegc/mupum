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
			{	if (maxima!='')
				{	
					if (edad >= minima && edad <= maxima)
					{
						this.ef('edad').resetear_error();
						return true;
						
					} else {
						this.ef('edad').set_error('La edad del familiar no respeta el rango de edades permitido.');
						return false;
					}
					
				}
			}
		}
		";
	}



}
?>