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
		
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__envio_descuento__procesar = function(es_inicial, fila)
		{
			if (this.ef('envio_descuento').ir_a_fila(fila).chequeado())
			{
				this.ef('idforma_pago').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('monto').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('idconcepto').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('fecha').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('descripcion').ir_a_fila(fila).set_solo_lectura(true);
			} else {
				this.ef('idforma_pago').ir_a_fila(fila).set_solo_lectura(false);
				this.ef('monto').ir_a_fila(fila).set_solo_lectura(false);
				this.ef('idconcepto').ir_a_fila(fila).set_solo_lectura(false);
				this.ef('fecha').ir_a_fila(fila).set_solo_lectura(false);
				this.ef('descripcion').ir_a_fila(fila).set_solo_lectura(false);
			}

		}
		";
	}

}
?>