<?php
class ei_cuadro_consumos_bono extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['cantidad_bonos'] > 0) 
		{
			$evento->anular();    
		}
	}

}

?>