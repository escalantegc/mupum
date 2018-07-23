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
		";
	}


}

?>