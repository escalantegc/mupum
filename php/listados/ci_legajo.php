<?php
require_once('dao.php');
class ci_legajo extends mupum_ci
{
	protected $s__criterios_filtrado;

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
		$filtro->columna('idpersona')->set_condicion_fija('es_igual_a');

	}

	function vista_jasperreports(toba_vista_jasperreports $report)
	{
		
		$encabezado = dao::get_encabezado();

		$reporte='legajo.jasper';
		$path=toba::proyecto()->get_path().'/exportaciones/'.$reporte;	

		$path_logo=toba::proyecto()->get_path().'/www/logo/logo.gif';	
		

		$report->set_path_reporte($path);
		$path_subreport = toba::proyecto()->get_path().'/exportaciones/';

		$report->set_parametro('SUBREPORT_DIR','S',$path_subreport);
		//$report->set_parametro('SUBREPORT_DIR','S',$path_subreport);
		//Parametro para el titulo
		$report->set_parametro('titulo','S','LEGAJO DEL AFILIADO ');
		//Parametros para el encabezado del titulo
		$report->set_parametro('logo','S',$path_logo);
		//Paramentro del filtro
		
		

		if (isset($this->s__criterios_filtrado['idpersona']['valor'])!='')
		{
			if (trim($this->s__criterios_filtrado['idpersona']['valor'])!='nopar')
			{
				$idpersona = $this->s__criterios_filtrado['idpersona']['valor'];

			}
		}

	
		$report->set_parametro('idpersona', 'E', $idpersona);
		$report->set_parametro('nombre_institucion', 'S', $encabezado['nombre_institucion']);
		$report->set_parametro('direccion', 'S', $encabezado['direccion']);
		$report->set_parametro('telefono', 'S', $encabezado['telefono']);
		//$report->set_parametro('detalleamostrar', 'S', $detalleamostrar);

	

		//Parametros para el usuario
		$report->set_parametro('usuario','S',toba::usuario()->get_id());
		$report->set_nombre_archivo('legajo.pdf');   	
		$db=toba::fuente('mupum')->get_db();
		$report->set_conexion($db);	
	}

	function ajax__get_dato_filtro_idpersona($idpersona, toba_ajax_respuesta $respuesta)
	{
		$this->s__criterios_filtrado['idpersona']['condicion'] =  'es_igual_a';
		$this->s__criterios_filtrado['idpersona']['valor'] =  $idpersona;
		$respuesta->set($idpersona);	
	}	

}

?>