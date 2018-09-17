<?php
class ei_frm_ml_detalle_pago_infraestructura extends mupum_ei_formulario_ml
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
		
			this.controlador.ajax('requiere_nro_comprobante', idfp, this, this.mostrar_campos); 	
		
		}
		
		{$this->objeto_js}.mostrar_campos = function(datos)
		{    
			var sera = (datos['requiere']);
		    var fila =  (datos['fila']);   
			if (sera=='si')
			{
				this.ef('nro_cheque_transaccion').ir_a_fila(fila).mostrar();
				
			} else {
				this.ef('nro_cheque_transaccion').ir_a_fila(fila).ocultar();
			}            
		}
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__monto__procesar = function(es_inicial, fila)
		{
			total = this.controlador.dep('frm_gasto').ef('monto').get_estado();

			total_filas = this.total('monto');
	
			if (total_filas > total)
			{
				alert('El total del detalle ppago supera a monto del gasto, por favor controle los valores de los detalles de pago.');
				this.ef('monto').ir_a_fila(fila).resetear_estado();
			}
		}
		";
	}


}
?>