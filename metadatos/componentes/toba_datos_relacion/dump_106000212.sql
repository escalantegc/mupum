------------------------------------------------------------
--[106000212]--  - dr_consumo_bono_propio 
------------------------------------------------------------

------------------------------------------------------------
-- apex_objeto
------------------------------------------------------------

--- INICIO Grupo de desarrollo 106
INSERT INTO apex_objeto (proyecto, objeto, anterior, identificador, reflexivo, clase_proyecto, clase, punto_montaje, subclase, subclase_archivo, objeto_categoria_proyecto, objeto_categoria, nombre, titulo, colapsable, descripcion, fuente_datos_proyecto, fuente_datos, solicitud_registrar, solicitud_obj_obs_tipo, solicitud_obj_observacion, parametro_a, parametro_b, parametro_c, parametro_d, parametro_e, parametro_f, usuario, creacion, posicion_botonera) VALUES (
	'mupum', --proyecto
	'106000212', --objeto
	NULL, --anterior
	NULL, --identificador
	NULL, --reflexivo
	'toba', --clase_proyecto
	'toba_datos_relacion', --clase
	'28', --punto_montaje
	NULL, --subclase
	NULL, --subclase_archivo
	NULL, --objeto_categoria_proyecto
	NULL, --objeto_categoria
	'- dr_consumo_bono_propio', --nombre
	NULL, --titulo
	NULL, --colapsable
	NULL, --descripcion
	'mupum', --fuente_datos_proyecto
	'auditoria', --fuente_datos
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
	'2018-07-27 08:41:47', --creacion
	NULL  --posicion_botonera
);
--- FIN Grupo de desarrollo 106

------------------------------------------------------------
-- apex_objeto_datos_rel
------------------------------------------------------------
INSERT INTO apex_objeto_datos_rel (proyecto, objeto, debug, clave, ap, punto_montaje, ap_clase, ap_archivo, sinc_susp_constraints, sinc_orden_automatico, sinc_lock_optimista) VALUES (
	'mupum', --proyecto
	'106000212', --objeto
	'0', --debug
	NULL, --clave
	'2', --ap
	'28', --punto_montaje
	NULL, --ap_clase
	NULL, --ap_archivo
	'0', --sinc_susp_constraints
	'1', --sinc_orden_automatico
	'1'  --sinc_lock_optimista
);

------------------------------------------------------------
-- apex_objeto_dependencias
------------------------------------------------------------

--- INICIO Grupo de desarrollo 106
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'mupum', --proyecto
	'106000211', --dep_id
	'106000212', --objeto_consumidor
	'106000203', --objeto_proveedor
	'dt_consumo_bono', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'2'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'mupum', --proyecto
	'106000212', --dep_id
	'106000212', --objeto_consumidor
	'106000234', --objeto_proveedor
	'dt_detalle_pago', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'3'  --orden
);
INSERT INTO apex_objeto_dependencias (proyecto, dep_id, objeto_consumidor, objeto_proveedor, identificador, parametros_a, parametros_b, parametros_c, inicializar, orden) VALUES (
	'mupum', --proyecto
	'106000188', --dep_id
	'106000212', --objeto_consumidor
	'106000209', --objeto_proveedor
	'dt_talonario_nros_bono', --identificador
	NULL, --parametros_a
	NULL, --parametros_b
	NULL, --parametros_c
	NULL, --inicializar
	'1'  --orden
);
--- FIN Grupo de desarrollo 106

------------------------------------------------------------
-- apex_objeto_datos_rel_asoc
------------------------------------------------------------

--- INICIO Grupo de desarrollo 106
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'mupum', --proyecto
	'106000212', --objeto
	'106000020', --asoc_id
	NULL, --identificador
	'mupum', --padre_proyecto
	'106000203', --padre_objeto
	'dt_consumo_bono', --padre_id
	NULL, --padre_clave
	'mupum', --hijo_proyecto
	'106000209', --hijo_objeto
	'dt_talonario_nros_bono', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'1'  --orden
);
INSERT INTO apex_objeto_datos_rel_asoc (proyecto, objeto, asoc_id, identificador, padre_proyecto, padre_objeto, padre_id, padre_clave, hijo_proyecto, hijo_objeto, hijo_id, hijo_clave, cascada, orden) VALUES (
	'mupum', --proyecto
	'106000212', --objeto
	'106000021', --asoc_id
	NULL, --identificador
	'mupum', --padre_proyecto
	'106000203', --padre_objeto
	'dt_consumo_bono', --padre_id
	NULL, --padre_clave
	'mupum', --hijo_proyecto
	'106000234', --hijo_objeto
	'dt_detalle_pago', --hijo_id
	NULL, --hijo_clave
	NULL, --cascada
	'2'  --orden
);
--- FIN Grupo de desarrollo 106

------------------------------------------------------------
-- apex_objeto_rel_columnas_asoc
------------------------------------------------------------
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'mupum', --proyecto
	'106000212', --objeto
	'106000020', --asoc_id
	'106000203', --padre_objeto
	'106000247', --padre_clave
	'106000209', --hijo_objeto
	'106000435'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'mupum', --proyecto
	'106000212', --objeto
	'106000020', --asoc_id
	'106000203', --padre_objeto
	'106000248', --padre_clave
	'106000209', --hijo_objeto
	'106000199'  --hijo_clave
);
INSERT INTO apex_objeto_rel_columnas_asoc (proyecto, objeto, asoc_id, padre_objeto, padre_clave, hijo_objeto, hijo_clave) VALUES (
	'mupum', --proyecto
	'106000212', --objeto
	'106000021', --asoc_id
	'106000203', --padre_objeto
	'106000247', --padre_clave
	'106000234', --hijo_objeto
	'106000266'  --hijo_clave
);
