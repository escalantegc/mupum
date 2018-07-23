<?php
class ei_frm_talonario_bono extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__nro_inicio__procesar = function(es_inicial)
		{
			inicio = this.ef('nro_inicio').get_estado();
			fin = this.ef('nro_fin').get_estado();
			if (inicio!='') 
			{
				if (fin!='') 
				{
					if (inicio > fin )
					{
						alert('El numero de inicio no puede ser mayor al numero de fin del talonario');
						this.ef('nro_inicio').resetear_estado();
					}					

					if (inicio == fin )
					{
						alert('El numero de inicio no puede ser igual al numero de fin del talonario');
						this.ef('nro_inicio').resetear_estado();
					}
					
				}	
			}
		

		}
		
		{$this->objeto_js}.evt__nro_fin__procesar = function(es_inicial)
		{
			inicio = this.ef('nro_inicio').get_estado();
			fin = this.ef('nro_fin').get_estado();
			if (inicio!='') 
			{
				if (fin!='') 
				{
					if (fin < inicio )
					{
						alert('El numero de fin no puede ser menor al numero de inicio del talonario');
						this.ef('nro_fin').resetear_estado();
					}
					if (inicio == fin )
					{
						alert('El numero de inicio no puede ser igual al numero de fin del talonario');
						this.ef('nro_inicio').resetear_estado();
					}
					
				}	
			}
		}
		";
	}

}

?>