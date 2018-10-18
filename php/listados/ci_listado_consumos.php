<?php
class ci_listado_consumos extends mupum_ci
{
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_consumos($this->s__where);
		}else{
			$datos = dao::get_listado_consumos();
		}
		
		$cuadro->set_datos($datos);
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
 		$filtro->columna('tipo')->set_condicion_fija('es_igual_a');

		if(isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__where = $filtro->get_sql_where();
			
			if (strstr($this->s__where, "tipo = 'bn'"))
			{
				$this->s__where = str_replace("tipo = 'bn'", "maneja_bono =true", $this->s__where);
			}
			if (strstr($this->s__where, "tipo = 'tk'"))
			{
				$this->s__where = str_replace("tipo = 'k'", "consumo_ticket =true", $this->s__where);
			}			

			if (strstr($this->s__where, "tipo = 'fi'"))
			{
				$this->s__where = str_replace("tipo = 'fi'", "permite_financiacion =true and ayuda_economica=false", $this->s__where);
			}			
			if (strstr($this->s__where, "tipo = 'ay'"))
			{
				$this->s__where = str_replace("tipo = 'ay'", "ayuda_economica =true", $this->s__where);
			}
		}
	}

	function evt__filtro__filtrar($datos)
	{
		$this->s__datos_filtro = $datos;
	}

	function evt__filtro__cancelar()
	{
		unset($this->s__datos_filtro);
	}

}

?>