-- Foreign Key: public.motivo_tipo_socio_idinstalacion_fkey

-- ALTER TABLE public.motivo_tipo_socio DROP CONSTRAINT motivo_tipo_socio_idinstalacion_fkey;

ALTER TABLE public.motivo_tipo_socio
  ADD CONSTRAINT motivo_tipo_socio_idinstalacion_fkey FOREIGN KEY (idinstalacion)
      REFERENCES public.instalacion (idinstalacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


ALTER TABLE public.motivo_tipo_socio ADD COLUMN idinstalacion integer;

ALTER TABLE public.motivo_tipo_socio ADD COLUMN monto_persona_extra double precision;

ALTER TABLE public.solicitud_reserva ADD COLUMN motivo_cancelacion text;
ALTER TABLE public.solicitud_reserva ADD COLUMN fecha_cancelacion date;
ALTER TABLE public.solicitud_reserva ADD COLUMN monto_final double precision;

-- Table: public.concepto

-- DROP TABLE public.concepto;

CREATE TABLE public.concepto
(
  idconcepto serial NOT NULL ,
  descripcion character(100) NOT NULL,
  CONSTRAINT concepto_pkey PRIMARY KEY (idconcepto)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.concepto
  OWNER TO postgres;

-- Index: public.idx_concepto

-- DROP INDEX public.idx_concepto;

CREATE UNIQUE INDEX idx_concepto
  ON public.concepto
  USING btree
  (descripcion COLLATE pg_catalog."default");



ALTER TABLE public.tipo_socio ADD COLUMN liquidacion boolean;
ALTER TABLE public.tipo_socio ALTER COLUMN liquidacion SET DEFAULT false;

ALTER TABLE public.instalacion ADD COLUMN cantidad_personas_reserva integer;

