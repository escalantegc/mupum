<?php
class ei_frm_ml_detalle_ayuda extends mupum_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idforma_pago__procesar = function(es_inicial, fila)
		{
			var idfp = new Array();
			idfp[1] = this.ef('idforma_pago').ir_a_fila(fila).get_estado();
			idfp[2] = fila;
			this.controlador.ajax('es_planilla', idfp, this, this.mostrar_campos); 	
				
		}

		{$this->objeto_js}.mostrar_campos = function(datos)
		{    
			var planilla = (datos['planilla']);
			var fila =  (datos['fila']);         
			if (planilla=='no')
			{
				this.ef('cuota_pagada').ir_a_fila(fila).mostrar();
				this.ef('fecha_pago').ir_a_fila(fila).mostrar();
				this.ef('cuota_pagada').ir_a_fila(fila).chequear();
				this.ef('cuota_pagada').ir_a_fila(fila).set_solo_lectura(true);

				var hoy = new Date();
				var hoy_texto = hoy.getDate() + '/' + (hoy.getMonth() +1)  + '/' + hoy.getFullYear();
				
				this.ef('fecha_pago').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('fecha_pago').ir_a_fila(fila).set_estado(hoy_texto);
			} else {
				this.ef('cuota_pagada').ir_a_fila(fila).ocultar();
				this.ef('fecha_pago').ir_a_fila(fila).ocultar();				
				this.ef('cuota_pagada').ir_a_fila(fila).resetear_estado();
				this.ef('fecha_pago').ir_a_fila(fila).resetear_estado();
			}            
		}
		";
	}

}

?>