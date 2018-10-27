<?php
class ei_frm_ml_detalle_consumo_ticket extends mupum_ei_formulario_ml
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
			total = this.controlador.dep('frm').ef('total').get_estado();
			total_filas = this.total('monto');

			if (total_filas > total)
			{
				alert('El total del detalle de pago supera el total del consumo por ticket, por favor controle los valores de los detalles.');
				return false;
			} else {
				return true;	
			}
		}
		
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__monto__procesar = function(es_inicial, fila)
		{
			total = this.controlador.dep('frm').ef('total').get_estado();

			total_filas = this.total('monto');
	
			if (total_filas > total)
			{
				alert('El total de detalle de tickets supera a monto total del consumo, por favor controle los valores de los tickets del consumo.');
				this.ef('monto').ir_a_fila(fila).resetear_estado();
			}
		}

		
		";
	}

}

?>