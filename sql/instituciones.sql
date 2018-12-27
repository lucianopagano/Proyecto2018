
ALTER TABLE institucion ADD COLUMN `longitud` varchar(255);
ALTER TABLE institucion ADD COLUMN `latitud` varchar(255) ;

--insert para insituciones
INSERT INTO `institucion` ( `nombre`, `director`, `telefono`, `region_sanitaria_id`, `tipo_institucion_id`) 
VALUES ('Hospital Policlinico 1', 'Luciano', '1165005814', '1', '1'),
( 'Hospital Policlinico 2', 'Alvarito', '11651564798', '2', '2');