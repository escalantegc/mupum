--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.12
-- Dumped by pg_dump version 9.5.12

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: actualizar_campo_envio_descuento_false0548(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_campo_envio_descuento_false0548(character) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    
BEGIN
       UPDATE public.detalle_pago
      SET  envio_descuento=false 
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago.fecha, 'MM/YYYY') ilike $1 ;

      UPDATE public.inscripcion_colono_plan_pago
      SET envio_descuento=false , cuota_pagada = false, fecha_pago = null
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1; 


      UPDATE public.detalle_pago_inscripcion_pileta
      SET envio_descuento=false
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_inscripcion_pileta.fecha, 'MM/YYYY') ilike $1;
 
      
   RETURN null;
END
$_$;


ALTER FUNCTION public.actualizar_campo_envio_descuento_false0548(character) OWNER TO postgres;

--
-- Name: actualizar_campo_envio_descuento_false0549(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_campo_envio_descuento_false0549(character) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    
BEGIN
      UPDATE public.consumo_convenio_cuotas
            SET envio_descuento=false , cuota_pagada = false ,fecha_pago = null
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1 ;

            UPDATE public.detalle_pago_consumo_convenio
            SET envio_descuento=false
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $1 ;
   RETURN null;
END
$_$;


ALTER FUNCTION public.actualizar_campo_envio_descuento_false0549(character) OWNER TO postgres;

--
-- Name: actualizar_campo_envio_descuento_false0550(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_campo_envio_descuento_false0550(character) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    
BEGIN
      UPDATE public.talonario_nros_bono_colaboracion
            SET pagado = false
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(fecha_compra, 'MM/YYYY') ilike $1;
   RETURN null;
END
$_$;


ALTER FUNCTION public.actualizar_campo_envio_descuento_false0550(character) OWNER TO postgres;

--
-- Name: actualizar_campo_envio_descuento_true0548(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_campo_envio_descuento_true0548(character) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    
BEGIN
      UPDATE public.detalle_pago
      SET  envio_descuento=true 
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago.fecha, 'MM/YYYY') ilike $1 ;

      UPDATE public.inscripcion_colono_plan_pago
      SET envio_descuento=true , cuota_pagada = true, fecha_pago = current_date
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1; 


      UPDATE public.detalle_pago_inscripcion_pileta
      SET envio_descuento=true
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_inscripcion_pileta.fecha, 'MM/YYYY') ilike $1;
 
      
   RETURN null;
END
$_$;


ALTER FUNCTION public.actualizar_campo_envio_descuento_true0548(character) OWNER TO postgres;

--
-- Name: actualizar_campo_envio_descuento_true0549(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_campo_envio_descuento_true0549(character) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    
BEGIN
UPDATE public.consumo_convenio_cuotas
            SET envio_descuento=true  , cuota_pagada = true ,fecha_pago = current_date
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1 ;

            UPDATE public.detalle_pago_consumo_convenio
            SET envio_descuento=true 
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $1 ;
      
   RETURN null;
END
$_$;


ALTER FUNCTION public.actualizar_campo_envio_descuento_true0549(character) OWNER TO postgres;

--
-- Name: actualizar_campo_envio_descuento_true0550(character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.actualizar_campo_envio_descuento_true0550(character) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    
BEGIN
      UPDATE public.talonario_nros_bono_colaboracion
            SET pagado = true
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(fecha_compra, 'MM/YYYY') ilike $1;
   RETURN null;
END
$_$;


ALTER FUNCTION public.actualizar_campo_envio_descuento_true0550(character) OWNER TO postgres;

--
-- Name: cantidad_numeros_talonario_bono_colaboracion(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*) as cantidad FROM public.talonario_nros_bono_colaboracion
      where
      idtalonario_bono_colaboracion = $1 );
      
   RETURN cantidad;
END
$_$;


ALTER FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer) OWNER TO postgres;

--
-- Name: cantidad_numeros_vendidos_talonario_bono(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.cantidad_numeros_vendidos_talonario_bono(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*) as cant
		FROM public.talonario_nros_bono
	      where
	      idtalonario_bono = $1 and
	      disponible =false);
      
   RETURN cantidad;
END
$_$;


ALTER FUNCTION public.cantidad_numeros_vendidos_talonario_bono(integer) OWNER TO postgres;

--
-- Name: cantidad_numeros_vendidos_talonario_bono_colaboracion(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.cantidad_numeros_vendidos_talonario_bono_colaboracion(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*) as cantidad FROM public.talonario_nros_bono_colaboracion
      where
      idtalonario_bono_colaboracion = $1 and
      pagado = true);
      
   RETURN cantidad;
END
$_$;


ALTER FUNCTION public.cantidad_numeros_vendidos_talonario_bono_colaboracion(integer) OWNER TO postgres;

--
-- Name: cantidad_registros_detalle_pago_inscripcion_pileta(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.cantidad_registros_detalle_pago_inscripcion_pileta(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    cantidad integer;
    
BEGIN
  cantidad := (SELECT count(*)
			  FROM public.detalle_pago_inscripcion_pileta
			  where 
	idinscripcion_pileta = $1 );
      
   RETURN cantidad;
END
$_$;


ALTER FUNCTION public.cantidad_registros_detalle_pago_inscripcion_pileta(integer) OWNER TO postgres;

--
-- Name: colonos_de_un_titular(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.colonos_de_un_titular(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1
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
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$_$;


ALTER FUNCTION public.colonos_de_un_titular(integer) OWNER TO postgres;

--
-- Name: colonos_de_un_titular(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.colonos_de_un_titular(integer, integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1 and
    inscripcion_colono.idconfiguracion_colonia = $2 
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
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$_$;


ALTER FUNCTION public.colonos_de_un_titular(integer, integer) OWNER TO postgres;

--
-- Name: colonos_de_un_titular_con_plan(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.colonos_de_un_titular_con_plan(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1 and
  cantidad_cuotas > 0
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
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$_$;


ALTER FUNCTION public.colonos_de_un_titular_con_plan(integer) OWNER TO postgres;

--
-- Name: colonos_de_un_titular_con_plan(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.colonos_de_un_titular_con_plan(integer, integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1 and
  inscripcion_colono.idconfiguracion_colonia = $2 and
  cantidad_cuotas > 0
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
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$_$;


ALTER FUNCTION public.colonos_de_un_titular_con_plan(integer, integer) OWNER TO postgres;

--
-- Name: colonos_de_un_titular_sin_plan(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.colonos_de_un_titular_sin_plan(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1 and
  cantidad_cuotas =0
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
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$_$;


ALTER FUNCTION public.colonos_de_un_titular_sin_plan(integer) OWNER TO postgres;

--
-- Name: colonos_de_un_titular_sin_plan(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.colonos_de_un_titular_sin_plan(integer, integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    colonos text;
BEGIN
    FOR REG IN (SELECT  idinscripcion_colono, 
                    idconfiguracion_colonia, 
                    idpersona_familia, 
                    es_alergico, 
                    alergias, 
                    informacion_complementaria, 
                    idafiliacion, 
                    fecha,
                    colono.apellido ||', '|| colono.nombres as colono,
                    tipo_socio.descripcion||': '||persona.apellido ||', '|| persona.nombres as titular

              FROM 
              public.inscripcion_colono
            inner join  familia using(idpersona_familia)
            inner join persona colono on familia.idpersona_familia = colono.idpersona
            inner join afiliacion using(idafiliacion)
            inner join tipo_socio on tipo_socio.idtipo_socio=afiliacion.idtipo_socio
            inner join persona on afiliacion.idpersona=persona.idpersona
            where 
  afiliacion.idafiliacion = $1 and
  inscripcion_colono.idconfiguracion_colonia = $2 and
  cantidad_cuotas =0
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
                    persona.nombres) LOOP
  colonos:=  coalesce(colonos,'') ||' | '||coalesce(reg.colono,'');

       
    END LOOP;
   RETURN colonos;
END
$_$;


ALTER FUNCTION public.colonos_de_un_titular_sin_plan(integer, integer) OWNER TO postgres;

--
-- Name: familiar_de_un_titular(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.familiar_de_un_titular(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    familiares text;
BEGIN
    FOR REG IN (SELECT  familia.idpersona, 
                    familia.idpersona_familia, 
                    persona.apellido ||', '||persona.nombres as titular,
                     parentesco.descripcion||': '||familiar.apellido ||', '||familiar.nombres as familiar_titular,
                    parentesco.descripcion as parentesco, 
                    fecha_relacion, 
                    acargo, 
                    fecha_carga,
                    extract(year from age( familiar.fecha_nacimiento)) as edad,
                    familiar.fecha_nacimiento,
                    (CASE WHEN familiar.sexo = 'm' THEN 'MASCULINO' else 'FEMENINO' end) as sexo,
                    tipo_documento.sigla ||' - '|| familiar.nro_documento as documento

            FROM 
                    familia
            inner join persona on persona.idpersona=familia.idpersona
            inner join persona familiar on familiar.idpersona=familia.idpersona_familia
            inner join parentesco using(idparentesco)
            inner join tipo_documento on familiar.idtipo_documento = tipo_documento.idtipo_documento
            inner join detalle_inscripcion_pileta on detalle_inscripcion_pileta.idpersona_familia= familia.idpersona_familia
            where
		persona.idpersona = $1) LOOP
  familiares:=  coalesce(familiares,'') ||' | '||coalesce(reg.familiar_titular,'');

       
    END LOOP;
   RETURN familiares;
END
$_$;


ALTER FUNCTION public.familiar_de_un_titular(integer) OWNER TO postgres;

--
-- Name: generar_detalle_pago_consumo_convenio(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_detalle_pago_consumo_convenio() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE

    monto double precision := new.total ;
    idconv integer := New.idconvenio;
    idfp integer ;
    bono boolean;
    ticket boolean;
   
BEGIN
    bono := (select maneja_bono from convenio where idconvenio = idconv);
    ticket := (select consumo_ticket from convenio where idconvenio = idconv);
   
    idfp := (SELECT idforma_pago  FROM public.forma_pago where planilla = true);

	IF (bono = true) or (ticket = true) THEN
		INSERT INTO public.detalle_pago_consumo_convenio(monto, 
								idconsumo_convenio, 
								idforma_pago, 
								fecha)
			VALUES (monto, 
				New.idconsumo_convenio, 
				idfp,
				current_date);

	END IF;

		   RETURN null;
END
$$;


ALTER FUNCTION public.generar_detalle_pago_consumo_convenio() OWNER TO postgres;

--
-- Name: generar_detalle_pago_solicitud_reserva(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_detalle_pago_solicitud_reserva() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE

    monto_final double precision := New.monto_final ;
    idsr integer := New.idsolicitud_reserva;
    monto_senia double precision;
monto_pago double precision;	
monto_tipo_socio  double precision;	
 porcentaje_tipo_socio  double precision;	  
BEGIN
    monto_senia := (SELECT monto  FROM public.detalle_pago where idsolicitud_reserva= idsr);
    monto_tipo_socio := (SELECT monto_reserva  FROM public.motivo_tipo_socio where idmotivo_tipo_socio = New.idmotivo_tipo_socio);
    porcentaje_tipo_socio := (SELECT porcentaje_senia FROM public.motivo_tipo_socio where idmotivo_tipo_socio = New.idmotivo_tipo_socio);
    monto_senia := monto_tipo_socio * (porcentaje_tipo_socio/100);
    monto_pago := monto_final - monto_senia;
    
	INSERT INTO public.detalle_pago(monto, 
					idsolicitud_reserva, 
					fecha)
	    VALUES (monto_pago, 
		    idsr, 
		    current_date);



		   RETURN null;
END
$$;


ALTER FUNCTION public.generar_detalle_pago_solicitud_reserva() OWNER TO postgres;

--
-- Name: generar_deuda_ayuda_economica(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_deuda_ayuda_economica() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    inicio integer := 0;
    fin integer := New.cantidad_cuotas;
    monto double precision := New.monto / fin;
    fecha_cuota date:=New.fecha;
BEGIN
    
  LOOP
  
  EXIT WHEN inicio = fin ;
  INSERT INTO public.detalle_ayuda_economica(idayuda_economica, nro_cuota, periodo,monto)
VALUES (New.idayuda_economica, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), monto);
  inicio:=inicio+1;
  
  
 END LOOP;
   RETURN null;
END
$$;


ALTER FUNCTION public.generar_deuda_ayuda_economica() OWNER TO postgres;

--
-- Name: generar_deuda_consumo_convenio_cuotas(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_deuda_consumo_convenio_cuotas() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    inicio integer := 0;
    fin integer := New.cantidad_cuotas;
    mm double precision := new.total / fin;
    monto double precision := (select round(cast(mm as numeric),2));
    monto_final double precision ;
    fecha_cuota date:=New.fecha;
    idconv integer := New.idconvenio;
    idcomer integer := New.idcomercio;
    bono boolean;
    ticket boolean;
    inter double precision;
    inter_total double precision;
    monto_interes double precision;
     monto_interes_redondeado double precision;
    monto_interes_cuota double precision;
    ayuda boolean;
    fecha_limite integer;
    fecha_actual integer;
    mes integer :=0;
    idfp integer; 
BEGIN
    bono := (select maneja_bono from convenio where idconvenio = idconv);
    ticket := (select consumo_ticket from convenio where idconvenio = idconv);
    ayuda := (select ayuda_economica from convenio where idconvenio = idconv);
    inter := (SELECT   porcentaje_interes  FROM public.comercios_por_convenio where idconvenio=idconv and idcomercio=idcomer);
    fecha_limite:= (SELECT fecha_limite_pedido_convenio  FROM public.configuracion);
    fecha_actual:= (SELECT extract(day from current_date));
    idfp := (SELECT idforma_pago  FROM public.forma_pago where planilla = true);

   IF bono = false THEN
    IF ticket = false THEN
  IF ayuda = false THEN
   LOOP
      
         EXIT WHEN inicio = fin ;
    INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto,idforma_pago)
VALUES (New.idconsumo_convenio, inicio+1, trim(to_char(extract(month from (fecha_cuota + (mes||' months')::interval)),'00')) ||'/'|| extract(YEAR from (fecha_cuota + (mes||' months')::interval)), monto,idfp);
          inicio:=inicio+1;
          mes:=mes+1;
        
   END LOOP;
   ELSE
     inter_total := fin * inter; 
     monto_interes := new.total * (inter_total/100);
    monto_interes_redondeado := (select round( cast(monto_interes as numeric),2));
     monto_interes_cuota := (select round( cast(monto_interes_redondeado/ fin as numeric),2)) ;
     monto_final:=(select round( cast(monto as numeric),2)) + monto_interes_cuota;
     LOOP
      
        EXIT WHEN inicio = fin ;
   INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto, interes, monto_puro,idforma_pago)
VALUES (New.idconsumo_convenio, inicio+1, trim(to_char(extract(month from (fecha_cuota + (mes||' months')::interval)),'00')) ||'/'|| extract(YEAR from (fecha_cuota + (mes||' months')::interval)), monto_final,inter, monto,idfp);
          inicio:=inicio+1;
          mes:=mes+1;
     END LOOP;
  END IF;
   END IF;
   END IF;

   RETURN null;
END
$$;


ALTER FUNCTION public.generar_deuda_consumo_convenio_cuotas() OWNER TO postgres;

--
-- Name: generar_deuda_consumo_financiado(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_deuda_consumo_financiado() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    inicio integer := 0;
    fin integer := New.cantidad_cuotas;
    monto double precision := new.total / fin;
    fecha_cuota date:=New.fecha;
BEGIN
    
  LOOP
  
  EXIT WHEN inicio = fin ;
  INSERT INTO public.detalle_consumo_financiado( idconsumo_financiado, nro_cuota, mes, anio, monto, fecha)
VALUES ( New.idconsumo_financiado, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)), extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), monto, (fecha_cuota + (inicio||' months')::interval)::date);
  inicio:=inicio+1;
  
  
 END LOOP;
   RETURN null;
END
$$;


ALTER FUNCTION public.generar_deuda_consumo_financiado() OWNER TO postgres;

--
-- Name: generar_numeros_talonario(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_numeros_talonario() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    inicio integer := New.nro_inicio;
    fin integer := New.nro_fin;
BEGIN
    
  LOOP
  EXIT WHEN inicio > fin ;
  INSERT INTO public.talonario_nros_bono(idtalonario_bono, nro_bono)
VALUES (New.idtalonario_bono,inicio);
  inicio:=inicio+1;
  
  
 END LOOP;
   RETURN null;
END
$$;


ALTER FUNCTION public.generar_numeros_talonario() OWNER TO postgres;

--
-- Name: generar_numeros_talonario_bono_colaboracion(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_numeros_talonario_bono_colaboracion() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    inicio integer := New.nro_inicio;
    fin integer := New.nro_fin;
BEGIN
    
  LOOP
  EXIT WHEN inicio > fin ;
  INSERT INTO public.talonario_nros_bono_colaboracion(idtalonario_bono_colaboracion, nro_bono,idforma_pago)
VALUES (New.idtalonario_bono_colaboracion,inicio, (select idforma_pago from forma_pago where planilla=true));
  inicio:=inicio+1;
  
  
 END LOOP;
   RETURN null;
END
$$;


ALTER FUNCTION public.generar_numeros_talonario_bono_colaboracion() OWNER TO postgres;

--
-- Name: generar_plan_pago_inscripcion_colonia(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_plan_pago_inscripcion_colonia() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    inicio integer := 1;
    fin integer := New.cantidad_cuotas;
    monto_menos_inscripcion double precision := new.monto - new.monto_inscripcion;
    monto_cuota double precision := monto_menos_inscripcion / fin;
    fecha_cuota date:= current_date;
    idfp integer;
    idfe integer;
    titular boolean;
BEGIN
    idfp := (SELECT idforma_pago  FROM public.forma_pago where planilla = true);
    idfe := (SELECT idforma_pago  FROM public.forma_pago where efectivo = true);
    titular := (SELECT  tipo_socio.titular FROM public.tipo_socio inner join afiliacion using(idtipo_socio) where idafiliacion = New.idafiliacion);
    
 IF (New.cantidad_cuotas > 0) and (Old.cantidad_cuotas = 0) THEN
     INSERT INTO public.inscripcion_colono_plan_pago(idinscripcion_colono, 
						   nro_cuota, 
						   periodo, 
						   monto, 
						   idforma_pago, 
						   fecha_generacion_plan, 
						   inscripcion)
    VALUES ( New.idinscripcion_colono,
	     1,
	     trim(to_char(extract(month from fecha_cuota ),'00')) ||'/'|| extract(YEAR from fecha_cuota ),
	     new.monto_inscripcion,
	     idfe,
	     fecha_cuota,
	     true);

   LOOP
      
         EXIT WHEN inicio > fin ;
	IF titular = true THEN
	     INSERT INTO public.inscripcion_colono_plan_pago(idinscripcion_colono, 
						   nro_cuota, 
						   periodo, 
						   monto, 
						   idforma_pago, 
						   fecha_generacion_plan, 
						   inscripcion)
	    VALUES ( New.idinscripcion_colono,
		     inicio+1,
		     trim(to_char(extract(month from (fecha_cuota + (inicio||' months')::interval)),'00')) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), 
		     monto_cuota,
		     idfp,
		     fecha_cuota,
		     false);
		  inicio:=inicio+1;
	ELSE
		INSERT INTO public.inscripcion_colono_plan_pago(idinscripcion_colono, 
						   nro_cuota, 
						   periodo, 
						   monto, 
						   idforma_pago, 
						   fecha_generacion_plan, 
						   inscripcion)
	    VALUES ( New.idinscripcion_colono,
		     inicio+1,
		     trim(to_char(extract(month from (fecha_cuota + (inicio||' months')::interval)),'00')) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), 
		     monto_cuota,
		     idfe,
		     fecha_cuota,
		     false);
		  inicio:=inicio+1;	
	END IF;
	    
        
	END LOOP;
 END IF;
 



   RETURN null;
END
$$;


ALTER FUNCTION public.generar_plan_pago_inscripcion_colonia() OWNER TO postgres;

--
-- Name: generar_solicitudes_reempadronamiento_socios(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.generar_solicitudes_reempadronamiento_socios() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
    reg RECORD;
    
BEGIN
    FOR REG IN (SELECT idafiliacion  
  FROM public.afiliacion
  inner join tipo_socio using(idtipo_socio)
  where activa =true and
        tipo_socio.titular =true)
  LOOP
  IF (TG_OP = 'INSERT') THEN
  INSERT INTO public.solicitud_reempadronamiento(idreempadronamiento, idafiliacion)
VALUES (New.idreempadronamiento, REG.idafiliacion);
  
  END IF;
 END LOOP;
   RETURN null;
END
$$;


ALTER FUNCTION public.generar_solicitudes_reempadronamiento_socios() OWNER TO postgres;

--
-- Name: premios_del_bono_colaboracion(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.premios_del_bono_colaboracion(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    premios text;
BEGIN
    FOR REG IN (SELECT 'Nro :'||nro_premio||' - '||descripcion as premio
			  FROM public.premio_sorteo
			  where
			  idtalonario_bono_colaboracion  =$1) 
	LOOP
		  premios:=  coalesce(premios,'') ||' | '||coalesce(reg.premio,'');

       
    END LOOP;
   RETURN premios;
END
$_$;


ALTER FUNCTION public.premios_del_bono_colaboracion(integer) OWNER TO postgres;

--
-- Name: recuperar_schema_temp(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.recuperar_schema_temp() RETURNS character varying
    LANGUAGE plpgsql
    AS $$
			DECLARE
			   schemas varchar;
			   pos_inicial int4;
			   pos_final int4;
			   schema_temp varchar;
			BEGIN
			   schema_temp := '';
			   SELECT INTO schemas current_schemas(true);
			   SELECT INTO pos_inicial strpos(schemas, 'pg_temp');
			   IF (pos_inicial > 0) THEN
			      SELECT INTO pos_final strpos(schemas, ',');
			      SELECT INTO schema_temp substr(schemas, pos_inicial, pos_final - pos_inicial);
			   END IF;
			   RETURN schema_temp;
			END;
			$$;


ALTER FUNCTION public.recuperar_schema_temp() OWNER TO postgres;

--
-- Name: telefonos_del_colono(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.telefonos_del_colono(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    telefonos text;
BEGIN
    FOR REG IN (SELECT 	tipo_telefono.descripcion ||' Nro :'||nro_telefono||' | Referencia: '||	parentesco.descripcion as telefono
		FROM public.telefono_inscripcion_colono
		inner join tipo_telefono using(idtipo_telefono)
		inner join parentesco using(idparentesco)
		where
		telefono_inscripcion_colono.idinscripcion_colono =$1) 
	LOOP
		  telefonos:=  coalesce(telefonos,'') ||' | '||coalesce(reg.telefono,'');

       
    END LOOP;
   RETURN telefonos;
END
$_$;


ALTER FUNCTION public.telefonos_del_colono(integer) OWNER TO postgres;

--
-- Name: total_abonado_detalle_pago_consumo_convenio(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.total_abonado_detalle_pago_consumo_convenio(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    total double precision;
    
BEGIN
  total := (SELECT sum (monto) as total
		FROM public.detalle_pago_consumo_convenio
		where idconsumo_convenio =  $1 and
		(envio_descuento = true or (idforma_pago != (select idforma_pago from forma_pago where planilla=true))));
      
   RETURN total;
END
$_$;


ALTER FUNCTION public.total_abonado_detalle_pago_consumo_convenio(integer) OWNER TO postgres;

--
-- Name: total_abonado_detalle_pago_inscripcion_pileta(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.total_abonado_detalle_pago_inscripcion_pileta(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    total double precision;
    
BEGIN
  total := (SELECT sum(monto)
			  FROM public.detalle_pago_inscripcion_pileta
			  where 
	idinscripcion_pileta = $1 and
		(envio_descuento = true or (idforma_pago != (select idforma_pago from forma_pago where planilla=true))));
      
   RETURN total;
END
$_$;


ALTER FUNCTION public.total_abonado_detalle_pago_inscripcion_pileta(integer) OWNER TO postgres;

--
-- Name: traer_cuotas_pagas(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.traer_cuotas_pagas(integer) RETURNS integer
    LANGUAGE plpgsql
    AS $_$
DECLARE
    cantidad integer;

BEGIN
    cantidad:= (select count(*) as c  from consumo_convenio_cuotas where cuota_pagada = true and idconsumo_convenio=$1);
   RETURN cantidad;
END
$_$;


ALTER FUNCTION public.traer_cuotas_pagas(integer) OWNER TO postgres;

--
-- Name: traer_detalle_pago_cancelado_reserva(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.traer_detalle_pago_cancelado_reserva(integer) RETURNS double precision
    LANGUAGE plpgsql
    AS $_$
DECLARE
    monto_planilla double precision:=0;
    monto_restante double precision:=0;
    monto_total double precision:=0;
  
BEGIN
    monto_planilla:= (SELECT (case when sum(monto) is null then 0 else sum(monto) end) as total  FROM public.detalle_pago
			inner join forma_pago using(idforma_pago)
			where
				forma_pago.planilla = true and
				detalle_pago.envio_descuento = true and
				detalle_pago.idsolicitud_reserva = $1);
   monto_restante:= (SELECT  (case when sum(monto) is null then 0 else sum(monto) end) as total  FROM public.detalle_pago
			inner join forma_pago using(idforma_pago)
			where
				forma_pago.planilla = false and
				detalle_pago.idsolicitud_reserva = $1);
				
   monto_total:= monto_planilla + monto_restante;
   return monto_total;
END
$_$;


ALTER FUNCTION public.traer_detalle_pago_cancelado_reserva(integer) OWNER TO postgres;

--
-- Name: traer_estad_situacion_afiliado(integer, character, character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.traer_estad_situacion_afiliado(integer, character, character) RETURNS double precision
    LANGUAGE plpgsql
    AS $_$
DECLARE
    total double precision;
    consumo_cuotas double precision := 0;
    consumo_pagos double precision:= 0;
    reserva double precision:= 0;
    bono double precision:= 0;
    pileta double precision:= 0;
    colonia double precision:= 0;
    saldo double precision:= 0;


BEGIN
  consumo_cuotas := (SELECT  sum (consumo_convenio_cuotas.monto) as monto
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
          consumo_convenio.pagado =  true and
          afiliacion.idafiliacion = $1 and 
          consumo_convenio_cuotas.periodo ilike  $2
        group by 
          
          consumo_convenio_cuotas.periodo,
          persona.legajo,
          persona.apellido,
          persona.nombres,
          afiliacion.idafiliacion );
     consumo_cuotas:=(case when consumo_cuotas is null then 0 else (select round(cast(consumo_cuotas as numeric),2)) end) ;    

  consumo_pagos:=(SELECT  sum(detalle_pago_consumo_convenio.monto)
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
          afiliacion.idafiliacion = $1 and 
          to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $2
        group by 
          persona.legajo,
          persona.apellido,
          persona.nombres,
          afiliacion.idafiliacion);
    consumo_pagos:= (case when consumo_pagos is null then 0 else (select round(cast(consumo_pagos as numeric),2)) end)  ;   
  reserva := (SELECT    sum (detalle_pago.monto) 
      FROM 
        public.solicitud_reserva
      inner join detalle_pago using(idsolicitud_reserva)
      inner join forma_pago  using(idforma_pago)
      inner join afiliacion using(idafiliacion)
      inner join persona using(idpersona)
      WHERE
        forma_pago.planilla = true and
        envio_descuento = false and 
        afiliacion.idafiliacion = $1 and 
        to_char(detalle_pago.fecha, 'MM/YYYY') ilike $2
      group by 
        
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
      reserva:= (case when reserva is null then 0 else (select round(cast(reserva as numeric),2)) end)  ;   

  colonia := (  SELECT  sum(inscripcion_colono_plan_pago.monto) 
      FROM 
        public.inscripcion_colono_plan_pago
      inner join forma_pago  using(idforma_pago)
      inner join inscripcion_colono using(idinscripcion_colono)
      inner join afiliacion using(idafiliacion)
      inner join persona using(idpersona)
      WHERE
        forma_pago.planilla = true  and
        envio_descuento = false and
	inscripcion_colono.baja = false and
        afiliacion.idafiliacion = $1 and 
        periodo ilike $2
      group by
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
              colonia:= (case when colonia is null then 0 else (select round(cast(colonia as numeric),2)) end)  ;   

  pileta :=(  SELECT  sum(monto) 
      FROM 
        public.detalle_pago_inscripcion_pileta
      inner join forma_pago using(idforma_pago)
      inner join inscripcion_pileta using(idinscripcion_pileta)
      inner join afiliacion using(idafiliacion)
      inner join persona using(idpersona)
      where
        forma_pago.planilla = true and
        envio_descuento = false and
        afiliacion.idafiliacion = $1 and 
        to_char(fecha, 'MM/YYYY') ilike $2

      group by
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
     pileta:= (case when pileta is null then 0 else (select round(cast(pileta as numeric),2)) end)  ;   

  bono:= (  SELECT  sum(talonario_bono_colaboracion.monto ) as total
      FROM 
        public.talonario_nros_bono_colaboracion
      inner join talonario_bono_colaboracion on talonario_bono_colaboracion.idtalonario_bono_colaboracion = talonario_nros_bono_colaboracion.idtalonario_bono_colaboracion
      inner join forma_pago using(idforma_pago)
      inner join afiliacion using (idafiliacion )
      inner join persona using (idpersona)
      where
        forma_pago.planilla = true  and
        pagado = false and
        afiliacion.idafiliacion = $1 and 
        to_char(fecha_compra, 'MM/YYYY') ilike $2
      group by 
        
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
         bono:= (case when bono is null then 0 else (select round(cast(bono as numeric),2)) end)  ;   
    
  saldo:= (  SELECT   detalle_liquidacion.saldo 
      FROM public.cabecera_liquidacion
      inner join detalle_liquidacion using(idcabecera_liquidacion)
      inner join afiliacion using (idafiliacion )
      inner join persona using (idpersona)
      where
        afiliacion.idafiliacion = $1 and 
        periodo ilike $3);
            saldo:= (case when saldo is null then 0 else (select round(cast(saldo as numeric),2)) end)  ;   
     
  total :=  consumo_cuotas +consumo_pagos+reserva+colonia+pileta+bono+saldo;
 
   RETURN total;
END
$_$;


ALTER FUNCTION public.traer_estad_situacion_afiliado(integer, character, character) OWNER TO postgres;

--
-- Name: traer_estad_situacion_afiliado33(integer, character, character); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.traer_estad_situacion_afiliado33(integer, character, character) RETURNS double precision
    LANGUAGE plpgsql
    AS $_$
DECLARE
    total double precision;
    consumo_cuotas double precision := 0;
    consumo_pagos double precision:= 0;
    reserva double precision:= 0;
    bono double precision:= 0;
    pileta double precision:= 0;
    colonia double precision:= 0;
    saldo double precision:= 0;


BEGIN
  
  colonia := (  SELECT  sum(inscripcion_colono_plan_pago.monto) 
      FROM 
        public.inscripcion_colono_plan_pago
      inner join forma_pago  using(idforma_pago)
      inner join inscripcion_colono using(idinscripcion_colono)
      inner join afiliacion using(idafiliacion)
      inner join persona using(idpersona)
      WHERE
        forma_pago.planilla = true  and
        envio_descuento = false and
        afiliacion.idafiliacion = $1 and 
        periodo ilike $2
      group by
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
  
  total :=  (case when colonia is null then 0 else (select round(cast(colonia as numeric),2)) end) ;
  
   RETURN total;
END
$_$;


ALTER FUNCTION public.traer_estad_situacion_afiliado33(integer, character, character) OWNER TO postgres;

--
-- Name: traer_fecha_pago_max_nro_cuota(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.traer_fecha_pago_max_nro_cuota(integer) RETURNS date
    LANGUAGE plpgsql
    AS $_$
DECLARE
    f date;

BEGIN
    f:= (select   fecha_pago  from consumo_convenio_cuotas 
 where   cuota_pagada = true and 
 idconsumo_convenio=$1 and 
 nro_cuota= (select max(nro_cuota) from consumo_convenio_cuotas where cuota_pagada = true and idconsumo_convenio=$1)
);
   RETURN f;
END
$_$;


ALTER FUNCTION public.traer_fecha_pago_max_nro_cuota(integer) OWNER TO postgres;

--
-- Name: traer_instalaciones_ocupadas(date); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.traer_instalaciones_ocupadas(date) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    reg RECORD;
    instalaciones text;
BEGIN
    FOR REG IN (SELECT  
                    instalacion.nombre
            FROM 
              public.solicitud_reserva
              inner join estado using (idestado)
              inner join instalacion using (idinstalacion)
		where 
		estado.cancelada = false and
		solicitud_reserva.fecha = $1)
  LOOP
 instalaciones:=  coalesce(instalaciones,'') ||'<u><b>'|| coalesce(reg.nombre,'') ||'</b></u>'||coalesce(chr(10),'');
 END LOOP;
   RETURN instalaciones;
END
$_$;


ALTER FUNCTION public.traer_instalaciones_ocupadas(date) OWNER TO postgres;

--
-- Name: traer_periodo_pago_max_nro_cuota(integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.traer_periodo_pago_max_nro_cuota(integer) RETURNS text
    LANGUAGE plpgsql
    AS $_$
DECLARE
    per character (7);

BEGIN
    per:= (select   trim(periodo)  from consumo_convenio_cuotas 
 where   cuota_pagada = true and 
 idconsumo_convenio=$1 and 
 nro_cuota= (select max(nro_cuota) from consumo_convenio_cuotas where cuota_pagada = true and idconsumo_convenio=$1)
);
   RETURN per;
END
$_$;


ALTER FUNCTION public.traer_periodo_pago_max_nro_cuota(integer) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: afiliacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.afiliacion (
    idafiliacion integer NOT NULL,
    idpersona integer NOT NULL,
    idtipo_socio integer NOT NULL,
    idestado integer,
    fecha_solicitud date,
    fecha_alta date,
    fecha_baja date,
    activa boolean DEFAULT false NOT NULL,
    solicitada boolean DEFAULT false,
    solicita_cancelacion boolean DEFAULT false,
    fecha_solicitud_cancelacion date,
    motivo_cancelacion text
);


ALTER TABLE public.afiliacion OWNER TO postgres;

--
-- Name: afiliacion_idafiliacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.afiliacion_idafiliacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.afiliacion_idafiliacion_seq OWNER TO postgres;

--
-- Name: afiliacion_idafiliacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.afiliacion_idafiliacion_seq OWNED BY public.afiliacion.idafiliacion;


--
-- Name: bolsita_escolar; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bolsita_escolar (
    idpersona integer NOT NULL,
    idpersona_familia integer NOT NULL,
    idparentesco integer NOT NULL,
    idnivel_estudio integer NOT NULL,
    anio character varying NOT NULL,
    idestado integer NOT NULL
);


ALTER TABLE public.bolsita_escolar OWNER TO postgres;

--
-- Name: cabecera_cuota_societaria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cabecera_cuota_societaria (
    idcabecera_cuota_societaria integer NOT NULL,
    archivo bytea NOT NULL,
    periodo character(7),
    fecha_importacion date,
    idconcepto_liquidacion integer
);


ALTER TABLE public.cabecera_cuota_societaria OWNER TO postgres;

--
-- Name: cabecera_cuota_societaria_idcabecera_cuota_societaria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cabecera_cuota_societaria_idcabecera_cuota_societaria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cabecera_cuota_societaria_idcabecera_cuota_societaria_seq OWNER TO postgres;

--
-- Name: cabecera_cuota_societaria_idcabecera_cuota_societaria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cabecera_cuota_societaria_idcabecera_cuota_societaria_seq OWNED BY public.cabecera_cuota_societaria.idcabecera_cuota_societaria;


--
-- Name: cabecera_liquidacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cabecera_liquidacion (
    idcabecera_liquidacion integer NOT NULL,
    idconcepto_liquidacion integer NOT NULL,
    periodo character(7) NOT NULL,
    fecha_liquidacion date NOT NULL,
    usuario character(50) NOT NULL,
    liquidado boolean DEFAULT false,
    exportado boolean DEFAULT false,
    conciliado boolean DEFAULT false,
    archivo bytea,
    archivo_unam bytea
);


ALTER TABLE public.cabecera_liquidacion OWNER TO postgres;

--
-- Name: cabecera_liquidacion_idcabecera_liquidacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cabecera_liquidacion_idcabecera_liquidacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cabecera_liquidacion_idcabecera_liquidacion_seq OWNER TO postgres;

--
-- Name: cabecera_liquidacion_idcabecera_liquidacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cabecera_liquidacion_idcabecera_liquidacion_seq OWNED BY public.cabecera_liquidacion.idcabecera_liquidacion;


--
-- Name: categoria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria (
    idcategoria integer NOT NULL,
    descripcion character varying(100) NOT NULL,
    monto_permitido double precision NOT NULL
);


ALTER TABLE public.categoria OWNER TO postgres;

--
-- Name: categoria_comercio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria_comercio (
    idcategoria_comercio integer NOT NULL,
    descripcion character(50) NOT NULL
);


ALTER TABLE public.categoria_comercio OWNER TO postgres;

--
-- Name: categoria_comercio_idcategoria_comercio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_comercio_idcategoria_comercio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_comercio_idcategoria_comercio_seq OWNER TO postgres;

--
-- Name: categoria_comercio_idcategoria_comercio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_comercio_idcategoria_comercio_seq OWNED BY public.categoria_comercio.idcategoria_comercio;


--
-- Name: categoria_estado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria_estado (
    idcategoria_estado integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.categoria_estado OWNER TO postgres;

--
-- Name: categoria_estado_idcategoria_estado_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_estado_idcategoria_estado_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_estado_idcategoria_estado_seq OWNER TO postgres;

--
-- Name: categoria_estado_idcategoria_estado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_estado_idcategoria_estado_seq OWNED BY public.categoria_estado.idcategoria_estado;


--
-- Name: categoria_idcategoria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_idcategoria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_idcategoria_seq OWNER TO postgres;

--
-- Name: categoria_idcategoria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_idcategoria_seq OWNED BY public.categoria.idcategoria;


--
-- Name: categoria_motivo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categoria_motivo (
    idcategoria_motivo integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.categoria_motivo OWNER TO postgres;

--
-- Name: categoria_motivo_idcategoria_motivo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categoria_motivo_idcategoria_motivo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.categoria_motivo_idcategoria_motivo_seq OWNER TO postgres;

--
-- Name: categoria_motivo_idcategoria_motivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categoria_motivo_idcategoria_motivo_seq OWNED BY public.categoria_motivo.idcategoria_motivo;


--
-- Name: claustro; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.claustro (
    idclaustro integer NOT NULL,
    descripcion character(50) NOT NULL
);


ALTER TABLE public.claustro OWNER TO postgres;

--
-- Name: claustro_idclaustro_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.claustro_idclaustro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.claustro_idclaustro_seq OWNER TO postgres;

--
-- Name: claustro_idclaustro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.claustro_idclaustro_seq OWNED BY public.claustro.idclaustro;


--
-- Name: comercio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.comercio (
    idcomercio integer NOT NULL,
    nombre character varying(100) NOT NULL,
    direccion character varying(100) NOT NULL,
    idlocalidad integer NOT NULL,
    idcategoria_comercio integer NOT NULL,
    codigo character(20),
    tipo character(2),
    nro_telefono character(10),
    cuit character(11),
    cbu character(25)
);


ALTER TABLE public.comercio OWNER TO postgres;

--
-- Name: comercio_idcomercio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.comercio_idcomercio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.comercio_idcomercio_seq OWNER TO postgres;

--
-- Name: comercio_idcomercio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.comercio_idcomercio_seq OWNED BY public.comercio.idcomercio;


--
-- Name: comercios_por_convenio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.comercios_por_convenio (
    idconvenio integer NOT NULL,
    idcomercio integer NOT NULL,
    fecha_inicio date NOT NULL,
    fecha_fin date,
    activo boolean DEFAULT false,
    porcentaje_interes double precision,
    porcentaje_descuento double precision
);


ALTER TABLE public.comercios_por_convenio OWNER TO postgres;

--
-- Name: concepto; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.concepto (
    idconcepto integer NOT NULL,
    descripcion character(100) NOT NULL,
    senia boolean DEFAULT false,
    pago_infraestructura boolean DEFAULT false,
    proveedor boolean DEFAULT false,
    reserva boolean DEFAULT false
);


ALTER TABLE public.concepto OWNER TO postgres;

--
-- Name: concepto_idconcepto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.concepto_idconcepto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.concepto_idconcepto_seq OWNER TO postgres;

--
-- Name: concepto_idconcepto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.concepto_idconcepto_seq OWNED BY public.concepto.idconcepto;


--
-- Name: concepto_liquidacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.concepto_liquidacion (
    idconcepto_liquidacion integer NOT NULL,
    descripcion character(100) NOT NULL,
    codigo character(4),
    liquidable boolean DEFAULT false
);


ALTER TABLE public.concepto_liquidacion OWNER TO postgres;

--
-- Name: concepto_liquidacion_idconcepto_liquidacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.concepto_liquidacion_idconcepto_liquidacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.concepto_liquidacion_idconcepto_liquidacion_seq OWNER TO postgres;

--
-- Name: concepto_liquidacion_idconcepto_liquidacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.concepto_liquidacion_idconcepto_liquidacion_seq OWNED BY public.concepto_liquidacion.idconcepto_liquidacion;


--
-- Name: configuracion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.configuracion (
    edad_maxima_bolsita_escolar integer NOT NULL,
    dias_confirmacion_reserva integer NOT NULL,
    limite_dias_para_reserva integer,
    porcentaje_confirmacion_reserva integer,
    minimo_meses_afiliacion integer NOT NULL,
    idconfiguracion integer NOT NULL,
    limite_por_socio double precision,
    fecha_limite_pedido_convenio integer
);


ALTER TABLE public.configuracion OWNER TO postgres;

--
-- Name: configuracion_bolsita; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.configuracion_bolsita (
    idconfiguracion_bolsita integer NOT NULL,
    anio integer NOT NULL,
    inicio date NOT NULL,
    fin date NOT NULL
);


ALTER TABLE public.configuracion_bolsita OWNER TO postgres;

--
-- Name: configuracion_bolsita_idconfiguracion_bolsita_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.configuracion_bolsita_idconfiguracion_bolsita_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.configuracion_bolsita_idconfiguracion_bolsita_seq OWNER TO postgres;

--
-- Name: configuracion_bolsita_idconfiguracion_bolsita_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.configuracion_bolsita_idconfiguracion_bolsita_seq OWNED BY public.configuracion_bolsita.idconfiguracion_bolsita;


--
-- Name: configuracion_colonia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.configuracion_colonia (
    idconfiguracion_colonia integer NOT NULL,
    anio integer NOT NULL,
    inicio date NOT NULL,
    fin date NOT NULL,
    inicio_inscripcion date NOT NULL,
    fin_inscripcion date NOT NULL,
    cupo integer,
    hora_concentracion time without time zone,
    hora_salida time without time zone,
    hora_llegada time without time zone,
    hora_finalizacion time without time zone,
    direccion character(100)
);


ALTER TABLE public.configuracion_colonia OWNER TO postgres;

--
-- Name: configuracion_colonia_idconfiguracion_colonia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.configuracion_colonia_idconfiguracion_colonia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.configuracion_colonia_idconfiguracion_colonia_seq OWNER TO postgres;

--
-- Name: configuracion_colonia_idconfiguracion_colonia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.configuracion_colonia_idconfiguracion_colonia_seq OWNED BY public.configuracion_colonia.idconfiguracion_colonia;


--
-- Name: configuracion_idconfiguracion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.configuracion_idconfiguracion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.configuracion_idconfiguracion_seq OWNER TO postgres;

--
-- Name: configuracion_idconfiguracion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.configuracion_idconfiguracion_seq OWNED BY public.configuracion.idconfiguracion;


--
-- Name: consumo_convenio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.consumo_convenio (
    idconsumo_convenio integer NOT NULL,
    idafiliacion integer NOT NULL,
    idconvenio integer,
    idcomercio integer,
    total double precision,
    fecha date,
    monto_proforma double precision,
    cantidad_cuotas integer,
    descripcion character(100),
    idtalonario_bono integer,
    cantidad_bonos integer,
    monto_bono double precision,
    periodo character(7),
    pagado boolean
);


ALTER TABLE public.consumo_convenio OWNER TO postgres;

--
-- Name: consumo_convenio_cuotas; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.consumo_convenio_cuotas (
    idconsumo_convenio_cuotas integer NOT NULL,
    idconsumo_convenio integer NOT NULL,
    nro_cuota integer NOT NULL,
    periodo character(7) NOT NULL,
    envio_descuento boolean DEFAULT false,
    monto double precision,
    idforma_pago integer,
    interes double precision,
    monto_puro double precision,
    cuota_pagada boolean DEFAULT false,
    fecha_pago date
);


ALTER TABLE public.consumo_convenio_cuotas OWNER TO postgres;

--
-- Name: consumo_convenio_cuotas_idconsumo_convenio_cuotas_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.consumo_convenio_cuotas_idconsumo_convenio_cuotas_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.consumo_convenio_cuotas_idconsumo_convenio_cuotas_seq OWNER TO postgres;

--
-- Name: consumo_convenio_cuotas_idconsumo_convenio_cuotas_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.consumo_convenio_cuotas_idconsumo_convenio_cuotas_seq OWNED BY public.consumo_convenio_cuotas.idconsumo_convenio_cuotas;


--
-- Name: consumo_convenio_idconsumo_convenio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.consumo_convenio_idconsumo_convenio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.consumo_convenio_idconsumo_convenio_seq OWNER TO postgres;

--
-- Name: consumo_convenio_idconsumo_convenio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.consumo_convenio_idconsumo_convenio_seq OWNED BY public.consumo_convenio.idconsumo_convenio;


--
-- Name: convenio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.convenio (
    idconvenio integer NOT NULL,
    idcategoria_comercio integer NOT NULL,
    titulo character(100),
    fecha_inicio date NOT NULL,
    fecha_fin date,
    maximo_cuotas integer,
    monto_maximo_mensual double precision,
    permite_financiacion boolean DEFAULT false,
    activo boolean DEFAULT false,
    maneja_bono boolean DEFAULT false,
    consumo_ticket boolean DEFAULT false,
    permite_renovacion boolean DEFAULT false,
    ayuda_economica boolean DEFAULT false,
    faltando_cuotas integer
);


ALTER TABLE public.convenio OWNER TO postgres;

--
-- Name: convenio_idconvenio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.convenio_idconvenio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.convenio_idconvenio_seq OWNER TO postgres;

--
-- Name: convenio_idconvenio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.convenio_idconvenio_seq OWNED BY public.convenio.idconvenio;


--
-- Name: costo_colonia_tipo_socio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.costo_colonia_tipo_socio (
    idcosto_colonia_tipo_socio integer NOT NULL,
    idconfiguracion_colonia integer NOT NULL,
    idtipo_socio integer NOT NULL,
    monto double precision NOT NULL,
    porcentaje_inscripcion double precision NOT NULL
);


ALTER TABLE public.costo_colonia_tipo_socio OWNER TO postgres;

--
-- Name: costo_colonia_tipo_socio_idcosto_colonia_tipo_socio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.costo_colonia_tipo_socio_idcosto_colonia_tipo_socio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.costo_colonia_tipo_socio_idcosto_colonia_tipo_socio_seq OWNER TO postgres;

--
-- Name: costo_colonia_tipo_socio_idcosto_colonia_tipo_socio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.costo_colonia_tipo_socio_idcosto_colonia_tipo_socio_seq OWNED BY public.costo_colonia_tipo_socio.idcosto_colonia_tipo_socio;


--
-- Name: costo_pileta_tipo_socio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.costo_pileta_tipo_socio (
    idcosto_pileta_tipo_socio integer NOT NULL,
    idtemporada_pileta integer NOT NULL,
    idtipo_socio integer NOT NULL,
    costo_grupo_familiar double precision NOT NULL,
    costo_cetificado_medico double precision NOT NULL,
    adicional_mayores_edad double precision DEFAULT 0
);


ALTER TABLE public.costo_pileta_tipo_socio OWNER TO postgres;

--
-- Name: costo_pileta_tipo_socio_idcosto_pileta_tipo_socio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.costo_pileta_tipo_socio_idcosto_pileta_tipo_socio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.costo_pileta_tipo_socio_idcosto_pileta_tipo_socio_seq OWNER TO postgres;

--
-- Name: costo_pileta_tipo_socio_idcosto_pileta_tipo_socio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.costo_pileta_tipo_socio_idcosto_pileta_tipo_socio_seq OWNED BY public.costo_pileta_tipo_socio.idcosto_pileta_tipo_socio;


--
-- Name: cuota_societaria; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cuota_societaria (
    idcuota_societaria integer NOT NULL,
    idpersona integer NOT NULL,
    idafiliacion integer NOT NULL,
    cargo character(6) NOT NULL,
    idconcepto_liquidacion integer NOT NULL,
    monto double precision NOT NULL,
    idcabecera_cuota_societaria integer
);


ALTER TABLE public.cuota_societaria OWNER TO postgres;

--
-- Name: cuota_societaria_idcuota_societaria_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.cuota_societaria_idcuota_societaria_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cuota_societaria_idcuota_societaria_seq OWNER TO postgres;

--
-- Name: cuota_societaria_idcuota_societaria_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.cuota_societaria_idcuota_societaria_seq OWNED BY public.cuota_societaria.idcuota_societaria;


--
-- Name: detalle_consumo_ticket; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_consumo_ticket (
    iddetalle_consumo_ticket integer NOT NULL,
    idconsumo_convenio integer NOT NULL,
    nro_ticket character(20),
    monto double precision NOT NULL,
    fecha date NOT NULL
);


ALTER TABLE public.detalle_consumo_ticket OWNER TO postgres;

--
-- Name: detalle_consumo_ticket_iddetalle_consumo_ticket_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_consumo_ticket_iddetalle_consumo_ticket_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_consumo_ticket_iddetalle_consumo_ticket_seq OWNER TO postgres;

--
-- Name: detalle_consumo_ticket_iddetalle_consumo_ticket_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_consumo_ticket_iddetalle_consumo_ticket_seq OWNED BY public.detalle_consumo_ticket.iddetalle_consumo_ticket;


--
-- Name: detalle_inscripcion_pileta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_inscripcion_pileta (
    iddetalle_inscripcion_pileta integer NOT NULL,
    idinscripcion_pileta integer NOT NULL,
    idpersona_familia integer NOT NULL,
    observacion character(150),
    costo_extra double precision DEFAULT 0
);


ALTER TABLE public.detalle_inscripcion_pileta OWNER TO postgres;

--
-- Name: detalle_inscripcion_pileta_iddetalle_inscripcion_pileta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_inscripcion_pileta_iddetalle_inscripcion_pileta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_inscripcion_pileta_iddetalle_inscripcion_pileta_seq OWNER TO postgres;

--
-- Name: detalle_inscripcion_pileta_iddetalle_inscripcion_pileta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_inscripcion_pileta_iddetalle_inscripcion_pileta_seq OWNED BY public.detalle_inscripcion_pileta.iddetalle_inscripcion_pileta;


--
-- Name: detalle_liquidacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_liquidacion (
    iddetalle_liquidacion integer NOT NULL,
    idcabecera_liquidacion integer NOT NULL,
    idafiliacion integer NOT NULL,
    monto double precision NOT NULL,
    saldo double precision DEFAULT 0 NOT NULL,
    concepto character(50)
);


ALTER TABLE public.detalle_liquidacion OWNER TO postgres;

--
-- Name: detalle_liquidacion_iddetalle_liquidacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_liquidacion_iddetalle_liquidacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_liquidacion_iddetalle_liquidacion_seq OWNER TO postgres;

--
-- Name: detalle_liquidacion_iddetalle_liquidacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_liquidacion_iddetalle_liquidacion_seq OWNED BY public.detalle_liquidacion.iddetalle_liquidacion;


--
-- Name: movimientos_monto_reserva; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.movimientos_monto_reserva (
    iddetalle_modificacion_monto integer NOT NULL,
    idconcepto integer NOT NULL,
    idsolicitud_reserva integer NOT NULL,
    monto double precision NOT NULL,
    descripcion character(50),
    tipo_movimiento character(3)
);


ALTER TABLE public.movimientos_monto_reserva OWNER TO postgres;

--
-- Name: COLUMN movimientos_monto_reserva.tipo_movimiento; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON COLUMN public.movimientos_monto_reserva.tipo_movimiento IS 'descuento
aumento';


--
-- Name: detalle_modificacion_monto_iddetalle_modificacion_monto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_modificacion_monto_iddetalle_modificacion_monto_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_modificacion_monto_iddetalle_modificacion_monto_seq OWNER TO postgres;

--
-- Name: detalle_modificacion_monto_iddetalle_modificacion_monto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_modificacion_monto_iddetalle_modificacion_monto_seq OWNED BY public.movimientos_monto_reserva.iddetalle_modificacion_monto;


--
-- Name: detalle_pago; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_pago (
    iddetalle_pago integer NOT NULL,
    monto double precision,
    idsolicitud_reserva integer,
    idforma_pago integer,
    idconcepto integer,
    descripcion character(50),
    fecha date,
    envio_descuento boolean DEFAULT false
);


ALTER TABLE public.detalle_pago OWNER TO postgres;

--
-- Name: detalle_pago_consumo_convenio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_pago_consumo_convenio (
    iddetalle_pago_consumo_convenio integer NOT NULL,
    monto double precision,
    idconsumo_convenio integer,
    idforma_pago integer,
    idconcepto integer,
    descripcion character(50),
    fecha date,
    envio_descuento boolean DEFAULT false
);


ALTER TABLE public.detalle_pago_consumo_convenio OWNER TO postgres;

--
-- Name: detalle_pago_consumo_convenio_iddetalle_pago_consumo_conven_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_pago_consumo_convenio_iddetalle_pago_consumo_conven_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_pago_consumo_convenio_iddetalle_pago_consumo_conven_seq OWNER TO postgres;

--
-- Name: detalle_pago_consumo_convenio_iddetalle_pago_consumo_conven_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_pago_consumo_convenio_iddetalle_pago_consumo_conven_seq OWNED BY public.detalle_pago_consumo_convenio.iddetalle_pago_consumo_convenio;


--
-- Name: detalle_pago_gasto_infraestructura; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_pago_gasto_infraestructura (
    iddetalle_pago_gasto_infraestructura integer NOT NULL,
    idgasto_infraestructura integer,
    idforma_pago integer NOT NULL,
    monto double precision NOT NULL,
    nro_cheque_transaccion character(50),
    fecha_pago date
);


ALTER TABLE public.detalle_pago_gasto_infraestructura OWNER TO postgres;

--
-- Name: detalle_pago_gasto_infraestru_iddetalle_pago_gasto_infraest_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_pago_gasto_infraestru_iddetalle_pago_gasto_infraest_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_pago_gasto_infraestru_iddetalle_pago_gasto_infraest_seq OWNER TO postgres;

--
-- Name: detalle_pago_gasto_infraestru_iddetalle_pago_gasto_infraest_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_pago_gasto_infraestru_iddetalle_pago_gasto_infraest_seq OWNED BY public.detalle_pago_gasto_infraestructura.iddetalle_pago_gasto_infraestructura;


--
-- Name: detalle_pago_iddetalle_pago_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_pago_iddetalle_pago_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_pago_iddetalle_pago_seq OWNER TO postgres;

--
-- Name: detalle_pago_iddetalle_pago_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_pago_iddetalle_pago_seq OWNED BY public.detalle_pago.iddetalle_pago;


--
-- Name: detalle_pago_inscripcion_pileta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.detalle_pago_inscripcion_pileta (
    iddetalle_pago_inscripcion_pileta integer NOT NULL,
    monto double precision,
    idinscripcion_pileta integer NOT NULL,
    idforma_pago integer,
    idconcepto integer,
    descripcion character(50),
    fecha date,
    envio_descuento boolean DEFAULT false
);


ALTER TABLE public.detalle_pago_inscripcion_pileta OWNER TO postgres;

--
-- Name: detalle_pago_inscripcion_pile_iddetalle_pago_inscripcion_pi_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.detalle_pago_inscripcion_pile_iddetalle_pago_inscripcion_pi_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.detalle_pago_inscripcion_pile_iddetalle_pago_inscripcion_pi_seq OWNER TO postgres;

--
-- Name: detalle_pago_inscripcion_pile_iddetalle_pago_inscripcion_pi_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.detalle_pago_inscripcion_pile_iddetalle_pago_inscripcion_pi_seq OWNED BY public.detalle_pago_inscripcion_pileta.iddetalle_pago_inscripcion_pileta;


--
-- Name: encabezado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.encabezado (
    idencabezado integer NOT NULL,
    nombre_institucion character(100) NOT NULL,
    direccion character(100) NOT NULL,
    telefono character(12) NOT NULL,
    logo bytea NOT NULL
);


ALTER TABLE public.encabezado OWNER TO postgres;

--
-- Name: encabezado_idencabezado_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.encabezado_idencabezado_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.encabezado_idencabezado_seq OWNER TO postgres;

--
-- Name: encabezado_idencabezado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.encabezado_idencabezado_seq OWNED BY public.encabezado.idencabezado;


--
-- Name: estado; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estado (
    idestado integer NOT NULL,
    descripcion character varying(50) NOT NULL,
    idcategoria_estado integer NOT NULL,
    confirmada boolean DEFAULT false,
    cancelada boolean DEFAULT false
);


ALTER TABLE public.estado OWNER TO postgres;

--
-- Name: estado_civil; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.estado_civil (
    idestado_civil integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.estado_civil OWNER TO postgres;

--
-- Name: estado_civil_idestado_civil_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estado_civil_idestado_civil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estado_civil_idestado_civil_seq OWNER TO postgres;

--
-- Name: estado_civil_idestado_civil_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estado_civil_idestado_civil_seq OWNED BY public.estado_civil.idestado_civil;


--
-- Name: estado_idestado_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.estado_idestado_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.estado_idestado_seq OWNER TO postgres;

--
-- Name: estado_idestado_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.estado_idestado_seq OWNED BY public.estado.idestado;


--
-- Name: familia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.familia (
    idpersona integer NOT NULL,
    idpersona_familia integer NOT NULL,
    idparentesco integer NOT NULL,
    fecha_relacion date NOT NULL,
    acargo boolean DEFAULT false,
    archivo bytea,
    fecha_carga date DEFAULT ('now'::text)::date,
    baja boolean DEFAULT false,
    fecha_baja date
);


ALTER TABLE public.familia OWNER TO postgres;

--
-- Name: forma_pago; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.forma_pago (
    idforma_pago integer NOT NULL,
    descripcion character(50),
    planilla boolean DEFAULT false,
    efectivo boolean DEFAULT false,
    requiere_nro_comprobante boolean DEFAULT false
);


ALTER TABLE public.forma_pago OWNER TO postgres;

--
-- Name: forma_pago_idforma_pago_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.forma_pago_idforma_pago_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.forma_pago_idforma_pago_seq OWNER TO postgres;

--
-- Name: forma_pago_idforma_pago_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.forma_pago_idforma_pago_seq OWNED BY public.forma_pago.idforma_pago;


--
-- Name: gasto_infraestructura; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.gasto_infraestructura (
    idgasto_infraestructura integer NOT NULL,
    idconcepto integer NOT NULL,
    idcomercio integer,
    fecha_pago date,
    monto double precision NOT NULL,
    periodo character(7)
);


ALTER TABLE public.gasto_infraestructura OWNER TO postgres;

--
-- Name: gasto_infraestructura_idgasto_infraestructura_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.gasto_infraestructura_idgasto_infraestructura_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gasto_infraestructura_idgasto_infraestructura_seq OWNER TO postgres;

--
-- Name: gasto_infraestructura_idgasto_infraestructura_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.gasto_infraestructura_idgasto_infraestructura_seq OWNED BY public.gasto_infraestructura.idgasto_infraestructura;


--
-- Name: inscripcion_colono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.inscripcion_colono (
    idinscripcion_colono integer NOT NULL,
    idconfiguracion_colonia integer NOT NULL,
    idpersona_familia integer NOT NULL,
    es_alergico boolean DEFAULT false NOT NULL,
    alergias text,
    informacion_complementaria text,
    idafiliacion integer NOT NULL,
    fecha date,
    medicamentos_toma text,
    cantidad_cuotas integer DEFAULT 0,
    monto double precision,
    porcentaje_inscripcion integer,
    monto_inscripcion double precision,
    baja boolean DEFAULT false
);


ALTER TABLE public.inscripcion_colono OWNER TO postgres;

--
-- Name: inscripcion_colono_idinscripcion_colono_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.inscripcion_colono_idinscripcion_colono_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.inscripcion_colono_idinscripcion_colono_seq OWNER TO postgres;

--
-- Name: inscripcion_colono_idinscripcion_colono_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.inscripcion_colono_idinscripcion_colono_seq OWNED BY public.inscripcion_colono.idinscripcion_colono;


--
-- Name: inscripcion_colono_plan_pago; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.inscripcion_colono_plan_pago (
    idinscripcion_colono_plan_pago integer NOT NULL,
    idinscripcion_colono integer NOT NULL,
    nro_cuota integer NOT NULL,
    periodo character(7) NOT NULL,
    envio_descuento boolean DEFAULT false,
    monto double precision,
    idforma_pago integer,
    cuota_pagada boolean DEFAULT false,
    fecha_pago date,
    fecha_generacion_plan date,
    inscripcion boolean DEFAULT false
);


ALTER TABLE public.inscripcion_colono_plan_pago OWNER TO postgres;

--
-- Name: inscripcion_colono_plan_pago_idinscripcion_colono_plan_pago_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.inscripcion_colono_plan_pago_idinscripcion_colono_plan_pago_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.inscripcion_colono_plan_pago_idinscripcion_colono_plan_pago_seq OWNER TO postgres;

--
-- Name: inscripcion_colono_plan_pago_idinscripcion_colono_plan_pago_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.inscripcion_colono_plan_pago_idinscripcion_colono_plan_pago_seq OWNED BY public.inscripcion_colono_plan_pago.idinscripcion_colono_plan_pago;


--
-- Name: inscripcion_pileta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.inscripcion_pileta (
    idinscripcion_pileta integer NOT NULL,
    idtemporada_pileta integer NOT NULL,
    idafiliacion integer NOT NULL,
    costo_grupo_familiar double precision NOT NULL,
    adicional_mayores_edad double precision DEFAULT 0,
    total double precision DEFAULT 0,
    costo_por_mayor double precision DEFAULT 0
);


ALTER TABLE public.inscripcion_pileta OWNER TO postgres;

--
-- Name: inscripcion_pileta_idinscripcion_pileta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.inscripcion_pileta_idinscripcion_pileta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.inscripcion_pileta_idinscripcion_pileta_seq OWNER TO postgres;

--
-- Name: inscripcion_pileta_idinscripcion_pileta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.inscripcion_pileta_idinscripcion_pileta_seq OWNED BY public.inscripcion_pileta.idinscripcion_pileta;


--
-- Name: instalacion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.instalacion (
    idinstalacion integer NOT NULL,
    nombre character varying(50) NOT NULL,
    cantidad_maxima_personas integer NOT NULL,
    domicilio character(100),
    cantidad_personas_reserva integer
);


ALTER TABLE public.instalacion OWNER TO postgres;

--
-- Name: instalacion_idinstalacion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.instalacion_idinstalacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.instalacion_idinstalacion_seq OWNER TO postgres;

--
-- Name: instalacion_idinstalacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.instalacion_idinstalacion_seq OWNED BY public.instalacion.idinstalacion;


--
-- Name: localidad; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.localidad (
    idlocalidad integer NOT NULL,
    idprovincia integer NOT NULL,
    descripcion character varying(100) NOT NULL
);


ALTER TABLE public.localidad OWNER TO postgres;

--
-- Name: localidad_idlocalidad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.localidad_idlocalidad_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.localidad_idlocalidad_seq OWNER TO postgres;

--
-- Name: localidad_idlocalidad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.localidad_idlocalidad_seq OWNED BY public.localidad.idlocalidad;


--
-- Name: motivo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motivo (
    idmotivo integer NOT NULL,
    idcategoria_motivo integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.motivo OWNER TO postgres;

--
-- Name: motivo_idmotivo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motivo_idmotivo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.motivo_idmotivo_seq OWNER TO postgres;

--
-- Name: motivo_idmotivo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.motivo_idmotivo_seq OWNED BY public.motivo.idmotivo;


--
-- Name: motivo_tipo_socio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.motivo_tipo_socio (
    idmotivo_tipo_socio integer NOT NULL,
    idtipo_socio integer NOT NULL,
    idmotivo integer NOT NULL,
    monto_reserva double precision NOT NULL,
    monto_limpieza_mantenimiento double precision NOT NULL,
    monto_garantia double precision,
    idinstalacion integer,
    monto_persona_extra double precision,
    porcentaje_senia integer
);


ALTER TABLE public.motivo_tipo_socio OWNER TO postgres;

--
-- Name: motivo_tipo_socio_idmotivo_tipo_socio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.motivo_tipo_socio_idmotivo_tipo_socio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.motivo_tipo_socio_idmotivo_tipo_socio_seq OWNER TO postgres;

--
-- Name: motivo_tipo_socio_idmotivo_tipo_socio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.motivo_tipo_socio_idmotivo_tipo_socio_seq OWNED BY public.motivo_tipo_socio.idmotivo_tipo_socio;


--
-- Name: nivel; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.nivel (
    idnivel integer NOT NULL,
    descripcion character(50) NOT NULL,
    edad_minima integer NOT NULL,
    edad_maxima integer,
    es_bolsita boolean DEFAULT false
);


ALTER TABLE public.nivel OWNER TO postgres;

--
-- Name: nivel_estudio_idnivel_estudio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nivel_estudio_idnivel_estudio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.nivel_estudio_idnivel_estudio_seq OWNER TO postgres;

--
-- Name: nivel_idnivel_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.nivel_idnivel_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.nivel_idnivel_seq OWNER TO postgres;

--
-- Name: nivel_idnivel_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.nivel_idnivel_seq OWNED BY public.nivel.idnivel;


--
-- Name: pais; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pais (
    idpais integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.pais OWNER TO postgres;

--
-- Name: pais_idpais_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pais_idpais_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pais_idpais_seq OWNER TO postgres;

--
-- Name: pais_idpais_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pais_idpais_seq OWNED BY public.pais.idpais;


--
-- Name: parentesco; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.parentesco (
    idparentesco integer NOT NULL,
    descripcion character varying(50) NOT NULL,
    bolsita_escolar boolean DEFAULT false NOT NULL,
    colonia boolean DEFAULT false
);


ALTER TABLE public.parentesco OWNER TO postgres;

--
-- Name: parentesco_idparentesco_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.parentesco_idparentesco_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parentesco_idparentesco_seq OWNER TO postgres;

--
-- Name: parentesco_idparentesco_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.parentesco_idparentesco_seq OWNED BY public.parentesco.idparentesco;


--
-- Name: persona_idpersona_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.persona_idpersona_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.persona_idpersona_seq OWNER TO postgres;

--
-- Name: persona; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.persona (
    idpersona integer DEFAULT nextval('public.persona_idpersona_seq'::regclass) NOT NULL,
    idtipo_documento integer NOT NULL,
    nro_documento character varying(9) NOT NULL,
    cuil character varying(11),
    legajo character varying(6),
    apellido character varying(50) NOT NULL,
    nombres character varying(100) NOT NULL,
    correo character varying(100),
    cbu character varying(22),
    fecha_nacimiento date,
    idlocalidad integer,
    calle character varying(50),
    altura character varying(6),
    piso character varying(2),
    depto character varying(2),
    idestado_civil integer,
    sexo character(1),
    foto bytea,
    idclaustro integer,
    idunidad_academica integer
);


ALTER TABLE public.persona OWNER TO postgres;

--
-- Name: premio_sorteo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.premio_sorteo (
    idpremio_sorteo integer NOT NULL,
    idtalonario_bono_colaboracion integer NOT NULL,
    nro_premio integer,
    descripcion character(100) NOT NULL,
    valor double precision,
    nro_bono_ganador integer
);


ALTER TABLE public.premio_sorteo OWNER TO postgres;

--
-- Name: premio_sorteo_idpremio_sorteo_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.premio_sorteo_idpremio_sorteo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.premio_sorteo_idpremio_sorteo_seq OWNER TO postgres;

--
-- Name: premio_sorteo_idpremio_sorteo_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.premio_sorteo_idpremio_sorteo_seq OWNED BY public.premio_sorteo.idpremio_sorteo;


--
-- Name: provincia_idprovincia_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.provincia_idprovincia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.provincia_idprovincia_seq OWNER TO postgres;

--
-- Name: provincia; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.provincia (
    idprovincia integer DEFAULT nextval('public.provincia_idprovincia_seq'::regclass) NOT NULL,
    descripcion character varying(50) NOT NULL,
    idpais integer NOT NULL
);


ALTER TABLE public.provincia OWNER TO postgres;

--
-- Name: reempadronamiento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.reempadronamiento (
    idreempadronamiento integer NOT NULL,
    nombre character(50) NOT NULL,
    anio integer,
    activo boolean DEFAULT false
);


ALTER TABLE public.reempadronamiento OWNER TO postgres;

--
-- Name: reempadronamiento_idreempadronamiento_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.reempadronamiento_idreempadronamiento_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reempadronamiento_idreempadronamiento_seq OWNER TO postgres;

--
-- Name: reempadronamiento_idreempadronamiento_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.reempadronamiento_idreempadronamiento_seq OWNED BY public.reempadronamiento.idreempadronamiento;


--
-- Name: solicitud_bolsita; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.solicitud_bolsita (
    idsolicitud_bolsita integer NOT NULL,
    idpersona_familia integer NOT NULL,
    fecha_solicitud date NOT NULL,
    idnivel integer NOT NULL,
    observacion text,
    fecha_entrega date,
    entregado boolean,
    idconfiguracion_bolsita integer NOT NULL,
    fecha_rechazo date
);


ALTER TABLE public.solicitud_bolsita OWNER TO postgres;

--
-- Name: solicitud_bolsita_idsolicitud_bolsita_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.solicitud_bolsita_idsolicitud_bolsita_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.solicitud_bolsita_idsolicitud_bolsita_seq OWNER TO postgres;

--
-- Name: solicitud_bolsita_idsolicitud_bolsita_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.solicitud_bolsita_idsolicitud_bolsita_seq OWNED BY public.solicitud_bolsita.idsolicitud_bolsita;


--
-- Name: solicitud_reempadronamiento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.solicitud_reempadronamiento (
    idreempadronamiento integer NOT NULL,
    idafiliacion integer NOT NULL,
    notificaciones integer DEFAULT 0,
    fecha_notificacion date,
    atendida boolean DEFAULT false
);


ALTER TABLE public.solicitud_reempadronamiento OWNER TO postgres;

--
-- Name: solicitud_reserva; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.solicitud_reserva (
    idsolicitud_reserva integer NOT NULL,
    fecha date NOT NULL,
    idinstalacion integer NOT NULL,
    idestado integer NOT NULL,
    nro_personas integer,
    idafiliacion integer NOT NULL,
    idmotivo_tipo_socio integer,
    monto double precision,
    idmotivo integer,
    observacion text,
    motivo_cancelacion text,
    fecha_cancelacion date,
    monto_final double precision
);


ALTER TABLE public.solicitud_reserva OWNER TO postgres;

--
-- Name: solicitud_reserva_idsolicitud_reserva_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.solicitud_reserva_idsolicitud_reserva_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.solicitud_reserva_idsolicitud_reserva_seq OWNER TO postgres;

--
-- Name: solicitud_reserva_idsolicitud_reserva_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.solicitud_reserva_idsolicitud_reserva_seq OWNED BY public.solicitud_reserva.idsolicitud_reserva;


--
-- Name: solicitud_subsidio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.solicitud_subsidio (
    idsolicitud_subsidio integer NOT NULL,
    idafiliacion integer NOT NULL,
    idtipo_subsidio integer NOT NULL,
    fecha_solicitud date,
    fecha_pago date,
    monto double precision,
    observacion text,
    pagado boolean
);


ALTER TABLE public.solicitud_subsidio OWNER TO postgres;

--
-- Name: solicitud_subsidio_idsolicitud_subsidio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.solicitud_subsidio_idsolicitud_subsidio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.solicitud_subsidio_idsolicitud_subsidio_seq OWNER TO postgres;

--
-- Name: solicitud_subsidio_idsolicitud_subsidio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.solicitud_subsidio_idsolicitud_subsidio_seq OWNED BY public.solicitud_subsidio.idsolicitud_subsidio;


--
-- Name: talonario_bono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.talonario_bono (
    idtalonario_bono integer NOT NULL,
    idconvenio integer NOT NULL,
    idcomercio integer NOT NULL,
    nro_talonario character(20) NOT NULL,
    nro_inicio integer NOT NULL,
    nro_fin integer NOT NULL,
    monto_bono integer
);


ALTER TABLE public.talonario_bono OWNER TO postgres;

--
-- Name: talonario_bono_colaboracion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.talonario_bono_colaboracion (
    idtalonario_bono_colaboracion integer NOT NULL,
    descripcion character(100) NOT NULL,
    nro_talonario integer,
    nro_inicio integer NOT NULL,
    nro_fin integer NOT NULL,
    fecha_sorteo date NOT NULL,
    monto double precision NOT NULL
);


ALTER TABLE public.talonario_bono_colaboracion OWNER TO postgres;

--
-- Name: talonario_bono_colaboracion_idtalonario_bono_colaboracion_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.talonario_bono_colaboracion_idtalonario_bono_colaboracion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.talonario_bono_colaboracion_idtalonario_bono_colaboracion_seq OWNER TO postgres;

--
-- Name: talonario_bono_colaboracion_idtalonario_bono_colaboracion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.talonario_bono_colaboracion_idtalonario_bono_colaboracion_seq OWNED BY public.talonario_bono_colaboracion.idtalonario_bono_colaboracion;


--
-- Name: talonario_bono_idtalonario_bono_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.talonario_bono_idtalonario_bono_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.talonario_bono_idtalonario_bono_seq OWNER TO postgres;

--
-- Name: talonario_bono_idtalonario_bono_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.talonario_bono_idtalonario_bono_seq OWNED BY public.talonario_bono.idtalonario_bono;


--
-- Name: talonario_nros_bono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.talonario_nros_bono (
    idtalonario_bono integer NOT NULL,
    nro_bono integer NOT NULL,
    disponible boolean DEFAULT true,
    idafiliacion integer,
    idconsumo_convenio integer
);


ALTER TABLE public.talonario_nros_bono OWNER TO postgres;

--
-- Name: talonario_nros_bono_colaboracion; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.talonario_nros_bono_colaboracion (
    idtalonario_bono_colaboracion integer NOT NULL,
    nro_bono integer NOT NULL,
    disponible boolean DEFAULT true,
    idafiliacion integer,
    idpersona_externa integer,
    fecha_compra date,
    idforma_pago integer NOT NULL,
    pagado boolean DEFAULT false,
    persona_externa boolean DEFAULT false
);


ALTER TABLE public.talonario_nros_bono_colaboracion OWNER TO postgres;

--
-- Name: telefono_inscripcion_colono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telefono_inscripcion_colono (
    idtipo_telefono integer NOT NULL,
    idinscripcion_colono integer NOT NULL,
    nro_telefono character(10) NOT NULL,
    idparentesco integer
);


ALTER TABLE public.telefono_inscripcion_colono OWNER TO postgres;

--
-- Name: telefono_por_persona; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.telefono_por_persona (
    idtipo_telefono integer NOT NULL,
    idpersona integer NOT NULL,
    nro_telefono character(10) NOT NULL
);


ALTER TABLE public.telefono_por_persona OWNER TO postgres;

--
-- Name: temporada_pileta; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.temporada_pileta (
    idtemporada_pileta integer NOT NULL,
    descripcion character(100) NOT NULL,
    fecha_inicio date NOT NULL,
    fecha_fin date NOT NULL
);


ALTER TABLE public.temporada_pileta OWNER TO postgres;

--
-- Name: temporada_pileta_idtemporada_pileta_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.temporada_pileta_idtemporada_pileta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.temporada_pileta_idtemporada_pileta_seq OWNER TO postgres;

--
-- Name: temporada_pileta_idtemporada_pileta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.temporada_pileta_idtemporada_pileta_seq OWNED BY public.temporada_pileta.idtemporada_pileta;


--
-- Name: tipo_documento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_documento (
    idtipo_documento integer NOT NULL,
    sigla character varying(10) NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.tipo_documento OWNER TO postgres;

--
-- Name: tipo_documento_idtipo_documento_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_documento_idtipo_documento_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_documento_idtipo_documento_seq OWNER TO postgres;

--
-- Name: tipo_documento_idtipo_documento_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_documento_idtipo_documento_seq OWNED BY public.tipo_documento.idtipo_documento;


--
-- Name: tipo_socio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_socio (
    idtipo_socio integer NOT NULL,
    descripcion character varying(50) NOT NULL,
    titular boolean DEFAULT false,
    liquidacion boolean DEFAULT false,
    externo boolean DEFAULT false
);


ALTER TABLE public.tipo_socio OWNER TO postgres;

--
-- Name: tipo_socio_idtipo_socio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_socio_idtipo_socio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_socio_idtipo_socio_seq OWNER TO postgres;

--
-- Name: tipo_socio_idtipo_socio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_socio_idtipo_socio_seq OWNED BY public.tipo_socio.idtipo_socio;


--
-- Name: tipo_subsidio; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_subsidio (
    idtipo_subsidio integer NOT NULL,
    descripcion character(50) NOT NULL,
    limite integer NOT NULL,
    monto double precision NOT NULL
);


ALTER TABLE public.tipo_subsidio OWNER TO postgres;

--
-- Name: tipo_subsidio_idtipo_subsidio_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_subsidio_idtipo_subsidio_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_subsidio_idtipo_subsidio_seq OWNER TO postgres;

--
-- Name: tipo_subsidio_idtipo_subsidio_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_subsidio_idtipo_subsidio_seq OWNED BY public.tipo_subsidio.idtipo_subsidio;


--
-- Name: tipo_telefono; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tipo_telefono (
    idtipo_telefono integer NOT NULL,
    descripcion character varying(50) NOT NULL
);


ALTER TABLE public.tipo_telefono OWNER TO postgres;

--
-- Name: tipo_telefono_idtipo_telefono_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tipo_telefono_idtipo_telefono_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.tipo_telefono_idtipo_telefono_seq OWNER TO postgres;

--
-- Name: tipo_telefono_idtipo_telefono_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tipo_telefono_idtipo_telefono_seq OWNED BY public.tipo_telefono.idtipo_telefono;


--
-- Name: unidad_academica; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.unidad_academica (
    idunidad_academica integer NOT NULL,
    sigla character(10) NOT NULL,
    descripcion character(100) NOT NULL
);


ALTER TABLE public.unidad_academica OWNER TO postgres;

--
-- Name: unidad_academica_idunidad_academica_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.unidad_academica_idunidad_academica_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.unidad_academica_idunidad_academica_seq OWNER TO postgres;

--
-- Name: unidad_academica_idunidad_academica_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.unidad_academica_idunidad_academica_seq OWNED BY public.unidad_academica.idunidad_academica;


--
-- Name: idafiliacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.afiliacion ALTER COLUMN idafiliacion SET DEFAULT nextval('public.afiliacion_idafiliacion_seq'::regclass);


--
-- Name: idcabecera_cuota_societaria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cabecera_cuota_societaria ALTER COLUMN idcabecera_cuota_societaria SET DEFAULT nextval('public.cabecera_cuota_societaria_idcabecera_cuota_societaria_seq'::regclass);


--
-- Name: idcabecera_liquidacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cabecera_liquidacion ALTER COLUMN idcabecera_liquidacion SET DEFAULT nextval('public.cabecera_liquidacion_idcabecera_liquidacion_seq'::regclass);


--
-- Name: idcategoria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria ALTER COLUMN idcategoria SET DEFAULT nextval('public.categoria_idcategoria_seq'::regclass);


--
-- Name: idcategoria_comercio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_comercio ALTER COLUMN idcategoria_comercio SET DEFAULT nextval('public.categoria_comercio_idcategoria_comercio_seq'::regclass);


--
-- Name: idcategoria_estado; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_estado ALTER COLUMN idcategoria_estado SET DEFAULT nextval('public.categoria_estado_idcategoria_estado_seq'::regclass);


--
-- Name: idcategoria_motivo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_motivo ALTER COLUMN idcategoria_motivo SET DEFAULT nextval('public.categoria_motivo_idcategoria_motivo_seq'::regclass);


--
-- Name: idclaustro; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claustro ALTER COLUMN idclaustro SET DEFAULT nextval('public.claustro_idclaustro_seq'::regclass);


--
-- Name: idcomercio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comercio ALTER COLUMN idcomercio SET DEFAULT nextval('public.comercio_idcomercio_seq'::regclass);


--
-- Name: idconcepto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.concepto ALTER COLUMN idconcepto SET DEFAULT nextval('public.concepto_idconcepto_seq'::regclass);


--
-- Name: idconcepto_liquidacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.concepto_liquidacion ALTER COLUMN idconcepto_liquidacion SET DEFAULT nextval('public.concepto_liquidacion_idconcepto_liquidacion_seq'::regclass);


--
-- Name: idconfiguracion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configuracion ALTER COLUMN idconfiguracion SET DEFAULT nextval('public.configuracion_idconfiguracion_seq'::regclass);


--
-- Name: idconfiguracion_bolsita; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configuracion_bolsita ALTER COLUMN idconfiguracion_bolsita SET DEFAULT nextval('public.configuracion_bolsita_idconfiguracion_bolsita_seq'::regclass);


--
-- Name: idconfiguracion_colonia; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configuracion_colonia ALTER COLUMN idconfiguracion_colonia SET DEFAULT nextval('public.configuracion_colonia_idconfiguracion_colonia_seq'::regclass);


--
-- Name: idconsumo_convenio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio ALTER COLUMN idconsumo_convenio SET DEFAULT nextval('public.consumo_convenio_idconsumo_convenio_seq'::regclass);


--
-- Name: idconsumo_convenio_cuotas; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio_cuotas ALTER COLUMN idconsumo_convenio_cuotas SET DEFAULT nextval('public.consumo_convenio_cuotas_idconsumo_convenio_cuotas_seq'::regclass);


--
-- Name: idconvenio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.convenio ALTER COLUMN idconvenio SET DEFAULT nextval('public.convenio_idconvenio_seq'::regclass);


--
-- Name: idcosto_colonia_tipo_socio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.costo_colonia_tipo_socio ALTER COLUMN idcosto_colonia_tipo_socio SET DEFAULT nextval('public.costo_colonia_tipo_socio_idcosto_colonia_tipo_socio_seq'::regclass);


--
-- Name: idcosto_pileta_tipo_socio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.costo_pileta_tipo_socio ALTER COLUMN idcosto_pileta_tipo_socio SET DEFAULT nextval('public.costo_pileta_tipo_socio_idcosto_pileta_tipo_socio_seq'::regclass);


--
-- Name: idcuota_societaria; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cuota_societaria ALTER COLUMN idcuota_societaria SET DEFAULT nextval('public.cuota_societaria_idcuota_societaria_seq'::regclass);


--
-- Name: iddetalle_consumo_ticket; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_consumo_ticket ALTER COLUMN iddetalle_consumo_ticket SET DEFAULT nextval('public.detalle_consumo_ticket_iddetalle_consumo_ticket_seq'::regclass);


--
-- Name: iddetalle_inscripcion_pileta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_inscripcion_pileta ALTER COLUMN iddetalle_inscripcion_pileta SET DEFAULT nextval('public.detalle_inscripcion_pileta_iddetalle_inscripcion_pileta_seq'::regclass);


--
-- Name: iddetalle_liquidacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_liquidacion ALTER COLUMN iddetalle_liquidacion SET DEFAULT nextval('public.detalle_liquidacion_iddetalle_liquidacion_seq'::regclass);


--
-- Name: iddetalle_pago; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago ALTER COLUMN iddetalle_pago SET DEFAULT nextval('public.detalle_pago_iddetalle_pago_seq'::regclass);


--
-- Name: iddetalle_pago_consumo_convenio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_consumo_convenio ALTER COLUMN iddetalle_pago_consumo_convenio SET DEFAULT nextval('public.detalle_pago_consumo_convenio_iddetalle_pago_consumo_conven_seq'::regclass);


--
-- Name: iddetalle_pago_gasto_infraestructura; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_gasto_infraestructura ALTER COLUMN iddetalle_pago_gasto_infraestructura SET DEFAULT nextval('public.detalle_pago_gasto_infraestru_iddetalle_pago_gasto_infraest_seq'::regclass);


--
-- Name: iddetalle_pago_inscripcion_pileta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_inscripcion_pileta ALTER COLUMN iddetalle_pago_inscripcion_pileta SET DEFAULT nextval('public.detalle_pago_inscripcion_pile_iddetalle_pago_inscripcion_pi_seq'::regclass);


--
-- Name: idencabezado; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.encabezado ALTER COLUMN idencabezado SET DEFAULT nextval('public.encabezado_idencabezado_seq'::regclass);


--
-- Name: idestado; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado ALTER COLUMN idestado SET DEFAULT nextval('public.estado_idestado_seq'::regclass);


--
-- Name: idestado_civil; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado_civil ALTER COLUMN idestado_civil SET DEFAULT nextval('public.estado_civil_idestado_civil_seq'::regclass);


--
-- Name: idforma_pago; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.forma_pago ALTER COLUMN idforma_pago SET DEFAULT nextval('public.forma_pago_idforma_pago_seq'::regclass);


--
-- Name: idgasto_infraestructura; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gasto_infraestructura ALTER COLUMN idgasto_infraestructura SET DEFAULT nextval('public.gasto_infraestructura_idgasto_infraestructura_seq'::regclass);


--
-- Name: idinscripcion_colono; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono ALTER COLUMN idinscripcion_colono SET DEFAULT nextval('public.inscripcion_colono_idinscripcion_colono_seq'::regclass);


--
-- Name: idinscripcion_colono_plan_pago; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono_plan_pago ALTER COLUMN idinscripcion_colono_plan_pago SET DEFAULT nextval('public.inscripcion_colono_plan_pago_idinscripcion_colono_plan_pago_seq'::regclass);


--
-- Name: idinscripcion_pileta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_pileta ALTER COLUMN idinscripcion_pileta SET DEFAULT nextval('public.inscripcion_pileta_idinscripcion_pileta_seq'::regclass);


--
-- Name: idinstalacion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instalacion ALTER COLUMN idinstalacion SET DEFAULT nextval('public.instalacion_idinstalacion_seq'::regclass);


--
-- Name: idlocalidad; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.localidad ALTER COLUMN idlocalidad SET DEFAULT nextval('public.localidad_idlocalidad_seq'::regclass);


--
-- Name: idmotivo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo ALTER COLUMN idmotivo SET DEFAULT nextval('public.motivo_idmotivo_seq'::regclass);


--
-- Name: idmotivo_tipo_socio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo_tipo_socio ALTER COLUMN idmotivo_tipo_socio SET DEFAULT nextval('public.motivo_tipo_socio_idmotivo_tipo_socio_seq'::regclass);


--
-- Name: iddetalle_modificacion_monto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimientos_monto_reserva ALTER COLUMN iddetalle_modificacion_monto SET DEFAULT nextval('public.detalle_modificacion_monto_iddetalle_modificacion_monto_seq'::regclass);


--
-- Name: idnivel; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nivel ALTER COLUMN idnivel SET DEFAULT nextval('public.nivel_idnivel_seq'::regclass);


--
-- Name: idpais; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pais ALTER COLUMN idpais SET DEFAULT nextval('public.pais_idpais_seq'::regclass);


--
-- Name: idparentesco; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parentesco ALTER COLUMN idparentesco SET DEFAULT nextval('public.parentesco_idparentesco_seq'::regclass);


--
-- Name: idpremio_sorteo; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.premio_sorteo ALTER COLUMN idpremio_sorteo SET DEFAULT nextval('public.premio_sorteo_idpremio_sorteo_seq'::regclass);


--
-- Name: idreempadronamiento; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reempadronamiento ALTER COLUMN idreempadronamiento SET DEFAULT nextval('public.reempadronamiento_idreempadronamiento_seq'::regclass);


--
-- Name: idsolicitud_bolsita; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_bolsita ALTER COLUMN idsolicitud_bolsita SET DEFAULT nextval('public.solicitud_bolsita_idsolicitud_bolsita_seq'::regclass);


--
-- Name: idsolicitud_reserva; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reserva ALTER COLUMN idsolicitud_reserva SET DEFAULT nextval('public.solicitud_reserva_idsolicitud_reserva_seq'::regclass);


--
-- Name: idsolicitud_subsidio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_subsidio ALTER COLUMN idsolicitud_subsidio SET DEFAULT nextval('public.solicitud_subsidio_idsolicitud_subsidio_seq'::regclass);


--
-- Name: idtalonario_bono; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_bono ALTER COLUMN idtalonario_bono SET DEFAULT nextval('public.talonario_bono_idtalonario_bono_seq'::regclass);


--
-- Name: idtalonario_bono_colaboracion; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_bono_colaboracion ALTER COLUMN idtalonario_bono_colaboracion SET DEFAULT nextval('public.talonario_bono_colaboracion_idtalonario_bono_colaboracion_seq'::regclass);


--
-- Name: idtemporada_pileta; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temporada_pileta ALTER COLUMN idtemporada_pileta SET DEFAULT nextval('public.temporada_pileta_idtemporada_pileta_seq'::regclass);


--
-- Name: idtipo_documento; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_documento ALTER COLUMN idtipo_documento SET DEFAULT nextval('public.tipo_documento_idtipo_documento_seq'::regclass);


--
-- Name: idtipo_socio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_socio ALTER COLUMN idtipo_socio SET DEFAULT nextval('public.tipo_socio_idtipo_socio_seq'::regclass);


--
-- Name: idtipo_subsidio; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_subsidio ALTER COLUMN idtipo_subsidio SET DEFAULT nextval('public.tipo_subsidio_idtipo_subsidio_seq'::regclass);


--
-- Name: idtipo_telefono; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_telefono ALTER COLUMN idtipo_telefono SET DEFAULT nextval('public.tipo_telefono_idtipo_telefono_seq'::regclass);


--
-- Name: idunidad_academica; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unidad_academica ALTER COLUMN idunidad_academica SET DEFAULT nextval('public.unidad_academica_idunidad_academica_seq'::regclass);


--
-- Name: bono_convenio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_bono
    ADD CONSTRAINT bono_convenio_pkey PRIMARY KEY (idtalonario_bono);


--
-- Name: cabecera_cuota_societaria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cabecera_cuota_societaria
    ADD CONSTRAINT cabecera_cuota_societaria_pkey PRIMARY KEY (idcabecera_cuota_societaria);


--
-- Name: cabecera_liquidacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cabecera_liquidacion
    ADD CONSTRAINT cabecera_liquidacion_pkey PRIMARY KEY (idcabecera_liquidacion);


--
-- Name: categoria_comercio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_comercio
    ADD CONSTRAINT categoria_comercio_pkey PRIMARY KEY (idcategoria_comercio);


--
-- Name: claustro_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.claustro
    ADD CONSTRAINT claustro_pkey PRIMARY KEY (idclaustro);


--
-- Name: concepto_liquidacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.concepto_liquidacion
    ADD CONSTRAINT concepto_liquidacion_pkey PRIMARY KEY (idconcepto_liquidacion);


--
-- Name: concepto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.concepto
    ADD CONSTRAINT concepto_pkey PRIMARY KEY (idconcepto);


--
-- Name: configuracion_bolsita_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configuracion_bolsita
    ADD CONSTRAINT configuracion_bolsita_pkey PRIMARY KEY (idconfiguracion_bolsita);


--
-- Name: configuracion_colonia_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.configuracion_colonia
    ADD CONSTRAINT configuracion_colonia_pkey PRIMARY KEY (idconfiguracion_colonia);


--
-- Name: consumo_convenio_cuotas_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio_cuotas
    ADD CONSTRAINT consumo_convenio_cuotas_pkey PRIMARY KEY (idconsumo_convenio_cuotas);


--
-- Name: consumo_convenio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio
    ADD CONSTRAINT consumo_convenio_pkey PRIMARY KEY (idconsumo_convenio);


--
-- Name: convenio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.convenio
    ADD CONSTRAINT convenio_pkey PRIMARY KEY (idconvenio);


--
-- Name: convenio_por_comercios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comercios_por_convenio
    ADD CONSTRAINT convenio_por_comercios_pkey PRIMARY KEY (idconvenio, idcomercio);


--
-- Name: costo_colonia_tipo_socio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.costo_colonia_tipo_socio
    ADD CONSTRAINT costo_colonia_tipo_socio_pkey PRIMARY KEY (idcosto_colonia_tipo_socio);


--
-- Name: costo_pileta_tipo_socio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.costo_pileta_tipo_socio
    ADD CONSTRAINT costo_pileta_tipo_socio_pkey PRIMARY KEY (idcosto_pileta_tipo_socio);


--
-- Name: cuota_societaria_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cuota_societaria
    ADD CONSTRAINT cuota_societaria_pkey PRIMARY KEY (idcuota_societaria);


--
-- Name: detalle_consumo_ticket_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_consumo_ticket
    ADD CONSTRAINT detalle_consumo_ticket_pkey PRIMARY KEY (iddetalle_consumo_ticket);


--
-- Name: detalle_inscripcion_pileta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_inscripcion_pileta
    ADD CONSTRAINT detalle_inscripcion_pileta_pkey PRIMARY KEY (iddetalle_inscripcion_pileta);


--
-- Name: detalle_liquidacion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_liquidacion
    ADD CONSTRAINT detalle_liquidacion_pkey PRIMARY KEY (iddetalle_liquidacion);


--
-- Name: detalle_modificacion_monto_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimientos_monto_reserva
    ADD CONSTRAINT detalle_modificacion_monto_pkey PRIMARY KEY (iddetalle_modificacion_monto);


--
-- Name: detalle_pago_consumo_convenio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_consumo_convenio
    ADD CONSTRAINT detalle_pago_consumo_convenio_pkey PRIMARY KEY (iddetalle_pago_consumo_convenio);


--
-- Name: detalle_pago_gasto_infraestructura_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_gasto_infraestructura
    ADD CONSTRAINT detalle_pago_gasto_infraestructura_pkey PRIMARY KEY (iddetalle_pago_gasto_infraestructura);


--
-- Name: detalle_pago_inscripcion_pileta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_inscripcion_pileta
    ADD CONSTRAINT detalle_pago_inscripcion_pileta_pkey PRIMARY KEY (iddetalle_pago_inscripcion_pileta);


--
-- Name: detalle_pago_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago
    ADD CONSTRAINT detalle_pago_pkey PRIMARY KEY (iddetalle_pago);


--
-- Name: forma_pago_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.forma_pago
    ADD CONSTRAINT forma_pago_pkey PRIMARY KEY (idforma_pago);


--
-- Name: gasto_infraestructura_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gasto_infraestructura
    ADD CONSTRAINT gasto_infraestructura_pkey PRIMARY KEY (idgasto_infraestructura);


--
-- Name: idafiliacion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.afiliacion
    ADD CONSTRAINT idafiliacion PRIMARY KEY (idafiliacion);


--
-- Name: idcategoria; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria
    ADD CONSTRAINT idcategoria PRIMARY KEY (idcategoria);


--
-- Name: idcategoria_estado; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_estado
    ADD CONSTRAINT idcategoria_estado PRIMARY KEY (idcategoria_estado);


--
-- Name: idcategoria_motivo; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categoria_motivo
    ADD CONSTRAINT idcategoria_motivo PRIMARY KEY (idcategoria_motivo);


--
-- Name: idcomercion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comercio
    ADD CONSTRAINT idcomercion PRIMARY KEY (idcomercio);


--
-- Name: idestado; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado
    ADD CONSTRAINT idestado PRIMARY KEY (idestado);


--
-- Name: idestado_civil; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado_civil
    ADD CONSTRAINT idestado_civil PRIMARY KEY (idestado_civil);


--
-- Name: idfamilia; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT idfamilia PRIMARY KEY (idpersona, idpersona_familia, idparentesco);


--
-- Name: idinstalacion; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.instalacion
    ADD CONSTRAINT idinstalacion PRIMARY KEY (idinstalacion);


--
-- Name: idlocalidad; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.localidad
    ADD CONSTRAINT idlocalidad PRIMARY KEY (idlocalidad);


--
-- Name: idmotivo; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo
    ADD CONSTRAINT idmotivo PRIMARY KEY (idmotivo);


--
-- Name: idpais; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pais
    ADD CONSTRAINT idpais PRIMARY KEY (idpais);


--
-- Name: idparentesco; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.parentesco
    ADD CONSTRAINT idparentesco PRIMARY KEY (idparentesco);


--
-- Name: idpersona; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT idpersona PRIMARY KEY (idpersona);


--
-- Name: idprovincia; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provincia
    ADD CONSTRAINT idprovincia PRIMARY KEY (idprovincia);


--
-- Name: idsolicitud_reserva; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reserva
    ADD CONSTRAINT idsolicitud_reserva PRIMARY KEY (idsolicitud_reserva);


--
-- Name: idtipo_documento; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_documento
    ADD CONSTRAINT idtipo_documento PRIMARY KEY (idtipo_documento);


--
-- Name: idtipo_socio; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_socio
    ADD CONSTRAINT idtipo_socio PRIMARY KEY (idtipo_socio);


--
-- Name: idtipo_telefono; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_telefono
    ADD CONSTRAINT idtipo_telefono PRIMARY KEY (idtipo_telefono);


--
-- Name: inscripcion_colono_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono
    ADD CONSTRAINT inscripcion_colono_pkey PRIMARY KEY (idinscripcion_colono);


--
-- Name: inscripcion_colono_plan_pago_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono_plan_pago
    ADD CONSTRAINT inscripcion_colono_plan_pago_pkey PRIMARY KEY (idinscripcion_colono_plan_pago);


--
-- Name: inscripcion_pileta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_pileta
    ADD CONSTRAINT inscripcion_pileta_pkey PRIMARY KEY (idinscripcion_pileta);


--
-- Name: motivo_tipo_socio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo_tipo_socio
    ADD CONSTRAINT motivo_tipo_socio_pkey PRIMARY KEY (idmotivo_tipo_socio);


--
-- Name: nivel_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.nivel
    ADD CONSTRAINT nivel_pkey PRIMARY KEY (idnivel);


--
-- Name: nros_talonorio_bono_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_nros_bono
    ADD CONSTRAINT nros_talonorio_bono_pkey PRIMARY KEY (idtalonario_bono, nro_bono);


--
-- Name: premio_sorteo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.premio_sorteo
    ADD CONSTRAINT premio_sorteo_pkey PRIMARY KEY (idpremio_sorteo);


--
-- Name: reempadronamiento_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.reempadronamiento
    ADD CONSTRAINT reempadronamiento_pkey PRIMARY KEY (idreempadronamiento);


--
-- Name: solicitud_bolsita_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_bolsita
    ADD CONSTRAINT solicitud_bolsita_pkey PRIMARY KEY (idsolicitud_bolsita);


--
-- Name: solicitud_reempadronamiento_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reempadronamiento
    ADD CONSTRAINT solicitud_reempadronamiento_pkey PRIMARY KEY (idreempadronamiento, idafiliacion);


--
-- Name: solicitud_subsidio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_subsidio
    ADD CONSTRAINT solicitud_subsidio_pkey PRIMARY KEY (idsolicitud_subsidio);


--
-- Name: talonario_bono_colaboracion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_bono_colaboracion
    ADD CONSTRAINT talonario_bono_colaboracion_pkey PRIMARY KEY (idtalonario_bono_colaboracion);


--
-- Name: talonario_nros_bono_colaboracion_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_nros_bono_colaboracion
    ADD CONSTRAINT talonario_nros_bono_colaboracion_pkey PRIMARY KEY (idtalonario_bono_colaboracion, nro_bono);


--
-- Name: telefono_por_persona_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_por_persona
    ADD CONSTRAINT telefono_por_persona_pkey PRIMARY KEY (idtipo_telefono, idpersona, nro_telefono);


--
-- Name: temporada_pileta_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.temporada_pileta
    ADD CONSTRAINT temporada_pileta_pkey PRIMARY KEY (idtemporada_pileta);


--
-- Name: tipo_subsidio_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tipo_subsidio
    ADD CONSTRAINT tipo_subsidio_pkey PRIMARY KEY (idtipo_subsidio);


--
-- Name: unidad_academica_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.unidad_academica
    ADD CONSTRAINT unidad_academica_pkey PRIMARY KEY (idunidad_academica);


--
-- Name: detalle_inscripcion_pileta_idpersona_familia_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX detalle_inscripcion_pileta_idpersona_familia_idx ON public.detalle_inscripcion_pileta USING btree (idinscripcion_pileta, idpersona_familia);


--
-- Name: idx_afiliacion; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_afiliacion ON public.afiliacion USING btree (idafiliacion, idpersona);


--
-- Name: idx_afiliacion_solicitada; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_afiliacion_solicitada ON public.afiliacion USING btree (idpersona, idtipo_socio) WHERE (((solicitada = true) AND (activa = false)) OR ((solicitada = false) AND (activa = true)));


--
-- Name: idx_anio; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_anio ON public.configuracion_bolsita USING btree (anio);


--
-- Name: idx_anio_colonia; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_anio_colonia ON public.configuracion_colonia USING btree (anio);


--
-- Name: idx_categoria_comercio; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_categoria_comercio ON public.categoria_comercio USING btree (descripcion);


--
-- Name: idx_categoria_estado; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_categoria_estado ON public.categoria_estado USING btree (descripcion);


--
-- Name: idx_categoria_motivo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_categoria_motivo ON public.categoria_motivo USING btree (descripcion);


--
-- Name: idx_claustro; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_claustro ON public.claustro USING btree (descripcion);


--
-- Name: idx_codigo_concepto; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_codigo_concepto ON public.concepto_liquidacion USING btree (codigo);


--
-- Name: idx_comercio; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_comercio ON public.comercio USING btree (nombre);


--
-- Name: idx_concepto; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_concepto ON public.concepto USING btree (descripcion);


--
-- Name: idx_consumo_ticket; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_consumo_ticket ON public.consumo_convenio USING btree (idafiliacion, idconvenio, idcomercio, periodo);


--
-- Name: idx_convenio; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_convenio ON public.convenio USING btree (titulo);


--
-- Name: idx_convenio_ayuda_economica_activo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_convenio_ayuda_economica_activo ON public.convenio USING btree (ayuda_economica, activo) WHERE ((ayuda_economica = true) AND (activo = true));


--
-- Name: idx_descripcion; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_descripcion ON public.tipo_subsidio USING btree (descripcion);


--
-- Name: idx_documento; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_documento ON public.persona USING btree (idtipo_documento, nro_documento);


--
-- Name: idx_estado; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_estado ON public.estado USING btree (descripcion, idcategoria_estado);


--
-- Name: idx_estado_civil; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_estado_civil ON public.estado_civil USING btree (descripcion);


--
-- Name: idx_forma_pago; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_forma_pago ON public.forma_pago USING btree (descripcion);


--
-- Name: idx_forma_pago_efectivo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_forma_pago_efectivo ON public.forma_pago USING btree (efectivo) WHERE (efectivo = true);


--
-- Name: idx_forma_pago_planilla; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_forma_pago_planilla ON public.forma_pago USING btree (planilla) WHERE (planilla = true);


--
-- Name: idx_inscripcion_colono; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_inscripcion_colono ON public.inscripcion_colono USING btree (idconfiguracion_colonia, idpersona_familia);


--
-- Name: idx_instalacion; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_instalacion ON public.instalacion USING btree (nombre);


--
-- Name: idx_legajo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_legajo ON public.persona USING btree (legajo);


--
-- Name: idx_localidad; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_localidad ON public.localidad USING btree (descripcion);


--
-- Name: idx_motivo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_motivo ON public.motivo USING btree (descripcion);


--
-- Name: idx_motivo_por_tipo_socio; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_motivo_por_tipo_socio ON public.motivo_tipo_socio USING btree (idtipo_socio, idmotivo, idinstalacion);


--
-- Name: idx_nivel; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_nivel ON public.nivel USING btree (descripcion);


--
-- Name: idx_pais; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_pais ON public.pais USING btree (descripcion);


--
-- Name: idx_parentesco; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_parentesco ON public.parentesco USING btree (descripcion);


--
-- Name: idx_periodo; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_periodo ON public.cabecera_cuota_societaria USING btree (periodo);


--
-- Name: idx_provincia; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_provincia ON public.provincia USING btree (descripcion);


--
-- Name: idx_sigla; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_sigla ON public.unidad_academica USING btree (sigla);


--
-- Name: idx_solicitud_bolsita; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_solicitud_bolsita ON public.solicitud_bolsita USING btree (idconfiguracion_bolsita, idpersona_familia);


--
-- Name: idx_talonario; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_talonario ON public.talonario_bono USING btree (idconvenio, idcomercio, nro_talonario);


--
-- Name: idx_temporada_pileta; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_temporada_pileta ON public.temporada_pileta USING btree (descripcion);


--
-- Name: idx_tipo_documento; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_tipo_documento ON public.tipo_documento USING btree (sigla);


--
-- Name: idx_tipo_socio; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_tipo_socio ON public.tipo_socio USING btree (descripcion);


--
-- Name: idx_tipo_telefono; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_tipo_telefono ON public.tipo_telefono USING btree (descripcion);


--
-- Name: idx_unidad_academica; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX idx_unidad_academica ON public.unidad_academica USING btree (descripcion);


--
-- Name: inscripcion_pileta_idtemporada_pileta_idafiliacion_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX inscripcion_pileta_idtemporada_pileta_idafiliacion_idx ON public.inscripcion_pileta USING btree (idtemporada_pileta, idafiliacion);


--
-- Name: talonario_bono_colaboracion_descripcion_idx; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX talonario_bono_colaboracion_descripcion_idx ON public.talonario_bono_colaboracion USING btree (descripcion);


--
-- Name: generar_detalle_pago_consumo_convenio; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER generar_detalle_pago_consumo_convenio AFTER INSERT ON public.consumo_convenio FOR EACH ROW EXECUTE PROCEDURE public.generar_detalle_pago_consumo_convenio();


--
-- Name: generar_detalle_pago_solicitud_reserva; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER generar_detalle_pago_solicitud_reserva AFTER INSERT ON public.solicitud_reserva FOR EACH ROW EXECUTE PROCEDURE public.generar_detalle_pago_solicitud_reserva();


--
-- Name: generar_deuda_consumo_convenio_cuotas; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER generar_deuda_consumo_convenio_cuotas AFTER INSERT ON public.consumo_convenio FOR EACH ROW EXECUTE PROCEDURE public.generar_deuda_consumo_convenio_cuotas();


--
-- Name: generar_numeros_talonario; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER generar_numeros_talonario AFTER INSERT ON public.talonario_bono FOR EACH ROW EXECUTE PROCEDURE public.generar_numeros_talonario();


--
-- Name: generar_numeros_talonario_bono_colaboracion; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER generar_numeros_talonario_bono_colaboracion AFTER INSERT ON public.talonario_bono_colaboracion FOR EACH ROW EXECUTE PROCEDURE public.generar_numeros_talonario_bono_colaboracion();


--
-- Name: generar_plan_pago_inscripcion_colonia; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER generar_plan_pago_inscripcion_colonia AFTER UPDATE ON public.inscripcion_colono FOR EACH ROW EXECUTE PROCEDURE public.generar_plan_pago_inscripcion_colonia();


--
-- Name: generar_solicitudes_reempadronamiento_socios; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER generar_solicitudes_reempadronamiento_socios AFTER INSERT ON public.reempadronamiento FOR EACH ROW EXECUTE PROCEDURE public.generar_solicitudes_reempadronamiento_socios();


--
-- Name: afiliacion_idestado_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.afiliacion
    ADD CONSTRAINT afiliacion_idestado_fkey FOREIGN KEY (idestado) REFERENCES public.estado(idestado) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: afiliacion_idpersona_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.afiliacion
    ADD CONSTRAINT afiliacion_idpersona_fkey FOREIGN KEY (idpersona) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: afiliacion_idtipo_socio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.afiliacion
    ADD CONSTRAINT afiliacion_idtipo_socio_fkey FOREIGN KEY (idtipo_socio) REFERENCES public.tipo_socio(idtipo_socio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: bono_convenio_idconvenio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_bono
    ADD CONSTRAINT bono_convenio_idconvenio_fkey FOREIGN KEY (idconvenio) REFERENCES public.convenio(idconvenio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cabecera_cuota_societaria_idconcepto_liquidacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cabecera_cuota_societaria
    ADD CONSTRAINT cabecera_cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion) REFERENCES public.concepto_liquidacion(idconcepto_liquidacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cabecera_liquidacion_idconcepto_liquidacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cabecera_liquidacion
    ADD CONSTRAINT cabecera_liquidacion_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion) REFERENCES public.concepto_liquidacion(idconcepto_liquidacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: categoria_estado_estado_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.estado
    ADD CONSTRAINT categoria_estado_estado_fk FOREIGN KEY (idcategoria_estado) REFERENCES public.categoria_estado(idcategoria_estado);


--
-- Name: categoria_motivo_motivo_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo
    ADD CONSTRAINT categoria_motivo_motivo_fk FOREIGN KEY (idcategoria_motivo) REFERENCES public.categoria_motivo(idcategoria_motivo);


--
-- Name: consumo_convenio_cuotas_idconsumo_convenio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio_cuotas
    ADD CONSTRAINT consumo_convenio_cuotas_idconsumo_convenio_fkey FOREIGN KEY (idconsumo_convenio) REFERENCES public.consumo_convenio(idconsumo_convenio) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: consumo_convenio_cuotas_idforma_pago_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio_cuotas
    ADD CONSTRAINT consumo_convenio_cuotas_idforma_pago_fkey FOREIGN KEY (idforma_pago) REFERENCES public.forma_pago(idforma_pago) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: consumo_convenio_idafiliacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio
    ADD CONSTRAINT consumo_convenio_idafiliacion_fkey FOREIGN KEY (idafiliacion) REFERENCES public.afiliacion(idafiliacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: consumo_convenio_idconvenio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio
    ADD CONSTRAINT consumo_convenio_idconvenio_fkey FOREIGN KEY (idconvenio, idcomercio) REFERENCES public.comercios_por_convenio(idconvenio, idcomercio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: consumo_convenio_idtalonario_bono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.consumo_convenio
    ADD CONSTRAINT consumo_convenio_idtalonario_bono_fkey FOREIGN KEY (idtalonario_bono) REFERENCES public.talonario_bono(idtalonario_bono) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: convenio_idcategoria_comercio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.convenio
    ADD CONSTRAINT convenio_idcategoria_comercio_fkey FOREIGN KEY (idcategoria_comercio) REFERENCES public.categoria_comercio(idcategoria_comercio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: convenio_por_comercios_idcomercio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comercios_por_convenio
    ADD CONSTRAINT convenio_por_comercios_idcomercio_fkey FOREIGN KEY (idcomercio) REFERENCES public.comercio(idcomercio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: convenio_por_comercios_idconvenio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.comercios_por_convenio
    ADD CONSTRAINT convenio_por_comercios_idconvenio_fkey FOREIGN KEY (idconvenio) REFERENCES public.convenio(idconvenio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: costo_pileta_tipo_socio_idtemporada_pileta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.costo_pileta_tipo_socio
    ADD CONSTRAINT costo_pileta_tipo_socio_idtemporada_pileta_fkey FOREIGN KEY (idtemporada_pileta) REFERENCES public.temporada_pileta(idtemporada_pileta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: costo_pileta_tipo_socio_idtipo_socio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.costo_pileta_tipo_socio
    ADD CONSTRAINT costo_pileta_tipo_socio_idtipo_socio_fkey FOREIGN KEY (idtipo_socio) REFERENCES public.tipo_socio(idtipo_socio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cuota_societaria_idafiliacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cuota_societaria
    ADD CONSTRAINT cuota_societaria_idafiliacion_fkey FOREIGN KEY (idafiliacion, idpersona) REFERENCES public.afiliacion(idafiliacion, idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: cuota_societaria_idcabecera_cuota_societaria_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cuota_societaria
    ADD CONSTRAINT cuota_societaria_idcabecera_cuota_societaria_fkey FOREIGN KEY (idcabecera_cuota_societaria) REFERENCES public.cabecera_cuota_societaria(idcabecera_cuota_societaria) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: cuota_societaria_idconcepto_liquidacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cuota_societaria
    ADD CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion) REFERENCES public.concepto_liquidacion(idconcepto_liquidacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_consumo_ticket_idconsumo_convenio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_consumo_ticket
    ADD CONSTRAINT detalle_consumo_ticket_idconsumo_convenio_fkey FOREIGN KEY (idconsumo_convenio) REFERENCES public.consumo_convenio(idconsumo_convenio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_inscripcion_pileta_idinscripcion_pileta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_inscripcion_pileta
    ADD CONSTRAINT detalle_inscripcion_pileta_idinscripcion_pileta_fkey FOREIGN KEY (idinscripcion_pileta) REFERENCES public.inscripcion_pileta(idinscripcion_pileta) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: detalle_liquidacion_idafiliacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_liquidacion
    ADD CONSTRAINT detalle_liquidacion_idafiliacion_fkey FOREIGN KEY (idafiliacion) REFERENCES public.afiliacion(idafiliacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_liquidacion_idcabecera_liquidacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_liquidacion
    ADD CONSTRAINT detalle_liquidacion_idcabecera_liquidacion_fkey FOREIGN KEY (idcabecera_liquidacion) REFERENCES public.cabecera_liquidacion(idcabecera_liquidacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_modificacion_monto_idconcepto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimientos_monto_reserva
    ADD CONSTRAINT detalle_modificacion_monto_idconcepto_fkey FOREIGN KEY (idconcepto) REFERENCES public.concepto(idconcepto) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_modificacion_monto_idsolicitud_reserva_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.movimientos_monto_reserva
    ADD CONSTRAINT detalle_modificacion_monto_idsolicitud_reserva_fkey FOREIGN KEY (idsolicitud_reserva) REFERENCES public.solicitud_reserva(idsolicitud_reserva) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_consumo_convenio_idconcepto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_consumo_convenio
    ADD CONSTRAINT detalle_pago_consumo_convenio_idconcepto_fkey FOREIGN KEY (idconcepto) REFERENCES public.concepto(idconcepto) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_consumo_convenio_idforma_pago_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_consumo_convenio
    ADD CONSTRAINT detalle_pago_consumo_convenio_idforma_pago_fkey FOREIGN KEY (idforma_pago) REFERENCES public.forma_pago(idforma_pago) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_gasto_infraestructura_idforma_pago_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_gasto_infraestructura
    ADD CONSTRAINT detalle_pago_gasto_infraestructura_idforma_pago_fkey FOREIGN KEY (idforma_pago) REFERENCES public.forma_pago(idforma_pago) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_gasto_infraestructura_idgasto_infraestructura_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_gasto_infraestructura
    ADD CONSTRAINT detalle_pago_gasto_infraestructura_idgasto_infraestructura_fkey FOREIGN KEY (idgasto_infraestructura) REFERENCES public.gasto_infraestructura(idgasto_infraestructura) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_idconcepto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago
    ADD CONSTRAINT detalle_pago_idconcepto_fkey FOREIGN KEY (idconcepto) REFERENCES public.concepto(idconcepto) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_idforma_pago_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago
    ADD CONSTRAINT detalle_pago_idforma_pago_fkey FOREIGN KEY (idforma_pago) REFERENCES public.forma_pago(idforma_pago) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_inscripcion_pileta_idconcepto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_inscripcion_pileta
    ADD CONSTRAINT detalle_pago_inscripcion_pileta_idconcepto_fkey FOREIGN KEY (idconcepto) REFERENCES public.concepto(idconcepto) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_inscripcion_pileta_idforma_pago_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_inscripcion_pileta
    ADD CONSTRAINT detalle_pago_inscripcion_pileta_idforma_pago_fkey FOREIGN KEY (idforma_pago) REFERENCES public.forma_pago(idforma_pago) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: detalle_pago_inscripcion_pileta_idinscripcion_pileta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.detalle_pago_inscripcion_pileta
    ADD CONSTRAINT detalle_pago_inscripcion_pileta_idinscripcion_pileta_fkey FOREIGN KEY (idinscripcion_pileta) REFERENCES public.inscripcion_pileta(idinscripcion_pileta) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: familia_idparentesco_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT familia_idparentesco_fkey FOREIGN KEY (idparentesco) REFERENCES public.parentesco(idparentesco) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: familia_idpersona_familia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT familia_idpersona_familia_fkey FOREIGN KEY (idpersona_familia) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: familia_idpersona_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familia
    ADD CONSTRAINT familia_idpersona_fkey FOREIGN KEY (idpersona) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: gasto_infraestructura_idconcepto_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gasto_infraestructura
    ADD CONSTRAINT gasto_infraestructura_idconcepto_fkey FOREIGN KEY (idconcepto) REFERENCES public.concepto(idconcepto) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: gasto_infraestructura_idproveedor_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.gasto_infraestructura
    ADD CONSTRAINT gasto_infraestructura_idproveedor_fkey FOREIGN KEY (idcomercio) REFERENCES public.comercio(idcomercio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: inscripcion_colono_idconfiguracion_colonia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono
    ADD CONSTRAINT inscripcion_colono_idconfiguracion_colonia_fkey FOREIGN KEY (idconfiguracion_colonia) REFERENCES public.configuracion_colonia(idconfiguracion_colonia) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: inscripcion_colono_idinscripcion_colono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono
    ADD CONSTRAINT inscripcion_colono_idinscripcion_colono_fkey FOREIGN KEY (idinscripcion_colono) REFERENCES public.inscripcion_colono(idinscripcion_colono) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: inscripcion_colono_plan_pago_idforma_pago_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono_plan_pago
    ADD CONSTRAINT inscripcion_colono_plan_pago_idforma_pago_fkey FOREIGN KEY (idforma_pago) REFERENCES public.forma_pago(idforma_pago) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: inscripcion_colono_plan_pago_idinscripcion_colono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_colono_plan_pago
    ADD CONSTRAINT inscripcion_colono_plan_pago_idinscripcion_colono_fkey FOREIGN KEY (idinscripcion_colono) REFERENCES public.inscripcion_colono(idinscripcion_colono) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: inscripcion_pileta_idafiliacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_pileta
    ADD CONSTRAINT inscripcion_pileta_idafiliacion_fkey FOREIGN KEY (idafiliacion) REFERENCES public.afiliacion(idafiliacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: inscripcion_pileta_idtemporada_pileta_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.inscripcion_pileta
    ADD CONSTRAINT inscripcion_pileta_idtemporada_pileta_fkey FOREIGN KEY (idtemporada_pileta) REFERENCES public.temporada_pileta(idtemporada_pileta) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: localidad_idprovincia_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.localidad
    ADD CONSTRAINT localidad_idprovincia_fkey FOREIGN KEY (idprovincia) REFERENCES public.provincia(idprovincia) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: motivo_tipo_socio_idmotivo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo_tipo_socio
    ADD CONSTRAINT motivo_tipo_socio_idmotivo_fkey FOREIGN KEY (idmotivo) REFERENCES public.motivo(idmotivo) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: motivo_tipo_socio_idtipo_socio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.motivo_tipo_socio
    ADD CONSTRAINT motivo_tipo_socio_idtipo_socio_fkey FOREIGN KEY (idtipo_socio) REFERENCES public.tipo_socio(idtipo_socio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: nros_talonorio_bono_idtalonario_bono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_nros_bono
    ADD CONSTRAINT nros_talonorio_bono_idtalonario_bono_fkey FOREIGN KEY (idtalonario_bono) REFERENCES public.talonario_bono(idtalonario_bono) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: pais_provincia_fk; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.provincia
    ADD CONSTRAINT pais_provincia_fk FOREIGN KEY (idpais) REFERENCES public.pais(idpais);


--
-- Name: persona_idclaustro_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idclaustro_fkey FOREIGN KEY (idclaustro) REFERENCES public.claustro(idclaustro) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: persona_idestado_civil_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idestado_civil_fkey FOREIGN KEY (idestado_civil) REFERENCES public.estado_civil(idestado_civil) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: persona_idlocalidad_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idlocalidad_fkey FOREIGN KEY (idlocalidad) REFERENCES public.localidad(idlocalidad) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: persona_idtipo_documento_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idtipo_documento_fkey FOREIGN KEY (idtipo_documento) REFERENCES public.tipo_documento(idtipo_documento) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: persona_idunidad_academica_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.persona
    ADD CONSTRAINT persona_idunidad_academica_fkey FOREIGN KEY (idunidad_academica) REFERENCES public.unidad_academica(idunidad_academica) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_bolsita_idconfiguracion_bolsita_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_bolsita
    ADD CONSTRAINT solicitud_bolsita_idconfiguracion_bolsita_fkey FOREIGN KEY (idconfiguracion_bolsita) REFERENCES public.configuracion_bolsita(idconfiguracion_bolsita) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_bolsita_idnivel_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_bolsita
    ADD CONSTRAINT solicitud_bolsita_idnivel_fkey FOREIGN KEY (idnivel) REFERENCES public.nivel(idnivel) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_reempadronamiento_idafiliacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reempadronamiento
    ADD CONSTRAINT solicitud_reempadronamiento_idafiliacion_fkey FOREIGN KEY (idafiliacion) REFERENCES public.afiliacion(idafiliacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_reempadronamiento_idreempadronamiento_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reempadronamiento
    ADD CONSTRAINT solicitud_reempadronamiento_idreempadronamiento_fkey FOREIGN KEY (idreempadronamiento) REFERENCES public.reempadronamiento(idreempadronamiento) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_reserva_idinstalacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reserva
    ADD CONSTRAINT solicitud_reserva_idinstalacion_fkey FOREIGN KEY (idinstalacion) REFERENCES public.instalacion(idinstalacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_reserva_idmotivo_tipo_socio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_reserva
    ADD CONSTRAINT solicitud_reserva_idmotivo_tipo_socio_fkey FOREIGN KEY (idmotivo_tipo_socio) REFERENCES public.motivo_tipo_socio(idmotivo_tipo_socio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_subsidio_idafiliacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_subsidio
    ADD CONSTRAINT solicitud_subsidio_idafiliacion_fkey FOREIGN KEY (idafiliacion) REFERENCES public.afiliacion(idafiliacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: solicitud_subsidio_idtipo_subsidio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.solicitud_subsidio
    ADD CONSTRAINT solicitud_subsidio_idtipo_subsidio_fkey FOREIGN KEY (idtipo_subsidio) REFERENCES public.tipo_subsidio(idtipo_subsidio) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: talonario_nros_bono_colaborac_idtalonario_bono_colaboracio_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_nros_bono_colaboracion
    ADD CONSTRAINT talonario_nros_bono_colaborac_idtalonario_bono_colaboracio_fkey FOREIGN KEY (idtalonario_bono_colaboracion) REFERENCES public.talonario_bono_colaboracion(idtalonario_bono_colaboracion) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: talonario_nros_bono_colaboracion_idafiliacion_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_nros_bono_colaboracion
    ADD CONSTRAINT talonario_nros_bono_colaboracion_idafiliacion_fkey FOREIGN KEY (idafiliacion) REFERENCES public.afiliacion(idafiliacion) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: talonario_nros_bono_colaboracion_idpersona_externa_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.talonario_nros_bono_colaboracion
    ADD CONSTRAINT talonario_nros_bono_colaboracion_idpersona_externa_fkey FOREIGN KEY (idpersona_externa) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: telefono_inscripcion_colono_idinscripcion_colono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_inscripcion_colono
    ADD CONSTRAINT telefono_inscripcion_colono_idinscripcion_colono_fkey FOREIGN KEY (idinscripcion_colono) REFERENCES public.inscripcion_colono(idinscripcion_colono) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- Name: telefono_inscripcion_colono_idtipo_telefono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_inscripcion_colono
    ADD CONSTRAINT telefono_inscripcion_colono_idtipo_telefono_fkey FOREIGN KEY (idtipo_telefono) REFERENCES public.tipo_telefono(idtipo_telefono) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: telefono_por_persona_idpersona_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_por_persona
    ADD CONSTRAINT telefono_por_persona_idpersona_fkey FOREIGN KEY (idpersona) REFERENCES public.persona(idpersona) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- Name: telefono_por_persona_idtipo_telefono_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.telefono_por_persona
    ADD CONSTRAINT telefono_por_persona_idtipo_telefono_fkey FOREIGN KEY (idtipo_telefono) REFERENCES public.tipo_telefono(idtipo_telefono) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- PostgreSQL database dump complete
--

