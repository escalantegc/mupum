-- Table: public.cabecera_cuota_societaria

-- DROP TABLE public.cabecera_cuota_societaria;

CREATE TABLE public.cabecera_cuota_societaria
(
  idcabecera_cuota_societaria SERIAL NOT NULL,
  archivo bytea NOT NULL,
  periodo character(7),
  fecha_importacion date,
  idconcepto_liquidacion integer,
  CONSTRAINT cabecera_cuota_societaria_pkey PRIMARY KEY (idcabecera_cuota_societaria),
  CONSTRAINT cabecera_cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.cabecera_cuota_societaria
  OWNER TO postgres;

-- Table: public.cuota_societaria

-- DROP TABLE public.cuota_societaria;

CREATE TABLE public.cuota_societaria
(
  idcuota_societaria integer NOT NULL DEFAULT nextval('cuota_societaria_idcuota_societaria_seq'::regclass),
  idpersona integer NOT NULL,
  idafiliacion integer NOT NULL,
  cargo character(6) NOT NULL,
  idconcepto_liquidacion integer NOT NULL,
  monto double precision NOT NULL,
  idcabecera_cuota_societaria integer,
  CONSTRAINT cuota_societaria_pkey PRIMARY KEY (idcuota_societaria),
  CONSTRAINT cuota_societaria_idafiliacion_fkey FOREIGN KEY (idafiliacion, idpersona)
      REFERENCES public.afiliacion (idafiliacion, idpersona) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT cuota_societaria_idconcepto_liquidacion_fkey FOREIGN KEY (idconcepto_liquidacion)
      REFERENCES public.concepto_liquidacion (idconcepto_liquidacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.cuota_societaria
  OWNER TO postgres;
