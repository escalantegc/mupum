<?php
class ei_frm_ml_comercios_por_convenios extends mupum_ei_formulario_ml
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
			var filas = this.filas();
			 for (id_fila in filas) {
			     if (this.controlador.dep('frm').ef('maneja_bono').chequeado())		
				{
					this.mostrar_boton_fila(id_fila, 'cargar_talonario');
				} else {
					this.ocultar_boton_fila(id_fila, 'cargar_talonario');
					
				}
			 }
		
			
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__fecha_inicio__procesar = function(es_inicial, fila)
		{

			var inicio_convenio = this.controlador.dep('frm').ef('fecha_inicio').fecha();
			var fin_convenio = this.controlador.dep('frm').ef('fecha_fin').fecha();	

			var inicio = this.ef('fecha_inicio').ir_a_fila(fila).fecha();
			var fin = this.ef('fecha_fin').ir_a_fila(fila).fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(inicio > fin)
						{
							alert('La fecha inicio no puede ser mayor a la fecha fin.');
							this.ef('fecha_fin').ir_a_fila(fila).resetear_estado();
							this.ef('fecha_inicio').ir_a_fila(fila).resetear_estado();
						} 
					}
					if (inicio_convenio != null)
						{
							if (fin_convenio != null)
							{
								if(inicio < inicio_convenio)
								{
									alert('La fecha inicio no puede ser menor a la fecha de inicio del convenio.');
									this.ef('fecha_inicio').ir_a_fila(fila).resetear_estado();
								} 							

								if(inicio > fin_convenio)
								{
									alert('La fecha inicio no puede ser mayor a la fecha de fin del convenio.');
									this.ef('fecha_inicio').ir_a_fila(fila).resetear_estado();
								} 

								
				
							}
						}
				}


		
			}
		}
		
		{$this->objeto_js}.evt__fecha_fin__procesar = function(es_inicial, fila)
		{

			var inicio_convenio = this.controlador.dep('frm').ef('fecha_inicio').fecha();
			var fin_convenio = this.controlador.dep('frm').ef('fecha_fin').fecha();			

			var inicio = this.ef('fecha_inicio').ir_a_fila(fila).fecha();
			var fin = this.ef('fecha_fin').ir_a_fila(fila).fecha();
			if (!es_inicial)
			{
				if (inicio != null)
				{
					if (fin != null)
					{
						if(fin < inicio)
						{
							alert('La fecha fin no puede ser menor a la fecha inicio de inicio');
							this.ef('fecha_fin').ir_a_fila(fila).resetear_estado();
							this.ef('fecha_inicio').ir_a_fila(fila).resetear_estado();
						} 

						if (inicio_convenio != null)
						{
							if (fin_convenio != null)
							{
								if(fin > fin_convenio)
								{
									alert('La fecha fin no puede ser mayor a la fecha de fin del convenio.');
									this.ef('fecha_fin').ir_a_fila(fila).resetear_estado();
								} 							

								if(fin < inicio_convenio)
								{
									alert('La fecha fin no puede ser menor a la fecha de inicio del convenio.');
									this.ef('fecha_fin').ir_a_fila(fila).resetear_estado();
								} 

								
				
							}
						}
					}
				}
			}
		}
		";
	}



}
?>