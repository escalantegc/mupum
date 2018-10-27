CREATE OR REPLACE FUNCTION public.actualizar_campo_envio_descuento_true0549(character)
  RETURNS integer AS
$BODY$
DECLARE
    
BEGIN
UPDATE public.consumo_convenio_cuotas
            SET envio_descuento=true  , cuota_pagada = true ,fecha_pago = current_date
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1 ;

            UPDATE public.detalle_pago_consumo_convenio
            SET envio_descuento=true 
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $1 ;
      
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

  -- Function: public.cantidad_numeros_talonario_bono_colaboracion(integer)

-- DROP FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.actualizar_campo_envio_descuento_false0549(character)
  RETURNS integer AS
$BODY$
DECLARE
    
BEGIN
      UPDATE public.consumo_convenio_cuotas
            SET envio_descuento=false , cuota_pagada = false ,fecha_pago = null
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1 ;

            UPDATE public.detalle_pago_consumo_convenio
            SET envio_descuento=false
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $1 ;
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;



-- Function: public.cantidad_numeros_talonario_bono_colaboracion(integer)

-- DROP FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.actualizar_campo_envio_descuento_true0550(character)
  RETURNS integer AS
$BODY$
DECLARE
    
BEGIN
      UPDATE public.talonario_nros_bono_colaboracion
            SET pagado = true
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(fecha_compra, 'MM/YYYY') ilike $1;
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

  -- Function: public.cantidad_numeros_talonario_bono_colaboracion(integer)

-- DROP FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.actualizar_campo_envio_descuento_false0550(character)
  RETURNS integer AS
$BODY$
DECLARE
    
BEGIN
      UPDATE public.talonario_nros_bono_colaboracion
            SET pagado = false
            WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(fecha_compra, 'MM/YYYY') ilike $1;
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;


-- Function: public.cantidad_numeros_talonario_bono_colaboracion(integer)

-- DROP FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.actualizar_campo_envio_descuento_true0548(character)
  RETURNS integer AS
$BODY$
DECLARE
    
BEGIN
      UPDATE public.detalle_pago
      SET  envio_descuento=true 
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago.fecha, 'MM/YYYY') ilike $1 ;

      UPDATE public.inscripcion_colono_plan_pago
      SET envio_descuento=true , cuota_pagada = true, fecha_pago = current_date
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1; 


      UPDATE public.detalle_pago_inscripcion_pileta
      SET envio_descuento=true
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_inscripcion_pileta.fecha, 'MM/YYYY') ilike $1;
 
      
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

  -- Function: public.cantidad_numeros_talonario_bono_colaboracion(integer)

-- DROP FUNCTION public.cantidad_numeros_talonario_bono_colaboracion(integer);

CREATE OR REPLACE FUNCTION public.actualizar_campo_envio_descuento_false0548(character)
  RETURNS integer AS
$BODY$
DECLARE
    
BEGIN
       UPDATE public.detalle_pago
      SET  envio_descuento=false 
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago.fecha, 'MM/YYYY') ilike $1 ;

      UPDATE public.inscripcion_colono_plan_pago
      SET envio_descuento=false , cuota_pagada = false, fecha_pago = null
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  periodo ilike $1; 


      UPDATE public.detalle_pago_inscripcion_pileta
      SET envio_descuento=false
      WHERE idforma_pago = (SELECT idforma_pago  FROM public.forma_pago where planilla = true) and  to_char(detalle_pago_inscripcion_pileta.fecha, 'MM/YYYY') ilike $1;
 
      
   RETURN null;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

