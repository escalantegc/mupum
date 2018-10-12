<?php
class ei_frm_rechazar_bolsita extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		

		{$this->objeto_js}.evt__fecha_rechazo__procesar = function(es_inicial)
		{
			var inicio = this.ef('fecha_solicitud').fecha();
			var fin = this.ef('fecha_rechazo').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(fin < inicio )
						{
							alert('La fecha rechazo no puede ser menor a la fecha solicitud');
							this.ef('fecha_rechazo').resetear_estado();
						} 
					}
				}
			}	
		}
		";
	}

}

?>