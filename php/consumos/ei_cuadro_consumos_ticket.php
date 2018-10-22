<?php
class ei_cuadro_consumos_ticket extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['total'] == $this->datos[$fila]['total_abonado']) 
		{
			$evento->anular();    
		}
	}

}

?>