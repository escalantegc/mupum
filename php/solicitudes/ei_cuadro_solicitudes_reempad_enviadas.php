<?php
class ei_cuadro_solicitudes_reempad_enviadas extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__notificar($evento, $fila)
	{
		//-ei_arbol($this->datos);
		if ( $this->datos[$fila]['atendida']=='SI') 
		{
			$evento->anular();    
		}
	}

}

?>