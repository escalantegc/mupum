<?php
require_once('dao.php');
class ci_administrar_usuarios extends mupum_ci
{
	protected $s__where;
	protected $s__datos_filtro;
	protected $s__user;
	//-----------------------------------------------------------------------------------
	//---- Eventos ----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function evt__procesar()
	{
	}

	function evt__cancelar()
	{
		$this->set_pantalla('pant_inicial');
		$this->cn()->resetear_dt_usuario();
	}

	//-----------------------------------------------------------------------------------
	//---- cuadro -----------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__cuadro(mupum_ei_cuadro $cuadro)
	{
		if(isset($this->s__datos_filtro))
		{
			$datos = dao::get_listado_socios_libre($this->s__where);
			$usuarios = array();
			foreach ($datos  as $dato) 
			{
				$filtro['usuario'] = trim($dato['nro_documento']);
				$this->cn()->cargar_dt_usuario($filtro);
				$resultado = $this->cn()->existe_dt_usuario($filtro);
				$dato['existe'] = 0;
				if ($resultado == 'existe')
				{
					$dato['existe'] = 1;
					if (toba::instancia()->es_usuario_bloqueado($filtro['usuario']))
	    			{
	    				$dato['bloqueado'] = 1;
	    			} else {
	    				$dato['bloqueado'] = 0;
	    			}
				} else {
					$dato['bloqueado'] = 0;
				}
				$usuarios[] = $dato;

			}

			$cuadro->set_datos($usuarios);
		}
		
	}

	function evt__cuadro__seleccion($seleccion)
	{
		$this->s__user = $seleccion['nro_documento'];
		$this->set_pantalla('pant_edicion');
	}

	function evt__cuadro__bloquear($seleccion)
	{
		toba::instancia()->bloquear_usuario($this->s__user);
	}

	function evt__cuadro__desbloquear($seleccion)
	{
		toba::instancia()->desbloquear_usuario($this->s__user);
	}
	
	function evt__cuadro__crear($seleccion)
	{
		$this->s__user = $seleccion['nro_documento'];
		$this->set_pantalla('pant_nuevo');
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
	//---- frm --------------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm(mupum_ei_formulario $form)
	{


		$datos['usuario'] = $this->s__user;
		$perfil = toba::instancia()->get_perfiles_funcionales($this->s__user,'mupum');
		$datos['perfil'] = trim($perfil[0]);
		$form->set_datos($datos);

	}

	function evt__frm__modificacion($datos)
	{

		toba_usuario::set_clave_usuario($clave, $user);

		toba::instancia()->agregar_usuario($user,$nombre,$clave,$atributos);
		toba::instancia()->get_perfiles_funcionales($usuario,'mupum');
		$perfil = 'afiliado';
		toba::instancia()->vincular_usuario('mupum',$user,$perfil);

	}

	

	//-----------------------------------------------------------------------------------
	//---- frm_nuevo --------------------------------------------------------------------
	//-----------------------------------------------------------------------------------

	function conf__frm_nuevo(mupum_ei_formulario $form)
	{
	}

	function evt__frm_nuevo__modificacion($datos)
	{
	}

}
?>