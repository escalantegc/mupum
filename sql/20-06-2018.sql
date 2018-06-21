ALTER TABLE public.persona ADD COLUMN foto bytea;

ALTER DATABASE mupum SET bytea_output TO 'escape';

ALTER TABLE public.familia ADD COLUMN fecha_carga date;
ALTER TABLE public.familia ALTER COLUMN fecha_carga SET DEFAULT ('now'::text)::date;

-- Table: public.claustro

-- DROP TABLE public.claustro;

CREATE TABLE public.claustro
(
  idclaustro serial NOT NULL ,
  descripcion character(50),
  CONSTRAINT claustro_pkey PRIMARY KEY (idclaustro)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.claustro
  OWNER TO postgres;


ALTER TABLE public.persona ADD COLUMN idclaustro integer;

-- Foreign Key: public.persona_idtipo_documento_fkey

-- ALTER TABLE public.persona DROP CONSTRAINT persona_idtipo_documento_fkey;

ALTER TABLE public.persona
  ADD CONSTRAINT persona_idtipo_documento_fkey FOREIGN KEY (idtipo_documento)
      REFERENCES public.tipo_documento (idtipo_documento) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


-- Table: public.unidad_academica

-- DROP TABLE public.unidad_academica;

CREATE TABLE public.unidad_academica
(
  idunidad_academica serial NOT NULL ,
  sigla character(10) NOT NULL,
  descripcion character(100) NOT NULL,
  CONSTRAINT unidad_academica_pkey PRIMARY KEY (idunidad_academica)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.unidad_academica
  OWNER TO postgres;

ALTER TABLE public.persona ADD COLUMN idunidad_academica integer;
-- Foreign Key: public.persona_idunidad_academica_fkey

-- ALTER TABLE public.persona DROP CONSTRAINT persona_idunidad_academica_fkey;

ALTER TABLE public.persona
  ADD CONSTRAINT persona_idunidad_academica_fkey FOREIGN KEY (idunidad_academica)
      REFERENCES public.unidad_academica (idunidad_academica) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;


-- Table: public.encabezado

-- DROP TABLE public.encabezado;

CREATE TABLE public.encabezado
(
  idencabezado serial NOT NULL ,
  nombre_institucion character(100) NOT NULL,
  direccion character(100) NOT NULL,
  telefono character(12) NOT NULL,
  logo bytea NOT NULL
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.encabezado
  OWNER TO postgres;


ALTER TABLE public.claustro ALTER COLUMN descripcion SET NOT NULL;


-- Index: public.idx_unidad_academica

-- DROP INDEX public.idx_unidad_academica;

CREATE UNIQUE INDEX idx_unidad_academica
  ON public.unidad_academica
  USING btree
  (descripcion COLLATE pg_catalog."default");
-- Index: public.idx_sigla

-- DROP INDEX public.idx_sigla;

CREATE UNIQUE INDEX idx_sigla
  ON public.unidad_academica
  USING btree
  (sigla COLLATE pg_catalog."default");
