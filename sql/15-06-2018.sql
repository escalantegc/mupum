ALTER TABLE public.afiliacion ADD COLUMN solicita_cancelacion boolean;
ALTER TABLE public.afiliacion ALTER COLUMN solicita_cancelacion SET DEFAULT false;
ALTER TABLE public.afiliacion ADD COLUMN fecha_solicitud_cancelacion date;
ALTER TABLE public.afiliacion ADD COLUMN motivo_cancelacion text;


ALTER TABLE public.solicitud_reserva ADD COLUMN idmotivo_tipo_socio integer;
ALTER TABLE public.solicitud_reserva ADD COLUMN monto double precision;


ALTER TABLE public.solicitud_reserva DROP CONSTRAINT solicitud_reserva_idmotivo_tipo_socio_fkey;

ALTER TABLE public.solicitud_reserva DROP COLUMN idmotivo;

-- ALTER TABLE public.solicitud_reserva DROP CONSTRAINT solicitud_reserva_idmotivo_tipo_socio_fkey;

ALTER TABLE public.solicitud_reserva
  ADD CONSTRAINT solicitud_reserva_idmotivo_tipo_socio_fkey FOREIGN KEY (idmotivo_tipo_socio)
      REFERENCES public.motivo_tipo_socio (idmotivo_tipo_socio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;

-- Table: public.motivo_tipo_socio

-- DROP TABLE public.motivo_tipo_socio;

CREATE TABLE public.motivo_tipo_socio
(
  idmotivo_tipo_socio integer NOT NULL DEFAULT nextval('motivo_tipo_socio_idmotivo_tipo_socio_seq'::regclass),
  idtipo_socio integer NOT NULL,
  idmotivo integer NOT NULL,
  monto_reserva double precision NOT NULL,
  monto_limpieza_mantenimiento double precision NOT NULL,
  monto_garantia double precision,
  CONSTRAINT motivo_tipo_socio_pkey PRIMARY KEY (idmotivo_tipo_socio),
  CONSTRAINT motivo_tipo_socio_idmotivo_fkey FOREIGN KEY (idmotivo)
      REFERENCES public.motivo (idmotivo) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT motivo_tipo_socio_idtipo_socio_fkey FOREIGN KEY (idtipo_socio)
      REFERENCES public.tipo_socio (idtipo_socio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.motivo_tipo_socio
  OWNER TO postgres;
