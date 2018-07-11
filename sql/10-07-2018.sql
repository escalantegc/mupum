ALTER TABLE public.solicitud_reserva ADD COLUMN observacion text;
-- Table: public.categoria_comercio

-- DROP TABLE public.categoria_comercio;

CREATE TABLE public.categoria_comercio
(
  idcategoria_comercio integer NOT NULL DEFAULT nextval('categoria_comercio_idcategoria_comercio_seq'::regclass),
  descripcion character(50) NOT NULL,
  CONSTRAINT categoria_comercio_pkey PRIMARY KEY (idcategoria_comercio)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.categoria_comercio
  OWNER TO postgres;

-- Index: public.idx_categoria_comercion

-- DROP INDEX public.idx_categoria_comercion;

CREATE UNIQUE INDEX idx_categoria_comercio
  ON public.categoria_comercio
  USING btree
  (descripcion COLLATE pg_catalog."default");



ALTER TABLE public.comercio ADD COLUMN idcategoria_comercio integer;
ALTER TABLE public.comercio ALTER COLUMN idcategoria_comercio SET NOT NULL;

-- Index: public.idx_comercio

-- DROP INDEX public.idx_comercio;

CREATE UNIQUE INDEX idx_comercio
  ON public.comercio
  USING btree
  (nombre COLLATE pg_catalog."default");

