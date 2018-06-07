<?php
class ei_cuadro_mis_reservas extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__cancelar($evento, $fila)
	{
		//-ei_arbol($this->datos);
		if (!strstr('SOLICITADA', $this->datos[$fila]['estado'])) 
		{
			$evento->anular();    
		}
	}

}
?>