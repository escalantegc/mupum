------------------------------------------------------------
--[106000135]--  - dr_usuario - dt_usuario_proyecto 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 106
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'mupum', --proyecto
	'106000135', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_tabla', --clase
	'28', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'- dr_usuario - dt_usuario_proyecto', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'mupum', --fuente_datos_proyecto
	'usuarios', --fuente_datos
	NULL, --solicitud_registrar
	NULL, --solicitud_obj_obs_tipo
	NULL, --solicitud_obj_observacion
	NULL, --parametro_a
	NULL, --parametro_b
	NULL, --parametro_c
	NULL, --parametro_d
	NULL, --parametro_e
	NULL, --parametro_f
	NULL, --usuario
	'2018-07-05 16:13:18', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 106

------------------------------------------------------------
-- apex_objeto_db_registros
------------------------------------------------------------
INSERT INTO apex_objeto_db_registros (objeto_proyecto, objeto, max_registros, min_registros, punto_montaje, ap, ap_clase, ap_archivo, tabla, tabla_ext, alias, modificar_claves, fuente_datos_proyecto, fuente_datos, permite_actualizacion_automatica, esquema, esquema_ext) VALUES (
	'mupum', --objeto_proyecto
	'106000135', --objeto
	NULL, --max_registros
	NULL, --min_registros
	'28', --punto_montaje
	'1', --ap
	NULL, --ap_clase
	NULL, --ap_archivo
	'apex_usuario_proyecto', --tabla
	NULL, --tabla_ext
	NULL, --alias
	'1', --modificar_claves
	'mupum', --fuente_datos_proyecto
	'usuarios', --fuente_datos
	'1', --permite_actualizacion_automatica
	'desarrollo', --esquema
	'desarrollo'  --esquema_ext
);

------------------------------------------------------------
-- apex_objeto_db_registros_col
------------------------------------------------------------

--- INICIO Grupo de desarrollo 106
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'mupum', --objeto_proyecto
	'106000135', --objeto
	'106000088', --col_id
	'proyecto', --columna
	'C', --tipo
	'1', --pk
	'', --secuencia
	'15', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'apex_usuario_proyecto'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'mupum', --objeto_proyecto
	'106000135', --objeto
	'106000089', --col_id
	'usuario_grupo_acc', --columna
	'C', --tipo
	'1', --pk
	'', --secuencia
	'30', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'apex_usuario_proyecto'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'mupum', --objeto_proyecto
	'106000135', --objeto
	'106000090', --col_id
	'usuario', --columna
	'C', --tipo
	'1', --pk
	'', --secuencia
	'60', --largo
	NULL, --no_nulo
	'1', --no_nulo_db
	NULL, --externa
	'apex_usuario_proyecto'  --tabla
);
INSERT INTO apex_objeto_db_registros_col (objeto_proyecto, objeto, col_id, columna, tipo, pk, secuencia, largo, no_nulo, no_nulo_db, externa, tabla) VALUES (
	'mupum', --objeto_proyecto
	'106000135', --objeto
	'106000091', --col_id
	'usuario_perfil_datos', --columna
	'X', --tipo
	'0', --pk
	'', --secuencia
	NULL, --largo
	NULL, --no_nulo
	'0', --no_nulo_db
	NULL, --externa
	'apex_usuario_proyecto'  --tabla
);
--- FIN Grupo de desarrollo 106
