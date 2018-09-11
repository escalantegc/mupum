<?php
class ci_migracion extends mupum_ci
{
	protected $s__nombrearchivo;
	protected $s__nombrearchivo2;
	//-----------------------------------------------------------------------------------
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{
		if (isset($this->s__nombrearchivo))
		{	
			$archivo = toba::proyecto()->get_www('/archivos/'.$this->s__nombrearchivo);
			$archivo2 = toba::proyecto()->get_www('/archivos/'.$this->s__nombrearchivo2);
			//ei_arbol($archivo);
			$datos['resultado'] = $enlace="<a href='{$archivo['url']}' TARGET='_blank'>Descargar</a>";
			$datos['resultado2'] = $enlace="<a href='{$archivo2['url']}' TARGET='_blank'>Descargar</a>";
			$form->set_datos($datos);
		}
		
	}

	function evt__frm__generar($datos)
	{

		$datos['mupum']['name'] ;
		$datos['mapuche']['name'] ;
		$datosmapuche = array();
		$finalmapuche = array();
		
		if (($mapuche = fopen($datos['mapuche']['tmp_name'] , "r")) !== FALSE) 
		{

			while (($datosm = fgetcsv($mapuche, 1000)) !== FALSE) 
			{
				//ei_arbol($datosm);	
				$datosmapuche['cuil'] = $datosm[3];	
				$datosmapuche['legajo'] = $datosm[0];
				$finalmapuche[] = $datosmapuche;				


			}
		}
		//ei_arbol($finalmapuche);

		// Utilizar el parámetro opcional flags a partir de PHP 5
		//$mupum = file($datos['mupum']['tmp_name'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		
		$fp = fopen($datos['mupum']['tmp_name'], "r");
		$finalmupum = array();
		$datosmupum = array();
		if (($mupum = fopen($datos['mupum']['tmp_name'] , "r")) !== FALSE) 
		{

			while (($datosmu = fgetcsv($mupum, 1000)) !== FALSE) 
			{
			$datosmupum['legajo'] = $datosmu[0];
			$datosmupum['apellido'] = $datosmu[1] ;
			$datosmupum['nombres'] = $datosmu[2];
			$datosmupum['nrodocumento'] = $datosmu[4];

			
			$finalmupum[] = $datosmupum;	
			}
		}
		fclose($fp);

		$this->s__nombrearchivo = "scriptsocios.sql";
		$this->s__nombrearchivo2 = "scriptafiliacion.sql";
		$filesocios = fopen(toba::proyecto()->get_path()."/www/archivos/".$this->s__nombrearchivo, "w");
		$fileafiliacion = fopen(toba::proyecto()->get_path()."/www/archivos/".$this->s__nombrearchivo2, "w");

		
		$final = array();
		foreach ($finalmupum as $mupum) 
		{
			foreach ($finalmapuche as $mapuche) 
			{
				if (trim($mupum['legajo'])==trim($mapuche['legajo']))
				{

					$depurado['legajo']=trim(quote("{$mupum['legajo']}"));
					$depurado['idtipo_documento'] = "(SELECT idtipo_documento  FROM public.tipo_documento where sigla = 'DNI')";

					$depurado['nrodocumento']=trim(quote("{$mupum['nrodocumento']}"));
					$depurado['apellido']=trim(quote("{$mupum['apellido']}"));
					$depurado['nombres']=trim(quote("{$mupum['nombres']}"));
				
					$depurado['cuil'] =  trim(str_replace("-", "", quote("{$mapuche['cuil']}")));
					
					$linea ="INSERT INTO public.persona(idtipo_documento, nro_documento,cuil, legajo, apellido, nombres) VALUES (".$depurado['idtipo_documento'].','. $depurado['nrodocumento'].','.  $depurado['cuil'].','.  $depurado['legajo'].','. $depurado['apellido'].','. $depurado['nombres'].');';
					$lineaafilaicion = 'INSERT INTO public.afiliacion(idpersona, idtipo_socio,fecha_alta,  activa ) VALUES ((select idpersona from persona where legajo ='. $depurado['legajo'] .  '), (SELECT idtipo_socio  FROM public.tipo_socio  where titular = true), current_date, true);';
	
					fwrite($filesocios, $linea . PHP_EOL);
					fwrite($fileafiliacion, $lineaafilaicion . PHP_EOL);

					break;
				}
			}
		}
	}

}
?>