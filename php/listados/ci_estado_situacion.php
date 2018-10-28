<?php
class ci_estado_situacion extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	public $s__afiliado;
	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_estado_situacion($this->s__datos_filtro['periodo']['valor'],$this->s__datos_filtro['idafiliacion']['valor']);
			$cuadro->set_datos($datos);
			
		}
		
		
	}

	//-----------------------------------------------------------------------------------
	//---- filtro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__filtro(mupum_ei_filtro $filtro)
	{
		if(isset($this->s__datos_filtro))
		{
			$filtro->set_datos($this->s__datos_filtro);
			$this->s__where = $filtro->get_sql_where();
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

	//-----------------------------------------------------------------------------------
	//---- Configuraciones --------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf()
	{
		if (isset($this->s__datos_filtro['idafiliacion']['valor']))
		{
			$this->s__afiliado = dao::get_datos_persona_afiliada($this->s__datos_filtro['idafiliacion']['valor']);	
		}
		
	}

}
?>