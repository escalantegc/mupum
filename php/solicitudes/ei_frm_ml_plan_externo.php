<?php
class ei_frm_ml_plan_externo extends mupum_ei_formulario_ml
{
	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
			
		{$this->objeto_js}.evt__inscripcion__procesar = function(es_inicial, fila)
		{
			if ( this.ef('nro_cuota').ir_a_fila(fila).get_estado()==1)
			{
				this.ef('inscripcion').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('inscripcion').ir_a_fila(fila).mostrar();
			} else {
				this.ef('inscripcion').ir_a_fila(fila).ocultar();	
			}
			 
		}
		";
	}
}

?>