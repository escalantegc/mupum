-- Table: public.consumo_bonos

-- DROP TABLE public.consumo_bonos;

CREATE TABLE public.consumo_bonos
(
  idconsumo_bono serial NOT NULL ,
  idtalonario_bono integer NOT NULL,
  numero_bono integer NOT NULL,
  idafiliacion integer NOT NULL,
  CONSTRAINT consumo_bonos_pkey PRIMARY KEY (idconsumo_bono),
  CONSTRAINT consumo_bonos_idtalonario_bono_fkey FOREIGN KEY (idtalonario_bono)
      REFERENCES public.talonario_bono (idtalonario_bono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.consumo_bonos
  OWNER TO postgres;

-- Index: public.idx_consumo

-- DROP INDEX public.idx_consumo;

CREATE UNIQUE INDEX idx_consumo
  ON public.consumo_bonos
  USING btree
  (idtalonario_bono, numero_bono);

