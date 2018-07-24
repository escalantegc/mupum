<?php
class ei_frm_solicitud_reempadronamiento extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__atendida__procesar = function(es_inicial)
		{
			if (this.ef('atendida').get_estado()==1)
			{
				res = confirm('Esta seguro de confirmar el reempadronamiento?');
				if (res == false)
				{
					this.ef('atendida').resetear_estado();
				}
			} 
		}
		";
	}

}

?>