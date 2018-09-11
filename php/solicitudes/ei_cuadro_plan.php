<?php
class ei_cuadro_plan extends mupum_ei_cuadro
{
	
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['baja'] == 'SI') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__alta($evento, $fila)
	{
		if ($this->datos[$fila]['baja'] != 'SI') 
		{
			$evento->anular();    
		}
	}

}
?>