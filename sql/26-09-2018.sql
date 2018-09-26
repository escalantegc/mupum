ALTER TABLE public.detalle_pago ADD COLUMN envio_descuento boolean;
ALTER TABLE public.detalle_pago ALTER COLUMN envio_descuento SET DEFAULT false;

-- Function: public.traer_cuotas_pagas(integer)

-- DROP FUNCTION public.traer_detalle_pago_cancelado_reserva(integer);

CREATE OR REPLACE FUNCTION public.traer_detalle_pago_cancelado_reserva(integer)
  RETURNS double precision AS
$BODY$
DECLARE
    monto_planilla double precision:=0;
    monto_restante double precision:=0;
    monto_total double precision:=0;
  
BEGIN
    monto_planilla:= (SELECT (case when sum(monto) is null then 0 else sum(monto) end) as total  FROM public.detalle_pago
			inner join forma_pago using(idforma_pago)
			where
				forma_pago.planilla = true and
				detalle_pago.envio_descuento = true and
				detalle_pago.idsolicitud_reserva = $1);
   monto_restante:= (SELECT  (case when sum(monto) is null then 0 else sum(monto) end) as total  FROM public.detalle_pago
			inner join forma_pago using(idforma_pago)
			where
				forma_pago.planilla = false and
				detalle_pago.idsolicitud_reserva = $1);
				
   monto_total:= monto_planilla + monto_restante;
   return monto_total;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

