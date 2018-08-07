
DROP TABLE public.detalle_ayuda_economica;
DROP TABLE public.detalle_consumo_financiado;
DROP TABLE public.detalle_consumo_ticket;

DROP TABLE public.ayuda_economica;
DROP TABLE public.consumo_bonos;
DROP TABLE public.consumo_ticket;
DROP TABLE public.consumo_financiado;


-- Table: public.consumo_convenio

-- DROP TABLE public.consumo_convenio;

CREATE TABLE public.consumo_convenio
(
  idconsumo_convenio serial NOT NULL ,
  idafiliacion integer NOT NULL,
  idconvenio integer ,
  idcomercio integer ,
  total double precision ,
  fecha date ,
  monto_proforma double precision ,
  cantidad_cuotas integer,
  descripcion character(100) ,
  idtalonario_bono integer,
  cantidad_bonos integer,
  monto_bono double precision,
  periodo character(7),
  CONSTRAINT consumo_convenio_pkey PRIMARY KEY (idconsumo_convenio),
  CONSTRAINT consumo_convenio_idafiliacion_fkey FOREIGN KEY (idafiliacion)
      REFERENCES public.afiliacion (idafiliacion) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT consumo_convenio_idconvenio_fkey FOREIGN KEY (idconvenio, idcomercio)
      REFERENCES public.comercios_por_convenio (idconvenio, idcomercio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
        CONSTRAINT consumo_convenio_idtalonario_bono_fkey FOREIGN KEY (idtalonario_bono)
      REFERENCES public.talonario_bono (idtalonario_bono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.consumo_convenio
  OWNER TO postgres;


-- Function: public.generar_deuda_consumo_convenio_cuotas()

-- DROP FUNCTION public.generar_deuda_consumo_convenio_cuotas();

CREATE OR REPLACE FUNCTION public.generar_deuda_consumo_convenio_cuotas()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := 0;
    fin integer := New.cantidad_cuotas;
    monto double precision := new.total / fin;
    fecha_cuota date:=New.fecha;
    idconv integer := New.idconvenio;
    bono boolean;
    ticket boolean;
BEGIN
    bono := (select maneja_bono from convenio where idconvenio = idconv);
    ticket := (select consumo_ticket from convenio where idconvenio = idconv);

   IF bono = false THEN
   IF ticket = false THEN
     LOOP
   
     EXIT WHEN inicio = fin ;
       INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto)
        VALUES (New.idconsumo_convenio, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), monto);
      inicio:=inicio+1;
      
    END LOOP;
  END IF;
   END IF;

   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.generar_deuda_consumo_convenio_cuotas()
  OWNER TO postgres;


-- Function: public.generar_deuda_consumo_financiado()

-- DROP FUNCTION public.generar_deuda_consumo_financiado();





CREATE TABLE public.consumo_convenio_cuotas
(
  idconsumo_convenio_cuotas serial NOT NULL ,
  idconsumo_convenio integer NOT NULL,
  nro_cuota integer NOT NULL,
  periodo character(7) NOT NULL,
  envio_descuento boolean DEFAULT false,
  monto double precision,
  idforma_pago integer,
  CONSTRAINT consumo_convenio_cuotas_pkey PRIMARY KEY (idconsumo_convenio_cuotas),
  CONSTRAINT consumo_convenio_cuotas_idconsumo_convenio_fkey FOREIGN KEY (idconsumo_convenio)
      REFERENCES public.consumo_convenio (idconsumo_convenio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT consumo_convenio_cuotas_idforma_pago_fkey FOREIGN KEY (idforma_pago)
      REFERENCES public.forma_pago (idforma_pago) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);


-- Table: public.detalle_pago

-- DROP TABLE public.detalle_pago;

CREATE TABLE public.detalle_pago_consumo_convenio
(
  iddetalle_pago_consumo_convenio serial NOT NULL ,
  monto double precision,
  idconsumo_convenio integer,
  idforma_pago integer,
  idconcepto integer,
  descripcion character(50),
  CONSTRAINT detalle_pago_consumo_convenio_pkey PRIMARY KEY (iddetalle_pago_consumo_convenio),
  CONSTRAINT detalle_pago_consumo_convenio_idforma_pago_fkey FOREIGN KEY (idforma_pago)
      REFERENCES public.forma_pago (idforma_pago) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);


-- Table: public.detalle_consumo_ticket

-- DROP TABLE public.detalle_consumo_ticket;

CREATE TABLE public.detalle_consumo_ticket
(
  iddetalle_consumo_ticket serial NOT NULL ,
  idconsumo_convenio integer NOT NULL,
  nro_ticket character(20),
  monto double precision NOT NULL,
  fecha date NOT NULL,
  CONSTRAINT detalle_consumo_ticket_pkey PRIMARY KEY (iddetalle_consumo_ticket),
  CONSTRAINT detalle_consumo_ticket_idconsumo_convenio_fkey FOREIGN KEY (idconsumo_convenio)
      REFERENCES public.consumo_convenio (idconsumo_convenio) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT
)
WITH (
  OIDS=FALSE
);
