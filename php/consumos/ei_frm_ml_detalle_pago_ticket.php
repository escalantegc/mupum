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

		{$this->objeto_js}.crear_fila_orig = {$this->objeto_js}.crear_fila; 
		{$this->objeto_js}.crear_fila       = function() {
			
			var hoy = new Date();
			var hoy_texto = hoy.getDate() + '/' + (hoy.getMonth() +1)  + '/' + hoy.getFullYear();
			id_fila = this.crear_fila_orig();
			this.ef('fecha').ir_a_fila(id_fila).set_estado(hoy_texto);
		}

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
		";
	}

}

?>