
INSERT INTO public.categoria_motivo ( descripcion) VALUES ( 'RESERVA');

INSERT INTO public.motivo ( idcategoria_motivo, descripcion) VALUES ( 1, 'ASADO CAMARADERIA');
INSERT INTO public.motivo ( idcategoria_motivo, descripcion) VALUES ( 1, 'CASAMIENTO');
ALTER TABLE public.configuracion ADD COLUMN limite_dias_para_reserva integer;
ALTER TABLE public.configuracion ADD COLUMN porcentaje_confirmacion_reserva integer;


ALTER TABLE public.solicitud_reserva DROP COLUMN idpersona;

ALTER TABLE public.solicitud_reserva ADD COLUMN idafiliacion integer;
ALTER TABLE public.solicitud_reserva ALTER COLUMN idafiliacion SET NOT NULL;



-- Table: public.forma_pago

-- DROP TABLE public.forma_pago;

CREATE TABLE public.forma_pago
(
  idforma_pago integer NOT NULL DEFAULT nextval('forma_pago_idforma_pago_seq'::regclass),
  descripcion character(50),
  CONSTRAINT forma_pago_pkey PRIMARY KEY (idforma_pago)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.forma_pago
  OWNER TO postgres;

-- Index: public.idx_forma_pago

-- DROP INDEX public.idx_forma_pago;

CREATE UNIQUE INDEX idx_forma_pago
  ON public.forma_pago
  USING btree
  (descripcion COLLATE pg_catalog."default");


-- Table: public.detalle_pago

-- DROP TABLE public.detalle_pago;

CREATE TABLE public.detalle_pago
(
  iddetalle_pago integer NOT NULL DEFAULT nextval('detalle_pago_iddetalle_pago_seq'::regclass),
  monto double precision,
  idsolicitud_reserva integer,
  idforma_pago integer NOT NULL,
  CONSTRAINT detalle_pago_pkey PRIMARY KEY (iddetalle_pago),
  CONSTRAINT detalle_pago_idforma_pago_fkey FOREIGN KEY (idforma_pago)
      REFERENCES public.forma_pago (idforma_pago) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.detalle_pago
  OWNER TO postgres;

INSERT INTO public.instalacion ( nombre, cantidad_maxima_personas) VALUES ( 'PREDIO', 100);
INSERT INTO public.instalacion ( nombre, cantidad_maxima_personas) VALUES ( 'SALON', 50);