
------------------------------------------------------------
-- apex_usuario_grupo_acc
------------------------------------------------------------
INSERT INTO apex_usuario_grupo_acc (proyecto, usuario_grupo_acc, nombre, nivel_acceso, descripcion, vencimiento, dias, hora_entrada, hora_salida, listar, permite_edicion, menu_usuario) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	'Jubilado', --nombre
	NULL, --nivel_acceso
	'perfil de afiliado jubilado', --descripcion
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
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'1'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'2'  --item
);
--- FIN Grupo de desarrollo 0

--- INICIO Grupo de desarrollo 106
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000011'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000012'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000028'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000029'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000078'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000079'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000097'  --item
);
INSERT INTO apex_usuario_grupo_acc_item (proyecto, usuario_grupo_acc, item_id, item) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	NULL, --item_id
	'106000098'  --item
);
--- FIN Grupo de desarrollo 106

------------------------------------------------------------
-- apex_grupo_acc_restriccion_funcional
------------------------------------------------------------
INSERT INTO apex_grupo_acc_restriccion_funcional (proyecto, usuario_grupo_acc, restriccion_funcional) VALUES (
	'mupum', --proyecto
	'jubilado', --usuario_grupo_acc
	'106000002'  --restriccion_funcional
);
