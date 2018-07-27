DROP INDEX public.idx_consumo_ticket;
ALTER TABLE public.consumo_ticket DROP COLUMN nro_ticket;
ALTER TABLE public.consumo_ticket DROP COLUMN monto;
ALTER TABLE public.consumo_ticket DROP COLUMN fecha;

-- Table: public.detalle_consumo_ticket

-- DROP TABLE public.detalle_consumo_ticket;

CREATE TABLE public.detalle_consumo_ticket
(
  iddetalle_consumo_ticket serial NOT NULL ,
  idconsumo_ticket integer NOT NULL,
  nro_ticket character(20),
  monto double precision NOT NULL,
  fecha date NOT NULL,
  CONSTRAINT detalle_consumo_ticket_pkey PRIMARY KEY (iddetalle_consumo_ticket),
  CONSTRAINT detalle_consumo_ticket_idconsumo_ticket_fkey FOREIGN KEY (idconsumo_ticket)
      REFERENCES public.consumo_ticket (idconsumo_ticket) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.detalle_consumo_ticket
  OWNER TO postgres;
