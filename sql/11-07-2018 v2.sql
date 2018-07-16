ALTER TABLE public.motivo_tipo_socio ADD COLUMN porcentaje_senia integer;

ALTER TABLE public.movimientos_monto_reserva DROP COLUMN idforma_pago;

ALTER TABLE detalle_modificacion_monto rename to movimientos_monto_reserva;