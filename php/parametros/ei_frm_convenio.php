<?php
class ei_frm_convenio extends mupum_ei_formulario
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.ini = function () {
		
			this.ef('titulo').input().onchange = function() 
			{
				var ef = {$this->objeto_js}.ef('titulo');
				var cadena = ef.get_estado().toUpperCase();
				ef.set_estado(cadena);
			}
		
		}
		{$this->objeto_js}.evt__permite_financiacion__procesar = function(es_inicial)
		{
			if (this.ef('permite_financiacion').chequeado())
			{
				this.ef('maximo_cuotas').mostrar();
				this.ef('permite_renovacion').mostrar();
				this.ef('ayuda_economica').mostrar();
			
			} else {
				this.ef('maximo_cuotas').resetear_estado();
				this.ef('permite_renovacion').resetear_estado();
				this.ef('maximo_cuotas').ocultar();
				this.ef('permite_renovacion').ocultar();
				this.ef('ayuda_economica').resetear_estado();
				this.ef('ayuda_economica').ocultar();
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__permite_renovacion__procesar = function(es_inicial)
		{
			if (this.ef('permite_renovacion').chequeado())
			{
				this.ef('faltando_cuotas').mostrar();
			} else {
				this.ef('faltando_cuotas').ocultar();
				this.ef('faltando_cuotas').resetear_estado();
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__maximo_cuotas__procesar = function(es_inicial)
		{
			var faltando = this.ef('faltando_cuotas').get_estado();
			var maximo_cuotas = this.ef('maximo_cuotas').get_estado();
		
			if (this.ef('permite_renovacion').chequeado())
			{
				if (faltando!='')
				{
					if(maximo_cuotas!='')
					{
						if (maximo_cuotas < faltando)
						{
							alert('El maximo de cuotas no puede ser menor al el campo faltando cuotas para renovacion');
							this.ef('faltando_cuotas').resetear_estado();
							this.ef('maximo_cuotas').resetear_estado();
						}
					}
				}
			}
		}
		
		{$this->objeto_js}.evt__faltando_cuotas__procesar = function(es_inicial)
		{
			var faltando = this.ef('faltando_cuotas').get_estado();
			var maximo_cuotas = this.ef('maximo_cuotas').get_estado();
		
			if (this.ef('permite_renovacion').chequeado())
			{
				if (faltando!='')
				{
					if(maximo_cuotas!='')
					{
						if (faltando > maximo_cuotas)
						{
							alert('El campo faltando cuotas para renovacion no puede ser mayor al campo maximo cuotas');
							this.ef('faltando_cuotas').resetear_estado();
							this.ef('maximo_cuotas').resetear_estado();
						}
					}
				}
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
							alert('La fecha inicio no puede ser mayor a la fecha fin del convenio.');
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
							alert('La fecha fin no puede ser menor a la fecha inicio de inicio del convenio');
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