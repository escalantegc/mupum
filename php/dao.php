<?php
class dao 
{

  function get_sql_usuario()
  {

    $usuario = toba::usuario()->get_id();
    $perfil = toba::usuario()->get_perfiles_funcionales();
    $usuario = quote("%{$usuario}%");
    $sql = '';
    if ( !strstr($perfil[0], 'admin') )
    {
      $sql = ' persona.nro_documento ilike '.trim($usuario);
    } else {
      $sql = ' 1 = 1 ';
    }
    return $sql;
  }

  function get_listado_persona($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
             nro_documento, 
            cuil, 
            legajo, 
            (apellido||', '||nombres) as persona, 
            correo, 
            cbu, 
            fecha_nacimiento, 
            idlocalidad, 
            calle, altura, 
            piso, 
            depto, 
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          where
            $where 
          order by
            apellido,nombres";
         
      return consultar_fuente($sql);
  }	

  function get_listado_persona_externa($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
             nro_documento, 
            cuil, 
            legajo, 
            (apellido||', '||nombres) as persona, 
            correo, 
            cbu, 
            fecha_nacimiento, 
            idlocalidad, 
            calle, altura, 
            piso, 
            depto, 
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          where
            legajo is null and
            $where 
          order by
            apellido,nombres";
         
      return consultar_fuente($sql);
  }

  function get_listado_socios_libre($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
             nro_documento as usuario, 
            cuil, 
            legajo, 
            (apellido||', '||nombres) as persona, 
            correo, 
            cbu, 
            fecha_nacimiento, 
            idlocalidad, 
            calle, altura, 
            piso, 
            depto, 
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          where
             $where 
          order by
            apellido,nombres";
      return consultar_fuente($sql);
  }

  function get_listado_socios($where = null)
	{
    $sql = '';
    $sql_usuario = self::get_sql_usuario();
    if (!isset($where))
    {
      $where = '1 = 1';
    }
   $sql = "SELECT  idpersona, 
                  (tipo_documento.sigla ||'-'||nro_documento) as documento, 
                  nro_documento, 
                  nro_documento as usuario, 
                  tipo_documento.sigla as tipo_documento,
                  apellido,
                  nombres,
                  cuil, 
                  legajo, 
                  (apellido||', '||nombres) as persona, 
                  correo, 
                  cbu, 
                  fecha_nacimiento, 
                  idlocalidad, 
                  calle, altura, 
                  piso, 
                  depto, 
                  estado_civil.descripcion as estado_civil,
                  (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                  tipo_socio.descripcion as tipo,
                  afiliacion.fecha_alta 
          FROM public.persona
            left outer join estado_civil using(idestado_civil)
            inner join tipo_documento using(idtipo_documento)
            inner join afiliacion using (idpersona)
            inner join tipo_socio using(idtipo_socio)
          where
            afiliacion.activa = true and
            $sql_usuario and
            $where 
          order by
            apellido,nombres";  		

      return consultar_fuente($sql);
	}


  function get_listado_tipo_socio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idtipo_socio, 
                    descripcion,
                    titular,
                    liquidacion,
                    externo
          FROM public.tipo_socio
          where
            $where
          order by
            titular desc,descripcion";
      return consultar_fuente($sql);
  }	

  function get_listado_tipo_socio_no_externo($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idtipo_socio, 
                    descripcion,
                    titular,
                    liquidacion,
                    externo
          FROM public.tipo_socio
          where
            externo = false and
            $where
          order by
            titular desc,descripcion";
      return consultar_fuente($sql);
  }  

  function get_listado_tipo_socio_externo($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idtipo_socio, 
						        descripcion,
                    titular,
                    liquidacion,
                    externo
  				FROM public.tipo_socio
  				where
            externo = true and
  					$where
  				order by
  					titular desc,descripcion";
  		return consultar_fuente($sql);
	}

	function get_listado_tipo_documento($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idtipo_documento, 
						sigla, 
						descripcion
  				FROM 
  					public.tipo_documento
  				where
  					$where
  				order by
  					sigla,
  					descripcion";
  		return consultar_fuente($sql);
	}

	function get_localidades_combo_editable($filtro = null)
	{
		if (! isset($filtro) || trim($filtro)=='')
		{
			return array();
		}
		$filtro = quote("%{$filtro}%");

		$sql = "SELECT 	localidad.idlocalidad, 
						localidad.descripcion ||' - '||provincia.descripcion ||' - '|| pais.descripcion as localidad
				  FROM 
				  	public.localidad
				  inner join provincia using (idprovincia)
				  inner join pais using (idpais)
				 WHERE 
				 	(localidad.descripcion ||' - '||provincia.descripcion ||' - '|| pais.descripcion) ilike $filtro limit 20 ";
		return consultar_fuente($sql);

	}	

	function get_descripcion_localidad($idlocalidad = null)
	{
		$sql = "SELECT 	localidad.idlocalidad, 
						localidad.descripcion ||' - '||provincia.descripcion ||' - '|| pais.descripcion as localidad
				  FROM 
				  	public.localidad
				  inner join provincia using (idprovincia)
				  inner join pais using (idpais)
				 WHERE 
				 	localidad.idlocalidad =  $idlocalidad";
		$res = consultar_fuente($sql);
		if (isset($res[0]['localidad']))
		{
			return $res[0]['localidad'];
		}

	}

	function get_listado_estado_civil($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idestado_civil, 
						        descripcion
  				FROM 
  					public.estado_civil	
  				WHERE
  					$where
  				order by
  					descripcion";
  		return consultar_fuente($sql);	
	}

	function get_tipo_telefono($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
		$sql = "SELECT 	idtipo_telefono, 
						descripcion
  				FROM 
  					public.tipo_telefono
  				WHERE
  					$where
  				order by
  					descripcion";
  		return consultar_fuente($sql);	
	}

	
	function get_listado_nivel_estudio($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}

