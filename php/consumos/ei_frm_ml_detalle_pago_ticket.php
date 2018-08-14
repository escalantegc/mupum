<?php
class ei_frm_ml_detalle_pago_ticket extends mupum_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__monto__procesar = function(es_inicial, fila)
		{
			total = this.controlador.dep('frm').ef('total').get_estado();

			total_filas = this.total('monto');
	
			if (total_filas > total)
			{
				alert('El total del detalle supera a monto total del consumo, por favor controle los valores de los detalles.');
				this.ef('monto').ir_a_fila(fila).resetear_estado();
			}

		}
		";
	}

}

?>