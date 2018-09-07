<?php
class ei_frm_configuracion_colonia extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__inicio__procesar = function(es_inicial)
		{

			var inicio = this.ef('inicio').fecha();
			var fin = this.ef('fin').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(inicio > fin)
						{
							alert('La fecha inicio no puede ser mayor a la fecha fin de colonia.');
							this.ef('fin').resetear_estado();
							this.ef('inicio').resetear_estado();
						} 

					}
				}

			}
		}
		
		{$this->objeto_js}.evt__fin__procesar = function(es_inicial)
		{
			var inicio = this.ef('inicio').fecha();
			var fin = this.ef('fin').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(fin < inicio)
						{
							alert('La fecha fin no puede ser menor a la fecha inicio de inicio de colonia');
							this.ef('fin').resetear_estado();
							this.ef('inicio').resetear_estado();
						} 
					}
				}
			}	
		}
		
		{$this->objeto_js}.evt__inicio_inscripcion__procesar = function(es_inicial)
		{
			var inicio = this.ef('inicio_inscripcion').fecha();
			var fin = this.ef('fin_inscripcion').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(inicio > fin)
						{
							alert('La fecha inicio  no puede ser mayor a la fecha fin de fin de inscripcion.');
							this.ef('fin_inscripcion').resetear_estado();
							this.ef('inicio_inscripcion').resetear_estado();
						} 
					}
				}
			}
		}
		
		{$this->objeto_js}.evt__fin_inscripcion__procesar = function(es_inicial)
		{
			var inicio = this.ef('inicio_inscripcion').fecha();
			var fin = this.ef('fin_inscripcion').fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(fin < inicio)
						{
							alert('La fecha fin no puede ser menor a la fecha inicio de inscripcion.');
							this.ef('fin_inscripcion').resetear_estado();
							this.ef('inicio_inscripcion').resetear_estado();
						}	
					}
				}
			}	
		}
		";
	}

}

?>