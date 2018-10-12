<?php
class ei_frm_bono_colaboracion extends mupum_ei_formulario
{
	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		{$this->objeto_js}.ini = function () {
		
		
			this.ef('descripcion').input().onchange = function() {
				var ef = {$this->objeto_js}.ef('descripcion');
				var cadena = ef.get_estado().toUpperCase();
			
				ef.set_estado(cadena);
			}
		}
			
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__persona_externa__procesar = function(es_inicial)
		{
			if (this.ef('persona_externa').chequeado())
			{
				this.ef('idafiliacion').resetear_estado();
				this.ef('idafiliacion').ocultar();
				this.ef('idpersona_externa').mostrar();
				var idfp = this.ef('idforma_pago').get_estado();
				if (this.ef('persona_externa').chequeado())
				{
					this.controlador.ajax('es_planilla', idfp, this, this.mostrar_campos); 	
				}
			} else {
				
				this.ef('idafiliacion').mostrar();
				this.ef('idpersona_externa').resetear_estado();
				this.ef('idpersona_externa').ocultar();
			}
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__nro_inicio__procesar = function(es_inicial)
		{
			var inicio = this.ef('nro_inicio').get_estado();
			var fin = this.ef('nro_fin').get_estado();
		
			if (inicio !='')
			{
				if (fin !='')
				{
					if (inicio > fin)
					{
						alert('El numero de inicio no puede ser mayor al numero de fin');
						this.ef('nro_inicio').resetear_estado();
						this.ef('nro_fin').resetear_estado();
					}
		
				}				
			}
		
		}
		
		{$this->objeto_js}.evt__nro_fin__procesar = function(es_inicial)
		{
			var inicio = this.ef('nro_inicio').get_estado();
			var fin = this.ef('nro_fin').get_estado();
		
			if (inicio !='')
			{
				if (fin !='')
				{
					if (fin < inicio)
					{
						alert('El numero de fin no puede ser menor al numero de inicio');
						this.ef('nro_inicio').resetear_estado();
						this.ef('nro_fin').resetear_estado();
					}
		
				}				
			}
		}
		//---- Validacion de EFs -----------------------------------
		
		{$this->objeto_js}.evt__fecha_compra__procesar = function(es_inicial)
		{
			var compra = this.ef('fecha_compra').fecha();
			var sorteo = this.ef('fecha_sorteo').fecha();
			if (!es_inicial)
			{
				if (compra != null)
				{
					if (sorteo != null)
					{
						if(compra > sorteo )
						{
							alert('La fecha de compra no puede ser mayor a la fecha de sorteo');
							this.ef('fecha_compra').resetear_estado();
						} 
					}
				}
			}	
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idforma_pago__procesar = function(es_inicial)
		{
			var idfp = this.ef('idforma_pago').get_estado();
			if (this.ef('persona_externa').chequeado())
			{
				this.controlador.ajax('es_planilla', idfp, this, this.mostrar_campos); 	
			}
		}


		{$this->objeto_js}.mostrar_campos = function(datos)
		{    
			var planilla = (datos['planilla']);     
			if (planilla=='si')
			{
				alert('No puede seleccionar forma de pago planilla para personas externas.');
				this.ef('idforma_pago').resetear_estado();
			}          
		}
		";
	}




}
?>