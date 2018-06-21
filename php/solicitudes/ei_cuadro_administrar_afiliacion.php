<?php
class ei_cuadro_administrar_afiliacion extends mupum_ei_cuadro
{
	//---- Config. EVENTOS sobre fila ---------------------------------------------------

	function conf_evt__formulario($evento, $fila)
	{
		if ($this->datos[$fila]['solicitada'] != 'SI') 
		{
			$evento->anular();    
		}
	}

	function conf_evt__activar($evento, $fila)
	{
		if ($this->datos[$fila]['activa'] == 'SI') 
		{
			$evento->anular();    
		}
		if (($this->datos[$fila]['activa'] != 'SI') and ($this->datos[$fila]['solicitada'] !=' SI') )
		{
			$evento->anular();    
		}
	}

	function conf_evt__baja($evento, $fila)
	{
		if (($this->datos[$fila]['activa'] != 'SI') and ($this->datos[$fila]['solicitada'] != 'SI') )
		{
			$evento->anular();    
		}
	}

	function vista_excel(toba_vista_excel $salida)
	{
		$salida->inicializar();
		
		$titulo = 'Listado de Solicitudes de Afiliacion';
		$salida->titulo($titulo); 
		       
		$salida->set_nombre_archivo('listado_solicitudes_afiliacion.xls');
					   
		$this->generar_salida('excel', $salida);
	}
       
	function vista_pdf(toba_vista_pdf $salida)
	{
		$salida->inicializar();
		$titulo = 'Listado de Solicitudes de Afiliacion';
		$salida->titulo($titulo); 
		       
		$salida->set_nombre_archivo('listado_solicitudes_afiliacion.pdf');
					   
		//Pie de pagina
		$pdf = $salida->get_pdf();
		$formato = 'Pagina {PAGENUM} de {TOTALPAGENUM}';
		$pdf->ezStartPageNumbers(580, 20, 8, 'center', $formato, 1);  
		$this->generar_salida('pdf', $salida);
	}

}
?>