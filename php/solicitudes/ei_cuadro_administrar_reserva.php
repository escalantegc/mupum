<?php
class ei_cuadro_administrar_reserva extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__cancelar($evento, $fila)
	{
		if (strstr($this->datos[$fila]['estado'], 'CANCELADA')) 
		{
			$evento->anular();    
		}
	}

}
?>