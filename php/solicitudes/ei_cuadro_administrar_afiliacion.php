<?php
class ei_cuadro_administrar_afiliacion extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__imprimir($evento, $fila)
	{
		if (!strstr('SOLICITADA', $this->datos[$fila]['estado'])) 
		{
			$evento->anular();    
		}
	}

}

?>