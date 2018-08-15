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
			
			cantidad = numeros.length;
			valor_bono = this.ef('monto_bono').get_estado();
			this.ef('cantidad_bonos').set_estado(cantidad); 
			this.ef('total').set_estado(cantidad * valor_bono); 
		}
		
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idtalonario_bono__procesar = function(es_inicial)
		{
		
				this.ef('cantidad_bonos').resetear_estado(); 
				this.ef('total').resetear_estado(); 
		

		}
		";
	}




}
?>