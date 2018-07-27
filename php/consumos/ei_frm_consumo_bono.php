<?php
class ei_frm_consumo_bono extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		
		{$this->objeto_js}.evt__nro_bono__procesar = function(es_inicial)
		{
			numeros = this.ef('nro_bono').get_estado();
			this.ef('cantidad_bonos').set_estado(numeros.length); 
		}
		";
	}

}

?>