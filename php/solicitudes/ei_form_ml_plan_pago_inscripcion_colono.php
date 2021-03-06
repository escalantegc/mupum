<?php
class ei_form_ml_plan_pago_inscripcion_colono extends mupum_ei_formulario_ml
{
	//-----------------------------------------------------------------------------------
	//---- JAVASCRIPT -------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function extender_objeto_js()
	{
		echo "
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__idforma_pago__procesar = function(es_inicial, fila)
		{
				var idfp = new Array();
				idfp[1] = this.ef('idforma_pago').ir_a_fila(fila).get_estado();
				idfp[2] = fila;
			if (!es_inicial)
			{
			
				this.controlador.ajax('es_planilla', idfp, this, this.mostrar_campos); 	
			} else {
				this.controlador.ajax('es_planilla', idfp, this, this.mostrar_campos2); 	
			}
		}
		
		{$this->objeto_js}.mostrar_campos = function(datos)
		{    
			var planilla = (datos['planilla']);
			var fila =  (datos['fila']);         
			if (planilla=='no')
			{
				//--this.ef('cuota_pagada').ir_a_fila(fila).mostrar();
				//--this.ef('fecha_pago').ir_a_fila(fila).mostrar();
				this.ef('cuota_pagada').ir_a_fila(fila).chequear();
				this.ef('cuota_pagada').ir_a_fila(fila).set_solo_lectura(true);
		
				var hoy = new Date();
				var hoy_texto = hoy.getDate() + '/' + (hoy.getMonth() +1)  + '/' + hoy.getFullYear();
				
				//--this.ef('fecha_pago').ir_a_fila(fila).set_solo_lectura(true);
				if (this.ef('fecha_pago').ir_a_fila(fila).get_estado()=='')
				{
					this.ef('fecha_pago').ir_a_fila(fila).set_estado(hoy_texto);
				}
				
			} else {
				//--this.ef('cuota_pagada').ir_a_fila(fila).ocultar();
				//--this.ef('fecha_pago').ir_a_fila(fila).ocultar();				
				this.ef('cuota_pagada').ir_a_fila(fila).resetear_estado();
				this.ef('fecha_pago').ir_a_fila(fila).resetear_estado();
			}            
		}

		{$this->objeto_js}.mostrar_campos2 = function(datos)
		{    
			var planilla = (datos['planilla']);
			var fila =  (datos['fila']);         
			if (planilla=='no')
			{
				//--this.ef('cuota_pagada').ir_a_fila(fila).mostrar();
				//--this.ef('fecha_pago').ir_a_fila(fila).mostrar();
				this.ef('cuota_pagada').ir_a_fila(fila).chequear();
				this.ef('cuota_pagada').ir_a_fila(fila).set_solo_lectura(true);
		
				var hoy = new Date();
				var hoy_texto = hoy.getDate() + '/' + (hoy.getMonth() +1)  + '/' + hoy.getFullYear();
				
				//--this.ef('fecha_pago').ir_a_fila(fila).set_solo_lectura(true);
				if (this.ef('fecha_pago').ir_a_fila(fila).get_estado()=='')
				{
					this.ef('fecha_pago').ir_a_fila(fila).set_estado(hoy_texto);
				}
				
			}           
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__inscripcion__procesar = function(es_inicial, fila)
		{
			if ( this.ef('nro_cuota').ir_a_fila(fila).get_estado()==1)
			{
				this.ef('inscripcion').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('inscripcion').ir_a_fila(fila).mostrar();
			} else {
				this.ef('inscripcion').ir_a_fila(fila).ocultar();	
			}
			 
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__cuota_pagada__procesar = function(es_inicial, fila)
		{
							this.ef('cuota_pagada').ir_a_fila(fila).set_solo_lectura(true);

			if (this.ef('cuota_pagada').ir_a_fila(fila).chequeado())
			{
				this.ef('fecha_pago').ir_a_fila(fila).mostrar()
			} else {
				this.ef('fecha_pago').ir_a_fila(fila).ocultar();

			}
		}
		";
	}



}
?>