<?php
class ei_frm_consumo_edicion extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__cantidad_bonos__procesar = function(es_inicial)
		{
			cantidad = this.ef('cantidad_bonos').get_estado();
			monto_bono = this.ef('monto_bono').get_estado();
			total = cantidad * monto_bono;
			this.ef('total').set_estado(total);
		}
		";
	}

}

?>