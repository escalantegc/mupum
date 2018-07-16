

CREATE OR REPLACE FUNCTION public.traer_suma_detalle_monto(integer)
  RETURNS double precision AS
$BODY$
DECLARE
  
    total double precision;
BEGIN
    
	total:= (select sum(detalle_pago.monto) total_detalle 
		 from 
			detalle_pago 
		 where 
			detalle_pago.idsolicitud_reserva =$1);
	return total;

END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

