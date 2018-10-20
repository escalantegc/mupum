-- Function: public.total_abonado_detalle_pago_consumo_convenio(integer)

-- DROP FUNCTION public.total_abonado_detalle_pago_consumo_convenio(integer);

CREATE OR REPLACE FUNCTION public.total_abonado_detalle_pago_consumo_convenio(integer)
  RETURNS integer AS
$BODY$
DECLARE
    total double precision;
    
BEGIN
  total := (SELECT sum (monto) as total
		FROM public.detalle_pago_consumo_convenio
		where idconsumo_convenio =  $1 and
		(envio_descuento = true or (idforma_pago != (select idforma_pago from forma_pago where planilla=true))));
      
   RETURN total;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.total_abonado_detalle_pago_consumo_convenio(integer)
  OWNER TO postgres;


CREATE OR REPLACE FUNCTION public.total_abonado_detalle_pago_inscripcion_pileta(integer)
  RETURNS integer AS
$BODY$
DECLARE
    total double precision;
    
BEGIN
  total := (SELECT sum(monto)
			  FROM public.detalle_pago_inscripcion_pileta
			  where 
	idinscripcion_pileta = $1 and
		(envio_descuento = true or (idforma_pago != (select idforma_pago from forma_pago where planilla=true))));
      
   RETURN total;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.total_abonado_detalle_pago_inscripcion_pileta(integer)
  OWNER TO postgres;


-- Index: public.idx_consumo_ticket

-- DROP INDEX public.idx_consumo_ticket;

CREATE UNIQUE INDEX idx_consumo_ticket
  ON public.consumo_convenio
  USING btree
  (idafiliacion, idconvenio, idcomercio, periodo COLLATE pg_catalog."default");
