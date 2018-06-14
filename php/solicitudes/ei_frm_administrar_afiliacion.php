<?php
class ei_frm_administrar_afiliacion extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__activa__procesar = function(es_inicial)
		{
			alert(this.ef('activa').get_estado());
			if (this.ef('activa').chequeado())
			{
				this.ef('solicitada').resetear_estado() ;
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__solicitada__procesar = function(es_inicial)
		{
			if (this.ef('solicitada').chequeado())
			{
				this.ef('activa').resetear_estado() ;
			}
		}
		";
	}


}
?>