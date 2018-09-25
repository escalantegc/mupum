ALTER TABLE public.detalle_pago_consumo_convenio ADD COLUMN fecha date;
ALTER TABLE public.detalle_pago ADD COLUMN fecha date;



ALTER TABLE public.detalle_pago_consumo_convenio ADD COLUMN envio_descuento boolean;
ALTER TABLE public.detalle_pago_consumo_convenio ALTER COLUMN envio_descuento SET DEFAULT false;



ALTER TABLE public.talonario_nros_bono ADD COLUMN idconsumo_convenio integer;

-- Function: public.generar_deuda_consumo_convenio_cuotas()

-- DROP FUNCTION public.generar_deuda_consumo_convenio_cuotas();

CREATE OR REPLACE FUNCTION public.generar_detalle_pago_consumo_convenio()
  RETURNS trigger AS
$BODY$
DECLARE

    monto double precision := new.total ;
    idconv integer := New.idconvenio;
    idfp integer ;
    bono boolean;
    ticket boolean;
   
BEGIN
    bono := (select maneja_bono from convenio where idconvenio = idconv);
    ticket := (select consumo_ticket from convenio where idconvenio = idconv);
   
    idfp := (SELECT idforma_pago  FROM public.forma_pago where planilla = true);

	IF (bono = true) or (ticket = true) THEN
		INSERT INTO public.detalle_pago_consumo_convenio(monto, 
								idconsumo_convenio, 
								idforma_pago, 
								fecha)
			VALUES (monto, 
				New.idconsumo_convenio, 
				idfp,
				current_date);

	END IF;

		   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


CREATE TRIGGER generar_detalle_pago_consumo_convenio
  AFTER INSERT
  ON public.consumo_convenio
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_detalle_pago_consumo_convenio();




CREATE OR REPLACE FUNCTION public.generar_detalle_pago_solicitud_reserva()
  RETURNS trigger AS
$BODY$
DECLARE

    monto_final double precision := New.monto_final ;
    idsr integer := New.idsolicitud_reserva;
    monto_senia double precision;
monto_pago double precision;	
monto_tipo_socio  double precision;	
 porcentaje_tipo_socio  double precision;	  
BEGIN
    monto_senia := (SELECT monto  FROM public.detalle_pago where idsolicitud_reserva= idsr);
    monto_tipo_socio := (SELECT monto_reserva  FROM public.motivo_tipo_socio where idmotivo_tipo_socio = New.idmotivo_tipo_socio);
    porcentaje_tipo_socio := (SELECT porcentaje_senia FROM public.motivo_tipo_socio where idmotivo_tipo_socio = New.idmotivo_tipo_socio);
    monto_senia := monto_tipo_socio * (porcentaje_tipo_socio/100);
    monto_pago := monto_final - monto_senia;
    
	INSERT INTO public.detalle_pago(monto, 
					idsolicitud_reserva, 
					fecha)
	    VALUES (monto_pago, 
		    idsr, 
		    current_date);



		   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;



CREATE TRIGGER generar_detalle_pago_solicitud_reserva
  AFTER INSERT
  ON public.solicitud_reserva
  FOR EACH ROW
  EXECUTE PROCEDURE public.generar_detalle_pago_solicitud_reserva();

