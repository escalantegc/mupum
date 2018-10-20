<?php
class ei_cuadro_consumo_financiado extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['cantidad_pagas'] > 0) 
		{
			$evento->anular();    
		}
	}

}

?>