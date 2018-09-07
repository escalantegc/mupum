
ALTER TABLE public.forma_pago ADD COLUMN efectivo boolean;
ALTER TABLE public.forma_pago ALTER COLUMN efectivo SET DEFAULT false;
ALTER TABLE public.inscripcion_colono ALTER COLUMN cantidad_cuotas SET DEFAULT 0;


-- Index: public.idx_forma_pago_planilla

-- DROP INDEX public.idx_forma_pago_planilla;

CREATE UNIQUE INDEX idx_forma_pago_efectivo
  ON public.forma_pago
  USING btree
  (efectivo)
  WHERE efectivo = true;

-- Table: public.inscripcion_colono_plan_pago

-- DROP TABLE public.inscripcion_colono_plan_pago;

CREATE TABLE public.inscripcion_colono_plan_pago
(
  idinscripcion_colono_plan_pago serial NOT NULL ,
  idinscripcion_colono integer NOT NULL,
  nro_cuota integer NOT NULL,
  periodo character(7) NOT NULL,
  envio_descuento boolean DEFAULT false,
  monto double precision,
  idforma_pago integer,
  cuota_pagada boolean DEFAULT false,
  fecha_pago date,
  fecha_generacion_plan date,
  inscripcion boolean DEFAULT false,
  CONSTRAINT inscripcion_colono_plan_pago_pkey PRIMARY KEY (idinscripcion_colono_plan_pago),
  CONSTRAINT inscripcion_colono_plan_pago_idforma_pago_fkey FOREIGN KEY (idforma_pago)
      REFERENCES public.forma_pago (idforma_pago) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT inscripcion_colono_plan_pago_idinscripcion_colono_fkey FOREIGN KEY (idinscripcion_colono)
      REFERENCES public.inscripcion_colono (idinscripcion_colono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.inscripcion_colono_plan_pago
  OWNER TO postgres;





-- Function: public.colonos_de_un_titular(integer)

-- DROP FUNCTION public.colonos_de_un_titular(integer);

CREATE OR REPLACE FUNCTION public.colonos_de_un_titular(integer)
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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.colonos_de_un_titular(integer)
  OWNER TO postgres;



CREATE OR REPLACE FUNCTION public.generar_plan_pago_inscripcion_colonia()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := 1;
    fin integer := New.cantidad_cuotas;
    monto_menos_inscripcion double precision := new.monto - new.monto_inscripcion;
    monto_cuota double precision := monto_menos_inscripcion / fin;
    fecha_cuota date:= current_date;
    idfp integer;
idfe integer;
BEGIN
    idfp := (SELECT idforma_pago  FROM public.forma_pago where planilla = true);
    idfe := (SELECT idforma_pago  FROM public.forma_pago where efectivo = true);

 IF New.cantidad_cuotas !=null THEN
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
       ifpe,
       fecha_cuota,
       true);

   LOOP
      
         EXIT WHEN inicio > fin ;
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
        
        
   END LOOP;
 END IF;


   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

CREATE TRIGGER generar_plan_pago_inscripcion_colonia
  AFTER UPDATE
  ON public.inscripcion_colono
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_plan_pago_inscripcion_colonia();

