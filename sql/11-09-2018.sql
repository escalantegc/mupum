-- Index: public.idx_inscripcion_colono

-- DROP INDEX public.idx_inscripcion_colono;

CREATE UNIQUE INDEX idx_inscripcion_colono
  ON public.inscripcion_colono
  USING btree
  (idconfiguracion_colonia, idpersona_familia);

ALTER TABLE public.inscripcion_colono ADD COLUMN baja boolean;
ALTER TABLE public.inscripcion_colono ALTER COLUMN baja SET DEFAULT false;


ALTER TABLE public.inscripcion_colono_plan_pago DROP CONSTRAINT inscripcion_colono_plan_pago_idinscripcion_colono_fkey;

ALTER TABLE public.inscripcion_colono_plan_pago
  ADD CONSTRAINT inscripcion_colono_plan_pago_idinscripcion_colono_fkey FOREIGN KEY (idinscripcion_colono)
      REFERENCES public.inscripcion_colono (idinscripcion_colono) MATCH SIMPLE
      ON UPDATE CASCADE ON DELETE RESTRICT;

-- Function: public.generar_plan_pago_inscripcion_colonia()

-- DROP FUNCTION public.generar_plan_pago_inscripcion_colonia();

CREATE OR REPLACE FUNCTION public.generar_plan_pago_inscripcion_colonia()
  RETURNS trigger AS
$BODY$
DECLARE
    inicio integer := 1;
    fin integer := New.cantidad_cuotas;
    monto_menos_inscripcion double precision := new.monto - new.monto_inscripcion;
    monto_cuota double precision := monto_menos_inscripcion / fin;
    fecha_cuota date:= current_date;
    idfp integer;
    idfe integer;
    titular boolean;
BEGIN
    idfp := (SELECT idforma_pago  FROM public.forma_pago where planilla = true);
    idfe := (SELECT idforma_pago  FROM public.forma_pago where efectivo = true);
    titular := (SELECT  titular FROM public.tipo_socio inner join afiliacion using(idtipo_socio) where idafiliacion = New.idafiliacion);
    
 IF New.cantidad_cuotas > 0 THEN
     INSERT INTO public.inscripcion_colono_plan_pago(idinscripcion_colono, 
						   nro_cuota, 
						   periodo, 
						   monto, 
						   idforma_pago, 
						   fecha_generacion_plan, 
						   inscripcion)
    VALUES ( New.idinscripcion_colono,
	     1,
	     trim(to_char(extract(month from fecha_cuota ),'00')) ||'/'|| extract(YEAR from fecha_cuota ),
	     new.monto_inscripcion,
	     idfe,
	     fecha_cuota,
	     true);

   LOOP
      
         EXIT WHEN inicio > fin ;
	IF titular == true THEN
	     INSERT INTO public.inscripcion_colono_plan_pago(idinscripcion_colono, 
						   nro_cuota, 
						   periodo, 
						   monto, 
						   idforma_pago, 
						   fecha_generacion_plan, 
						   inscripcion)
	    VALUES ( New.idinscripcion_colono,
		     inicio+1,
		     trim(to_char(extract(month from (fecha_cuota + (inicio||' months')::interval)),'00')) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), 
		     monto_cuota,
		     idfp,
		     fecha_cuota,
		     false);
		  inicio:=inicio+1;
	ELSE
		INSERT INTO public.inscripcion_colono_plan_pago(idinscripcion_colono, 
						   nro_cuota, 
						   periodo, 
						   monto, 
						   idforma_pago, 
						   fecha_generacion_plan, 
						   inscripcion)
	    VALUES ( New.idinscripcion_colono,
		     inicio+1,
		     trim(to_char(extract(month from (fecha_cuota + (inicio||' months')::interval)),'00')) ||'/'|| extract(YEAR from (fecha_cuota + (inicio||' months')::interval)), 
		     monto_cuota,
		     idfe,
		     fecha_cuota,
		     false);
		  inicio:=inicio+1;	
	END IF;
	    
        
	END LOOP;
 END IF;
 



   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION public.generar_plan_pago_inscripcion_colonia()
  OWNER TO postgres;
