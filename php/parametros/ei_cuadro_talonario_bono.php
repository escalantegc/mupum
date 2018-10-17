<?php
class ei_cuadro_talonario_bono extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__seleccion($evento, $fila)
	{
		if ($this->datos[$fila]['cantidad_vendidos'] > 0) 
		{
			$evento->anular();    
		}
	}

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['cantidad_vendidos'] > 0) 
		{
			$evento->anular();    
		}
	}

}
?>