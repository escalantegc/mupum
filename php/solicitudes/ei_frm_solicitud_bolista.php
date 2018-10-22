<?php
class ei_frm_solicitud_bolista extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
			
	
		
		
		//---- Validacion general ----------------------------------
		
		{$this->objeto_js}.evt__validar_datos = function()
		{
			minima = this.ef('minima').get_estado();
			maxima = this.ef('maxima').get_estado();
			edad = this.ef('edad').get_estado();
			if (minima!='')
			{	if (maxima!='')
				{	
					if (edad >= minima && edad <= maxima)
					{
						return true;
						
					} else {
						alert('La edad del familiar no respeta el rango de edades permitido.');
						this.ef('edad').resetear_estado();
						this.ef('idpersona_familia').resetear_estado();
						return false;
					}
					
				}
			}
		}
		";
	}






}
?>