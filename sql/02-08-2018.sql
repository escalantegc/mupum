
-- Table: public.ayuda_economica

-- DROP TABLE public.ayuda_economica;

CREATE TABLE public.ayuda_economica
(
  idayuda_economica integer NOT NULL DEFAULT nextval('ayuda_economica_idayuda_economica_seq'::regclass),
  idafiliacion integer NOT NULL,
  idconvenio integer NOT NULL,
  monto double precision NOT NULL,
  cantidad_cuotas integer NOT NULL,
  fecha date,
  CONSTRAINT ayuda_economica_pkey PRIMARY KEY (idayuda_economica),
  CONSTRAINT ayuda_economica_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT ayuda_economica_idconvenio_fkey FOREIGN KEY (idconvenio)
      REFERENCES public.convenio (idconvenio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.ayuda_economica
  OWNER TO postgres;


  -- Table: public.detalle_ayuda_economica

-- DROP TABLE public.detalle_ayuda_economica;

CREATE TABLE public.detalle_ayuda_economica
(
  iddetalle_ayuda_economica integer NOT NULL DEFAULT nextval('detalle_ayuda_economica_iddetalle_ayuda_economica_seq'::regclass),
  idayuda_economica integer NOT NULL,
  nro_cuota integer NOT NULL,
  periodo character(7) NOT NULL,
  envio_descuento boolean DEFAULT false,
  CONSTRAINT detalle_ayuda_economica_pkey PRIMARY KEY (iddetalle_ayuda_economica),
  CONSTRAINT detalle_ayuda_economica_idayuda_economica_fkey FOREIGN KEY (idayuda_economica)
      REFERENCES public.ayuda_economica (idayuda_economica) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.detalle_ayuda_economica
  OWNER TO postgres;


-- Trigger: generar_deuda_ayuda_economica on public.ayuda_economica

-- DROP TRIGGER generar_deuda_ayuda_economica ON public.ayuda_economica;

CREATE TRIGGER generar_deuda_ayuda_economica
  AFTER INSERT
  ON public.ayuda_economica
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_deuda_ayuda_economica();





-- Function: public.generar_deuda_consumo_financiado()

-- DROP FUNCTION public.generar_deuda_consumo_financiado();

CREATE OR REPLACE FUNCTION public.generar_deuda_ayuda_economica()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := 0;
    fin integer := New.cantidad_cuotas;
    monto double precision := New.monto / fin;
    fecha_cuota date:=New.fecha;
BEGIN
    
	 LOOP
	 
	 EXIT WHEN inicio = fin ;
	 INSERT INTO public.detalle_ayuda_economica(idayuda_economica, nro_cuota, periodo)
	VALUES (New.idayuda_economica, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)));
		inicio:=inicio+1;
		
		
	END LOOP;
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.generar_deuda_ayuda_economica()
  OWNER TO postgres;



  -- Trigger: generar_deuda_consumo_financiado on public.consumo_financiado

-- DROP TRIGGER generar_deuda_consumo_financiado ON public.consumo_financiado;

CREATE TRIGGER generar_deuda_ayuda_economica
  AFTER INSERT
  ON public.ayuda_economica
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_deuda_ayuda_economica();

ALTER TABLE public.convenio ADD COLUMN ayuda_economica boolean;
ALTER TABLE public.convenio ALTER COLUMN ayuda_economica SET DEFAULT false;
