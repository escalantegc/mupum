-- Function: public.colonos_de_un_titular_con_plan(integer)

-- DROP FUNCTION public.colonos_de_un_titular_con_plan(integer);

CREATE OR REPLACE FUNCTION public.colonos_de_un_titular_con_plan(integer,integer)
  RETURNS text AS
$BODY$
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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


-- Function: public.colonos_de_un_titular_sin_plan(integer)

-- DROP FUNCTION public.colonos_de_un_titular_sin_plan(integer);

CREATE OR REPLACE FUNCTION public.colonos_de_un_titular_sin_plan(integer,integer)
  RETURNS text AS
$BODY$
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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.colonos_de_un_titular_sin_plan(integer)
  OWNER TO postgres;


-- Function: public.colonos_de_un_titular(integer)

-- DROP FUNCTION public.colonos_de_un_titular(integer);

CREATE OR REPLACE FUNCTION public.colonos_de_un_titular(integer,integer)
  RETURNS text AS
$BODY$
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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.colonos_de_un_titular(integer)
  OWNER TO postgres;


ALTER TABLE public.concepto ADD COLUMN reserva boolean;
ALTER TABLE public.concepto ALTER COLUMN reserva SET DEFAULT false;



ALTER TABLE public.detalle_pago
  ADD CONSTRAINT detalle_pago_idconcepto_fkey FOREIGN KEY (idconcepto)
      REFERENCES public.concepto (idconcepto) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;



ALTER TABLE public.detalle_pago_consumo_convenio
  ADD CONSTRAINT detalle_pago_consumo_convenio_idconcepto_fkey FOREIGN KEY (idconcepto)
      REFERENCES public.concepto (idconcepto) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


ALTER TABLE public.detalle_pago_inscripcion_pileta
  ADD CONSTRAINT detalle_pago_inscripcion_pileta_idconcepto_fkey FOREIGN KEY (idconcepto)
      REFERENCES public.concepto (idconcepto) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;
