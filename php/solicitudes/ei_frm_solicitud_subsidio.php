<?php
class ei_frm_solicitud_subsidio extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Validacion de EFs -----------------------------------
		
			
		
		{$this->objeto_js}.evt__cantidad__validar = function()
		{
			cantidad = this.ef('cantidad').get_estado();
			limite = this.ef('limite').get_estado();
			if (cantidad >= limite)
			{
				this.ef('cantidad').set_error('Usted ya pidio la cantidad de veces permitidas para el tipo de subsidio.');
				return false;
			}
			return true;
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__monto__procesar = function(es_inicial)
		{
			this.ef('monto').desactivar();
		}
		";
	}


}
?>