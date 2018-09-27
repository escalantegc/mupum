<?php
class ei_frm_temporada_pileta extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		{$this->objeto_js}.ini = function () 
		{
			this.ef('descripcion').input().onchange = function() 
			{
				var ef = {$this->objeto_js}.ef('descripcion');
				var cadena = ef.get_estado().toUpperCase();
				ef.set_estado(cadena);
			}
		
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fecha_inicio__procesar = function(es_inicial)
		{
			var inicio = this.ef('fecha_inicio').fecha();
			var fin = this.ef('fecha_fin').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(inicio > fin)
						{
							alert('La fecha inicio no puede ser mayor a la fecha fin de la temporada.');
							this.ef('fecha_fin').resetear_estado();
							this.ef('fecha_inicio').resetear_estado();
						} 
					}
				}
			}
		}
		
		{$this->objeto_js}.evt__fecha_fin__procesar = function(es_inicial)
		{
			var inicio = this.ef('fecha_inicio').fecha();
			var fin = this.ef('fecha_fin').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(fin < inicio)
						{
							alert('La fecha fin no puede ser menor a la fecha inicio de la temporada.');
							this.ef('fecha_fin').resetear_estado();
							this.ef('fecha_inicio').resetear_estado();
						} 
					}
				}
			}
		}
		";
	}

}

?>