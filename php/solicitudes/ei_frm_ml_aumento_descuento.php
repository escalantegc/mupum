<?php
class ei_frm_ml_aumento_descuento extends mupum_ei_formulario_ml
{
	function extender_objeto_js()
	{
		echo "
			
			{$this->objeto_js}.crear_fila_orig = {$this->objeto_js}.crear_fila; 
			{$this->objeto_js}.crear_fila       = function() {
				
				id_fila = this.crear_fila_orig();
				return id_fila;
			}
			
			{$this->objeto_js}.eliminar_fila_orig = {$this->objeto_js}.eliminar_fila; 
			{$this->objeto_js}.eliminar_fila      = function(fila) {
			
				this.eliminar_fila_orig(fila);
				monto = this.controlador.dep('frm').ef('monto_final').get_estado();
				monto_mov = this.ef('monto').ir_a_fila(fila).get_estado();

				if (this.ef('tipo_movimiento').ir_a_fila(fila).get_estado()=='aum')
				{
					alert('monto final: '+monto);
					alert('monto movimiento: '+monto_mov);
					monto_total = parseInt(monto)  - parseInt(monto_mov);
					
					this.controlador.dep('frm').ef('monto_final').set_estado(monto_total);
				} else {
					alert('monto final: '+monto);
					alert('monto movimiento: '+monto_mov);
					monto_total = parseInt(monto) + parseInt(monto_mov);
					this.controlador.dep('frm').ef('monto_final').set_estado(monto_total);				
				}
				
			}
			
			{$this->objeto_js}.deshacer_orig = {$this->objeto_js}.deshacer; 
			{$this->objeto_js}.deshacer         = function() {
				
				this.deshacer_orig();
				
			}
			
		//---- Procesamiento de EFs --------------------------------
		
		{$this->objeto_js}.evt__monto__procesar = function(es_inicial, fila)
		{
			if (!es_inicial)
			{
				monto = this.controlador.dep('frm').ef('monto_final').get_estado();
				
				monto_mov = this.ef('monto').ir_a_fila(fila).get_estado();
				
				if (this.ef('tipo_movimiento').ir_a_fila(fila).get_estado()=='aum')
				{
					monto_total = monto + monto_mov;
					this.controlador.dep('frm').ef('monto_final').set_estado(monto_total);
				} else {
					monto_total = monto - monto_mov;
					this.controlador.dep('frm').ef('monto_final').set_estado(monto_total);				
				}	
				this.ef('monto').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('idconcepto').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('tipo_movimiento').ir_a_fila(fila).set_solo_lectura(true);
				this.ef('descripcion').ir_a_fila(fila).set_solo_lectura(true);
			}

		}
		";
	}

}
?>