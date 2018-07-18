DROP TABLE public.convenio;

-- Table: public.convenio

-- DROP TABLE public.convenio;

CREATE TABLE public.convenio
(
  idconvenio serial NOT NULL,
  idcategoria_comercio integer NOT NULL,
  titulo character(100),
  fecha_inicio date NOT NULL,
  fecha_fin date,
  maximo_cuotas integer,
  monto_maximo_mensual double precision,
  permite_financiacion boolean DEFAULT false,
  activo boolean DEFAULT false,
  maneja_bono boolean DEFAULT false,
  CONSTRAINT convenio_pkey PRIMARY KEY (idconvenio),
  CONSTRAINT convenio_idcategoria_comercio_fkey FOREIGN KEY (idcategoria_comercio)
      REFERENCES public.categoria_comercio (idcategoria_comercio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.convenio
  OWNER TO postgres;

-- Index: public.idx_convenio

-- DROP INDEX public.idx_convenio;

CREATE UNIQUE INDEX idx_convenio
  ON public.convenio
  USING btree
  (titulo COLLATE pg_catalog."default");

-- Table: public.comercios_por_convenio

-- DROP TABLE public.comercios_por_convenio;

CREATE TABLE public.comercios_por_convenio
(
  idconvenio integer NOT NULL,
  idcomercio integer NOT NULL,
  fecha_inicio date NOT NULL,
  fecha_fin date,
  activo boolean DEFAULT false,
  CONSTRAINT convenio_por_comercios_pkey PRIMARY KEY (idconvenio, idcomercio),
  CONSTRAINT convenio_por_comercios_idcomercio_fkey FOREIGN KEY (idcomercio)
      REFERENCES public.comercio (idcomercio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT convenio_por_comercios_idconvenio_fkey FOREIGN KEY (idconvenio)
      REFERENCES public.convenio (idconvenio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.comercios_por_convenio
  OWNER TO postgres;
