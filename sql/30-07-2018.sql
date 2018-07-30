ALTER TABLE public.consumo_bonos ADD COLUMN total double precision;
ALTER TABLE public.consumo_ticket ADD COLUMN total double precision;


-- Table: public.consumo_ticket

-- DROP TABLE public.consumo_ticket;

CREATE TABLE public.consumo_financiado
(
  idconsumo_financiado serial NOT NULL,
  idafiliacion integer NOT NULL,
  idconvenio integer NOT NULL,
  idcomercio integer NOT NULL,
  total double precision NOT NULL,
  fecha date NOT NULL,
  monto_proforma double precision NOT NULL,
  cantidad_cuotas integer,
  CONSTRAINT consumo_financiado_pkey PRIMARY KEY (idconsumo_financiado),
  CONSTRAINT consumo_financiado_idconvenio_fkey FOREIGN KEY (idconvenio, idcomercio)
      REFERENCES public.comercios_por_convenio (idconvenio, idcomercio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT consumo_financiado_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);

-- Table: public.consumo_ticket

-- DROP TABLE public.consumo_ticket;

CREATE TABLE public.consumo_financiado
(
  idconsumo_financiado serial NOT NULL,
  idafiliacion integer NOT NULL,
  idconvenio integer NOT NULL,
  idcomercio integer NOT NULL,
  total double precision NOT NULL,
  fecha date NOT NULL,
  monto_proforma double precision NOT NULL,
  cantidad_cuotas integer,
  CONSTRAINT consumo_financiado_pkey PRIMARY KEY (idconsumo_financiado),
  CONSTRAINT consumo_financiado_idconvenio_fkey FOREIGN KEY (idconvenio, idcomercio)
      REFERENCES public.comercios_por_convenio (idconvenio, idcomercio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT consumo_financiado_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);

-- Table: public.consumo_ticket

-- DROP TABLE public.consumo_ticket;

CREATE TABLE public.detalle_consumo_financiado
(
  iddetalle_consumo_financiado serial NOT NULL,
  idconsumo_financiado integer NOT NULL,
  nro_cuota integer NOT NULL,
  mes integer NOT NULL,
  anio integer NOT NULL,
  monto double precision NOT NULL,
  CONSTRAINT detalle_consumo_financiado_pkey PRIMARY KEY (iddetalle_consumo_financiado),

    CONSTRAINT detalle_consumo_financiado_idconsumo_financiado_fkey FOREIGN KEY (idconsumo_financiado)
      REFERENCES public.consumo_financiado (idconsumo_financiado) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);





ALTER TABLE public.consumo_financiado ADD COLUMN descripcion character(100);
ALTER TABLE public.consumo_financiado ALTER COLUMN descripcion SET NOT NULL;


ALTER TABLE public.detalle_consumo_financiado ADD COLUMN envio_descuento boolean;
ALTER TABLE public.detalle_consumo_financiado ALTER COLUMN envio_descuento SET DEFAULT false;
