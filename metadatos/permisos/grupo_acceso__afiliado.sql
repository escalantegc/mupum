
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'mupum', --proyecto
	'afiliado', --usuario_grupo_acc
	'afiliado', --nombre
	NULL, --nivel_acceso
	'perfil de afiliado', --descripcion
	NULL, --vencimiento
	NULL, --dias
	NULL, --hora_entrada
	NULL, --hora_salida
	NULL, --listar
	'1', --permite_edicion
	NULL  --menu_usuario
);

------------------------------------------------------------
-- apex_usuario_grupo_acc_item
------------------------------------------------------------

--- INICIO Grupo de desarrollo 0
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'afiliado', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'afiliado', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'afiliado', --usuario_grupo_acc
	NULL, --item_id
	'3947'  --item
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 106
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'afiliado', --usuario_grupo_acc
	NULL, --item_id
	'106000002'  --item
);
--- FIN Grupo de desarrollo 106