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
		{$this->objeto_js}.ini = function () 
		{
			if (this.ef('valor').get_estado()!='')
			{
				this.ef('valor').desactivar();	
			}
			if (this.ef('porcentaje_inscripcion').get_estado()!='')
			{
				this.ef('porcentaje_inscripcion').desactivar();	
			}
		}
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
		

		
		{$this->objeto_js}.evt__porcentaje_inscripcion__procesar = function(es_inicial)
		{	
		
			if (this.ef('porcentaje_inscripcion').get_estado()!='')
			{
				this.ef('porcentaje_inscripcion').set_solo_lectura(true);	
			}
			
		
		}
			
		{$this->objeto_js}.evt__monto__procesar = function(es_inicial)
		{
			if (this.ef('monto').get_estado()!='')
			{
				this.ef('monto').set_solo_lectura(true);		
			}
		}
		
		{$this->objeto_js}.evt__monto_inscripcion__procesar = function(es_inicial)
		{
			if (this.ef('monto_inscripcion').get_estado()!='')
			{
				this.ef('monto_inscripcion').set_solo_lectura(true);		
			}
		}
		";
	}




}
?>