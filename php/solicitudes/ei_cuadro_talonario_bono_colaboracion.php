<?php
class ei_cuadro_talonario_bono_colaboracion extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__borrar($evento, $fila)
	{
		if ($this->datos[$fila]['vendidos'] > 0) 
		{
			$evento->anular();    
		}
	}

}

?>