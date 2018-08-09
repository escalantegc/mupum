

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
    idcomer integer := New.idcomercio;
    bono boolean;
    ticket boolean;
    inter double precision;
    ayuda boolean;
BEGIN
    bono := (select maneja_bono from convenio where idconvenio = idconv);
    ticket := (select consumo_ticket from convenio where idconvenio = idconv);
    ayuda := (select ayuda_economica from convenio where idconvenio = idconv);
    inter := (SELECT   porcentaje_interes  FROM public.comercios_por_convenio where idconvenio=idconv and idcomercio=idcomer);
    
   IF bono = false THEN
   IF ticket = false THEN
	IF ayuda = false THEN
	     LOOP
	   
	     EXIT WHEN inicio = fin ;
	       INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto)
		VALUES (New.idconsumo_convenio, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), monto);
	      inicio:=inicio+1;
	      
	    END LOOP;
	 ELSE
	monto_final:=monto * (inter/100 +1);
	   LOOP
	   
	     EXIT WHEN inicio = fin ;
	       INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto, interes, monto_puro)
		VALUES (New.idconsumo_convenio, inicio+1, extract(month from (fecha_cuota + (inicio||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), monto_final,inter, monto);
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


ALTER TABLE public.consumo_convenio_cuotas ADD COLUMN interes double precision;
ALTER TABLE public.consumo_convenio_cuotas ADD COLUMN monto_puro double precision;
ALTER TABLE public.configuracion ADD COLUMN fecha_limite_pedido_convenio integer;



CREATE TRIGGER generar_deuda_consumo_convenio_cuotas
  AFTER INSERT OR UPDATE OR DELETE
  ON public.consumo_convenio
  FOR EACH ROW
  EXECUTE PROCEDURE generar_deuda_consumo_convenio_cuotas();