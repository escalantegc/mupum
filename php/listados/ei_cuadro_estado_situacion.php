<?php
class ei_cuadro_estado_situacion extends mupum_ei_cuadro
{

	function vista_excel(toba_vista_excel $salida)
	{

		$salida->inicializar();
		
		$titulo = 'Estado Situacion: '.$this->controlador()->s__afiliado[0]['persona'];
		$salida->titulo($titulo); 
		       
		$salida->set_nombre_archivo('estado_situacion_'.trim($this->controlador()->s__afiliado[0]['nombre_completo']).'.xls');
					   
		$this->generar_salida('excel', $salida);
	}
       
	function vista_pdf(toba_vista_pdf $salida)
	{
		$salida->inicializar();
		$titulo = 'Estado Situacion: '.$this->controlador()->s__afiliado[0]['persona'];
		$salida->titulo($titulo); 
		       
		$salida->set_nombre_archivo('estado_situacion_'.trim($this->controlador()->s__afiliado[0]['nombre_completo']).'.pdf');
					   
		//Pie de pagina
		$pdf = $salida->get_pdf();
		$formato = 'Pagina {PAGENUM} de {TOTALPAGENUM}';
		$pdf->ezStartPageNumbers(580, 20, 8, 'center', $formato, 1);  
		$this->generar_salida('pdf', $salida);
	}
}
?>