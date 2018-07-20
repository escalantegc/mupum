-- Table: public.reempadronamiento

-- DROP TABLE public.reempadronamiento;

CREATE TABLE public.reempadronamiento
(
  idreempadronamiento serial NOT NULL ,
  nombre character(50) NOT NULL,
  anio integer,
  activo boolean DEFAULT false,
  CONSTRAINT reempadronamiento_pkey PRIMARY KEY (idreempadronamiento)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.reempadronamiento
  OWNER TO postgres;

-- Table: public.solicitud_reempadronamiento

-- DROP TABLE public.solicitud_reempadronamiento;

CREATE TABLE public.solicitud_reempadronamiento
(
  idreempadronamiento integer NOT NULL,
  idafiliacion integer NOT NULL,
  notificaciones integer DEFAULT 0,
  fecha_notificacion date,
  atendida boolean DEFAULT false,
  CONSTRAINT solicitud_reempadronamiento_pkey PRIMARY KEY (idreempadronamiento, idafiliacion),
  CONSTRAINT solicitud_reempadronamiento_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT solicitud_reempadronamiento_idreempadronamiento_fkey FOREIGN KEY (idreempadronamiento)
      REFERENCES public.reempadronamiento (idreempadronamiento) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.solicitud_reempadronamiento
  OWNER TO postgres;


CREATE OR REPLACE FUNCTION public.generar_solicitudes_reempadronamiento_socios()
  RETURNS trigger AS
$BODY$
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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER generar_solicitudes_reempadronamiento_socios
  AFTER INSERT 
  ON public.reempadronamiento
  FOR EACH ROW
  EXECUTE PROCEDURE generar_solicitudes_reempadronamiento_socios();


