<?php
class ei_frm_aceptar_bolsita extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fecha_solicitud__procesar = function(es_inicial)
		{
		}
		
		{$this->objeto_js}.evt__fecha_entrega__procesar = function(es_inicial)
		{
				var inicio = this.ef('fecha_solicitud').fecha();
			var fin = this.ef('fecha_entrega').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(fin < inicio )
						{
							alert('La fecha entrega no puede ser menor a la fecha solicitud');
							this.ef('fecha_entrega').resetear_estado();
						} 
					}
				}
			}	
		}
		";
	}

}

?>