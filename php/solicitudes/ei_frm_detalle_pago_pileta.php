<?php
class ei_frm_detalle_pago_pileta extends mupum_ei_formulario_ml
{
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
				alert('El total del detalle de pago supera a monto total de la inscripcion, por favor controle los valores de los detalles.');
				this.ef('monto').ir_a_fila(fila).resetear_estado();
			}
		}
		
		";
	}
}

?>