<?php
class eI_frm_ml_grupo_familiar extends mupum_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__edad__procesar = function(es_inicial, fila)
		{
			var edad = this.ef('edad').ir_a_fila(fila).get_estado();
		this.ef('edad').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('costo_extra').ir_a_fila(fila).set_solo_lectura(true);
			var costo_extra = 0;
			if (edad > 21)
			{	
				costo_extra = this.controlador.dep('frm').ef('costo_por_mayor').get_estado();
				this.ef('costo_extra').ir_a_fila(fila).set_estado(costo_extra);
				this.ef('edad').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('costo_extra').ir_a_fila(fila).set_solo_lectura(true);

			} else {
				this.ef('costo_extra').ir_a_fila(fila).set_estado(costo_extra);
			
			}

			var total = this.total('costo_extra');
			var costo_grupo = this.controlador.dep('frm').ef('costo_grupo_familiar').get_estado();
			var totalisimo = total + costo_grupo;
			this.controlador.dep('frm').ef('total').set_estado(totalisimo);
			this.controlador.dep('frm').ef('adicional_mayores_edad').set_estado(total);
		}
		";
	}

}

?>