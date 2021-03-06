-- Index: public.idx_forma_pago_planilla

-- DROP INDEX public.idx_forma_pago_planilla;

CREATE UNIQUE INDEX idx_forma_pago_planilla
  ON public.forma_pago
  USING btree
  (planilla)
  WHERE planilla = true;
  
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
    idcomer integer := New.idcomercio;
    bono boolean;
    ticket boolean;
    inter double precision;
    inter_total double precision;
    monto_interes double precision;
    monto_interes_cuota double precision;
    ayuda boolean;
    fecha_limite integer;
    fecha_actual integer;
    mes integer :=0;
    idfp integer; 
BEGIN
    bono := (select maneja_bono from convenio where idconvenio = idconv);
    ticket := (select consumo_ticket from convenio where idconvenio = idconv);
    ayuda := (select ayuda_economica from convenio where idconvenio = idconv);
    inter := (SELECT   porcentaje_interes  FROM public.comercios_por_convenio where idconvenio=idconv and idcomercio=idcomer);
    fecha_limite:= (SELECT fecha_limite_pedido_convenio  FROM public.configuracion);
    fecha_actual:= (SELECT extract(day from current_date));
    idfp := (SELECT idforma_pago  FROM public.forma_pago where planilla = true);
    IF fecha_actual > fecha_limite THEN
	mes:=1;
    END IF;
   IF bono = false THEN
	   IF ticket = false THEN
		IF ayuda = false THEN
			LOOP
		    
			      EXIT WHEN inicio = fin ;
				INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto,idforma_pago)
				VALUES (New.idconsumo_convenio, inicio+1, extract(month from (fecha_cuota + (mes||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (mes||' months')::interval)), monto,idfp);
			       inicio:=inicio+1;
			       mes:=mes+1;
	       
			END LOOP;
		 ELSE
			  inter_total := fin * inter; 
			  monto_interes := new.total * (inter_total/100);
			  monto_interes_cuota := monto_interes / fin;
			  monto_final:=monto +monto_interes_cuota;
		   LOOP
		    
		      EXIT WHEN inicio = fin ;
			INSERT INTO public.consumo_convenio_cuotas(idconsumo_convenio, nro_cuota, periodo,monto, interes, monto_puro,idforma_pago)
			VALUES (New.idconsumo_convenio, inicio+1, extract(month from (fecha_cuota + (mes||' months')::interval)) ||'/'|| extract(YEAR from (fecha_cuota + (mes||' months')::interval)), monto_final,inter, monto,idfp);
			       inicio:=inicio+1;
			       mes:=mes+1;
		   END LOOP;
		END IF;
	  END IF;
   END IF;

   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.generar_deuda_consumo_convenio_cuotas()
  OWNER TO postgres;
