--OP FUNCTION public.cantidad_registros_detalle_pago_inscripcion_pileta(integer);  (select round(cast(mm as numeric),2));

CREATE OR REPLACE FUNCTION public.traer_estad_situacion_afiliado(integer, character,character)
  RETURNS double precision AS
$BODY$
DECLARE
    total double precision;
    consumo_cuotas double precision := 0;
    consumo_pagos double precision:= 0;
    reserva double precision:= 0;
    bono double precision:= 0;
    pileta double precision:= 0;
    colonia double precision:= 0;
    saldo double precision:= 0;


BEGIN
  consumo_cuotas := (SELECT  sum (consumo_convenio_cuotas.monto) as monto
        FROM 
          public.consumo_convenio
        inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
        inner join consumo_convenio_cuotas using (idconsumo_convenio)
        inner join afiliacion using (idafiliacion)
        inner join persona using (idpersona)
        inner join forma_pago using(idforma_pago)
        WHERE
          convenio.permite_financiacion = true and
          forma_pago.planilla = true and
          consumo_convenio_cuotas.envio_descuento =  false and
          afiliacion.idafiliacion = $1 and 
          consumo_convenio_cuotas.periodo ilike  $2
        group by 
          
          consumo_convenio_cuotas.periodo,
          persona.legajo,
          persona.apellido,
          persona.nombres,
          afiliacion.idafiliacion );
     consumo_cuotas:=(case when consumo_cuotas is null then 0 else (select round(cast(consumo_cuotas as numeric),2)) end) ;    

  consumo_pagos:=(SELECT  sum(detalle_pago_consumo_convenio.monto)
        FROM 
          public.consumo_convenio
        inner join convenio on convenio.idconvenio = consumo_convenio.idconvenio
        inner join detalle_pago_consumo_convenio using (idconsumo_convenio)
        inner join forma_pago using(idforma_pago)
        inner join afiliacion using (idafiliacion)
        inner join persona using (idpersona)

        WHERE
          forma_pago.planilla = true and
          detalle_pago_consumo_convenio.envio_descuento =  false and
          afiliacion.idafiliacion = $1 and 
          to_char(detalle_pago_consumo_convenio.fecha, 'MM/YYYY') ilike $2
        group by 
          persona.legajo,
          persona.apellido,
          persona.nombres,
          afiliacion.idafiliacion);
    consumo_pagos:= (case when consumo_pagos is null then 0 else (select round(cast(consumo_pagos as numeric),2)) end)  ;   
  reserva := (SELECT    sum (detalle_pago.monto) 
      FROM 
        public.solicitud_reserva
      inner join detalle_pago using(idsolicitud_reserva)
      inner join forma_pago  using(idforma_pago)
      inner join afiliacion using(idafiliacion)
      inner join persona using(idpersona)
      WHERE
        forma_pago.planilla = true and
        envio_descuento = false and 
        afiliacion.idafiliacion = $1 and 
        to_char(detalle_pago.fecha, 'MM/YYYY') ilike $2
      group by 
        
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
      reserva:= (case when reserva is null then 0 else (select round(cast(reserva as numeric),2)) end)  ;   

  colonia := (  SELECT  sum(inscripcion_colono_plan_pago.monto) 
      FROM 
        public.inscripcion_colono_plan_pago
      inner join forma_pago  using(idforma_pago)
      inner join inscripcion_colono using(idinscripcion_colono)
      inner join afiliacion using(idafiliacion)
      inner join persona using(idpersona)
      WHERE
        forma_pago.planilla = true  and
        envio_descuento = false and
        afiliacion.idafiliacion = $1 and 
        periodo ilike $2
      group by
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
              colonia:= (case when colonia is null then 0 else (select round(cast(colonia as numeric),2)) end)  ;   

  pileta :=(  SELECT  sum(monto) 
      FROM 
        public.detalle_pago_inscripcion_pileta
      inner join forma_pago using(idforma_pago)
      inner join inscripcion_pileta using(idinscripcion_pileta)
      inner join afiliacion using(idafiliacion)
      inner join persona using(idpersona)
      where
        forma_pago.planilla = true and
        envio_descuento = false and
        afiliacion.idafiliacion = $1 and 
        to_char(fecha, 'MM/YYYY') ilike $2

      group by
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
     pileta:= (case when pileta is null then 0 else (select round(cast(pileta as numeric),2)) end)  ;   

  bono:= (  SELECT  count (*) * talonario_bono_colaboracion.monto 
      FROM 
        public.talonario_nros_bono_colaboracion
      inner join talonario_bono_colaboracion on talonario_bono_colaboracion.idtalonario_bono_colaboracion = talonario_nros_bono_colaboracion.idtalonario_bono_colaboracion
      inner join forma_pago using(idforma_pago)
      inner join afiliacion using (idafiliacion )
      inner join persona using (idpersona)
      where
        forma_pago.planilla = true  and
        pagado = false and
        afiliacion.idafiliacion = $1 and 
        to_char(fecha_compra, 'MM/YYYY') ilike $2
      group by 
        
        talonario_bono_colaboracion.monto,
        persona.legajo,
        persona.apellido,
        persona.nombres,
        afiliacion.idafiliacion);
         bono:= (case when bono is null then 0 else (select round(cast(bono as numeric),2)) end)  ;   
    
  saldo:= (  SELECT   detalle_liquidacion.saldo 
      FROM public.cabecera_liquidacion
      inner join detalle_liquidacion using(idcabecera_liquidacion)
      inner join afiliacion using (idafiliacion )
      inner join persona using (idpersona)
      where
        afiliacion.idafiliacion = $1 and 
        periodo ilike $3);
            saldo:= (case when saldo is null then 0 else (select round(cast(saldo as numeric),2)) end)  ;   
     
  total :=  consumo_cuotas +consumo_pagos+reserva+colonia+pileta+bono+saldo;
 
   RETURN total;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