		$sql = "SELECT idnivel_estudio, 
						descripcion, 
						nivel,
						orden
  				FROM 
  				public.nivel_estudio
  				WHERE
  					$where
  				order by orden asc";
  		return consultar_fuente($sql);		
	}

	  
  function get_listado_pais($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	idpais, 
  						descripcion
  				FROM public.pais
  				WHERE
  					$where
  				order by 
  					descripcion";
  		return consultar_fuente($sql);
  	}  

  function get_listado_provincia($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	idprovincia, 
  						pais.descripcion as pais,
  						provincia.descripcion
  				FROM 
  					public.provincia
  				inner join pais using (idpais)
   				WHERE
  					$where
  				order by 
  					provincia.descripcion";
  		return consultar_fuente($sql);
  	} 

  function get_listado_localidad($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	localidad.idprovincia, 
  						localidad.idlocalidad,
  						pais.descripcion as pais,
  						provincia.descripcion as provincia,
  						localidad.descripcion,
              localidad.descripcion  ||' - '|| provincia.descripcion as localidad
  				FROM  
  					public.localidad
  				inner join provincia using (idprovincia)
  				inner join pais using (idpais)
   				WHERE
  					$where
  				order by 
  					localidad.descripcion";
  		return consultar_fuente($sql);
  	}

    function get_pais_localidad($idlocalidad)
  	{
  		$sql = "SELECT idpais
				FROM 
					public.localidad
				 inner join provincia using (idprovincia)
				   where idlocalidad =$idlocalidad";

		return consultar_fuente($sql);
  	}
  	
    function get_pais_provincia($idprovincia)
  	{
  		$sql = "SELECT idpais
				FROM 
					public.provincia
				   where idprovincia =$idprovincia";

		return consultar_fuente($sql);
  	}


    function get_listado_provincia_cascada($idpais = null)
    {

    	$sql = "SELECT 	idprovincia, 
    					provincia.descripcion
    			FROM 
    				public.provincia
    				WHERE
    				provincia.idpais = $idpais 
    			order by
    				descripcion";
    	return consultar_fuente($sql);
    }  
  
  	function get_nombre_localidad($idlocalidad = null)
  	{
  		$sql = "SELECT  descripcion
  				FROM 
  					public.localidad
  				WHERE
  					idlocalidad = $idlocalidad;";
  		return consultar_fuente($sql);
  	}

   	
  	
	function get_descripcion_persona_popup($idpersona)
	{
		$sql = "SELECT  
					nombres||', '|| apellido as persona
				FROM 
					persona
				where 
					idpersona=$idpersona ";
		$resultado = consultar_fuente($sql);
		if ( isset($resultado[0]) ) {
			return $resultado[0]['persona'];
		}
	}

	function get_listado_parentesco($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT 	idparentesco, 
  						descripcion, 
  						bolsita_escolar,
              colonia
  				FROM public.parentesco
   				WHERE
  					$where
  				order by 
  					parentesco.descripcion";
  		return consultar_fuente($sql);
  }

  function get_listado_tipo_telefono($where = null)
	{
		if (!isset($where))
		{
			$where = '1 = 1';
		}
  		$sql = "SELECT idtipo_telefono, 
  						descripcion
 				 FROM 
 				 	public.tipo_telefono
   				WHERE
  					$where
  				order by 
  					tipo_telefono.descripcion";
  		return consultar_fuente($sql);
	}

  function get_listado_estado($categoria_estado = null)
  {
    $categoria_estado = quote("%{$categoria_estado}%");
    $sql = "SELECT  estado.idestado, 
            estado.descripcion

        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike $categoria_estado ";
    return consultar_fuente($sql);

  }  

  function get_estado_cancelada_segun_categoria($categoria_estado = null)
  {
    $categoria_estado = quote("%{$categoria_estado}%");
    $sql = "SELECT  estado.idestado, 
            estado.descripcion

        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike $categoria_estado and
          cancelada=true ";
    return consultar_fuente($sql);

  }
  
  function get_listado_estado_afiliacion($estado = null)
  {
    $estado = quote("%{$estado}%");
    $sql = "SELECT  estado.idestado, 
            estado.descripcion

        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike '%afiliacion%' and
          estado.descripcion ilike $estado";
    return consultar_fuente($sql);

  }	

  function get_listado_estado_reserva($estado = null)
  {
    $estado = quote("%{$estado}%");
    $sql = "SELECT  estado.idestado, 
            estado.descripcion


        FROM 
          public.estado
        inner join categoria_estado using (idcategoria_estado)
        WHERE
          categoria_estado.descripcion ilike '%reserva%' and
          estado.descripcion ilike $estado";
    return consultar_fuente($sql);

  }
  function get_listado_estado_cancelado_reserva()
	{

		$sql = "SELECT 	estado.idestado, 
						estado.descripcion


				FROM 
					public.estado
				inner join categoria_estado using (idcategoria_estado)
				WHERE
					categoria_estado.descripcion ilike '%reserva%' and
          estado.cancelada = true";
		return consultar_fuente($sql);

	}

  function get_listado_afiliacion($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  afiliacion.idafiliacion, 
                    afiliacion.idpersona, 
                    tipo_socio.descripcion  as tipo, 
                    estado.descripcion as estado, 
                    fecha_solicitud, 
                    fecha_alta, 
                    fecha_baja, 
                    afiliacion.activa,
                    afiliacion.solicitada,
                    solicita_cancelacion,
                    fecha_solicitud_cancelacion,
                    extract(YEAR FROM age(current_date::DATE ,fecha_alta::DATE))*12 + extract(MONTH FROM age (current_date::DATE, fecha_alta::DATE))as meses_afiliacion
            FROM
                public.afiliacion
            left outer join estado using (idestado)
            inner join tipo_socio using (idtipo_socio)
            WHERE
              $where
            order by 
              afiliacion.fecha_alta";
    return consultar_fuente($sql);
  }  

  function get_listado_solicitud_afiliacion($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  afiliacion.idafiliacion, 
                    afiliacion.idpersona, 
                    tipo_socio.descripcion  as tipo, 
                    estado.descripcion as estado, 
                    fecha_solicitud, 
                    fecha_alta, 
                    fecha_baja, 
                    afiliacion.activa,
                    persona.apellido||', '|| persona.nombres as persona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento as documento,
                    afiliacion.solicitada,
                    persona.legajo
            FROM
                public.persona
           
            inner join afiliacion using (idpersona)
            inner join tipo_documento using(idtipo_documento)
            left outer join estado using (idestado)
            inner join tipo_socio using (idtipo_socio)
            WHERE
              afiliacion.solicitada = true and
              $where
            order by 
              afiliacion.fecha_solicitud desc";
    return consultar_fuente($sql);
  } 

  function get_listado_cancelacion_afiliacion($where = null)
  {
    if (!isset($where))
    {
    	$where = '1 = 1';
    }
  	$sql = "SELECT 	afiliacion.idafiliacion, 
            				afiliacion.idpersona, 
            				tipo_socio.descripcion  as tipo, 
            				estado.descripcion as estado, 
            				fecha_solicitud, 
            				fecha_alta, 
            				fecha_baja, 
            				afiliacion.activa,
                    persona.apellido||', '|| persona.nombres as persona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento as documento,
                    afiliacion.solicitada,
                    fecha_solicitud_cancelacion,
                    solicita_cancelacion,
                    persona.legajo
      		  FROM
      		  		public.persona
      		 
      		  inner join afiliacion using (idpersona)
            inner join tipo_documento using(idtipo_documento)
            left outer join estado using (idestado)
            inner join tipo_socio using (idtipo_socio)
      		  WHERE
      				 solicita_cancelacion = true and
               $where
      			order by 
      				afiliacion.fecha_solicitud desc";
  	return consultar_fuente($sql);
  }

  function get_listado_categoria_estado($where = null)
  {
  	if (!isset($where))
  	{
  		$where = '1 = 1';
  	}
  		$sql = "SELECT idcategoria_estado, 
  						descripcion
  				FROM 
  					public.categoria_estado
   				WHERE
  					$where
  				order by 
  					categoria_estado.descripcion";
  		return consultar_fuente($sql);
  	}

  function get_listado_estados($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
        $sql = "SELECT  estado.idestado, 
                        estado.descripcion,
                        estado.confirmada,
                        estado.cancelada,
                        categoria_estado.descripcion as categoria
            FROM 
              public.estado
          inner join categoria_estado using (idcategoria_estado)
          where
            $where
          order by 
            categoria,estado.idestado";
      return consultar_fuente($sql);
  }
  
  function get_tipo_socio_titular()
  {
        $sql = "SELECT  idtipo_socio, 
                        descripcion, 
                        titular
                FROM 
                  public.tipo_socio
                where 
                  titular = true";
      return consultar_fuente($sql);
  }  

  function get_tipo_socio($idtipo_socio = null)
	{
      $datos['tipo'] = 'notitular';
    	$sql = "SELECT  idtipo_socio, 
                        descripcion, 
                        titular
                FROM 
                  public.tipo_socio
                WHERE
                  idtipo_socio = $idtipo_socio";
      $res = consultar_fuente($sql);
      if ($res[0]['titular'] == 1)
      {
        $datos['tipo'] = 'titular';
      }
      return $datos;
  		
  }

  function cargar_calendario_reserva () {
    
    $sql = "SELECT  idsolicitud_reserva, 
                    idafiliacion, 
                    fecha, 
                    instalacion.idinstalacion, 
                    instalacion.nombre as instalacion, 
                    estado.idestado, 
                    idmotivo, 
                    nro_personas,
                    
                    (select traer_instalaciones_ocupadas(fecha)) as contenido,
                    fecha as dia
            FROM 
              public.solicitud_reserva
              inner join estado using (idestado)
              inner join instalacion using (idinstalacion)
            where estado.cancelada = false";

    $dias = consultar_fuente($sql);
    $datos = null;
    foreach ($dias as $dia) {
      $datos[$dia['dia']] = array('dia'=> $dia['dia'], 'contenido'=> $dia['contenido'],'idsolicitud_reserva'=> $dia['idsolicitud_reserva']) ;
    } 
    return $datos;
  }

  function get_personas_afiliadas()
  {
    $sql_usuario = self::get_sql_usuario();
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              $sql_usuario
            order by
               persona.apellido,persona.nombres";

    return consultar_fuente($sql);

  }  

  function get_datos_persona_afiliada($idafiliacion = null)
  {
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona,
                 persona.apellido as nombre_completo,
                 persona.correo,
                 *
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              afiliacion.idafiliacion = $idafiliacion";

    return consultar_fuente($sql);

  }    

  function get_datos_persona_afiliada_descripcion($idafiliacion = null)
  {
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona,
                 persona.correo,
                 *
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              afiliacion.idafiliacion = $idafiliacion";

    $res = consultar_fuente($sql);
    if(isset($res[0]['persona']))
    {
      return $res[0]['persona']; 
    }

  }  

  function get_datos_persona_afiliada_para_archivo($idafiliacion = null)
  {
    $sql ="SELECT persona.legajo,
                  persona.apellido,
                  persona.nombres,
                  tipo_documento.sigla as tipodocumento,
                  persona.nro_documento,
                  persona.cuil,
                  afiliacion.idafiliacion,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona

            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            inner join tipo_documento using(idtipo_documento)
            where 
             
              afiliacion.idafiliacion = $idafiliacion";

    $res = consultar_fuente($sql);
    if (isset($res[0]))
    {
      return $res[0];
    }

  }   

  function get_descripcion_persona_afiliada($idafiliacion = null)
  {
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as socio,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona,
                 persona.correo,
                 *
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              afiliacion.idafiliacion = $idafiliacion";

    return consultar_fuente($sql);
    
  } 

  function get_datos_persona_afiliada_legajo($legajo = null)
  {
    //--$legajo = quote("%{$legajo}%");
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona,
                 persona.correo,
                 *
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              persona.legajo ilike $legajo";
  
    return consultar_fuente($sql);

  }  

  function get_personas_afiliadas_titulares()
  {
    $sql_usuario = self::get_sql_usuario();
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              tipo_socio.titular = true and
              $sql_usuario";

    return consultar_fuente($sql);

  }  

  function get_personas_afiliadas_combo_editable($filtro = null)
  {
    if (! isset($filtro) || trim($filtro)=='')
    {
      return array();
    }
    $filtro = quote("%{$filtro}%");

    $sql_usuario = self::get_sql_usuario();
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              titular = true and 
              $sql_usuario and
              persona.legajo||' - '|| persona.apellido||', '|| persona.nombres ilike $filtro limit 10";

    return consultar_fuente($sql);


  }

  function get_personas_afiliadas_activas_combo_editable($filtro = null)
  {
    if (! isset($filtro) || trim($filtro)=='')
    {
      return array();
    }
    $filtro = quote("%{$filtro}%");

    $sql_usuario = self::get_sql_usuario();
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            inner join  tipo_socio using(idtipo_socio)
            where 
              activa = true and
              $sql_usuario and
              persona.legajo||' - '|| persona.apellido||', '|| persona.nombres ilike $filtro limit 10";

    return consultar_fuente($sql);


  }

  function get_descripcion_persona($idafiliacion = null)
  {
    
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            where 
              afiliacion.idafiliacion =  $idafiliacion";
    $res = consultar_fuente($sql);
    if (isset($res[0]['persona']))
    {
      return $res[0]['persona'];
    }

  }    



  function get_descripcion_persona_idpersona($idpersona = null)
  {
    
    $sql ="SELECT afiliacion.idafiliacion, 
                  afiliacion.idpersona,
                 coalesce (persona.legajo,'0000')||' - '|| persona.apellido||', '|| persona.nombres as persona
            FROM 
              public.afiliacion
            inner join persona using (idpersona)
            where 
              afiliacion.idpersona =  $idpersona";
    $res = consultar_fuente($sql);
    if (isset($res[0]['persona']))
    {
      return $res[0]['persona'];
    }

  }

  function get_listado_instalacion ($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql ="SELECT   idinstalacion, 
                      nombre, 
                      cantidad_personas_reserva,
                      cantidad_maxima_personas,
                      domicilio
              FROM 
                public.instalacion 
              where 
                $where
              order by
                nombre";
      return consultar_fuente($sql);
  }  

  function get_listado_instalacion_disponible ($idafiliacion=null, $fecha = null)
  {
      $sql = "SELECT idinstalacion  
              FROM public.solicitud_reserva  
              inner join estado on estado.idestado = solicitud_reserva.idestado 
              where 
                fecha = $fecha and 
                estado.cancelada = false";
      $solicitudes = consultar_fuente($sql);
      
      $where = null;
      foreach ($solicitudes as $solicitud) 
      {
        $where.= ' instalacion.idinstalacion != '.$solicitud['idinstalacion'] .' and';
      }
     
      
      $sql = '';
      if (isset($where))
      {
       $where = substr($where, 0, strlen($where)-4);
       $sql ="  SELECT  instalacion.idinstalacion, 
                        instalacion.nombre, 
                        instalacion.cantidad_maxima_personas,
                        instalacion.domicilio
              FROM 
                public.instalacion 
                inner join motivo_tipo_socio on motivo_tipo_socio.idinstalacion = instalacion.idinstalacion
                inner join afiliacion on motivo_tipo_socio.idtipo_socio = afiliacion.idtipo_socio
              where 
                afiliacion.idafiliacion = $idafiliacion and
                $where
                ";

      } else {
         $sql ="SELECT   instalacion.idinstalacion, 
                      instalacion.nombre, 
                      instalacion.cantidad_maxima_personas,
                      instalacion.domicilio
              FROM 
                public.instalacion 
              inner join motivo_tipo_socio on motivo_tipo_socio.idinstalacion = instalacion.idinstalacion
              inner join afiliacion on motivo_tipo_socio.idtipo_socio = afiliacion.idtipo_socio
              where 
                afiliacion.idafiliacion = $idafiliacion";

      }
     
      return consultar_fuente($sql);
  }

  function get_listado_motivos($categoria_motivo = null)
  {
    $categoria_motivo = quote("%{$categoria_motivo}%");
    $sql = "SELECT  motivo.idmotivo, 
                    motivo.descripcion  
            FROM 
                public.motivo
            inner join categoria_motivo using(idcategoria_motivo)
            where 
                categoria_motivo.descripcion ilike $categoria_motivo
                ";
     return consultar_fuente($sql);
  }  

  function get_listado_motivo($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
    $sql = "SELECT  motivo.idmotivo, 
                    motivo.descripcion,
                    categoria_motivo.descripcion as categoria
            FROM 
                public.motivo
            inner join categoria_motivo using(idcategoria_motivo)
            where 
                $where
            order by
                descripcion";
     return consultar_fuente($sql);
  }

  function get_listado_reserva($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql="SELECT  solicitud_reserva.idsolicitud_reserva, 
                    persona.apellido ||', '|| persona.nombres as persona,
                    solicitud_reserva.fecha, 
                    instalacion.nombre as instalacion, 
                    estado.descripcion as estado, 
                    motivo.descripcion as motivo, 
                    nro_personas,
                    solicitud_reserva.monto,
                    monto_final,
                    (traer_detalle_pago_cancelado_reserva(solicitud_reserva.idsolicitud_reserva)) as pago_detalle
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            left outer join detalle_pago using(idsolicitud_reserva)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo_tipo_socio using(idmotivo_tipo_socio)
            inner join motivo on motivo.idmotivo = motivo_tipo_socio.idmotivo
            inner join instalacion on solicitud_reserva.idinstalacion = instalacion.idinstalacion
            where
              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              solicitud_reserva.fecha, 
              instalacion.nombre , 
              estado.descripcion , 
              motivo.descripcion , 
              nro_personas,
              solicitud_reserva.monto,
              monto_final
            order by 
              fecha desc";
      $datos = consultar_fuente($sql);
      $resultado = array();
      foreach ($datos as $dato) 
      {
        if ($dato['monto_final']==$dato['pago_detalle'])
        {
          $dato['pago'] = 1;
        } else{
           $dato['pago'] = 0;
        }
        $resultado[] = $dato;
      }
      return $resultado;
  }
  function get_listado_reserva_mes_en_curso($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql="SELECT  solicitud_reserva.idsolicitud_reserva, 
                    persona.apellido ||', '|| persona.nombres as persona,
                    solicitud_reserva.fecha, 
                    instalacion.nombre as instalacion, 
                    estado.descripcion as estado, 
                    motivo.descripcion as motivo, 
                    nro_personas,
                    solicitud_reserva.monto,
                    monto_final,
                    (traer_detalle_pago_cancelado_reserva(solicitud_reserva.idsolicitud_reserva)) as pago_detalle
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            left outer join detalle_pago using(idsolicitud_reserva)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo_tipo_socio using(idmotivo_tipo_socio)
            inner join motivo on motivo.idmotivo = motivo_tipo_socio.idmotivo
            inner join instalacion on solicitud_reserva.idinstalacion = instalacion.idinstalacion
            where
              solicitud_reserva.fecha >= ('01'||'/'||extract(MONTH FROM current_date)||'/'||extract(year FROM current_date))::date and

              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              solicitud_reserva.fecha, 
              instalacion.nombre , 
              estado.descripcion , 
              motivo.descripcion , 
              nro_personas,
              solicitud_reserva.monto,
              monto_final,
              estado.confirmada 
            order by 
              estado.confirmada desc,fecha asc";
      $datos = consultar_fuente($sql);
      $resultado = array();
      foreach ($datos as $dato) 
      {
        if ($dato['monto_final']==$dato['pago_detalle'])
        {
          $dato['pago'] = 1;
        } else{
           $dato['pago'] = 0;
        }
        $resultado[] = $dato;
      }
      return $resultado;
  }
  
  function get_listado_reserva_historial($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql="SELECT  solicitud_reserva.idsolicitud_reserva, 
                    persona.apellido ||', '|| persona.nombres as persona,
                    solicitud_reserva.fecha, 
                    instalacion.nombre as instalacion, 
                    estado.descripcion as estado, 
                    motivo.descripcion as motivo, 
                    nro_personas,
                    solicitud_reserva.monto,
                    monto_final,
                    (traer_detalle_pago_cancelado_reserva(solicitud_reserva.idsolicitud_reserva)) as pago_detalle
            FROM 
                public.solicitud_reserva
            inner join afiliacion using(idafiliacion)
            left outer join detalle_pago using(idsolicitud_reserva)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join estado on estado.idestado = solicitud_reserva.idestado
            inner join motivo_tipo_socio using(idmotivo_tipo_socio)
            inner join motivo on motivo.idmotivo = motivo_tipo_socio.idmotivo
            inner join instalacion on solicitud_reserva.idinstalacion = instalacion.idinstalacion
            where
              extract(MONTH FROM solicitud_reserva.fecha) < extract(MONTH FROM current_date) and
              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              solicitud_reserva.fecha, 
              instalacion.nombre , 
              estado.descripcion , 
              motivo.descripcion , 
              nro_personas,
              solicitud_reserva.monto,
              monto_final
            order by 
              fecha desc";
      $datos = consultar_fuente($sql);
      $resultado = array();
      foreach ($datos as $dato) 
      {
        if ($dato['monto_final']==$dato['pago_detalle'])
        {
          $dato['pago'] = 1;
        } else{
           $dato['pago'] = 0;
        }
        $resultado[] = $dato;
      }
      return $resultado;
  }

  function get_listado_forma_pago($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql = "SELECT  idforma_pago, 
                      descripcion,
                      planilla,
                      efectivo,
                      requiere_nro_comprobante 

              FROM 
                  public.forma_pago 
              
              where
                $where
              order by
                  planilla desc";
      return consultar_fuente($sql);
  }     

  function get_forma_pago_idforma_pago($idforma_pago = null)
  {
      
      $sql = "SELECT  idforma_pago, 
                      descripcion,
                      planilla,
                      efectivo,
                      requiere_nro_comprobante 

              FROM 
                  public.forma_pago 
              
              where
                idforma_pago = $idforma_pago
              order by
                  planilla desc";
      return consultar_fuente($sql);
  }   

  function get_listado_forma_pago_menos_planilla($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql = "SELECT  idforma_pago, 
                      descripcion,
                      planilla

              FROM 
                  public.forma_pago 
              
              where
                  planilla = false   and
                  $where
              order by
                  planilla,descripcion";
      return consultar_fuente($sql);
  } 

  function get_listado_forma_pago_planilla()
  {
    
      $sql = "SELECT  idforma_pago, 
                      descripcion
              FROM 
                  public.forma_pago 
              
              where
                planilla = true 
              order by
                  descripcion";
      return consultar_fuente($sql);
  }

  function get_listado_categoria_motivo($where = null)
  {
      if (!isset($where))
      {
        $where = '1 = 1';
      }
      $sql = "SELECT  idcategoria_motivo, 
                      descripcion
              FROM 
                  public.categoria_motivo
              where
                $where
                order by 
                  descripcion";
      return consultar_fuente($sql);
  }

  function get_descripcion_tipo_telefono($idtipo_telefono = null)
  {
    $sql = "SELECT  descripcion
            FROM 
              public.tipo_telefono
            where 
             idtipo_telefono=$idtipo_telefono";
    $res = consultar_fuente($sql);
    if (isset($res[0]['descripcion']))
    {
      return $res[0]['descripcion'] ;
    }

  }  

  function get_descripcion_tipo_documento($idtipo_documento = null)
  {
    $sql = "SELECT  sigla
            FROM 
              public.tipo_documento
            where 
             idtipo_documento = $idtipo_documento";
    $res = consultar_fuente($sql);
    if (isset($res[0]['sigla']))
    {
      return $res[0]['sigla'] ;
    }

  }

  function get_motivo_por_tipo_socio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idmotivo_tipo_socio, 
                    tipo_socio.descripcion as tipo_socio, 
                    motivo.descripcion as motivo,
                    monto_reserva, 
                    monto_limpieza_mantenimiento, 
                    monto_garantia,
                    COALESCE(monto_reserva,0) + COALESCE(monto_limpieza_mantenimiento,0) + COALESCE(monto_garantia,0) as total
            FROM 
            public.motivo_tipo_socio
            inner join tipo_socio using(idtipo_socio)
            inner join motivo using(idmotivo)
            inner join afiliacion using (idtipo_socio)
            where
              afiliacion.activa =  true and
              $where";

    return consultar_fuente($sql);
  }  

  function get_listado_motivo_por_tipo_socio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idmotivo_tipo_socio, 
                    tipo_socio.descripcion as tipo_socio, 
                    motivo.descripcion as motivo,
                    tipo_socio.descripcion||' - '||motivo.descripcion as motivo_tipo,
                    monto_reserva, 
                    monto_limpieza_mantenimiento, 
                    monto_garantia,
                    instalacion.nombre as instalacion,
                    monto_persona_extra,
                    porcentaje_senia,
                    COALESCE(monto_reserva,0) + COALESCE(monto_limpieza_mantenimiento,0) + COALESCE(monto_garantia,0) as total
            FROM 
            public.motivo_tipo_socio
            inner join tipo_socio using(idtipo_socio)
            inner join motivo using(idmotivo)
            left outer join instalacion using(idinstalacion)
            where
             $where";
    return consultar_fuente($sql);
  } 

  function get_monto_segun_motivo_por_tipo_socio($idmotivo_tipo_socio)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  
                    COALESCE(monto_reserva,0) + COALESCE(monto_limpieza_mantenimiento,0) + COALESCE(monto_garantia,0) as total
            FROM 
              public.motivo_tipo_socio
            where
              idmotivo_tipo_socio =  $idmotivo_tipo_socio";
    $motivo = consultar_fuente($sql);
    if(isset($motivo[0]['total']))
    {
      return $motivo[0]['total']; 
    }
  }
  function get_monto_porcentaje($idmotivo_tipo_socio)
  {
   
    $sql = "SELECT  
                    monto_reserva,
                    porcentaje_senia
            FROM 
              public.motivo_tipo_socio
            where
              idmotivo_tipo_socio =  $idmotivo_tipo_socio";
    $motivo = consultar_fuente($sql);
    if((isset($motivo[0]['monto_reserva'])) and (isset($motivo[0]['porcentaje_senia'])))
    {
        $datos['monto_porcentaje'] = $motivo[0]['monto_reserva'] *  ($motivo[0]['porcentaje_senia']/100);
        return $datos;
    }
  }

  function get_porcentaje_senia_reserva_segun_motivo_por_tipo_socio($idmotivo_tipo_socio)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  
                    porcentaje_senia
            FROM 
              public.motivo_tipo_socio
            where
              idmotivo_tipo_socio =  $idmotivo_tipo_socio";
    $motivo = consultar_fuente($sql);
    if(isset($motivo[0]['porcentaje_senia']))
    {
      return $motivo[0]['porcentaje_senia']; 
    }
  }

  function get_configuracion()
  {
    $sql = "SELECT  edad_maxima_bolsita_escolar,  
                    dias_confirmacion_reserva, 
                    limite_dias_para_reserva, 
                    porcentaje_confirmacion_reserva, 
                    minimo_meses_afiliacion, 
                    idconfiguracion,
                    limite_por_socio,
                    fecha_limite_pedido_convenio
            FROM 
              public.configuracion;";
    $res = consultar_fuente($sql);
    if (isset($res[0]))
    {
      return $res[0]; 
    }
  }

  function get_listado_claustro($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idclaustro, 
                    descripcion
            FROM 
              public.claustro
            where
              $where";
    return consultar_fuente($sql);
  }

  function get_listado_unidad_academica($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idunidad_academica, 
                    sigla, 
                    descripcion
            FROM 
            public.unidad_academica
            where
              $where";
    return consultar_fuente($sql);
  }

  function get_encabezado()
  {
    $sql = "SELECT  idencabezado, 
                    nombre_institucion, 
                    direccion, 
                    'Telefono: '||telefono as telefono, 
                    logo
            FROM 
              public.encabezado;";
    $res = consultar_fuente($sql);
    if(isset($res[0]))
    {
      return $res[0];
    }
  }

  function get_listado_novedades_familia($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  logs_familia.idpersona, 
                    logs_familia.idpersona_familia, 
                    logs_persona.apellido ||' - '||logs_persona.nombres as titular,
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    logs_parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    logs_familia.auditoria_usuario, 
                    logs_familia.auditoria_fecha, 
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    (CASE WHEN logs_familia.auditoria_operacion = 'I' then 'ALTA' else (CASE WHEN logs_familia.auditoria_operacion = 'D' then 'BAJA' else 'MODIFICACION' end) end) as tipo_movimiento, 
                    logs_familia.auditoria_id_solicitud,
                    logs_tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    public_auditoria.logs_familia
            inner join public_auditoria.logs_persona on logs_persona.idpersona=logs_familia.idpersona
            inner join public_auditoria.logs_persona familiar on familiar.idpersona=logs_familia.idpersona_familia
            inner join public_auditoria.logs_parentesco using(idparentesco)
            inner join public_auditoria.logs_tipo_documento on familiar.idtipo_documento = logs_tipo_documento.idtipo_documento
            where
              logs_familia.auditoria_operacion != 'U' and
              $where
          group by
                    logs_familia.idpersona, 
                    logs_familia.idpersona_familia, 
                    logs_persona.apellido,
                    logs_persona.nombres ,
                    familiar.apellido ,
                    familiar.nombres ,
                    logs_parentesco.descripcion , 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    logs_familia.auditoria_usuario, 
                    logs_familia.auditoria_fecha, 
                    familiar.fecha_nacimiento,
                    familiar.sexo ,
                    logs_familia.auditoria_operacion,
                    logs_familia.auditoria_id_solicitud,
                    logs_tipo_documento.sigla,
                     familiar.nro_documento 
            
            order by
              logs_familia.auditoria_fecha desc";
              
   /* $sql2 = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||' - '||persona.nombres as titular,
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga
            FROM 
                    public.familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)";*/
      return toba::db('auditoria')->consultar($sql);  


  }
  function get_perfiles_mupum()
  {
      $sql = "SELECT usuario_grupo_acc
              FROM 
                desarrollo.apex_usuario_grupo_acc
              where 
                proyecto = 'mupum' and
                usuario_grupo_acc != 'admin'";
      return toba::db('usuarios')->consultar($sql);  
  }

  function get_listado_categoria_comercio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idcategoria_comercio, 
                    descripcion
            FROM 
              public.categoria_comercio
            where
              $where
            order by
              descripcion";
    return consultar_fuente($sql);
  }

  function get_listado_comercios($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql =" SELECT  idcomercio, 
                    codigo ||' - '||categoria_comercio.descripcion ||' - '||nombre as nombre, 
                    direccion, 
                    nombre as comercio,
                    localidad.descripcion as localidad, 
                    categoria_comercio.descripcion as categoria,
                    codigo,
                    (case when tipo ='co' then 'Comercio' else (case when tipo ='pr' then 'Proveedor' else 'Comercio-Proveedor' end ) end ) as tipo
            FROM public.comercio
            inner join localidad using(idlocalidad)
            inner join categoria_comercio using(idcategoria_comercio)
            where
              $where
            order by
              categoria_comercio.descripcion";
    return consultar_fuente($sql);
  }  
  function get_listado_concepto($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql =" SELECT idconcepto, 
                  descripcion,
                  senia,
                  pago_infraestructura,
                  proveedor,
                  reserva
            FROM public.concepto

            where
              $where
            order by
              descripcion";
    return consultar_fuente($sql);
  }  
  function get_listado_concepto_reserva($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql =" SELECT idconcepto, 
                  descripcion,
                  senia,
                  pago_infraestructura,
                  proveedor,
                  reserva
            FROM public.concepto

            where
              reserva = true and
              $where
            order by
              descripcion";
    return consultar_fuente($sql);
  }  

  function get_listado_concepto_infraestructura($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql =" SELECT idconcepto, 
                  descripcion,
                  senia,
                  pago_infraestructura,
                  proveedor
            FROM public.concepto

            where
              pago_infraestructura = true and
              $where";
    return consultar_fuente($sql);
  }

  function get_listado_concepto_senia()
  {
    $sql =" SELECT idconcepto, 
                  descripcion
            FROM public.concepto

            where
              senia = true";
    return consultar_fuente($sql);
  }

  function get_mensaje_excedente_por_persona_reserva($idinstalacion = null, $idmotivo_tipo_socio = null)
  {
    $sql1 = " SELECT monto_persona_extra
              FROM 
                public.motivo_tipo_socio
              where 
              idmotivo_tipo_socio = $idmotivo_tipo_socio";
    $montos = consultar_fuente($sql1);         

    $sql2 = " SELECT  cantidad_maxima_personas,  
                      cantidad_personas_reserva
              FROM 
                public.instalacion
              where 
                idinstalacion = $idinstalacion";
    $cantidades = consultar_fuente($sql2);  

    $monto_excedente = $montos[0]['monto_persona_extra'];
    $capacidad_permitida =  $cantidades[0]['cantidad_personas_reserva'];
    $capacidad_maxima =  $cantidades[0]['cantidad_maxima_personas'];

    $mensaje =  '<p>El monto de la reserva es hasta '. $capacidad_permitida.' personas.</br> Por cada persona extra se cobrara: $'.$monto_excedente.'</p>';
   
    return $mensaje;
  }
  function get_monto_por_persona_excedente( $idmotivo_tipo_socio = null)
  {
    $sql1 = " SELECT monto_persona_extra
              FROM 
                public.motivo_tipo_socio
              where 
              idmotivo_tipo_socio = $idmotivo_tipo_socio";
    $montos = consultar_fuente($sql1);         

  

   return $montos[0]['monto_persona_extra'];
    
  }

  function get_capacidad_reserva_instalacion($idinstalacion = null)
  {
        

    $sql2 = " SELECT  cantidad_maxima_personas,  
                      cantidad_personas_reserva
              FROM 
                public.instalacion
              where 
                idinstalacion = $idinstalacion";
    $cantidades = consultar_fuente($sql2);  

    $capacidad_permitida =  $cantidades[0]['cantidad_personas_reserva'];
    $capacidad_maxima =  $cantidades[0]['cantidad_maxima_personas'];

    return $capacidad_permitida ;
  }

  function get_capacidad_maxima_instalacion($idinstalacion = null)
  {
        

    $sql2 = " SELECT  cantidad_maxima_personas,  
                      cantidad_personas_reserva
              FROM 
                public.instalacion
              where 
                idinstalacion = $idinstalacion";
    $cantidades = consultar_fuente($sql2);  

    $capacidad_permitida =  $cantidades[0]['cantidad_personas_reserva'];
    $capacidad_maxima =  $cantidades[0]['cantidad_maxima_personas'];

    return $capacidad_maxima ;
  }

  function get_listado_convenios($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket,
                      ayuda_economica,
                      (case when activo = true then 'Activos' else 'Inactivos' end) as estado
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 

                $where";
      return consultar_fuente($sql);
          
  }  

  function get_listado_convenios_segun_categoria($idcategoria_comercio = null)
  {

      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket,
                      ayuda_economica,
                      (case when activo = true then 'Activos' else 'Inactivos' end) as estado
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 

                convenio.idcategoria_comercio = $idcategoria_comercio";
      return consultar_fuente($sql);
          
  }

  function get_listado_convenios_con_bono($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 
                maneja_bono = true and
                convenio.activo = true and
                $where";
      return consultar_fuente($sql);
          
  }  

  function get_listado_convenios_con_ticket($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 
                consumo_ticket = true and
                convenio.activo = true and
                $where";
      return consultar_fuente($sql);
          
  } 

  function get_listado_convenios_con_financiamiento($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 
                permite_financiacion = true and
                convenio.activo = true and
                (convenio.ayuda_economica is null or convenio.ayuda_economica = false) and
                $where";
      return consultar_fuente($sql);
          
  }  

  function get_listado_convenios_ayuda_economica($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
      $sql = "SELECT  idconvenio, 
                      categoria_comercio.descripcion as categoria, 
                      titulo, 
                      fecha_inicio, 
                      fecha_fin, 
                      maximo_cuotas, 
                      monto_maximo_mensual, 
                      permite_financiacion, 
                      activo, 
                      maneja_bono,
                      consumo_ticket
              FROM 
                public.convenio
              inner join categoria_comercio using (idcategoria_comercio)
              where 
                ayuda_economica = true and
                convenio.activo = true and
                $where";
      return consultar_fuente($sql);
          
  }

  function get_listado_comercios_por_convenio($idconvenio = null)
  {
    
    $sql =" SELECT   comercio.idcomercio, 
                   comercio.codigo||' - '|| categoria_comercio.descripcion ||' - '||comercio.nombre as nombre, 
                    comercio.direccion, 
                    localidad.descripcion as localidad, 
                    categoria_comercio.descripcion as categoria
            FROM public.comercio
            inner join localidad using(idlocalidad)
            inner join categoria_comercio using(idcategoria_comercio)
            inner join comercios_por_convenio using (idcomercio)
            where
              comercios_por_convenio.idconvenio = $idconvenio ";
    return consultar_fuente($sql);
  }  

  function get_comercios_combo_editable($filtro = null)
  {
    if (! isset($filtro) || trim($filtro)=='')
    {
      return array();
    }
    $filtro = quote("%{$filtro}%");

    $sql = "  SELECT idcomercio, codigo ||' - '||categoria_comercio.descripcion ||' - '||nombre as nombre, direccion, idlocalidad
              FROM public.comercio
              inner join categoria_comercio using (idcategoria_comercio)
              WHERE 
                   codigo ||' - '||categoria_comercio.descripcion ||' - '||nombre ilike $filtro limit 20 ";
    return consultar_fuente($sql);

  } 

  function get_descripcion_comercio($idcomercio = null)
  {
    $sql = "SELECT idcomercio, codigo ||' - '||categoria_comercio.descripcion ||' - '||nombre as nombre, direccion, idlocalidad
              FROM public.comercio
            inner join categoria_comercio using (idcategoria_comercio)
            WHERE 
              comercio.idcomercio =  $idcomercio";
    $res = consultar_fuente($sql);
    if (isset($res[0]['nombre']))
    {
      return $res[0]['nombre'];
    }

  }

  function get_listado_reempadronamiento ($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idreempadronamiento, 
                    nombre, 
                    anio, 
                    activo
            FROM 
              public.reempadronamiento 
            where 
                $where";
      return consultar_fuente($sql);

  }  

  function get_listado_solicitudes_reempadronamientos ($idreempadronamiento = null)
  {

    $sql = "SELECT  idreempadronamiento,  
                    idafiliacion, 
                    notificaciones, 
                    fecha_notificacion, 
                    atendida,
                    (apellido||', '|| nombres) as socio,
                    correo,
                    persona.idpersona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento  as documento

            FROM 
              public.solicitud_reempadronamiento
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join tipo_documento on tipo_documento.idtipo_documento = persona.idtipo_documento
            where 
                  notificaciones = 0 and
                  solicitud_reempadronamiento.idreempadronamiento =$idreempadronamiento
            order by
                  apellido, nombres";
      return consultar_fuente($sql);

  }  

  function get_listado_solicitudes_reempadronamientos_enviadas ($idreempadronamiento = null)
  {

    $sql = "SELECT  idreempadronamiento,  
                    idafiliacion, 
                    notificaciones, 
                    fecha_notificacion, 
                    atendida,
                    (apellido||', '|| nombres) as socio,
                    correo,
                    persona.idpersona,
                    tipo_documento.sigla ||'-'|| persona.nro_documento  as documento

            FROM 
              public.solicitud_reempadronamiento
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join tipo_documento on tipo_documento.idtipo_documento = persona.idtipo_documento
            where 
                  notificaciones != 0 and
                  solicitud_reempadronamiento.idreempadronamiento = $idreempadronamiento
            order by
                  apellido, nombres";
      return consultar_fuente($sql);

  }

   function get_solicitud_reempadronamiento_no_atenida ($idpersona = null)
  {

    $sql = "SELECT  idreempadronamiento,  
                    idafiliacion, 
                    notificaciones, 
                    fecha_notificacion, 
                    atendida,
                    (apellido||', '|| nombres) as socio,
                    correo,
                    persona.idpersona

            FROM 
              public.solicitud_reempadronamiento
            inner join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            where 
                  atendida = false and
                  afiliacion.activa = true and
                  notificaciones > 0 and
                  persona.idpersona =$idpersona";
      return consultar_fuente($sql);

  }

  function get_correo_persona($idpersona = null)
  {
    $sql = "SELECT  correo
                  
            FROM 
              public.persona
            where   
              idpersona = $idpersona";
    $res = consultar_fuente($sql);
    if (isset($res[0]['correo']))
    {
      return $res[0]['correo'];
    }
  }

  function get_cantidad_solicitudes_no_atendidas()
  {
    $sql = "SELECT count(*) as cantidad 
            FROM public.solicitud_reempadronamiento
             inner join afiliacion using(idafiliacion)
            where 
              atendida = false and
                  afiliacion.activa = true and
                  notificaciones > 0 ";
    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  }

  function get_listado_talonario_bono($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  talonario_bono.idtalonario_bono, 
                    convenio.titulo as convenio, 
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    nro_talonario, 
                    nro_inicio, 
                    nro_fin,
                    monto_bono,
                    (cantidad_numeros_vendidos_talonario_bono(talonario_bono.idtalonario_bono)) as cantidad_vendidos
            FROM public.talonario_bono
            inner join comercio using(idcomercio)
            inner join convenio using(idconvenio)
            where 
                $where
            order by
              convenio, comercio.nombre";
      return consultar_fuente($sql);
  }

  function get_idconvenio_talonario_bono($idtalonario_bono = null)
  {
    $sql = "SELECT idconvenio
            FROM 
              public.comercios_por_convenio
            inner join talonario_bono using(idconvenio)
            where 
              idtalonario_bono = $idtalonario_bono";
    $res = consultar_fuente($sql);
    if (isset($res[0]['idconvenio']))
    {
      return $res[0]; 
    }
  }  

  function get_idcomercio_talonario_bono($idtalonario_bono = null)
  {
    $sql = "SELECT idcomercio
            FROM 
              public.comercios_por_convenio
            inner join talonario_bono using(idcomercio)
            where 
              idtalonario_bono = $idtalonario_bono";
    $res = consultar_fuente($sql);
    if (isset($res[0]['idcomercio']))
    {
      return $res[0]['idcomercio']; 
    }
  }

  function  get_talonarios($idconvenio = null)
  {
    $sql = "SELECT  idtalonario_bono, 
                    comercio.codigo ||' - '||comercio.nombre ||'- Talonario Nro: '|| nro_talonario as talonario
            FROM 
              public.talonario_bono
          inner join comercios_por_convenio using(idcomercio,idconvenio)
          inner join comercio on comercio.idcomercio = comercios_por_convenio.idcomercio
          WHERE
            comercios_por_convenio.idconvenio = $idconvenio ";
    return consultar_fuente($sql);
  }

  function get_listado_consumos_bono_historico($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconsumo_convenio, 
                    idtalonario_bono, 
                    (persona.apellido||', '|| persona.nombres) as socio,
                    talonario_bono.monto_bono,
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio,
                    cantidad_bonos,
                    cantidad_bonos *   talonario_bono.monto_bono as total,
                    fecha
            FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner  join talonario_bono using(idtalonario_bono) 
            inner join convenio on convenio.idconvenio = talonario_bono.idconvenio
            inner join comercio on comercio.idcomercio= talonario_bono.idcomercio
            WHERE
             extract(month from fecha ) < extract(month from (current_date - (2||' months')::interval)) and
              $where
            order by
              fecha desc";
      return consultar_fuente($sql);
  }    

  function get_listado_consumos_bono_ultimos_tres_meses($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconsumo_convenio, 
                    idtalonario_bono, 
                    (persona.apellido||', '|| persona.nombres) as socio,
                    talonario_bono.monto_bono,
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio,
                    cantidad_bonos,
                    cantidad_bonos *   talonario_bono.monto_bono as total,
                    fecha
              FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner  join talonario_bono using(idtalonario_bono) 
            inner join convenio on convenio.idconvenio = talonario_bono.idconvenio
            inner join comercio on comercio.idcomercio= talonario_bono.idcomercio
            where extract(month from fecha ) between extract(month from (current_date - (2||' months')::interval)) and extract(month from current_date ) and
                  $where
            order by
              convenio.titulo,fecha desc,socio";
      return consultar_fuente($sql);
  }  

  function get_listado_consumos_ticket_ultimos_tres_meses($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconsumo_convenio, 
                    
                    (persona.apellido||', '|| persona.nombres) as socio,
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    total,
                    periodo,
                    periodo   as mes,
                    (total_abonado_detalle_pago_consumo_convenio(consumo_convenio.idconsumo_convenio)) as total_abonado                
            FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner join comercios_por_convenio using(idconvenio,idcomercio)
            inner join convenio on convenio.idconvenio = comercios_por_convenio.idconvenio
            inner join comercio on comercio.idcomercio= comercios_por_convenio.idcomercio
            WHERE
              substring(periodo, 1,2)::integer between extract(month from (current_date - (2||' months')::interval)) and extract(month from current_date ) and
              convenio.consumo_ticket = true and
              $where
            order by mes desc,socio ";
      return consultar_fuente($sql);
  }
  function get_listado_consumos_ticket_historico($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconsumo_convenio, 
                    
                    (persona.apellido||', '|| persona.nombres) as socio,
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    total,
                    periodo,
                    periodo as mes                
            FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner join comercios_por_convenio using(idconvenio,idcomercio)
            inner join convenio on convenio.idconvenio = comercios_por_convenio.idconvenio
            inner join comercio on comercio.idcomercio= comercios_por_convenio.idcomercio
            WHERE
              substring(periodo, 1,2)::integer < extract(month from (current_date - (2||' months')::interval)) and
              convenio.consumo_ticket = true and
              $where
            order by mes desc";
      return consultar_fuente($sql);
  }
  function get_listado_consumos_financiado($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  consumo_convenio.idconsumo_convenio, 
                    (persona.apellido||', '|| persona.nombres) as socio,
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    total, 
                    fecha, 
                    monto_proforma, 
                    cantidad_cuotas, 
                    descripcion,  
   
                    (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) as cantidad_pagas
            FROM 
                public.consumo_convenio
            inner  join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join comercios_por_convenio using(idconvenio,idcomercio)
            inner join convenio on convenio.idconvenio = comercios_por_convenio.idconvenio
            inner join comercio on comercio.idcomercio= comercios_por_convenio.idcomercio
            inner join consumo_convenio_cuotas using (idconsumo_convenio)
            WHERE
              convenio.permite_financiacion = true and
              
              (convenio.ayuda_economica is null or convenio.ayuda_economica = false) and
                (consumo_convenio_cuotas.cuota_pagada =  false or
               ((current_date - (2||' months')::interval)  <= (select traer_fecha_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)))) and 
              $where
          
            group by 
              consumo_convenio.idconsumo_convenio, 
              socio,
              comercio, 
              convenio ,
              total, 
              fecha, 
              monto_proforma, 
              cantidad_cuotas, 
              descripcion
            order by fecha desc";
      return consultar_fuente($sql);
  }  

  function get_listado_consumos_financiado_historico($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  consumo_convenio.idconsumo_convenio, 
                    (persona.apellido||', '|| persona.nombres) as socio,
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    total, 
                    fecha, 
                    monto_proforma, 
                    cantidad_cuotas, 
                    descripcion,  
                    (traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) as cantidad_pagas
            FROM 
                public.consumo_convenio
            inner  join afiliacion using(idafiliacion)
            inner join persona on persona.idpersona = afiliacion.idpersona
            inner join comercios_por_convenio using(idconvenio,idcomercio)
            inner join convenio on convenio.idconvenio = comercios_por_convenio.idconvenio
            inner join comercio on comercio.idcomercio= comercios_por_convenio.idcomercio
            inner join consumo_convenio_cuotas using (idconsumo_convenio)
            WHERE
              convenio.permite_financiacion = true and
               consumo_convenio_cuotas.cuota_pagada =  true and
              (convenio.ayuda_economica is null or convenio.ayuda_economica = false) and
               
               ((current_date - (3||' months')::interval)  >= (select traer_fecha_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio))) and 
              $where
          
            group by 
             consumo_convenio.idconsumo_convenio, 
                   socio,
                     comercio, 
                    convenio ,
                    total, 
                    fecha, 
                    monto_proforma, 
                    cantidad_cuotas, 
                    descripcion 
            having 
              cantidad_cuotas = count(consumo_convenio_cuotas.idconsumo_convenio_cuotas)
            order by fecha desc";
      return consultar_fuente($sql);
  }
  
  function get_listado_ayuda_economica($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
     $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  consumo_convenio.idconsumo_convenio,               
                    (persona.apellido||', '|| persona.nombres) as socio,                  
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    sum(consumo_convenio_cuotas.monto)as total, 
                    fecha, 
                    cantidad_cuotas,
                    consumo_convenio.total as total_solicitado,
                    (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) as cantidad_pagas,
                    consumo_convenio_cuotas.monto_puro  as valor_cuota ,
                    (case when pagado = true then 'ACEPTADA' else (case when pagado = false then 'RECHAZADA' else 'PENDIENTE' end) end) as pagado        
           
            FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner join convenio using(idconvenio)
            inner join consumo_convenio_cuotas using(idconsumo_convenio)
            WHERE
              convenio.ayuda_economica = true and 
              $sql_usuario and
              $where
            group by 
              consumo_convenio.idconsumo_convenio,
              persona.apellido, 
              persona.nombres, 
              convenio.titulo,
              convenio.monto_maximo_mensual,
              total, 
              fecha, 
              cantidad_cuotas,
              consumo_convenio_cuotas.monto_puro 
            order by fecha desc";
      return consultar_fuente($sql);
  }  

  function get_listado_ayuda_economica_mutual($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
 
    $sql = "SELECT  consumo_convenio.idconsumo_convenio,               
                    (persona.apellido||', '|| persona.nombres) as socio,                  
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    sum(consumo_convenio_cuotas.monto)as total, 
                    fecha, 
                    cantidad_cuotas,
                    consumo_convenio.total as total_solicitado,
                     (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) as cantidad_pagas,
                     (select traer_periodo_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)) as perido_max_nro_cuota,
                     (select traer_fecha_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)) as fecha_max_nro_cuota,
                    consumo_convenio_cuotas.monto_puro  as valor_cuota,
                    (case when pagado = true then 'ACEPTADA' else (case when pagado = false then 'RECHAZADA' else 'PENDIENTE' end) end) as pagado        
            FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner join convenio using(idconvenio)
            inner join consumo_convenio_cuotas using(idconsumo_convenio)
            WHERE
              convenio.ayuda_economica = true and 
               (consumo_convenio_cuotas.cuota_pagada =  false or
               ((current_date - (2||' months')::interval)  <= (select traer_fecha_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)))) and
              $where
            group by 
              consumo_convenio.idconsumo_convenio,
              persona.apellido, 
              persona.nombres, 
              convenio.titulo,
              convenio.monto_maximo_mensual,
              total, 
              fecha, 
              cantidad_cuotas,
              consumo_convenio_cuotas.monto_puro 
            order by fecha desc";
      return consultar_fuente($sql);
  } 

  function get_listado_ayuda_economica_mutual_historico($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }

    $sql = "SELECT  consumo_convenio.idconsumo_convenio,               
                    (persona.apellido||', '|| persona.nombres) as socio,                  
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    cantidad_cuotas * consumo_convenio_cuotas.monto as total, 
                    fecha, 
                    cantidad_cuotas,
                    (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) as cantidad_pagas,
                    consumo_convenio_cuotas.monto  as valor_cuota,
                    (case when pagado = true then 'ACEPTADA' else (case when pagado = false then 'RECHAZADA' else 'PENDIENTE' end) end) as pagado        
        
            FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner join convenio using(idconvenio)
            inner join consumo_convenio_cuotas using(idconsumo_convenio)
            WHERE
              convenio.ayuda_economica = true and 
              consumo_convenio_cuotas.cuota_pagada =  true and 
              (consumo_convenio_cuotas.cuota_pagada =  false or
               ((current_date - (3||' months')::interval)  >= (select traer_fecha_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)))) and 
              $where
            group by 
              consumo_convenio.idconsumo_convenio,
              persona.apellido, 
              persona.nombres, 
              convenio.titulo,
              convenio.monto_maximo_mensual,
              total, 
              fecha, 
              cantidad_cuotas,
              consumo_convenio_cuotas.monto 
              having 
              cantidad_cuotas = count(consumo_convenio_cuotas.idconsumo_convenio_cuotas)
            order by fecha desc";
      return consultar_fuente($sql);
  }

  function get_listado_mis_consumos($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  (persona.apellido||', '|| persona.nombres) as socio,
                    convenio.titulo as convenio,
                    comercio.codigo ||'-'||comercio.nombre as comercio, 
                    total, 
                    (case when fecha is null then periodo else to_char(fecha, 'MM/YYYY') end) as periodo,
                    (case when cantidad_cuotas > 0 then cantidad_cuotas else null end ) as cantidad_cuotas,
                    (case when (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) > 0 then (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) else null end) as cantidad_pagas,
                    null as monto_bono,
                    null as cantidad_bonos
                  
            FROM 
              public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join comercio on comercio.idcomercio = consumo_convenio.idcomercio
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
              $sql_usuario and 
              $where
            group by
                    persona.apellido, 
                    persona.nombres,
                    convenio.titulo ,
                    comercio.codigo,
                    comercio.nombre , 
                    total, 
                    fecha, 
                    periodo,
                    cantidad_cuotas, 
                    cantidad_bonos, 
                    comercio.nombre ,
                    consumo_convenio.idconsumo_convenio
            UNION
            SELECT 
                  (persona.apellido||', '|| persona.nombres) as socio,
                  convenio.titulo as convenio,
                  comercio.codigo ||'-'||comercio.nombre as comercio, 
                  cantidad_bonos *   talonario_bono.monto_bono as total,
                  (case when fecha is null then periodo else to_char(fecha, 'MM/YYYY') end) as periodo,
                  null as cantidad_cuotas,
                  null as cuotas_pagas,
                  talonario_bono.monto_bono,
                  cantidad_bonos
                    
                    
              FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner  join talonario_bono using(idtalonario_bono) 
            inner join convenio on convenio.idconvenio = talonario_bono.idconvenio
            inner join comercio on comercio.idcomercio= talonario_bono.idcomercio
            where
              $sql_usuario and 
              $where
            order by
              convenio,socio";
        return consultar_fuente($sql);
  }

  function get_cuotas_pagas_consumo_convenio($idconsumo_convenio = null)
  {
    $sql = "SELECT idconsumo_convenio_cuotas, 
                    idconsumo_convenio, 
                    nro_cuota, 
                    periodo, 
                    envio_descuento, 
                    monto, 
                    forma_pago.descripcion as forma_pago, 
                    interes, 
                    monto_puro, 
                    cuota_pagada, 
                    fecha_pago
            FROM public.consumo_convenio_cuotas
          inner join forma_pago using(idforma_pago)
          where 
            cuota_pagada = true and
            idconsumo_convenio = $idconsumo_convenio
            order by 
             nro_cuota asc ";
     return consultar_fuente($sql); 
  }

  function get_nros_bonos_segun_talonario_cantidad($idtalonario_bono =null, $cantidad= null)
  {
    $sql = "SELECT  idtalonario_bono, 
                    nro_bono, 
                    disponible, 
                    idafiliacion
            FROM 
            public.talonario_nros_bono
            where 
              disponible = true and
              idtalonario_bono = $idtalonario_bono
            order by 
              nro_bono asc
            limit 
              $cantidad";
      return consultar_fuente($sql);
  } 
  function get_nros_bonos_segun_talonario($idtalonario_bono =null)
  {
    $sql = "SELECT  idtalonario_bono, 
                    nro_bono, 
                    disponible, 
                    idafiliacion
            FROM 
            public.talonario_nros_bono
            where 
              disponible = true and
              idtalonario_bono = $idtalonario_bono
            order by 
              nro_bono asc";
      return consultar_fuente($sql);
  }

  function get_monto_bono($idtalonario_bono = null)
  {
    $sql = "SELECT monto_bono
            FROM public.talonario_bono
            WHERE
              idtalonario_bono = $idtalonario_bono";
    $res = consultar_fuente($sql);
    if (isset($res[0]['monto_bono']))
    {
      return $res[0]['monto_bono'];
    }
  }

  function get_monto_maximo_convenio($idconvenio = null)
  {
    $sql = "SELECT  maximo_cuotas, 
                    monto_maximo_mensual
            FROM 
              public.convenio
            where 
              convenio.idconvenio = $idconvenio";

    $res = consultar_fuente($sql);
    if (isset($res[0]['monto_maximo_mensual']))
    {
      return $res[0]['monto_maximo_mensual'];
    }
  } 

  function get_maximo_cuotas_convenio($idconvenio = null)
  {
    $sql = "SELECT  maximo_cuotas, 
                    monto_maximo_mensual
            FROM 
              public.convenio
            where 
              convenio.idconvenio = $idconvenio";

    $res = consultar_fuente($sql);
    if (isset($res[0]['maximo_cuotas']))
    {
      return $res[0]['maximo_cuotas'];
    }
  }  

  function get_minimo_coutas_para_pedir_otra_ayuda()
  {
    $sql = "SELECT  faltando_cuotas
            FROM 
              public.convenio
            where 
              ayuda_economica = true and
              activo = true";

    $res = consultar_fuente($sql);
    if (isset($res[0]['faltando_cuotas']))
    {
      return $res[0]['faltando_cuotas'];
    } else {
      return 0;
    }
  }   
  
  function get_ayuda_economicas_pendientes()
  {
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  count(*) as cantidad
            FROM public.consumo_convenio
            inner join convenio using(idconvenio)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
              ayuda_economica = true and
              pagado is null and
              $sql_usuario";

    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  }  
  function get_ayuda_economicas_pendientes_socio($idafiliacion)
  {
    $sql = "SELECT  count(*) as cantidad
            FROM public.consumo_convenio
            inner join convenio using(idconvenio)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
              ayuda_economica = true and
              pagado is null and
              afiliacion.idafiliacion = $idafiliacion";

    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  }  



  function get_minimo_coutas_para_pedir_otra_consumo_financiado($idconvenio)
  {
    $sql = "SELECT  faltando_cuotas
            FROM 
              public.convenio
            where 
              ayuda_economica = false and
              permite_financiacion = true and
              activo = true and
              convenio.idconvenio = $idconvenio";

    $res = consultar_fuente($sql);
    if (isset($res[0]['faltando_cuotas']))
    {
      return $res[0]['faltando_cuotas'];
    }
  }
  
  function get_cuotas_faltantes_ayuda()
  {
    $sql_usuario = self::get_sql_usuario();
    $sql = "  SELECT  count(idconsumo_convenio_cuotas)  as cuotas_sin_pagar            
       
                      FROM 
                          public.consumo_convenio
                      inner  join afiliacion using(idafiliacion)
                      inner join convenio  using(idconvenio)
                      inner join consumo_convenio_cuotas using (idconsumo_convenio)
                      inner join persona on persona.idpersona = afiliacion.idpersona
                      WHERE
                        convenio.ayuda_economica = true and
                        consumo_convenio_cuotas.cuota_pagada =  false and
                        $sql_usuario";
      $res = consultar_fuente($sql);
      $cuotasfaltantes = 0;
      if (isset($res[0]['cuotas_sin_pagar']))
      {
        $cuotasfaltantes = $res[0]['cuotas_sin_pagar'];
      }
      return $cuotasfaltantes;

  }   

  function get_cuotas_faltantes_ayuda_socio($idafiliacion)
  {
    $sql = "  SELECT  count(idconsumo_convenio_cuotas)  as cuotas_sin_pagar            
       
                      FROM 
                          public.consumo_convenio
                      inner  join afiliacion using(idafiliacion)
                      inner join convenio  using(idconvenio)
                      inner join consumo_convenio_cuotas using (idconsumo_convenio)
                      inner join persona on persona.idpersona = afiliacion.idpersona
                      WHERE
                        convenio.ayuda_economica = true and
                        consumo_convenio_cuotas.cuota_pagada =  false and
                        afiliacion.idafiliacion = $idafiliacion";
      $res = consultar_fuente($sql);
      $cuotasfaltantes = 0;
      if (isset($res[0]['cuotas_sin_pagar']))
      {
        $cuotasfaltantes = $res[0]['cuotas_sin_pagar'];
      }
      return $cuotasfaltantes;

  }  

  function get_cuotas_faltantes_consumo_financiado($idconvenio, $idafiliacion)
  {
    $sql_usuario = self::get_sql_usuario();
    $sql = "  SELECT  count(idconsumo_convenio_cuotas)  as cuotas_sin_pagar            
       
                      FROM 
                          public.consumo_convenio
                      inner  join afiliacion using(idafiliacion)
                      inner join convenio  using(idconvenio)
                      inner join consumo_convenio_cuotas using (idconsumo_convenio)
                      inner join persona on persona.idpersona = afiliacion.idpersona
                      WHERE
                        convenio.permite_financiacion = true and
                        convenio.ayuda_economica = false and
                        consumo_convenio_cuotas.cuota_pagada =  false and
                        afiliacion.idafiliacion = $idafiliacion and
                        convenio.idconvenio = $idconvenio";
      $res = consultar_fuente($sql);
      $cuotasfaltantes = 0;
      if (isset($res[0]['cuotas_sin_pagar']))
      {
        $cuotasfaltantes = $res[0]['cuotas_sin_pagar'];
      }
      return $cuotasfaltantes;

  }

  function get_listado_configuracion_bolsita($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconfiguracion_bolsita, 
                    anio, 
                    inicio, 
                    fin
            FROM 
              public.configuracion_bolsita
            WHERE
              $where
            order by
              anio asc";
      return consultar_fuente($sql);
  }   

  function get_listado_configuracion_bolsita_controlada($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconfiguracion_bolsita, 
                    anio, 
                    inicio, 
                    fin
            FROM 
              public.configuracion_bolsita
            WHERE
              current_date between inicio and fin
            order by
              anio asc";
      return consultar_fuente($sql);
  }  

  function get_listado_nivel_bolsita($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idnivel, 
                    descripcion, 
                    edad_minima, 
                    edad_maxima, 
                    es_bolsita
            FROM public.nivel
            WHERE
              $where
            order by
              descripcion";
      return consultar_fuente($sql);
  }

  function get_listado_familia_menores_edad($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||', '||persona.nombres as titular,
                    familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            where 
              extract(year from age( familiar.fecha_nacimiento)) < 18 and
              $sql_usuario and
              $where";
      return consultar_fuente($sql);
  } 

  function get_listado_familiares($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||' - '||persona.nombres as titular,
                    parentesco.descripcion||': '||familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            where 
              
              $sql_usuario and
              $where";
      return consultar_fuente($sql);
  } 

  function get_datos_familiar($idfamiliar = null)
  {
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.correo,
                    persona.apellido ||', '||persona.nombres as titular,
                    familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    tipo_documento.sigla||' - '||familiar.nro_documento as documento,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            where 
              $sql_usuario and
              familia.idpersona_familia = $idfamiliar 
              ";
      return consultar_fuente($sql);
  }  

  function get_listado_familia_menores_edad_que_usan_bolsita($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||' - '||persona.nombres as titular,
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            where 
              extract(year from age( familiar.fecha_nacimiento)) < 22 and
              $sql_usuario and
              parentesco.bolsita_escolar = true and
              $where";
      return consultar_fuente($sql);
  } 

  function get_listado_familia_menores_edad_que_van_colonia($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||' - '||persona.nombres as titular,
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            where 
              extract(year from age( familiar.fecha_nacimiento)) < 18 and
              $sql_usuario and
              parentesco.colonia = true and
              $where";
      return consultar_fuente($sql);
  }  

  function get_listado_familia_menores_edad_que_van_colonia_segun_titular($idafiliacion = null)
  {

    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||' - '||persona.nombres as titular,
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||'-'|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join afiliacion on afiliacion.idpersona = persona.idpersona 
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            where 
              extract(year from age( familiar.fecha_nacimiento)) <= 21 and
              $sql_usuario and
              parentesco.colonia = true and
              afiliacion.activa =true and
              afiliacion.idafiliacion = $idafiliacion ";
      return consultar_fuente($sql);
  }

  function get_edad_familiar($idpersona_familia)
  {
    $sql = "SELECT  
                    extract(year from age( familiar.fecha_nacimiento)) as edad

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            
            where 
              idpersona_familia = $idpersona_familia";
    $res = consultar_fuente($sql);
    if (isset($res[0]['edad']))
    {
      return $res[0]['edad'];
    }
  }  

  function get_edad_minima_nivel($idnivel)
  {
    $sql = "SELECT  
                   edad_minima as minima

            FROM 
                    nivel
            where 
              idnivel = $idnivel";
    $res = consultar_fuente($sql);
    if (isset($res[0]['minima']))
    {
      return $res[0]['minima'];
    }
  }  

  function get_edad_maxima_nivel($idnivel)
  {
       $sql = "SELECT  
                   edad_maxima as maxima

            FROM 
                    nivel
            where 
              idnivel = $idnivel";
    $res = consultar_fuente($sql);
    if (isset($res[0]['maxima']))
    {
      return $res[0]['maxima'];
    }
  }
  function get_listado_solicitudes_bolsita_escolar($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  solicitud_bolsita.idsolicitud_bolsita, 
                    familia.idpersona_familia, 
                    familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    persona.apellido ||', '||persona.nombres as titular,
                    solicitud_bolsita.fecha_solicitud, 
                    nivel.descripcion as nivel, 
                    observacion, 
                    fecha_entrega,
                    (case when entregado is null then 'PENDIENTE' else (case when entregado = true then 'ENTREGADO' else 'RECHAZADO' end) end) as estado,
                    configuracion_bolsita.anio
            FROM 
              public.solicitud_bolsita
              inner join nivel using(idnivel) 
              inner join familia using(idpersona_familia)
              inner join persona familiar on familiar.idpersona=familia.idpersona_familia
              inner join persona on familia.idpersona=persona.idpersona
              inner join configuracion_bolsita using(idconfiguracion_bolsita)
            where 
              $sql_usuario and 
              $where";
      return consultar_fuente($sql);
  }  

  function get_listado_solicitudes_bolsita_escolar_administrar($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  solicitud_bolsita.idsolicitud_bolsita, 
                    familia.idpersona_familia, 
                    familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    persona.legajo ||' - '||persona.apellido ||', '||persona.nombres as titular,
                    solicitud_bolsita.fecha_solicitud, 
                    nivel.descripcion as nivel, 
                    observacion, 
                    fecha_entrega,
                    (case when entregado is null then 'PENDIENTE' else (case when entregado = true then 'ENTREGADO' else 'RECHAZADO' end) end) as estado,
                    configuracion_bolsita.anio
            FROM 
              public.solicitud_bolsita
              inner join nivel using(idnivel) 
              inner join familia using(idpersona_familia)
              inner join persona familiar on familiar.idpersona=familia.idpersona_familia
              inner join persona on familia.idpersona=persona.idpersona
              inner join configuracion_bolsita using(idconfiguracion_bolsita)
            where 
              entregado is null and
              $where ";
      return consultar_fuente($sql);
  }  

  function get_listado_solicitudes_bolsita_escolar_historial($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  solicitud_bolsita.idsolicitud_bolsita, 
                    familia.idpersona_familia, 
                    familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    persona.legajo ||', '||persona.apellido ||', '||persona.nombres as titular,
                    solicitud_bolsita.fecha_solicitud, 
                    nivel.descripcion as nivel, 
                    observacion, 
                    fecha_entrega,
                    fecha_rechazo,
                    (case when entregado is null then 'PENDIENTE' else (case when entregado = true then 'ENTREGADO' else 'RECHAZADO' end) end) as estado,
                    configuracion_bolsita.anio
            FROM 
              public.solicitud_bolsita
              inner join nivel using(idnivel) 
              inner join familia using(idpersona_familia)
              inner join persona familiar on familiar.idpersona=familia.idpersona_familia
              inner join persona on familia.idpersona=persona.idpersona
              inner join configuracion_bolsita using(idconfiguracion_bolsita)
            where 
              entregado is not null and
              $where ";
      return consultar_fuente($sql);
  }

  function get_cantida_configuracion_bolsita_vigentes()
  {
    $sql = "SELECT  count(*)as cantidad
            FROM 
              public.configuracion_bolsita
             where current_date between inicio and fin";
    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  }  

  function get_cantidad_configuracion_colonia_vigentes()
  {
    $sql = "SELECT  count(*)as cantidad
            FROM 
              public.configuracion_colonia
             where current_date between inicio_inscripcion and fin_inscripcion";
    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  } 

  function get_cupo_configuracion_colonia()
  {
    $sql = "SELECT  cupo
            FROM 
              public.configuracion_colonia
             where 
               extract(year from current_date) = extract(year from inicio_inscripcion)";
    $res = consultar_fuente($sql);
    if (isset($res[0]['cupo']))
    {
      return $res[0]['cupo'];
    }
  }

  function get_cantidad_colonos_inscriptos()
  {
    $sql = "SELECT count(*) as cantidad
            FROM 
              public.inscripcion_colono
            inner join configuracion_colonia using (idconfiguracion_colonia)
            where 
              baja = false and
              extract(year from current_date) = extract(year from inicio_inscripcion)";
    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  }

  function get_listado_tipo_subsidio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idtipo_subsidio, 
                    descripcion, 
                    limite, 
                    monto
            FROM 
              public.tipo_subsidio
            where 
              $where ";
      return consultar_fuente($sql);
  }

  function get_listado_solicitud_subsidio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql= "SELECT solicitud_subsidio.idsolicitud_subsidio, 
                  persona.legajo||' - '|| persona.apellido||', '|| persona.nombres as socio,
                  tipo_subsidio.descripcion as tipo_subsidio, 
                  solicitud_subsidio.fecha_solicitud, 
                  fecha_pago, 
                  solicitud_subsidio.monto, 
                  observacion, 
                  (case when pagado is null then 'PENDIENTE' else (case when pagado = true then 'PAGADO' else 'RECHAZADO' end) end) as estado
           FROM 
              public.solicitud_subsidio
            inner join  tipo_subsidio using(idtipo_subsidio)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
                $sql_usuario and
                $where 
            order by
              solicitud_subsidio.fecha_solicitud desc";
      return consultar_fuente($sql);
  }

  function get_monto_tipo_subsidio($idtipo_subsidio)
  {
    $sql = "SELECT  idtipo_subsidio, 
                    descripcion, 
                    limite, 
                    monto
            FROM 
              public.tipo_subsidio
            where 
              idtipo_subsidio = $idtipo_subsidio";
    $res = consultar_fuente($sql);
    if (isset($res[0]['monto']))
    {
      return $res[0]['monto'];   
    } 
  }  

  function get_limite_tipo_subsidio($idtipo_subsidio)
  {
    $sql = "SELECT  idtipo_subsidio, 
                    descripcion, 
                    limite, 
                    monto
            FROM 
              public.tipo_subsidio
            where 
              idtipo_subsidio = $idtipo_subsidio";
    $res = consultar_fuente($sql);
    if (isset($res[0]['limite']))
    {
      return $res[0]['limite'];   
    } 
  }

  function get_cantidad_subsidio_por_persona_por_tipo($idafiliacion = null,$idtipo_subsidio = null )
  {
    $sql = "SELECT count(*) as cantidad
            FROM 
              public.solicitud_subsidio
            inner join  tipo_subsidio using(idtipo_subsidio)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where 
              afiliacion.idafiliacion = $idafiliacion and
              tipo_subsidio.idtipo_subsidio= $idtipo_subsidio ";
    $res = consultar_fuente($sql);
    return $res[0]['cantidad'];
  }
  function get_listado_talonario_bono_colaboracion($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idtalonario_bono_colaboracion, 
                    descripcion, 
                    nro_talonario, 
                    nro_inicio, 
                    nro_fin, 
                    fecha_sorteo, 
                    monto,
                    (cantidad_numeros_vendidos_talonario_bono_colaboracion(idtalonario_bono_colaboracion)) as vendidos
            FROM 
              public.talonario_bono_colaboracion
            WHERE
              $where";
      return consultar_fuente($sql);
  }

  function get_nros_vendidos($idtalonario_bono_colaboracion)
  {
    $sql = "SELECT  idtalonario_bono_colaboracion, 
                    nro_bono, 
                    disponible, 
                    (case when idafiliacion is not null then persona.legajo||' - '|| persona.apellido||', '|| persona.nombres else  pex.apellido||', '|| pex.nombres  end) as comprador,
                    persona.legajo||' - '|| persona.apellido||', '|| persona.nombres as socio,
                    idpersona_externa, 
                    fecha_compra, 
                    forma_pago.descripcion as forma_pago, 
                    pagado, 
                    persona_externa
            FROM 
              public.talonario_nros_bono_colaboracion
              inner join forma_pago using(idforma_pago)
              left outer  join afiliacion using (idafiliacion)
              left outer join persona using (idpersona)
              left outer join persona pex on pex.idpersona = talonario_nros_bono_colaboracion.idpersona_externa
            where 
                pagado = true and
                idtalonario_bono_colaboracion = $idtalonario_bono_colaboracion
            order by
              nro_bono asc";
    return consultar_fuente($sql);
  }   

  function get_nros_vendidos_combo_editable($filtro = null,$idtalonario_bono_colaboracion = null)
  {
    if (! isset($filtro) || trim($filtro)=='')
    {
      return array();
    }
    $filtro = quote("%{$filtro}%");
    $sql = "SELECT  idtalonario_bono_colaboracion, 
                    nro_bono, 
                    disponible, 
                    (case when idafiliacion is not null then 'Nro bono: '||nro_bono||' - Comprador: '||persona.legajo||' - '|| persona.apellido||', '|| persona.nombres else  'Nro bono: '||nro_bono||' - Comprador: '||pex.apellido||', '|| pex.nombres  end) as comprador,
                    persona.legajo||' - '|| persona.apellido||', '|| persona.nombres as socio,
                    idpersona_externa, 
                    fecha_compra, 
                    forma_pago.descripcion as forma_pago, 
                    pagado, 
                    persona_externa
            FROM 
              public.talonario_nros_bono_colaboracion
              inner join forma_pago using(idforma_pago)
              left outer  join afiliacion using (idafiliacion)
              left outer join persona using (idpersona)
              left outer join persona pex on pex.idpersona = talonario_nros_bono_colaboracion.idpersona_externa
            where 
                pagado = true and
                talonario_nros_bono_colaboracion.idtalonario_bono_colaboracion = $idtalonario_bono_colaboracion and
               (case when idafiliacion is not null then 'Nro bono: '||nro_bono||' - Comprador: '||persona.legajo||' - '|| persona.apellido||', '|| persona.nombres else  'Nro bono: '||nro_bono||' - Comprador: '||pex.apellido||', '|| pex.nombres  end) ilike $filtro limit 20

            ";
    return consultar_fuente($sql);
  }  
  function get_descripcion_nro_vendido($nro_bono = null)
  {
    $sql =  "SELECT  idtalonario_bono_colaboracion, 
                    nro_bono, 
                    disponible, 
                    (case when idafiliacion is not null then 'Nro bono: '||nro_bono||' - Comprador: '||persona.legajo||' - '|| persona.apellido||', '|| persona.nombres else  'Nro bono: '||nro_bono||' - Comprador: '||pex.apellido||', '|| pex.nombres  end) as comprador,
                    persona.legajo||' - '|| persona.apellido||', '|| persona.nombres as socio,
                    idpersona_externa, 
                    fecha_compra, 
                    forma_pago.descripcion as forma_pago, 
                    pagado, 
                    persona_externa
            FROM 
              public.talonario_nros_bono_colaboracion
              inner join forma_pago using(idforma_pago)
              left outer  join afiliacion using (idafiliacion)
              left outer join persona using (idpersona)
              left outer join persona pex on pex.idpersona = talonario_nros_bono_colaboracion.idpersona_externa
            where 
                pagado = true and
               nro_bono = $nro_bono
            ";
    $res = consultar_fuente($sql);
    if (isset($res[0]['comprador']))
    {
      return $res[0]['comprador'];
    }

  }


  function get_nros_disponibles($idtalonario_bono_colaboracion)
  {
    $sql = "SELECT  idtalonario_bono_colaboracion, 
                    nro_bono, 
                    disponible, 
                    (case when idafiliacion is not null then persona.legajo||' - '|| persona.apellido||', '|| persona.nombres else  pex.apellido||', '|| pex.nombres  end) as comprador,
                    persona.legajo||' - '|| persona.apellido||', '|| persona.nombres as socio,
                    idpersona_externa, 
                    fecha_compra, 
                    forma_pago.descripcion as forma_pago, 
                    pagado, 
                    persona_externa
            FROM 
              public.talonario_nros_bono_colaboracion
              inner join forma_pago using(idforma_pago)
              left outer  join afiliacion using (idafiliacion)
              left outer join persona using (idpersona)
              left outer join persona pex on pex.idpersona = talonario_nros_bono_colaboracion.idpersona_externa
            where 
                pagado = false and
                idtalonario_bono_colaboracion = $idtalonario_bono_colaboracion
            order by
              nro_bono asc";
    return consultar_fuente($sql);
  }

  function get_listado_configuracion_colonia($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql ="SELECT idconfiguracion_colonia, 
                  anio, 
                  inicio, 
                  fin, 
                  inicio_inscripcion, 
                  fin_inscripcion,
                  cupo
          FROM 
            public.configuracion_colonia
          WHERE
              $where
          order by
            anio desc";
      return consultar_fuente($sql);
  }  

  function get_listado_configuracion_colonia_controlada()
  {
   
    $sql ="SELECT idconfiguracion_colonia, 
                  anio, 
                  inicio, 
                  fin, 
                  inicio_inscripcion, 
                  fin_inscripcion,
                  cupo
          FROM 
            public.configuracion_colonia
          WHERE
              current_date between inicio_inscripcion and fin_inscripcion
              ";
      return consultar_fuente($sql);
  }  

  function get_datos_configuracion_colonia($idconfiguracion_colonia = null)
  {

    $sql ="SELECT idconfiguracion_colonia, 
                  anio, 
                  to_char(inicio, 'DD/MM/YYYY') as fecha_inicio,
                  to_char(fin, 'DD/MM/YYYY') as fecha_fin,
                  inicio_inscripcion, 
                  fin_inscripcion,
                  cupo,
                  to_char(hora_concentracion, 'HH:MM') as concentracion ,
                  to_char(hora_salida, 'HH:MM') as salida ,
                  to_char(hora_llegada, 'HH:MM') as llegada ,
                  to_char(hora_finalizacion, 'HH:MM') as finalizacion ,
                  direccion  as domicilio
          FROM 
            public.configuracion_colonia
          WHERE
              idconfiguracion_colonia = $idconfiguracion_colonia";
      return consultar_fuente($sql);
  }

  function get_listado_inscripcion_colono($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular,
                    cantidad_cuotas,
                    monto,
                    porcentaje_inscripcion,
                    monto_inscripcion,
                    persona.correo,
                    inscripcion_colono.baja ,
                    (case when cantidad_cuotas > 0 then 'SI' else 'NO' end) as tiene_plan,
                    configuracion_colonia.anio

              FROM 
              public.inscripcion_colono
            inner join configuracion_colonia using(idconfiguracion_colonia)
            inner join familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            WHERE
              inscripcion_colono.baja = false and
              $sql_usuario and
              $where

             group by 
                    idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido,
                    colono.nombres ,
                    tipo_socio.descripcion,
                    persona.apellido ,
                    persona.nombres,
                    persona.correo,
                    configuracion_colonia.anio
             order by
             anio desc,
              fecha desc,
              
              colono";
      return consultar_fuente($sql);
  }  


  function get_listado_inscripcion_colono_sin_plan($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    inscripcion_colono.fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular,
                    cantidad_cuotas,
                    inscripcion_colono.monto,
                    porcentaje_inscripcion,
                    monto_inscripcion,
                    persona.correo,
                    inscripcion_colono.baja ,
                    (case when cantidad_cuotas > 0 then 'SI' else 'NO' end) as tiene_plan,
                    configuracion_colonia.anio

              FROM 
              public.inscripcion_colono
            inner join configuracion_colonia using(idconfiguracion_colonia)
            inner join familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            left outer join  inscripcion_colono_plan_pago using(idinscripcion_colono)
            WHERE
              inscripcion_colono_plan_pago.idinscripcion_colono is null and
              inscripcion_colono.baja = false and
              $sql_usuario and
              $where

             group by 
                    idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido,
                    colono.nombres ,
                    tipo_socio.descripcion,
                    persona.apellido ,
                    persona.nombres,
                    persona.correo,
                    configuracion_colonia.anio
             order by
              fecha,
              colono";
      return consultar_fuente($sql);
  }
  function get_listado_inscripcion_colono_sin_baja($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular,
                    cantidad_cuotas,
                    monto,
                    porcentaje_inscripcion,
                    monto_inscripcion,
                    inscripcion_colono.baja,
                    (case when cantidad_cuotas > 0 then 'SI' else 'NO' end) as tiene_plan,
                    tipo_socio.titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            WHERE
              $sql_usuario and
              cantidad_cuotas > 0 and
              $where
             group by 
                    idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido,
                    colono.nombres ,
                    tipo_socio.descripcion,
                    persona.apellido ,
                    persona.nombres,
                    tipo_socio.titular ";
      return consultar_fuente($sql);
  }

  function get_monto_costo_colonia_tipo_socio($idafiliacion)
  {
    $sql = "SELECT  costo_colonia_tipo_socio.idcosto_colonia_tipo_socio, 
                    costo_colonia_tipo_socio.idconfiguracion_colonia, 
                    monto, 
                    porcentaje_inscripcion
            FROM 
              public.costo_colonia_tipo_socio
            inner join afiliacion using(idtipo_socio)
            where 
              afiliacion.idafiliacion = $idafiliacion";  
    $res = consultar_fuente($sql);
    if (isset($res[0]['monto']))
    {
      return $res[0]['monto'];
    }
  }  

  function get_porcentaje_costo_colonia_tipo_socio($idafiliacion)
  {
    $sql = "SELECT  costo_colonia_tipo_socio.idcosto_colonia_tipo_socio, 
                    costo_colonia_tipo_socio.idconfiguracion_colonia, 
                    monto, 
                    porcentaje_inscripcion
            FROM 
              public.costo_colonia_tipo_socio
            inner join afiliacion using(idtipo_socio)
            where 
              afiliacion.idafiliacion = $idafiliacion";  
    $res = consultar_fuente($sql);
    if (isset($res[0]['porcentaje_inscripcion']))
    {
      return $res[0]['porcentaje_inscripcion'];
    }
  }  

  function get_monto_porcentaje_costo_colonia_tipo_socio($idafiliacion)
  {
    $sql = "SELECT  costo_colonia_tipo_socio.idcosto_colonia_tipo_socio, 
                    costo_colonia_tipo_socio.idconfiguracion_colonia, 
                    monto, 
                    porcentaje_inscripcion,
                    monto * porcentaje_inscripcion / 100 as inscripcion

            FROM 
              public.costo_colonia_tipo_socio
            inner join afiliacion using(idtipo_socio)
            where 
              afiliacion.idafiliacion = $idafiliacion";  
    $res = consultar_fuente($sql);
    if (isset($res[0]['inscripcion']))
    {
      return $res[0]['inscripcion'];
    }
  }

  function get_colonos_del_afiliado($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  
                    afiliacion.idafiliacion,
                     tipo_socio.descripcion||': '|| persona.apellido ||', '|| persona.nombres as titular,
                    configuracion_colonia.anio,
                    configuracion_colonia.idconfiguracion_colonia,
                    colonos_de_un_titular_sin_plan( afiliacion.idafiliacion,configuracion_colonia.idconfiguracion_colonia) as colonos

              FROM 
              public.inscripcion_colono
              inner join configuracion_colonia using (idconfiguracion_colonia)
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            left outer join  inscripcion_colono_plan_pago using(idinscripcion_colono)
            WHERE
              inscripcion_colono_plan_pago.idinscripcion_colono is null and
              inscripcion_colono.baja = false and
              $where
            group by
                  afiliacion.idafiliacion,
                  persona.apellido,
                  persona.nombres,
                  configuracion_colonia.anio,
                  tipo_socio.descripcion,
                  configuracion_colonia.idconfiguracion_colonia
            order by 
             configuracion_colonia.anio desc,
              titular";
    return consultar_fuente($sql);

  } 

  function get_colonos_del_afiliado_con_plan($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  
                    afiliacion.idafiliacion,
                    tipo_socio.descripcion||': '|| persona.apellido ||', '|| persona.nombres as titular,
                    configuracion_colonia.anio,
                    configuracion_colonia.idconfiguracion_colonia,
                    colonos_de_un_titular_con_plan( afiliacion.idafiliacion,configuracion_colonia.idconfiguracion_colonia) as colonos

              FROM 
              public.inscripcion_colono
              inner join configuracion_colonia using (idconfiguracion_colonia)
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            inner join inscripcion_colono_plan_pago using(idinscripcion_colono)
          where
            $where
           group by
                  afiliacion.idafiliacion,
                  persona.apellido,
                  persona.nombres,
                  configuracion_colonia.anio,
                  tipo_socio.descripcion,
                  configuracion_colonia.idconfiguracion_colonia
            order by 
            configuracion_colonia.anio desc,
              titular";
    return consultar_fuente($sql);

  }

  function get_listado_gasto_infraestructura($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idgasto_infraestructura, 
                    concepto.descripcion as concepto, 
                    comercio.nombre as proveedor, 
                    fecha_pago, 
                    monto,
                    periodo
            FROM 
              public.gasto_infraestructura
            inner join concepto using(idconcepto)
            left outer join comercio  using(idcomercio)
            WHERE
              $where";
    return consultar_fuente($sql);

  }

  function get_listado_egresos($where = null)
  {
    if (!isset($where))
    {
      $valor_where = '%%';
      $valor_where =  quote("%{$valor_where}%");

    } else {
        $valor_where = quote("%{$where['periodo']['valor']}%");
    }
    
    $sql = "  SELECT  'SUBSIDIO' as concepto,
                       sum (monto) as monto,
                       to_char(fecha_pago,'MM/YYYY') as periodo
              FROM 
                        public.solicitud_subsidio
              WHERE
                  pagado = true and
                  to_char(fecha_pago,'MM/YYYY') ilike $valor_where
              group by
                  monto,
                  periodo
              UNION 
              SELECT  categoria_comercio.descripcion as concepto,
                      sum (total) as monto, 
                      (case when fecha is null then periodo else to_char(fecha, 'MM/YYYY') end) as periodo
              FROM 
                      public.consumo_convenio
                inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
                inner join categoria_comercio on categoria_comercio.idcategoria_comercio = convenio.idcategoria_comercio
              WHERE
                    convenio.ayuda_economica = true and
                    consumo_convenio.pagado = true and
                   (case when fecha is null then periodo else to_char(fecha, 'MM/YYYY') end) ilike $valor_where
              group by
                  categoria_comercio.descripcion,
                  fecha,
                  total,
                  periodo
             
           
              UNION
              SELECT   concepto.descripcion as concepto, 
                       sum(monto) as monto,
                       periodo
              FROM 
                      public.gasto_infraestructura
              inner join concepto using(idconcepto)
              WHERE
               periodo ilike $valor_where
              group by
                concepto,
                monto,
                periodo
              order by 
                periodo desc, concepto asc ";

  return consultar_fuente($sql);

  }
  function get_listado_ingresos($where = null)
  {
    if (!isset($where))
    {
      $valor_where = '%%';
      $valor_where =  quote("%{$valor_where}%");

    } else {
        $valor_where = quote("%{$where['periodo']['valor']}%");
    }
    $sql = "SELECT  
                    '0547' as concepto,
                    'CUOTA SOCIETARIA' AS detalle,
                    cabecera_cuota_societaria.periodo, 
                    sum(cuota_societaria.monto) as descuento,
                    0 as otros
            FROM 
              public.cabecera_cuota_societaria
              inner join cuota_societaria using(idcabecera_cuota_societaria)
            where
              periodo ilike $valor_where
 
            group by 
                cabecera_cuota_societaria.periodo   
            UNION
            SELECT 
                    '0548' as concepto,
                    'RESERVA' as detalle,
                    to_char(detalle_pago.fecha, 'MM/YYYY') as periodo,
                     0 as descuento,
                     sum (detalle_pago.monto) as otros
                    
            FROM 
                public.solicitud_reserva
            inner join detalle_pago using(idsolicitud_reserva)
            inner join forma_pago using(idforma_pago)
            where
                forma_pago.planilla = false and
                to_char(detalle_pago.fecha,'MM/YYYY') ilike $valor_where
            group by 
              forma_pago.descripcion,
              periodo
            UNION
            SELECT    '0548' as concepto,
                      'COLONIA' as detalle,  
                      to_char(fecha_pago, 'MM/YYYY') as periodo,
                     0 as descuento,
                     sum (monto) as otros
            FROM 
              public.inscripcion_colono_plan_pago
             inner join forma_pago using(idforma_pago)
            where
              forma_pago.planilla = false and  
              cuota_pagada = true and
              to_char(fecha_pago,'MM/YYYY') ilike $valor_where
            group by
                fecha_pago,
                forma_pago.descripcion 
            UNION
            SELECT  '0550' as concepto, 
                    'BONO COLABORACION' as detalle,
                    to_char(fecha_compra, 'MM/YYYY') as periodo, 
                    0 as descuento,       
                    count (*) * talonario_bono_colaboracion.monto as otros
                   
            FROM 
              public.talonario_nros_bono_colaboracion
              inner join talonario_bono_colaboracion using(idtalonario_bono_colaboracion)
              inner join forma_pago using(idforma_pago)
            where 
                forma_pago.planilla = false and   
                pagado = true and
                to_char(fecha_compra,'MM/YYYY') ilike $valor_where
            group by 
              periodo,
              talonario_bono_colaboracion.monto,
              forma_pago.descripcion 
            UNION
            SELECT      
                    '0549' as concepto,
                    convenio.titulo as detalle,
                    to_char(consumo_convenio_cuotas.fecha_pago, 'MM/YYYY') as periodo,
                    0 as descuento,  
                    sum (consumo_convenio_cuotas.monto) as otros
                    
            FROM 
                public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join consumo_convenio_cuotas using (idconsumo_convenio)
            inner join forma_pago using(idforma_pago)
            WHERE
              convenio.permite_financiacion = true and
              consumo_convenio_cuotas.cuota_pagada =  true and
              forma_pago.planilla = false and
              to_char(consumo_convenio_cuotas.fecha_pago,'MM/YYYY') ilike $valor_where
            group by 
              concepto,
              to_char(consumo_convenio_cuotas.fecha_pago, 'MM/YYYY') ,
               forma_pago.descripcion ,
               convenio.titulo
            UNION
            SELECT      
                   '0549' as concepto,
                   convenio.titulo as detalle,
                    to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY')  as periodo,
                    0 as descuento  ,  
                    sum (detalle_pago_consumo_convenio.monto) as otros
                   
            FROM 
                public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join detalle_pago_consumo_convenio using (idconsumo_convenio)
            inner join forma_pago using(idforma_pago)
        WHERE
             forma_pago.planilla = false and
             to_char(detalle_pago_consumo_convenio.fecha,'MM/YYYY') ilike $valor_where
            group by 
              concepto,
              to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ,
              forma_pago.descripcion ,
              convenio.titulo
          UNION
          SELECT 
              concepto_liquidacion.codigo as concepto,
              'LIQUIDACION' as detalle,
              cabecera_liquidacion.periodo,
              sum(detalle_liquidacion.monto) - sum(detalle_liquidacion.saldo) as descuento,
               0 as otros
          FROM public.cabecera_liquidacion
          inner join detalle_liquidacion using(idcabecera_liquidacion)
          inner join concepto_liquidacion using (idconcepto_liquidacion)
          WHERE
            cabecera_liquidacion.periodo ilike $valor_where
          group by
            concepto_liquidacion.codigo ,
            cabecera_liquidacion.periodo
          order by 
              periodo desc,concepto asc, detalle";
      return consultar_fuente($sql);
  }


  function get_listado_concepto_liquidacion($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconcepto_liquidacion, 
                    descripcion, 
                    codigo,
                    codigo ||' - '||descripcion as concepto,
                    liquidable
            FROM 
              public.concepto_liquidacion
            where
              $where";
    return consultar_fuente($sql);
  }  

  function get_listado_concepto_liquidacion_liquidables($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconcepto_liquidacion, 
                    descripcion, 
                    codigo,
                    codigo ||' - '||descripcion as concepto,
                    liquidable
            FROM 
              public.concepto_liquidacion
            where
              liquidable = true and
              $where";
    return consultar_fuente($sql);
  }    

  function get_listado_concepto_liquidacion_no_liquidables($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idconcepto_liquidacion, 
                    descripcion, 
                    codigo,
                    codigo ||' - '||descripcion as concepto,
                    liquidable
            FROM 
              public.concepto_liquidacion
            where
              liquidable = false and
              $where";
    return consultar_fuente($sql);
  }  

  function get_codigo_concepto_liquidacion($idconcepto_liquidacion = null)
  {

    $sql = "SELECT  idconcepto_liquidacion, 
                    descripcion, 
                    codigo,
                    codigo ||' - '||descripcion as concepto 
            FROM 
              public.concepto_liquidacion
            where
              idconcepto_liquidacion = $idconcepto_liquidacion";
    $res = consultar_fuente($sql);
    if (isset($res[0]['codigo']))
    {
      return $res[0]['codigo'];
    }
  }

  function get_listado_cabecera_cuota_societaria($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idcabecera_cuota_societaria, 
                    archivo, 
                    periodo, 
                    fecha_importacion, 
                    concepto_liquidacion.descripcion as concepto
            FROM 
              public.cabecera_cuota_societaria
            inner join concepto_liquidacion using(idconcepto_liquidacion)
            WHERE
              $where";

      $cabeceras = consultar_fuente($sql);
      $datos=array();
      foreach($cabeceras as $cabecera)
      {
        if(isset($cabecera['archivo']) and !empty($cabecera['archivo']))
        {
          $fp_imagen = $cabecera['archivo'];
          //-- Se necesita el path fisico y la url de una archivo temporal que va a contener la imagen
          
          $periodo = str_replace("/", "-", $cabecera['periodo']);
          $temp_nombre = $periodo.'_0547.txt';
          $temp_archivo = toba::proyecto()->get_www_temp($temp_nombre);
     
          //-- Se pasa el contenido al archivo temporal
          $temp_fp = fopen($temp_archivo['path'], 'w');
          stream_copy_to_stream($fp_imagen, $temp_fp);
          fclose($temp_fp);
          $tamaño = round(filesize($temp_archivo['path']) / 1024);
          
          //-- Se muestra la imagen temporal
          //$datos['imagen_vista_previa'] = "";
          $enlace="<a href='{$temp_archivo['url']}' target='_blank'>Descargar</a>";
          $cabecera['archivo'] =$enlace;
        }
        $datos[] = $cabecera;
      }
      return $datos;
     
  }

 

  function get_listado_temporada_pileta($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idtemporada_pileta, 
                    descripcion, 
                    fecha_inicio, 
                    fecha_fin
            FROM 
              public.temporada_pileta 
            where
              $where";
    return consultar_fuente($sql);
  }  

  function get_listado_temporada_pileta_vigente($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idtemporada_pileta, 
                    descripcion, 
                    fecha_inicio, 
                    fecha_fin
            FROM 
              public.temporada_pileta 
            where
               current_date between fecha_inicio and fecha_fin";
    return consultar_fuente($sql);
  }
  function get_cantidad_temporada_pileta_vigente()
  {
    $sql = "SELECT  count(*)as cantidad
            FROM 
              public.temporada_pileta
             where current_date between fecha_inicio and fecha_fin";
    $res = consultar_fuente($sql);
    if (isset($res[0]['cantidad']))
    {
      return $res[0]['cantidad'];
    }
  }

  function get_listado_inscripcion_pileta($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  idinscripcion_pileta, 
                      temporada_pileta.descripcion as temporada, 
                      persona.legajo||' - '|| persona.apellido||', '|| persona.nombres as titular,
                      (familiar_de_un_titular(persona.idpersona) ) as grupo_familiar,
                      costo_grupo_familiar,
                      total,
                      (total_abonado_detalle_pago_inscripcion_pileta(idinscripcion_pileta)) as total_abonado
              FROM 
                public.inscripcion_pileta
              inner join afiliacion using(idafiliacion)
              inner join persona on persona.idpersona = afiliacion.idpersona
              inner join temporada_pileta using(idtemporada_pileta)
              where 
                $sql_usuario and
                $where
              order by
                temporada, titular";
    return consultar_fuente($sql);
  }  

  function get_costo_temporada_pileta_tipo_socio($idtemporada_pileta = null, $idafiliacion = null)
  {

     $sql = "SELECT costo_grupo_familiar
             FROM 
               public.costo_pileta_tipo_socio
               
              inner join afiliacion on afiliacion.idtipo_socio = costo_pileta_tipo_socio.idtipo_socio
             where   afiliacion.idafiliacion = $idafiliacion and costo_pileta_tipo_socio.idtemporada_pileta=$idtemporada_pileta";
    $res = consultar_fuente($sql);
    if (isset($res[0]['costo_grupo_familiar']))
    {
      return $res[0]['costo_grupo_familiar'];
    } else {
       return 0;
    }
  } 

  function get_adicional_mayores_edad_temporada_pileta_tipo_socio($idtemporada_pileta = null,$idafiliacion = null)
  {

     $sql = "SELECT adicional_mayores_edad
             FROM 
               public.costo_pileta_tipo_socio
               
              inner join afiliacion on afiliacion.idtipo_socio = costo_pileta_tipo_socio.idtipo_socio
             where   afiliacion.idafiliacion = $idafiliacion and costo_pileta_tipo_socio.idtemporada_pileta=$idtemporada_pileta";
    $res = consultar_fuente($sql);
    if (isset($res[0]['adicional_mayores_edad']))
    {
      return $res[0]['adicional_mayores_edad'];
    } else {
      return 0;
    }
  }


  function get_listado_ingresos_0549($periodo = null)
  {
    $periodo_anterior = self::calcular_periodo_anterior($periodo);
    $periodo_anterior = quote("%{$periodo_anterior}%");
    $periodo = quote("%{$periodo}%");
    $sql = "SELECT      
                    convenio.titulo as beneficio,
                    consumo_convenio_cuotas.periodo,
                    sum (consumo_convenio_cuotas.monto) as monto,
                    persona.legajo,
                    persona.apellido||', '|| persona.nombres as persona,
                    afiliacion.idafiliacion
            FROM 
                  public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join consumo_convenio_cuotas using (idconsumo_convenio)
            inner join afiliacion using (idafiliacion)
            inner join persona using (idpersona)
            inner join forma_pago using(idforma_pago)
            WHERE
                  convenio.permite_financiacion = true and
                  forma_pago.planilla = true and
                  consumo_convenio_cuotas.envio_descuento =  false and
                  consumo_convenio_cuotas.periodo ilike  $periodo
            group by 
              beneficio,
              consumo_convenio_cuotas.periodo,
              persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
           UNION
            SELECT      
                  convenio.titulo as beneficio,
                  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY')  as periodo,
                  sum(detalle_pago_consumo_convenio.monto),
                  persona.legajo,
                  persona.apellido||', '|| persona.nombres as persona,
                  afiliacion.idafiliacion
            FROM 
                public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join detalle_pago_consumo_convenio using (idconsumo_convenio)
            inner join forma_pago using(idforma_pago)
            inner join afiliacion using (idafiliacion)
            inner join persona using (idpersona)
           
            WHERE
                  forma_pago.planilla = true and
                  detalle_pago_consumo_convenio.envio_descuento =  false and
                  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $periodo
            group by 
              beneficio,
              to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ,
              persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
            UNION
             SELECT 'SALDO LIQUIDACION ANTERIOR' as beneficio,
                    periodo,
                    saldo as monto,
                    persona.legajo,
                    persona.apellido||', '|| persona.nombres as persona,
                    afiliacion.idafiliacion  
            FROM public.cabecera_liquidacion
            inner join detalle_liquidacion using(idcabecera_liquidacion)
            inner join afiliacion using (idafiliacion )
            inner join persona using (idpersona)
              where
                detalle_liquidacion.concepto ilike '%0549%' and
                periodo ilike $periodo_anterior
            order by
              persona";

    $datos = consultar_fuente($sql);
    $concepto_liquidacion = dao::get_listado_concepto_liquidacion("codigo ilike  '%0549%'");

    $consumos = array();
    for( $i = 0; $i<count($datos) ; $i++)
    {
        $consumos[$i] = array($datos[$i]['idafiliacion'] => $datos[$i]['monto']);
    }  

    $totales = array();    
    foreach($consumos as $dato)
    {
        foreach ($dato as $clave=>$valor) 
        {
            $totales[$clave]+=$valor;
        }
    } 
    $descuentos = array();
    foreach ($totales as $key => $value) 
    {
      $afiliado = self::get_datos_persona_afiliada_para_archivo($key);
      $afiliado['monto'] = number_format($value, 2, '.', ''); ;
      $afiliado['concepto'] = trim($concepto_liquidacion[0]['codigo']);      
      $descuentos[] = $afiliado;
    }
    return $descuentos;
  }

  function get_listado_ingresos_0548($periodo = null)
  {
    $periodo_anterior = self::calcular_periodo_anterior($periodo);
    $periodo_anterior = quote("%{$periodo_anterior}%");
    $periodo = quote("%{$periodo}%");
    $sql = "SELECT 
                    'RESERVAS' as beneficio,
                    to_char(detalle_pago.fecha, 'MM/YYYY') as periodo,
                    sum (detalle_pago.monto) as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion
            FROM 
                public.solicitud_reserva
            inner join detalle_pago using(idsolicitud_reserva)
            inner join forma_pago  using(idforma_pago)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            WHERE
              forma_pago.planilla = true and
              envio_descuento = false and 
              to_char(detalle_pago.fecha, 'MM/YYYY') ilike $periodo
            group by 
              periodo,
                 persona.legajo,
              persona.apellido,
              persona.nombres,
               afiliacion.idafiliacion
            UNION
            SELECT  'COLONIA' as beneficio,
                    periodo,
                    sum(inscripcion_colono_plan_pago.monto) as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion
            FROM 
              public.inscripcion_colono_plan_pago
            inner join forma_pago  using(idforma_pago)
            inner join inscripcion_colono using(idinscripcion_colono)
             inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            WHERE
              forma_pago.planilla = true  and
              envio_descuento = false and
              periodo ilike $periodo
            group by
               periodo,
                persona.legajo,
              persona.apellido,
              persona.nombres,
               afiliacion.idafiliacion
            UNION
            SELECT  'PILETA' as beneficio, 
                    to_char(fecha, 'MM/YYYY') as periodo,
                    sum(monto) as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion
            FROM 
              public.detalle_pago_inscripcion_pileta
            inner join forma_pago using(idforma_pago)
            inner join inscripcion_pileta using(idinscripcion_pileta)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
              forma_pago.planilla = true and
              envio_descuento = false and
              to_char(fecha, 'MM/YYYY') ilike $periodo

            group by
               to_char(fecha, 'MM/YYYY'),
               persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
            UNION
             SELECT 'SALDO LIQUIDACION ANTERIOR' as beneficio,
                    periodo,
                    saldo as monto,
                    persona.legajo,
                    persona.apellido||', '|| persona.nombres as persona,
                    afiliacion.idafiliacion  
            FROM public.cabecera_liquidacion
            inner join detalle_liquidacion using(idcabecera_liquidacion)
            inner join afiliacion using (idafiliacion )
            inner join persona using (idpersona)
              where
                detalle_liquidacion.concepto ilike '%0548%' and
                periodo ilike $periodo_anterior
           order by
              persona";
     
      $datos = consultar_fuente($sql);
    $concepto_liquidacion = dao::get_listado_concepto_liquidacion("codigo ilike  '%0548%'");

    $consumos = array();
    for( $i = 0; $i<count($datos) ; $i++)
    {
        $consumos[$i] = array($datos[$i]['idafiliacion'] => $datos[$i]['monto']);
    }  

    $totales = array();    
    foreach($consumos as $dato)
    {
        foreach ($dato as $clave=>$valor) 
        {
            $totales[$clave]+=$valor;
        }
    } 
    $descuentos = array();
    foreach ($totales as $key => $value) 
    {
      $afiliado = self::get_datos_persona_afiliada_para_archivo($key);
      $afiliado['monto'] = number_format($value, 2, '.', ''); ;
      $afiliado['concepto'] = trim($concepto_liquidacion[0]['codigo']);
      $descuentos[] = $afiliado;
    }
    return $descuentos;
  } 

  function get_listado_ingresos_0550($periodo = null)
  {
    $periodo_anterior = self::calcular_periodo_anterior($periodo);
    $periodo_anterior = quote("%{$periodo_anterior}%");
    $periodo = quote("%{$periodo}%");
    $sql = " SELECT  'BONO COLABORACION' as beneficio, 
                    to_char(fecha_compra, 'MM/YYYY') as periodo, 
                    count (*) * talonario_bono_colaboracion.monto as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion            
            FROM 
              public.talonario_nros_bono_colaboracion
              inner join talonario_bono_colaboracion on talonario_bono_colaboracion.idtalonario_bono_colaboracion = talonario_nros_bono_colaboracion.idtalonario_bono_colaboracion
              inner join forma_pago using(idforma_pago)
              inner join afiliacion using (idafiliacion )
              inner join persona using (idpersona)
            where
                forma_pago.planilla = true  and
                pagado = false and
                to_char(fecha_compra, 'MM/YYYY') ilike $periodo
            group by 
              periodo,
              talonario_bono_colaboracion.monto,
              persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
              UNION
             SELECT 'SALDO LIQUIDACION ANTERIOR' as beneficio,
                    periodo,
                    saldo as monto,
                    persona.legajo,
                    persona.apellido||', '|| persona.nombres as persona,
                    afiliacion.idafiliacion  
            FROM public.cabecera_liquidacion
            inner join detalle_liquidacion using(idcabecera_liquidacion)
            inner join afiliacion using (idafiliacion )
            inner join persona using (idpersona)
              where
                detalle_liquidacion.concepto ilike '%0550%' and
                periodo ilike $periodo_anterior
            order by
              persona";
    $datos = consultar_fuente($sql);
    $concepto_liquidacion = dao::get_listado_concepto_liquidacion("codigo ilike  '%0550%'");

    $consumos = array();
    for( $i = 0; $i<count($datos) ; $i++)
    {
        $consumos[$i] = array($datos[$i]['idafiliacion'] => $datos[$i]['monto']);
    }  

    $totales = array();    
    foreach($consumos as $dato)
    {
        foreach ($dato as $clave=>$valor) 
        {
            $totales[$clave]+=$valor;
        }
    } 
    $descuentos = array();
    foreach ($totales as $key => $value) 
    {
      $afiliado = self::get_datos_persona_afiliada_para_archivo($key);
      $afiliado['monto'] = number_format($value, 2, '.', ''); ;
      $afiliado['concepto'] = trim($concepto_liquidacion[0]['codigo']);      
      $descuentos[] = $afiliado;
    }
    return $descuentos;
  }

  function get_listado_cabecera_liquidacion($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idcabecera_liquidacion, 
                   concepto_liquidacion.codigo||' - ' ||  concepto_liquidacion.descripcion as concepto, 
                    periodo, 
                    concepto_liquidacion.idconcepto_liquidacion,
                    fecha_liquidacion, 
                    usuario, 
                    liquidado, 
                    exportado, 
                    conciliado,
                    archivo
            FROM 
              public.cabecera_liquidacion
            inner join concepto_liquidacion using(idconcepto_liquidacion)
            where
              $where";
    $cabeceras = consultar_fuente($sql);
    $datos = array();
    foreach($cabeceras as $cabecera)
      {
        if(isset($cabecera['archivo']) and !empty($cabecera['archivo']))
        {
          $fp_imagen = $cabecera['archivo'];
          //-- Se necesita el path fisico y la url de una archivo temporal que va a contener la imagen
          
          $periodo = str_replace("/", "-", $cabecera['periodo']);
          $concepto_liquidacion = self::get_codigo_concepto_liquidacion($cabecera['idconcepto_liquidacion']);

          $temp_nombre = $concepto_liquidacion."_".$periodo.".txt";
          $temp_archivo = toba::proyecto()->get_www('archivos/'.$temp_nombre);
     
          //-- Se pasa el contenido al archivo temporal
          $temp_fp = fopen($temp_archivo['path'], 'w');
          stream_copy_to_stream($fp_imagen, $temp_fp);
          fclose($temp_fp);
          $tamaño = round(filesize($temp_archivo['path']) / 1024);
          
          //-- Se muestra la imagen temporal
          //$datos['imagen_vista_previa'] = "";
          $enlace="<a href='{$temp_archivo['url']}' target='_blank'>Ver archivo</a>";
          $cabecera['archivo'] =$enlace;
        }
        $datos[] = $cabecera;
      }
      return $datos;
  }

  function setear_envio_descuento_true_0548($periodo = null)
  {
    $periodo = quote("%{$periodo}%");
    $sql = "select actualizar_campo_envio_descuento_true0548($periodo)";
    return consultar_fuente($sql);      
  }  
  function setear_envio_descuento_false_0548($periodo = null)
  {
    $periodo = quote("%{$periodo}%");
    $sql = "select actualizar_campo_envio_descuento_false0548($periodo)";
    return consultar_fuente($sql);      
  }

  function setear_envio_descuento_true_0549($periodo = null)
  {
    $periodo = quote("%{$periodo}%");
    $sql = "select actualizar_campo_envio_descuento_true0549($periodo)";
    return consultar_fuente($sql);
  }    

  function setear_envio_descuento_false_0549($periodo = null)
  {
    $periodo = quote("%{$periodo}%");
    $sql = "select actualizar_campo_envio_descuento_false0549($periodo)";
    return consultar_fuente($sql);
  }   

  function setear_envio_descuento_true_0550($periodo = null)
  {
    $periodo = quote("%{$periodo}%");
    $sql = "select actualizar_campo_envio_descuento_true0550($periodo)";
    return consultar_fuente($sql);
  }    

  function setear_envio_descuento_false_0550($periodo = null)
  {
    $periodo = quote("%{$periodo}%");
    $sql = "select actualizar_campo_envio_descuento_false0550($periodo)";
    return consultar_fuente($sql);
  }  


  function get_fecha_sorteo_bono_colaboracion($idtalonario_bono_colaboracion= null)
  {
    $sql = "SELECT to_char(fecha_sorteo, 'DD/MM/YYYY') as fecha_sorteo   
            FROM 
              public.talonario_bono_colaboracion
            where
             idtalonario_bono_colaboracion =$idtalonario_bono_colaboracion ";
    $res = consultar_fuente($sql);

    if (isset($res[0]['fecha_sorteo']))
    {
      return $res[0]['fecha_sorteo'];
    }
  }  

  function get_valor_bono_colaboracion($idtalonario_bono_colaboracion= null)
  {
    $sql = "SELECT monto  as monto_bono
            FROM 
              public.talonario_bono_colaboracion
            where
             idtalonario_bono_colaboracion =$idtalonario_bono_colaboracion ";
    return consultar_fuente($sql);

  }



  function get_listado_ayudas_economicas($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
 
    $sql = "SELECT  consumo_convenio.idconsumo_convenio,               
                    ('Socio: '||persona.legajo||' - '||persona.apellido||', '|| persona.nombres||' | Fecha Solicitud: '||to_char(fecha,'DD/MM/YYYY')||'| Monto: $ ' ||consumo_convenio.total||' | Cuotas: '||cantidad_cuotas) as socio,                  
                    convenio.titulo||' - Monto mensual permitido: $'|| convenio.monto_maximo_mensual  as convenio ,
                    consumo_convenio_cuotas.nro_cuota, 
                    consumo_convenio_cuotas.periodo,
                    consumo_convenio_cuotas.monto_puro  as monto_puro,  
                    consumo_convenio_cuotas.interes, 
                    consumo_convenio_cuotas.monto as monto_a_pagar, 
                    forma_pago.descripcion as forma_pago,
                    cuota_pagada,
                    fecha_pago
            FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner join convenio using(idconvenio)
            inner join consumo_convenio_cuotas using(idconsumo_convenio)
            inner join forma_pago using (idforma_pago)

            WHERE
              convenio.ayuda_economica = true and 
              consumo_convenio.pagado = true and
              $where
            group by 
              consumo_convenio.idconsumo_convenio,
              persona.apellido, 
              persona.legajo, 
              persona.nombres, 
              convenio.titulo,
              convenio.monto_maximo_mensual,
              total, 
              fecha,
               consumo_convenio_cuotas.nro_cuota, 
                   consumo_convenio_cuotas.periodo,
                   consumo_convenio_cuotas.monto_puro  ,  
                   consumo_convenio_cuotas.interes, 
                   consumo_convenio_cuotas.monto, 
                    forma_pago.descripcion ,
                    cuota_pagada,
                    fecha_pago
            order by fecha,nro_cuota, total, socio desc";
      return consultar_fuente($sql);
  } 

   function get_listado_solicitudes_bolsitas($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  solicitud_bolsita.idsolicitud_bolsita, 
                    familia.idpersona_familia, 
                    familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    persona.legajo ||' - '||persona.apellido ||', '||persona.nombres as titular,
                    solicitud_bolsita.fecha_solicitud, 
                    nivel.descripcion as nivel, 
                    observacion, 
                    fecha_entrega,
                    (case when entregado is null then 'PENDIENTE' else (case when entregado = true then 'ENTREGADO' else 'RECHAZADO' end) end) as estado,
                    configuracion_bolsita.anio
            FROM 
              public.solicitud_bolsita
              inner join nivel using(idnivel) 
              inner join familia using(idpersona_familia)
              inner join persona familiar on familiar.idpersona=familia.idpersona_familia
              inner join persona on familia.idpersona=persona.idpersona
              inner join configuracion_bolsita using(idconfiguracion_bolsita)
            where 
              $where 
            order by
              configuracion_bolsita.anio,  solicitud_bolsita.fecha_solicitud, titular";
      return consultar_fuente($sql);
  }


  function get_listado_solicitudes_subsidio($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql= "SELECT solicitud_subsidio.idsolicitud_subsidio, 
                  persona.legajo||' - '|| persona.apellido||', '|| persona.nombres as socio,
                  tipo_subsidio.descripcion as tipo_subsidio, 
                  solicitud_subsidio.fecha_solicitud, 
                  fecha_pago, 
                  solicitud_subsidio.monto, 
                  observacion, 
                  (case when pagado is null then 'PENDIENTE' else (case when pagado = true then 'PAGADO' else 'RECHAZADO' end) end) as estado
           FROM 
              public.solicitud_subsidio
            inner join  tipo_subsidio using(idtipo_subsidio)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
                $sql_usuario and
                $where 
            order by
              solicitud_subsidio.fecha_solicitud desc,socio,tipo_subsidio";
      return consultar_fuente($sql);
  }

  function get_listado_inscripciones_colonos($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular,
                    cantidad_cuotas,
                    monto,
                    porcentaje_inscripcion,
                    monto_inscripcion,
                    persona.correo,
                    medicamentos_toma,
                    inscripcion_colono.baja ,
                    (case when cantidad_cuotas > 0 then 'SI' else 'NO' end) as tiene_plan,
                    configuracion_colonia.anio,
                    (select telefonos_del_colono(inscripcion_colono.idinscripcion_colono)) as telefonos

              FROM 
              public.inscripcion_colono
            inner join configuracion_colonia using(idconfiguracion_colonia)
            inner join familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            WHERE
              inscripcion_colono.baja = false and
              $sql_usuario and
              $where

             group by 
                    idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido,
                    colono.nombres ,
                    tipo_socio.descripcion,
                    persona.apellido ,
                    persona.nombres,
                    persona.correo,
                    configuracion_colonia.anio
             order by
              fecha desc,
              anio desc,
              colono";
      return consultar_fuente($sql);
  }  

  function get_listado_talonarios_bono_colaboracion($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql = "SELECT  idtalonario_bono_colaboracion, 
                    descripcion, 
                    nro_talonario, 
                    nro_inicio, 
                    nro_fin, 
                    (cantidad_numeros_talonario_bono_colaboracion(idtalonario_bono_colaboracion)) as cantidad,
                    fecha_sorteo, 
                    monto,
                    (cantidad_numeros_vendidos_talonario_bono_colaboracion(idtalonario_bono_colaboracion)) as vendidos,
                    (premios_del_bono_colaboracion(idtalonario_bono_colaboracion)) as premios
            FROM 
              public.talonario_bono_colaboracion
            WHERE
              $where
            order by
            fecha_sorteo";
      return consultar_fuente($sql);
  }

    function get_listado_consumos($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql_usuario = self::get_sql_usuario();
    $sql = "SELECT   (persona.apellido||', '|| persona.nombres) as socio,
                    convenio.titulo as convenio,
                    idconsumo_convenio, 
                    categoria_comercio.descripcion as categoria,
                    idafiliacion, 
                    consumo_convenio.idconvenio, 
                    comercio.idcomercio, total, 
                    fecha, 
                    monto_proforma, 
                    (case when cantidad_cuotas > 0 then cantidad_cuotas else null end ) as cantidad_cuotas, 
                    consumo_convenio.descripcion, 
                    cantidad_bonos, 
                  comercio.codigo ||'-'||comercio.nombre as comercio, 
                    '$'||' '||(case when monto_bono > 0 then monto_bono else null end ) as monto_bono, 
                    (case when fecha is null then periodo else to_char(fecha, 'MM/YYYY') end) as periodo,
                    (case when (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) > 0 then (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) else null end) as cantidad_pagas,
                    (case when consumo_ticket=true then 'Ticket' else (case when maneja_bono=true then 'Bono' else (case when permite_financiacion=true and ayuda_economica=false then 'Financiado' else 'Ayuda Economica' end) end) end) as tipo
                  
            FROM 
              public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join categoria_comercio on categoria_comercio.idcategoria_comercio = convenio.idcategoria_comercio
            inner join comercio on comercio.idcomercio = consumo_convenio.idcomercio
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
              $sql_usuario and
              $where
            group by
              persona.apellido, 
              persona.nombres,
              convenio.titulo ,
              idconsumo_convenio, 
              categoria_comercio.descripcion ,
              idafiliacion, 
              consumo_convenio.idconvenio, 
              comercio.idcomercio, total, 
              fecha, 
              monto_proforma, 
              cantidad_cuotas, 
              consumo_convenio.descripcion, 
              cantidad_bonos, 
              comercio.nombre,
              consumo_ticket,
              maneja_bono,
              permite_financiacion,
              ayuda_economica
            
            UNION
            SELECT 
                (persona.apellido||', '|| persona.nombres) as socio,
                convenio.titulo as convenio,
                idconsumo_convenio, 
                categoria_comercio.descripcion as categoria,
                idafiliacion, 
                consumo_convenio.idconvenio, 
                comercio.idcomercio, 
                cantidad_bonos *   talonario_bono.monto_bono as total,
                fecha, 
                null as   monto_proforma, 
                null as cantidad_cuotas,
                consumo_convenio.descripcion, 
                cantidad_bonos, 
                comercio.codigo ||'-'||comercio.nombre as comercio, 
                '$'||' '||(case when talonario_bono.monto_bono > 0 then talonario_bono.monto_bono else null end ) as monto_bono, 
                (case when fecha is null then periodo else to_char(fecha, 'MM/YYYY') end) as periodo,
                null as cantidad_pagas,
                (case when consumo_ticket=true then 'Ticket' else (case when maneja_bono=true then 'Bono' else (case when permite_financiacion=true and ayuda_economica=false then 'Financiado' else 'Ayuda Economica' end) end) end) as tipo

                    
              FROM 
                public.consumo_convenio
            left outer  join afiliacion using(idafiliacion)
            left outer join persona on persona.idpersona = afiliacion.idpersona
            inner  join talonario_bono using(idtalonario_bono) 
            inner join convenio on convenio.idconvenio = talonario_bono.idconvenio
                        inner join categoria_comercio on categoria_comercio.idcategoria_comercio = convenio.idcategoria_comercio

            inner join comercio on comercio.idcomercio= talonario_bono.idcomercio
            where
              $sql_usuario and
              $where    
            group by
              persona.apellido, 
              persona.nombres,
              convenio.titulo ,
              idconsumo_convenio, 
              categoria_comercio.descripcion ,
              idafiliacion, 
              consumo_convenio.idconvenio, 
              comercio.idcomercio, total, 
              fecha, 
              monto_proforma, 
              cantidad_cuotas, 
              consumo_convenio.descripcion, 
              talonario_bono.monto_bono,
              cantidad_bonos, 
              comercio.nombre,
              consumo_ticket,
              maneja_bono,
              permite_financiacion,
              ayuda_economica
         order by 
             periodo desc, tipo, categoria asc ,  socio  ";
        return consultar_fuente($sql);
  }

  function get_estado_situacion($periodo = null, $idafiliacion = null)
  {
    $periodo_anterior = self::calcular_periodo_anterior($periodo);
    $periodo_anterior = quote("%{$periodo_anterior}%");
    $periodo = quote("%{$periodo}%");
        
    $sql = "SELECT      
                    convenio.titulo as beneficio,
                    consumo_convenio_cuotas.periodo,
                    sum (consumo_convenio_cuotas.monto) as monto,
                    persona.legajo,
                    persona.apellido||', '|| persona.nombres as persona,
                    afiliacion.idafiliacion
            FROM 
                  public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join consumo_convenio_cuotas using (idconsumo_convenio)
            inner join afiliacion using (idafiliacion)
            inner join persona using (idpersona)
            inner join forma_pago using(idforma_pago)
            WHERE
                  convenio.permite_financiacion = true and
                  forma_pago.planilla = true and
                  consumo_convenio.pagado = true and
                  consumo_convenio_cuotas.envio_descuento =  false and
                  afiliacion.idafiliacion = $idafiliacion and 
                  consumo_convenio_cuotas.periodo ilike  $periodo
            group by 
              beneficio,
              consumo_convenio_cuotas.periodo,
              persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
           UNION
            SELECT      
                  convenio.titulo as beneficio,
                  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY')  as periodo,
                  sum(detalle_pago_consumo_convenio.monto),
                  persona.legajo,
                  persona.apellido||', '|| persona.nombres as persona,
                  afiliacion.idafiliacion
            FROM 
                public.consumo_convenio
            inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
            inner join detalle_pago_consumo_convenio using (idconsumo_convenio)
            inner join forma_pago using(idforma_pago)
            inner join afiliacion using (idafiliacion)
            inner join persona using (idpersona)
           
            WHERE
                  forma_pago.planilla = true and
                  detalle_pago_consumo_convenio.envio_descuento =  false and
                  afiliacion.idafiliacion = $idafiliacion and 
                  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $periodo
            group by 
              beneficio,
              to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ,
              persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
           
            UNION
              SELECT 
                    'RESERVAS' as beneficio,
                    to_char(detalle_pago.fecha, 'MM/YYYY') as periodo,
                    sum (detalle_pago.monto) as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion
            FROM 
                public.solicitud_reserva
            inner join detalle_pago using(idsolicitud_reserva)
            inner join forma_pago  using(idforma_pago)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            WHERE
              forma_pago.planilla = true and
              envio_descuento = false and 
              afiliacion.idafiliacion = $idafiliacion and 
              to_char(detalle_pago.fecha, 'MM/YYYY') ilike $periodo
            group by 
              periodo,
                 persona.legajo,
              persona.apellido,
              persona.nombres,
               afiliacion.idafiliacion
            UNION
            SELECT  'COLONIA' as beneficio,
                    periodo,
                    sum(inscripcion_colono_plan_pago.monto) as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion
            FROM 
              public.inscripcion_colono_plan_pago
            inner join forma_pago  using(idforma_pago)
            inner join inscripcion_colono using(idinscripcion_colono)
             inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            WHERE
              forma_pago.planilla = true  and
              envio_descuento = false and
              afiliacion.idafiliacion = $idafiliacion and 
              periodo ilike $periodo
            group by
               periodo,
                persona.legajo,
              persona.apellido,
              persona.nombres,
               afiliacion.idafiliacion
            UNION
            SELECT  'PILETA' as beneficio, 
                    to_char(fecha, 'MM/YYYY') as periodo,
                    sum(monto) as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion
            FROM 
              public.detalle_pago_inscripcion_pileta
            inner join forma_pago using(idforma_pago)
            inner join inscripcion_pileta using(idinscripcion_pileta)
            inner join afiliacion using(idafiliacion)
            inner join persona using(idpersona)
            where
              forma_pago.planilla = true and
              envio_descuento = false and
              afiliacion.idafiliacion = $idafiliacion and 
              to_char(fecha, 'MM/YYYY') ilike $periodo

            group by
               to_char(fecha, 'MM/YYYY'),
               persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
          
            UNION  
           SELECT  'BONO COLABORACION' as beneficio, 
                    to_char(fecha_compra, 'MM/YYYY') as periodo, 
                    sum(talonario_bono_colaboracion.monto) as monto,
                     persona.legajo,
                     persona.apellido||', '|| persona.nombres as persona,
                     afiliacion.idafiliacion            
            FROM 
              public.talonario_nros_bono_colaboracion
              inner join talonario_bono_colaboracion on talonario_bono_colaboracion.idtalonario_bono_colaboracion = talonario_nros_bono_colaboracion.idtalonario_bono_colaboracion
              inner join forma_pago using(idforma_pago)
              inner join afiliacion using (idafiliacion )
              inner join persona using (idpersona)
            where
                forma_pago.planilla = true  and
                pagado = false and
                afiliacion.idafiliacion = $idafiliacion and 
                to_char(fecha_compra, 'MM/YYYY') ilike $periodo
            group by 
              periodo,
              persona.legajo,
              persona.apellido,
              persona.nombres,
              afiliacion.idafiliacion
            UNION
            SELECT 'SALDO LIQUIDACION ANTERIOR' as beneficio,
                    periodo,
                    saldo as monto,
                    persona.legajo,
                    persona.apellido||', '|| persona.nombres as persona,
                    afiliacion.idafiliacion  
            FROM public.cabecera_liquidacion
            inner join detalle_liquidacion using(idcabecera_liquidacion)
            inner join afiliacion using (idafiliacion )
            inner join persona using (idpersona)
              where
                afiliacion.idafiliacion = $idafiliacion and 
                periodo ilike $periodo_anterior
            order by
              persona";

     return consultar_fuente($sql);

  }

  function calcular_periodo_anterior($periodo)
  {
    list($mes, $anio) = explode('/', $periodo);
    $mes_anterior = '0';
    $anio_anterior = '0';

    if ($mes=='01')
    {
      $mes_anterior = 12;
      $anio_anterior =(int) $anio -1;
    } else {
      $mes_anterior = (int)$mes -1 ;
      $anio_anterior =(int) $anio ;
    }

    return $mes_anterior.'/'.$anio_anterior;

  }

  function get_total_consumido_en_bono_por_convenio_por_socio($idafiliacion = null, $idconvenio = null)
  {
    $sql = "SELECT  sum(consumo_convenio.total) as total
            FROM public.consumo_convenio
            where
              idafiliacion = $idafiliacion and
              idconvenio = $idconvenio"; 
    $res = consultar_fuente($sql);
    if (isset($res[0]['total']))
    {
      return $res[0]['total'];
    }
  }

  function get_monto_maximo_mensual_convenio($idconvenio = null)
  {
    $sql = "SELECT monto_maximo_mensual
            FROM 
              public.convenio
            where
              idconvenio = $idconvenio";
    $res = consultar_fuente($sql);
    if (isset($res[0]['monto_maximo_mensual']))
    {
      return $res[0]['monto_maximo_mensual'];
    }
  }

  function get_total_estado_situacion($periodo = null, $idafiliacion = null)
  {
    $periodo_anterior = self::calcular_periodo_anterior($periodo);
    $periodo_anterior = quote("%{$periodo_anterior}%");
    $periodo = quote("%{$periodo}%");

   $sql = "SELECT traer_estad_situacion_afiliado($idafiliacion,$periodo,$periodo_anterior) as total";
    $res = consultar_fuente($sql);
    if (isset($res[0]['total']))
    {
      return $res[0]['total'];
    }
  }
  function sacar_periodo_fecha($fecha)
  {
      list($anio,$mes,$dia) = explode('-', $fecha);  
      return $mes.'/'.$anio;
  }
}
?>
