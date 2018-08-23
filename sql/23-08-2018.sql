-- Function: public.traer_periodo_pago_max_nro_cuota(integer)

-- DROP FUNCTION public.traer_periodo_pago_max_nro_cuota(integer);

CREATE OR REPLACE FUNCTION public.traer_fecha_pago_max_nro_cuota(integer)
  RETURNS date AS
$BODY$
DECLARE
    f date;

BEGIN
    f:= (select   fecha_pago  from consumo_convenio_cuotas 
 where   cuota_pagada = true and 
 idconsumo_convenio=$1 and 
 nro_cuota= (select max(nro_cuota) from consumo_convenio_cuotas where cuota_pagada = true and idconsumo_convenio=$1)
);
   RETURN f;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

