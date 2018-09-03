<?php
class ei_frm_inscripcion_colonia extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------

		{$this->objeto_js}.evt__es_alergico__procesar = function(es_inicial)
		{
			if (this.ef('es_alergico').chequeado())
			{
				this.ef('alergias').mostrar();
			} else {
				this.ef('alergias').resetear_estado();
				this.ef('alergias').ocultar();
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__valor__procesar = function(es_inicial)
		{
			this.ef('valor').desactivar();	
		}
		
		{$this->objeto_js}.evt__porcentaje_inscripcion__procesar = function(es_inicial)
		{
			this.ef('porcentaje_inscripcion').desactivar();	
		}
		
		{$this->objeto_js}.evt__inscripcion__procesar = function(es_inicial)
		{
			this.ef('inscripcion').desactivar();	
		}
		";
	}


}
?>