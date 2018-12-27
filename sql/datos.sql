##usuarios
INSERT INTO `usuario`(`email`, `username`, `password`, `activo`, `updated_at`, `created_at`, `first_name`, `last_name`) VALUES ('user@user.com','usuario','usuario',1,'2018-09-12 14:49:18
','2018-09-12 14:49:18','lucho','lucho');

INSERT INTO `usuario`(`email`, `username`, `password`, `activo`, `updated_at`, `created_at`, `first_name`, `last_name`) VALUES ('equipoGuardia@equipoGuardia.com','eguardia','123',1,'2018-09-12 14:49:18
','2018-09-12 14:49:18','Equipo','De Guardia');

INSERT INTO `usuario`(`email`, `username`, `password`, `activo`, `updated_at`, `created_at`, `first_name`, `last_name`) VALUES ('otro@otro.com','otro','123',1,'2018-09-12 14:49:18
','2018-09-12 14:49:18','otro','otro');


##configuracion
INSERT INTO `configuracion` (`variable`, `valor`) VALUES ('mantenimiento', '0');
INSERT INTO `configuracion` (`variable`, `valor`) VALUES ('cantidad_elementos_pagina', '10');
INSERT INTO `configuracion` (`variable`, `valor`) VALUES ('titulo', 'Hospital Alejandro Korn');
INSERT INTO `configuracion` (`variable`, `valor`) VALUES ('descripcion', 'descripcion de prueba');
INSERT INTO `configuracion` (`variable`, `valor`) VALUES ('mail', 'mail@mail.com');


##roles
INSERT INTO `rol`(`id`, `nombre`) VALUES (1,'administrador');
INSERT INTO `rol`(`id`, `nombre`) VALUES (3,'otro');
INSERT INTO `rol`(`id`, `nombre`) VALUES (30,'equiopDeGuardia');

##Permisos
INSERT INTO permiso VALUES(1,'configuracion_update');
INSERT INTO permiso VALUES(30,'paciente_index');
INSERT INTO permiso VALUES(31,'paciente_show');
INSERT INTO permiso VALUES(32,'paciente_update');
INSERT INTO permiso VALUES(33,'paciente_new');
INSERT INTO permiso VALUES(34,'paciente_destroy');


INSERT INTO permiso VALUES(40,'reporte_motivo_show');
INSERT INTO permiso VALUES(41,'reporte_genero_show');
INSERT INTO permiso VALUES(42,'reporte_localidad_show');


#usuario_tiene_rol
## usuario->administrador
INSERT INTO `usuario_tiene_rol`(`usuario_id`, `rol_id`) VALUES (1,1);

##rol tiene permiso
### administrador->configuracion_update


## permisos de rol paciente
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,30);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,31);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,32);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,33);

INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,30);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,31);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,32);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,33);


INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,40);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,41);
INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,42);

#INSERT INTO `rol_tiene_permiso`(`rol_id`, `permiso_id`) VALUES (30,34);
