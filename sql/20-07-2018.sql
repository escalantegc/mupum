ALTER TABLE public.convenio ADD COLUMN consumo_ticket boolean;
ALTER TABLE public.convenio ALTER COLUMN consumo_ticket SET DEFAULT false;

-- Table: public.talonario_bono

-- DROP TABLE public.talonario_bono;

CREATE TABLE public.talonario_bono
(
  idtalonario_bono serial NOT NULL ,
  idconvenio integer NOT NULL,
  idcomercio integer NOT NULL,
  nro_talonario integer NOT NULL,
  nro_inicio integer NOT NULL,
  nro_fin integer NOT NULL,
  CONSTRAINT bono_convenio_pkey PRIMARY KEY (idtalonario_bono),
  CONSTRAINT bono_convenio_idconvenio_fkey FOREIGN KEY (idconvenio)
      REFERENCES public.convenio (idconvenio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.talonario_bono
  OWNER TO postgres;

-- Index: public.idx_talonario

-- DROP INDEX public.idx_talonario;

CREATE UNIQUE INDEX idx_talonario
  ON public.talonario_bono
  USING btree
  (idconvenio, idcomercio, nro_talonario);

