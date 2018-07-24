-- Table: public.consumo_ticket

-- DROP TABLE public.consumo_ticket;

CREATE TABLE public.consumo_ticket
(
  idconsumo_ticket serial NOT NULL ,
  idafiliacion integer NOT NULL,
  idconvenio integer NOT NULL,
  idcomercio integer NOT NULL,
  nro_ticket character(20) NOT NULL,
  monto integer NOT NULL,
  CONSTRAINT consumo_ticket_pkey PRIMARY KEY (idconsumo_ticket),
  CONSTRAINT consumo_ticket_idconvenio_fkey FOREIGN KEY (idconvenio, idcomercio)
      REFERENCES public.comercios_por_convenio (idconvenio, idcomercio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.consumo_ticket
  OWNER TO postgres;

-- Index: public.idx_consumo_ticket

-- DROP INDEX public.idx_consumo_ticket;

CREATE UNIQUE INDEX idx_consumo_ticket
  ON public.consumo_ticket
  USING btree
  (idcomercio, nro_ticket COLLATE pg_catalog."default");

