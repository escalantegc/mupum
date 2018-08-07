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

		
		{$this->objeto_js}.evt__efectivo__procesar = function(es_inicial)
		{
			if (this.ef('efectivo').chequeado())
			{
				this.ef('monto_efectivo').mostrar();	
			} else {
				this.ef('monto_efectivo').resetear_estado();
				this.ef('monto_efectivo').ocultar();
			}
		}
		";
	}



}
?>