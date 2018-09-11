<?php
class dao 
{

  function get_sql_usuario()
  {

    $usuario = toba::usuario()->get_id();
    $perfil = toba::usuario()->get_perfiles_funcionales();
    $usuario = quote("%{$usuario}%");
    $sql = '';
    if ($perfil[0] == 'afiliado')
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
		if (isset($where))
		{
			 $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
            nro_documento, 
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
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
            tipo_socio.descripcion as tipo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          inner join afiliacion using (idpersona)
          inner join tipo_socio using(idtipo_socio)
          where
            afiliacion.activa = true and
            $sql_usuario and
            $where 
          order by
            apellido,nombres";
		} else {
      $sql = "SELECT  idpersona, 
            (tipo_documento.sigla ||'-'||nro_documento) as documento, 
            nro_documento, 
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
            idestado_civil,
            (CASE WHEN sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
            tipo_socio.descripcion as tipo
          FROM public.persona
          inner join tipo_documento using(idtipo_documento)
          inner join afiliacion using (idpersona)
          inner join tipo_socio using(idtipo_socio)
          where
            afiliacion.activa = true and
            tipo_socio.titular = true and
            $sql_usuario 
          order by
            apellido,nombres";
    }
  
   
		

  		
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
              $sql_usuario";

    return consultar_fuente($sql);

  }  

  function get_datos_persona_afiliada($idafiliacion = null)
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
                $where";
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
                    fecha, 
                    instalacion.nombre as instalacion, 
                    estado.descripcion as estado, 
                    motivo.descripcion as motivo, 
                    nro_personas,
                    solicitud_reserva.monto,
                    monto_final,
                    sum (detalle_pago.monto) as pago_detalle
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
              fecha, 
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
                    fecha, 
                    instalacion.nombre as instalacion, 
                    estado.descripcion as estado, 
                    motivo.descripcion as motivo, 
                    nro_personas,
                    solicitud_reserva.monto,
                    monto_final,
                    sum (detalle_pago.monto) as pago_detalle
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
              extract(MONTH FROM fecha) = extract(MONTH FROM current_date) and
              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              fecha, 
              instalacion.nombre , 
              estado.descripcion , 
              motivo.descripcion , 
              nro_personas,
              solicitud_reserva.monto,
              monto_final,
              estado.confirmada 
            order by 
              estado.confirmada desc,fecha desc";
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
                    fecha, 
                    instalacion.nombre as instalacion, 
                    estado.descripcion as estado, 
                    motivo.descripcion as motivo, 
                    nro_personas,
                    solicitud_reserva.monto,
                    monto_final,
                    sum (detalle_pago.monto) as pago_detalle
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
              extract(MONTH FROM fecha) != extract(MONTH FROM current_date) and
              $where
            group by 
              solicitud_reserva.idsolicitud_reserva,
              persona.apellido ,
              persona.nombres ,
              fecha, 
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
                      efectivo

              FROM 
                  public.forma_pago 
              
              where
                $where
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
              $where";
    return consultar_fuente($sql);
  }

  function get_listado_comercios($where = null)
  {
    if (!isset($where))
    {
      $where = '1 = 1';
    }
    $sql =" SELECT   idcomercio, 
                    nombre, 
                    direccion, 
                    localidad.descripcion as localidad, 
                    categoria_comercio.descripcion as categoria,
                    codigo
            FROM public.comercio
            inner join localidad using(idlocalidad)
            inner join categoria_comercio using(idcategoria_comercio)
            where
              $where";
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
                  senia
            FROM public.concepto

            where
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

  function get_listado_solicitudes_reempadronamientos ()
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
                  notificaciones = 0
            order by
                  apellido, nombres
            limit 50";
      return consultar_fuente($sql);

  }  

  function get_listado_solicitudes_reempadronamientos_enviadas ()
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
                  notificaciones != 0
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
            where atendida = false";
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
                    monto_bono
            FROM public.talonario_bono
            inner join comercio using(idcomercio)
            inner join convenio using(idconvenio)
            where 
                $where";
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
              $where";
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
                  $where";
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
                    periodo   as mes                
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
            order by mes desc";
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
              consumo_convenio_cuotas.envio_descuento =  false and 
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
   
                    count(consumo_convenio_cuotas.idconsumo_convenio_cuotas) as cantidad_pagas
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
              consumo_convenio_cuotas.envio_descuento =  true and 
              (convenio.ayuda_economica is null or convenio.ayuda_economica = false) and
                (consumo_convenio_cuotas.cuota_pagada =  false or
               ((current_date - (3||' months')::interval)  >= (select traer_fecha_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)))) and 
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
                    cantidad_cuotas * consumo_convenio_cuotas.monto as total, 
                    fecha, 
                    cantidad_cuotas,
                     (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) as cantidad_pagas,
                    consumo_convenio_cuotas.monto  as valor_cuota        
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
              consumo_convenio_cuotas.monto 
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
                    cantidad_cuotas * consumo_convenio_cuotas.monto as total, 
                    fecha, 
                    cantidad_cuotas,
                     (select traer_cuotas_pagas(consumo_convenio.idconsumo_convenio)) as cantidad_pagas,
                     (select traer_periodo_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)) as perido_max_nro_cuota,
                     (select traer_fecha_pago_max_nro_cuota(consumo_convenio.idconsumo_convenio)) as fecha_max_nro_cuota,
                    consumo_convenio_cuotas.monto  as valor_cuota        
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
              consumo_convenio_cuotas.monto 
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
                    consumo_convenio_cuotas.monto  as valor_cuota        
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
              extract(year from age( familiar.fecha_nacimiento)) < 18 and
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
    $sql = "SELECT  solicitud_bolsita.idsolicitud_bolsita, 
                    familia.idpersona_familia, 
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    persona.apellido ||' - '||persona.nombres as titular,
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
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
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
                    familiar.apellido ||' - '||familiar.nombres as familiar_titular,
                    persona.legajo ||' - '||persona.apellido ||', '||persona.nombres as titular,
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

  function get_nros_vendidos_combo_editable($filtro = null)
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
              $where";
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
                    inscripcion_colono.baja 

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
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
                    persona.nombres ";
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
                    inscripcion_colono.baja 

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            WHERE
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
                    persona.nombres ";
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

  function get_colonos_del_afiliado()
  {
    $sql = "SELECT  
                    afiliacion.idafiliacion,
                     tipo_socio.descripcion||': '|| persona.apellido ||', '|| persona.nombres as titular,
                    configuracion_colonia.anio,
                    colonos_de_un_titular( afiliacion.idafiliacion) as colonos

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
              inscripcion_colono.baja = false
            group by
                  afiliacion.idafiliacion,
                  persona.apellido,
                  persona.nombres,
                  configuracion_colonia.anio,
                  tipo_socio.descripcion";
    return consultar_fuente($sql);

  } 

  function get_colonos_del_afiliado_con_plan()
  {
    $sql = "SELECT  
                    afiliacion.idafiliacion,
                     tipo_socio.descripcion||': '|| persona.apellido ||', '|| persona.nombres as titular,
                    configuracion_colonia.anio,
                    colonos_de_un_titular( afiliacion.idafiliacion) as colonos

              FROM 
              public.inscripcion_colono
              inner join configuracion_colonia using (idconfiguracion_colonia)
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            inner join inscripcion_colono_plan_pago using(idinscripcion_colono)
          
           group by
                  afiliacion.idafiliacion,
                  persona.apellido,
                  persona.nombres,
                  configuracion_colonia.anio,
                  tipo_socio.descripcion";
    return consultar_fuente($sql);

  }
}
?>
