-- Function: public.traer_instalaciones_ocupadas(date)

-- DROP FUNCTION public.traer_instalaciones_ocupadas(date);

CREATE OR REPLACE FUNCTION public.traer_cuotas_pagas(integer)
  RETURNS integer AS
$BODY$
DECLARE
    cantidad integer;

BEGIN
    cantidad:= (select count(*) as c  from consumo_convenio_cuotas where envio_descuento = true and idconsumo_convenio=$1);
   RETURN cantidad;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

