ALTER TABLE public.motivo_tipo_socio ADD COLUMN porcentaje_senia integer;

ALTER TABLE public.detalle_modificacion_monto DROP COLUMN idforma_pago;

ALTER TABLE detalle_modificacion_monto rename to movimientos_monto_reserva;