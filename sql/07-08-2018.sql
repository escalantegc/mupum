﻿

-- Function: public.generar_deuda_consumo_convenio_cuotas()

-- DROP FUNCTION public.generar_deuda_consumo_convenio_cuotas();

CREATE OR REPLACE FUNCTION public.generar_deuda_consumo_convenio_cuotas()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := 0;
    fin integer := New.cantidad_cuotas;
    monto double precision := new.total / fin;
    monto_final double precision ;
    fecha_cuota date:=New.fecha;
    idconv integer := New.idconvenio;
    idcomer := New.idcomercio
    bono boolean;
    ticket boolean;
    interes double precision;
    ayuda boolean;
BEGIN
    bono := (select maneja_bono from convenio where idconvenio = idconv);
    ticket := (select consumo_ticket from convenio where idconvenio = idconv);
    ayuda := (select ayuda_economica from convenio where idconvenio = idconv);
    inter := (SELECT   porcentaje_interes  FROM public.comercios_por_convenio where idconvenio=idconv and idcomercio=idcomer);
    
   IF bono = false THEN
   IF ticket = false THEN
	if ayuda = false
	     LOOP
	   
	     EXIT WHEN inicio = fin ;
	       INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto)
		VALUES (New.idconsumo_convenio, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), monto);
	      inicio:=inicio+1;
	      
	    END LOOP;
	 ELSE
	monto:=
	   LOOP
	   
	     EXIT WHEN inicio = fin ;
	       INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto, interes, monto_puro)
		VALUES (New.idconsumo_convenio, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), ,inter, monto);
	      inicio:=inicio+1;
	      
	    END LOOP;
	 END IF;
  END IF;
   END IF;

   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
