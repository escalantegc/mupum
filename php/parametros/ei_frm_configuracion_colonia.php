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
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__hora_salida__procesar = function(es_inicial)
		{
			var llegada = this.ef('hora_llegada').hora();
			var salida = this.ef('hora_salida').hora();
			if (!es_inicial)
			{
				if (llegada != null)
				{
					if (salida != null)
					{
						if(salida > llegada)
						{
							alert('La hora de llegada  no puede ser mayor a la hora de salida.');
							this.ef('hora_salida').resetear_estado();
							this.ef('hora_llegada').resetear_estado();
						} 
					}
				}
			}
		}
		
		{$this->objeto_js}.evt__hora_llegada__procesar = function(es_inicial)
		{
			var llegada = this.ef('hora_llegada').hora();
			var salida = this.ef('hora_salida').hora();
			
			if (!es_inicial)
			{
				if (llegada != null)
				{
					if (salida != null)
					{
						if(llegada < salida )
						{
							alert('La hora de llegada  no puede ser menor a la hora de salida.');
							this.ef('hora_salida').resetear_estado();
							this.ef('hora_llegada').resetear_estado();
						} 
					}
				}
			}
		}

		{$this->objeto_js}.ini = function () {
		

			this.ef('direccion').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('direccion');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
		
		}
		";
	}


}
?>