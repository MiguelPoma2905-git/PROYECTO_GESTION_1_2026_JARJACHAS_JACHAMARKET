-- ============================================================
-- LLENAR DATOS DE PRUEBA — Jacha Marketplace
-- 200+ usuarios, 40 negocios, 160+ productos, pedidos y mÃ¡s
-- Password para TODOS los usuarios de prueba: 12345678
-- Admin preservado: mikypramos2905@gmail.com (id_usuario=2) — insertado en top_3.sql
-- Password del admin: Pomada-23
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;

-- ============================================================
-- 1. CATEGORIAS (jerarquicas) — IDs explicitos 10,20,30,40,50
-- ============================================================
INSERT INTO categorias (id_categoria, id_padre, nombre, slug) VALUES
(10, NULL, 'Electronica', 'electronica'),
(11, 10, 'Telefonos', 'telefonos'),
(12, 10, 'Computadoras', 'computadoras'),
(13, 10, 'Audifonos', 'audifonos'),
(14, 10, 'Cargadores', 'cargadores'),
(20, NULL, 'Ropa y Accesorios', 'ropa-accesorios'),
(21, 20, 'Ropa para Hombre', 'ropa-hombre'),
(22, 20, 'Ropa para Mujer', 'ropa-mujer'),
(23, 20, 'Calzado', 'calzado'),
(24, 20, 'Accesorios', 'accesorios'),
(30, NULL, 'Alimentos y Bebidas', 'alimentos-bebidas'),
(31, 30, 'Comida rapida', 'comida-rapida'),
(32, 30, 'Bebidas', 'bebidas'),
(33, 30, 'Snacks', 'snacks'),
(34, 30, 'Reposteria', 'reposteria'),
(40, NULL, 'Hogar', 'hogar'),
(41, 40, 'Muebles', 'muebles'),
(42, 40, 'Decoracion', 'decoracion'),
(43, 40, 'Cocina', 'cocina'),
(50, NULL, 'Salud y Belleza', 'salud-belleza'),
(51, 50, 'Maquillaje', 'maquillaje'),
(52, 50, 'Cuidado personal', 'cuidado-personal');


-- ============================================================
-- 2. USUARIOS (200+)
-- Admin es id=2 (mikypramos2905@gmail.com) — se conserva
-- Los nuevos usuarios empiezan en id=3
-- Password hash de '12345678'
-- ============================================================

SET @hash = '\\\.onjAovDaCRQLFZ3IuhqOS';

INSERT INTO usuarios (id_usuario, nombres, apellidos, email, password_hash, telefono, ubicacion, estado) VALUES
(3,  'Carlos',   'Garcia Quispe',     'carlos.garcia@email.com',      @hash, '77710001', 'La Paz',      'Activo'),
(4,  'Maria',    'Mamani Condori',    'maria.mamani@email.com',       @hash, '77710002', 'El Alto',     'Activo'),
(5,  'Jose',     'Rodriguez Lopez',   'jose.rodriguez@email.com',      @hash, '77710003', 'Santa Cruz',  'Activo'),
(6,  'Ana',      'Martinez Perez',    'ana.martinez@email.com',        @hash, '77710004', 'Cochabamba',  'Activo'),
(7,  'Luis',     'Flores Choque',     'luis.flores@email.com',         @hash, '77710005', 'La Paz',      'Activo'),
(8,  'Carmen',   'Vargas Morales',    'carmen.vargas@email.com',       @hash, '77710006', 'Santa Cruz',  'Activo'),
(9,  'Pedro',    'Gutierrez Suarez',  'pedro.gutierrez@email.com',     @hash, '77710007', 'Cochabamba',  'Activo'),
(10, 'Rosa',     'Alvarez Sanchez',   'rosa.alvarez@email.com',        @hash, '77710008', 'Sucre',       'Activo'),
(11, 'Diego',    'Romero Torrez',     'diego.romero@email.com',        @hash, '77710009', 'Tarija',      'Activo'),
(12, 'Elena',    'Rojas Castro',      'elena.rojas@email.com',         @hash, '77710010', 'Potosi',      'Activo'),
(13, 'Fernando', 'Ortiz Nunez',       'fernando.ortiz@email.com',      @hash, '77710011', 'Oruro',       'Activo'),
(14, 'Laura',    'Vasquez Cruz',      'laura.vasquez@email.com',       @hash, '77710012', 'La Paz',      'Activo'),
(15, 'Javier',   'Santos Ramos',      'javier.santos@email.com',       @hash, '77710013', 'Santa Cruz',  'Activo'),
(16, 'Sofia',    'Mendoza Rivero',    'sofia.mendoza@email.com',       @hash, '77710014', 'Cochabamba',  'Activo'),
(17, 'Gabriel',  'Paredes Salinas',   'gabriel.paredes@email.com',     @hash, '77710015', 'Trinidad',    'Activo'),
(18, 'Valeria',  'Aguilar Miranda',   'valeria.aguilar@email.com',     @hash, '77710016', 'Cobija',      'Activo'),
(19, 'Andres',   'Medina Campos',     'andres.medina@email.com',       @hash, '77710017', 'La Paz',      'Activo'),
(20, 'Patricia', 'Vargas Velasco',    'patricia.vargas@email.com',     @hash, '77710018', 'El Alto',     'Activo'),
(21, 'Roberto',  'Vallejos Carrasco', 'roberto.vallejos@email.com',    @hash, '77710019', 'Santa Cruz',  'Activo'),
(22, 'Daniela',  'Rios Padilla',      'daniela.rios@email.com',        @hash, '77710020', 'Cochabamba',  'Activo'),
(23, 'Pablo',    'Delgado Cabrera',   'pablo.delgado@email.com',       @hash, '77710021', 'Sucre',       'Activo'),
(24, 'Gloria',   'Toledo Guzman',     'gloria.toledo@email.com',       @hash, '77710022', 'Tarija',      'Activo'),
(25, 'Marco',    'Pena Quiroga',      'marco.pena@email.com',          @hash, '77710023', 'Potosi',      'Activo'),
(26, 'Lucia',    'Saavedra Antezana', 'lucia.saavedra@email.com',      @hash, '77710024', 'Oruro',       'Activo'),
(27, 'Miguel',   'Balderrama Bohorquez','miguel.balderrama@email.com', @hash, '77710025', 'La Paz',      'Activo'),
(28, 'Veronica', 'Montero Barriga',   'veronica.montero@email.com',    @hash, '77710026', 'Santa Cruz',  'Activo'),
(29, 'Ricardo',  'Ferrufino Revilla', 'ricardo.ferrufino@email.com',   @hash, '77710027', 'Cochabamba',  'Activo'),
(30, 'Sandra',   'Urquizo Salinas',   'sandra.urquizo@email.com',      @hash, '77710028', 'Trinidad',    'Activo'),
(31, 'Jorge',    'Garcia Mamani',     'jorge.garcia2@email.com',       @hash, '77710029', 'La Paz',      'Activo'),
(32, 'Marta',    'Condori Lopez',     'marta.condori@email.com',       @hash, '77710030', 'El Alto',     'Activo'),
(33, 'Hugo',     'Perez Flores',      'hugo.perez@email.com',          @hash, '77710031', 'Santa Cruz',  'Activo'),
(34, 'Teresa',   'Choque Vargas',     'teresa.choque@email.com',       @hash, '77710032', 'Cochabamba',  'Activo'),
(35, 'Victor',   'Morales Rojas',     'victor.morales@email.com',      @hash, '77710033', 'Sucre',       'Activo'),
(36, 'Juana',    'Suarez Castro',     'juana.suarez@email.com',        @hash, '77710034', 'Tarija',      'Activo'),
(37, 'Raul',     'Sanchez Romero',    'raul.sanchez@email.com',        @hash, '77710035', 'Potosi',      'Activo'),
(38, 'Isabel',   'Torrez Rojas',      'isabel.torrez@email.com',       @hash, '77710036', 'Oruro',       'Activo'),
(39, 'Mario',    'Lopez Martinez',    'mario.lopez@email.com',         @hash, '77710037', 'La Paz',      'Activo'),
(40, 'Elena',    'Gutierrez Rivero',  'elena.gutierrez2@email.com',    @hash, '77710038', 'Santa Cruz',  'Activo'),
(41, 'Daniel',   'Cruz Santos',       'daniel.cruz@email.com',         @hash, '77710039', 'Cochabamba',  'Activo'),
(42, 'Claudia',  'Ramos Mendoza',     'claudia.ramos@email.com',       @hash, '77710040', 'La Paz',      'Activo'),
(43, 'Angel',    'Miranda Medina',    'angel.miranda@email.com',       @hash, '77710041', 'El Alto',     'Activo'),
(44, 'Monica',   'Campos Aguilar',    'monica.campos@email.com',       @hash, '77710042', 'Santa Cruz',  'Activo'),
(45, 'David',    'Paredes Vargas',    'david.paredes@email.com',       @hash, '77710043', 'Cochabamba',  'Activo'),
(46, 'Gabriela', 'Salinas Vallejos',  'gabriela.salinas@email.com',    @hash, '77710044', 'Sucre',       'Activo'),
(47, 'Alejandro','Carrasco Rios',     'alejandro.carrasco@email.com',  @hash, '77710045', 'Tarija',      'Activo'),
(48, 'Camila',   'Padilla Delgado',   'camila.padilla@email.com',      @hash, '77710046', 'Potosi',      'Activo'),
(49, 'Sebastian','Cabrera Toledo',    'sebastian.cabrera@email.com',   @hash, '77710047', 'Oruro',       'Activo'),
(50, 'Andrea',   'Guzman Pena',       'andrea.guzman@email.com',       @hash, '77710048', 'La Paz',      'Activo'),
(51, 'Felipe',   'Quiroga Saavedra',  'felipe.quiroga@email.com',      @hash, '77710049', 'Santa Cruz',  'Activo'),
(52, 'Natalia',  'Antezana Montero',  'natalia.antezana@email.com',    @hash, '77710050', 'Cochabamba',  'Activo');
INSERT INTO usuarios (id_usuario, nombres, apellidos, email, password_hash, telefono, ubicacion, estado) VALUES
(53, 'Martin',   'Revilla Urquizo',   'martin.revilla@email.com',     @hash, '77710051', 'La Paz',      'Activo'),
(54, 'Paula',    'Bohorquez Rivas',   'paula.bohorquez@email.com',    @hash, '77710052', 'El Alto',     'Activo'),
(55, 'Adrian',   'Ferrufino Delgado', 'adrian.ferrufino@email.com',   @hash, '77710053', 'Santa Cruz',  'Activo'),
(56, 'Alejandra','Mamani Quispe',     'alejandra.mamani@email.com',   @hash, '77710054', 'Cochabamba',  'Activo'),
(57, 'Gonzalo',  'Condori Choque',    'gonzalo.condori@email.com',    @hash, '77710055', 'Sucre',       'Activo'),
(58, 'Jimena',   'Flores Vargas',     'jimena.flores@email.com',      @hash, '77710056', 'Tarija',      'Activo'),
(59, 'Cristian', 'Lopez Morales',     'cristian.lopez@email.com',     @hash, '77710057', 'Potosi',      'Activo'),
(60, 'Liliana',  'Perez Rojas',       'liliana.perez@email.com',      @hash, '77710058', 'Oruro',       'Activo'),
(61, 'Eduardo',  'Garcia Rodriguez',  'eduardo.garcia@email.com',     @hash, '77710059', 'La Paz',      'Activo'),
(62, 'Beatriz',  'Martinez Gutierrez','beatriz.martinez@email.com',   @hash, '77710060', 'Santa Cruz',  'Activo'),
(63, 'Francisco','Vargas Suarez',     'francisco.vargas@email.com',   @hash, '77710061', 'Cochabamba',  'Activo'),
(64, 'Carolina', 'Rivero Paredes',    'carolina.rivero@email.com',    @hash, '77710062', 'La Paz',      'Activo'),
(65, 'Tomas',    'Salinas Aguilar',   'tomas.salinas@email.com',      @hash, '77710063', 'El Alto',     'Activo'),
(66, 'Vanessa',  'Miranda Ortiz',     'vanessa.miranda@email.com',    @hash, '77710064', 'Santa Cruz',  'Activo'),
(67, 'Sergio',   'Medina Rios',       'sergio.medina@email.com',      @hash, '77710065', 'Cochabamba',  'Activo'),
(68, 'Mariana',  'Campos Delgado',    'mariana.campos@email.com',     @hash, '77710066', 'Sucre',       'Activo'),
(69, 'Emilio',   'Cruz Santos',       'emilio.cruz@email.com',        @hash, '77710067', 'Tarija',      'Activo'),
(70, 'Diana',    'Ramos Padilla',     'diana.ramos@email.com',        @hash, '77710068', 'Potosi',      'Activo'),
(71, 'Manuel',   'Toledo Guzman',     'manuel.toledo@email.com',      @hash, '77710069', 'Oruro',       'Activo'),
(72, 'Ruth',     'Pena Quispe',       'ruth.pena@email.com',          @hash, '77710070', 'La Paz',      'Activo'),
(73, 'Nicolas',  'Quiroga Morales',   'nicolas.quiroga@email.com',    @hash, '77710071', 'Santa Cruz',  'Activo'),
(74, 'Pamela',   'Saavedra Antezana', 'pamela.saavedra@email.com',    @hash, '77710072', 'Cochabamba',  'Activo'),
(75, 'Hector',   'Balderrama Revilla','hector.balderrama@email.com',  @hash, '77710073', 'La Paz',      'Activo'),
(76, 'Angelica', 'Montero Barriga',   'angelica.montero@email.com',   @hash, '77710074', 'El Alto',     'Activo'),
(77, 'Fernanda', 'Ferrufino Rivas',   'fernanda.ferrufino@email.com', @hash, '77710075', 'Santa Cruz',  'Activo'),
(78, 'Marcelo',  'Garcia Lopez',      'marcelo.garcia@email.com',     @hash, '77710076', 'Cochabamba',  'Activo'),
(79, 'Lorena',   'Mamani Condori',    'lorena.mamani@email.com',      @hash, '77710077', 'Trinidad',    'Activo'),
(80, 'Rodrigo',  'Rodriguez Martinez','rodrigo.rodriguez@email.com',  @hash, '77710078', 'Cobija',      'Activo'),
(81, 'Brenda',   'Flores Choque',     'brenda.flores@email.com',      @hash, '77710079', 'La Paz',      'Activo'),
(82, 'Alberto',  'Vargas Morales',    'alberto.vargas@email.com',     @hash, '77710080', 'Santa Cruz',  'Activo'),
(83, 'Silvia',   'Gutierrez Suarez',  'silvia.gutierrez@email.com',   @hash, '77710081', 'Cochabamba',  'Activo'),
(84, 'Joaquin',  'Alvarez Sanchez',   'joaquin.alvarez@email.com',    @hash, '77710082', 'Sucre',       'Activo'),
(85, 'Violeta',  'Romero Torrez',     'violeta.romero@email.com',     @hash, '77710083', 'Tarija',      'Activo'),
(86, 'Ivan',     'Rojas Castro',      'ivan.rojas@email.com',         @hash, '77710084', 'Potosi',      'Activo'),
(87, 'Mercedes', 'Ortiz Nunez',       'mercedes.ortiz@email.com',     @hash, '77710085', 'Oruro',       'Activo'),
(88, 'Fabian',   'Vasquez Cruz',      'fabian.vasquez@email.com',     @hash, '77710086', 'La Paz',      'Activo'),
(89, 'Adriana',  'Santos Ramos',      'adriana.santos@email.com',     @hash, '77710087', 'Santa Cruz',  'Activo'),
(90, 'Renato',   'Mendoza Rivero',    'renato.mendoza@email.com',     @hash, '77710088', 'Cochabamba',  'Activo'),
(91, 'Gissela',  'Paredes Salinas',   'gissela.paredes@email.com',    @hash, '77710089', 'La Paz',      'Activo'),
(92, 'Luis',     'Aguilar Miranda',   'luis.aguilar@email.com',       @hash, '77710090', 'El Alto',     'Activo'),
(93, 'Rocio',    'Medina Campos',     'rocio.medina@email.com',       @hash, '77710091', 'Santa Cruz',  'Activo'),
(94, 'Esteban',  'Vargas Velasco',    'esteban.vargas@email.com',     @hash, '77710092', 'Cochabamba',  'Activo'),
(95, 'Daniela',  'Vallejos Carrasco', 'daniela.vallejos@email.com',   @hash, '77710093', 'Sucre',       'Activo'),
(96, 'Gustavo',  'Rios Padilla',      'gustavo.rios@email.com',       @hash, '77710094', 'Tarija',      'Activo'),
(97, 'Leticia',  'Delgado Cabrera',   'leticia.delgado@email.com',    @hash, '77710095', 'Potosi',      'Activo'),
(98, 'Mauricio', 'Toledo Guzman',     'mauricio.toledo@email.com',    @hash, '77710096', 'Oruro',       'Activo'),
(99, 'Graciela', 'Pena Quiroga',      'graciela.pena@email.com',      @hash, '77710097', 'La Paz',      'Activo'),
(100,'Salvador', 'Saavedra Antezana', 'salvador.saavedra@email.com',  @hash, '77710098', 'Santa Cruz',  'Activo'),
(101,'Irene',    'Urquizo Salinas',   'irene.urquizo@email.com',      @hash, '77710099', 'Cochabamba',  'Activo'),
(102,'Ramiro',   'Balderrama Revilla','ramiro.balderrama@email.com',  @hash, '77710100', 'Trinidad',    'Activo');
INSERT INTO usuarios (id_usuario, nombres, apellidos, email, password_hash, telefono, ubicacion, estado) VALUES
(103,'Olga',     'Montero Barriga',   'olga.montero@email.com',       @hash, '77710101', 'Cobija',      'Activo'),
(104,'Erick',    'Ferrufino Rivas',   'erick.ferrufino@email.com',    @hash, '77710102', 'La Paz',      'Activo'),
(105,'Marisol',  'Garcia Quispe',     'marisol.garcia@email.com',     @hash, '77710103', 'Santa Cruz',  'Activo'),
(106,'Rolando',  'Mamani Lopez',      'rolando.mamani@email.com',     @hash, '77710104', 'Cochabamba',  'Activo'),
(107,'Mirtha',   'Condori Perez',     'mirtha.condori@email.com',     @hash, '77710105', 'Sucre',       'Activo'),
(108,'Aldo',     'Choque Flores',     'aldo.choque@email.com',        @hash, '77710106', 'Tarija',      'Activo'),
(109,'Karen',    'Sanchez Morales',   'karen.sanchez@email.com',      @hash, '77710107', 'Potosi',      'Activo'),
(110,'Wilson',   'Gutierrez Rojas',   'wilson.gutierrez@email.com',   @hash, '77710108', 'Oruro',       'Activo'),
(111,'Yolanda',  'Lopez Suarez',      'yolanda.lopez@email.com',      @hash, '77710109', 'La Paz',      'Activo'),
(112,'Cesar',    'Martinez Romero',   'cesar.martinez@email.com',     @hash, '77710110', 'Santa Cruz',  'Activo'),
(113,'Elsa',     'Rivero Torrez',     'elsa.rivero@email.com',        @hash, '77710111', 'Cochabamba',  'Activo'),
(114,'Humberto', 'Vargas Rojas',      'humberto.vargas@email.com',    @hash, '77710112', 'La Paz',      'Activo'),
(115,'Zulema',   'Cruz Castro',       'zulema.cruz@email.com',        @hash, '77710113', 'El Alto',     'Activo'),
(116,'Teofilo',  'Santos Mendoza',    'teofilo.santos@email.com',     @hash, '77710114', 'Santa Cruz',  'Activo'),
(117,'Noemi',    'Ramos Paredes',     'noemi.ramos@email.com',        @hash, '77710115', 'Cochabamba',  'Activo'),
(118,'Abel',     'Miranda Aguilar',   'abel.miranda@email.com',       @hash, '77710116', 'Sucre',       'Activo'),
(119,'Nadia',    'Medina Salinas',    'nadia.medina@email.com',       @hash, '77710117', 'Tarija',      'Activo'),
(120,'Orlando',  'Campos Vargas',     'orlando.campos@email.com',     @hash, '77710118', 'Potosi',      'Activo'),
(121,'Susana',   'Paredes Vallejos',  'susana.paredes@email.com',     @hash, '77710119', 'Oruro',       'Activo'),
(122,'Armando',  'Carrasco Rios',     'armando.carrasco@email.com',   @hash, '77710120', 'La Paz',      'Activo'),
(123,'Bianca',   'Padilla Delgado',   'bianca.padilla@email.com',     @hash, '77710121', 'Santa Cruz',  'Activo'),
(124,'Ciro',     'Cabrera Toledo',    'ciro.cabrera@email.com',       @hash, '77710122', 'Cochabamba',  'Activo'),
(125,'Dora',     'Guzman Pena',       'dora.guzman@email.com',        @hash, '77710123', 'La Paz',      'Activo'),
(126,'Eugenio',  'Quiroga Saavedra',  'eugenio.quiroga@email.com',    @hash, '77710124', 'El Alto',     'Activo'),
(127,'Flor',     'Antezana Montero',  'flor.antezana@email.com',      @hash, '77710125', 'Santa Cruz',  'Activo'),
(128,'Gilberto', 'Revilla Urquizo',   'gilberto.revilla@email.com',   @hash, '77710126', 'Cochabamba',  'Activo'),
(129,'Herminia', 'Bohorquez Rivas',   'herminia.bohorquez@email.com', @hash, '77710127', 'Sucre',       'Activo'),
(130,'Ignacio',  'Ferrufino Delgado', 'ignacio.ferrufino@email.com',  @hash, '77710128', 'Tarija',      'Activo'),
(131,'Julia',    'Mamani Quispe',     'julia.mamani2@email.com',      @hash, '77710129', 'Potosi',      'Activo'),
(132,'Kevin',    'Condori Choque',    'kevin.condori@email.com',      @hash, '77710130', 'Oruro',       'Activo'),
(133,'Lidia',    'Flores Vargas',     'lidia.flores@email.com',       @hash, '77710131', 'La Paz',      'Activo'),
(134,'Mauro',    'Lopez Morales',     'mauro.lopez@email.com',        @hash, '77710132', 'Santa Cruz',  'Activo'),
(135,'Norma',    'Perez Rojas',       'norma.perez@email.com',        @hash, '77710133', 'Cochabamba',  'Activo'),
(136,'Oscar',    'Garcia Rodriguez',  'oscar.garcia@email.com',       @hash, '77710134', 'La Paz',      'Activo'),
(137,'Perla',    'Martinez Gutierrez','perla.martinez@email.com',     @hash, '77710135', 'El Alto',     'Activo'),
(138,'Ruben',    'Vargas Suarez',     'ruben.vargas@email.com',       @hash, '77710136', 'Santa Cruz',  'Activo'),
(139,'Sasha',    'Rivero Paredes',    'sasha.rivero@email.com',       @hash, '77710137', 'Cochabamba',  'Activo'),
(140,'Tania',    'Salinas Aguilar',   'tania.salinas@email.com',      @hash, '77710138', 'Sucre',       'Activo'),
(141,'Ulises',   'Miranda Ortiz',     'ulises.miranda@email.com',     @hash, '77710139', 'Tarija',      'Activo'),
(142,'Veronica', 'Medina Rios',       'veronica.medina2@email.com',   @hash, '77710140', 'Potosi',      'Activo'),
(143,'Walter',   'Campos Delgado',    'walter.campos@email.com',      @hash, '77710141', 'Oruro',       'Activo'),
(144,'Ximena',   'Cruz Santos',       'ximena.cruz@email.com',        @hash, '77710142', 'La Paz',      'Activo'),
(145,'Yamil',    'Ramos Padilla',     'yamil.ramos@email.com',        @hash, '77710143', 'Santa Cruz',  'Activo'),
(146,'Zara',     'Toledo Guzman',     'zara.toledo@email.com',        @hash, '77710144', 'Cochabamba',  'Activo'),
(147,'Amilcar',  'Pena Quispe',       'amilcar.pena@email.com',       @hash, '77710145', 'La Paz',      'Activo'),
(148,'Brigida',  'Quiroga Morales',   'brigida.quiroga@email.com',    @hash, '77710146', 'El Alto',     'Activo'),
(149,'Clemente', 'Saavedra Antezana', 'clemente.saavedra@email.com',  @hash, '77710147', 'Santa Cruz',  'Activo'),
(150,'Daysi',    'Balderrama Revilla','daysi.balderrama@email.com',   @hash, '77710148', 'Cochabamba',  'Activo'),
(151,'Elio',     'Montero Barriga',   'elio.montero@email.com',       @hash, '77710149', 'Sucre',       'Activo'),
(152,'Susy',     'Ferrufino Rivas',   'susy.ferrufino@email.com',     @hash, '77710150', 'Tarija',      'Activo');
INSERT INTO usuarios (id_usuario, nombres, apellidos, email, password_hash, telefono, ubicacion, estado) VALUES
(153,'Felix',    'Garcia Mamani',     'felix.garcia@email.com',       @hash, '77710151', 'Potosi',      'Activo'),
(154,'Gladys',   'Rodriguez Lopez',   'gladys.rodriguez@email.com',   @hash, '77710152', 'Oruro',       'Activo'),
(155,'Heriberto','Martinez Perez',    'heriberto.martinez@email.com', @hash, '77710153', 'La Paz',      'Activo'),
(156,'Ines',     'Flores Choque',     'ines.flores@email.com',        @hash, '77710154', 'Santa Cruz',  'Activo'),
(157,'Joel',     'Vargas Morales',    'joel.vargas@email.com',        @hash, '77710155', 'Cochabamba',  'Activo'),
(158,'Katia',    'Gutierrez Suarez',  'katia.gutierrez@email.com',    @hash, '77710156', 'La Paz',      'Activo'),
(159,'Leonardo', 'Alvarez Sanchez',   'leonardo.alvarez@email.com',   @hash, '77710157', 'El Alto',     'Activo'),
(160,'Melany',   'Romero Torrez',     'melany.romero@email.com',      @hash, '77710158', 'Santa Cruz',  'Activo'),
(161,'Nelson',   'Rojas Castro',      'nelson.rojas@email.com',       @hash, '77710159', 'Cochabamba',  'Activo'),
(162,'Oriana',   'Ortiz Nunez',       'oriana.ortiz@email.com',       @hash, '77710160', 'Trinidad',    'Activo'),
(163,'Placido',  'Vasquez Cruz',      'placido.vasquez@email.com',    @hash, '77710161', 'Cobija',      'Activo'),
(164,'Queen',    'Santos Ramos',      'queen.santos@email.com',       @hash, '77710162', 'La Paz',      'Activo'),
(165,'Reinaldo', 'Mendoza Rivero',    'reinaldo.mendoza@email.com',   @hash, '77710163', 'Santa Cruz',  'Activo'),
(166,'Sonia',    'Paredes Salinas',   'sonia.paredes@email.com',      @hash, '77710164', 'Cochabamba',  'Activo'),
(167,'Timoteo',  'Aguilar Miranda',   'timoteo.aguilar@email.com',    @hash, '77710165', 'Sucre',       'Activo'),
(168,'Ursula',   'Medina Campos',     'ursula.medina@email.com',      @hash, '77710166', 'Tarija',      'Activo'),
(169,'Valentin', 'Vargas Velasco',    'valentin.vargas@email.com',    @hash, '77710167', 'Potosi',      'Activo'),
(170,'Wendy',    'Vallejos Carrasco', 'wendy.vallejos@email.com',     @hash, '77710168', 'Oruro',       'Activo'),
(171,'Xavier',   'Rios Padilla',      'xavier.rios@email.com',        @hash, '77710169', 'La Paz',      'Activo'),
(172,'Yessica',  'Delgado Cabrera',   'yessica.delgado@email.com',    @hash, '77710170', 'Santa Cruz',  'Activo'),
(173,'Zacarias', 'Toledo Guzman',     'zacarias.toledo@email.com',    @hash, '77710171', 'Cochabamba',  'Activo'),
(174,'Alicia',   'Pena Quiroga',      'alicia.pena@email.com',        @hash, '77710172', 'La Paz',      'Activo'),
(175,'Benjamin', 'Saavedra Antezana', 'benjamin.saavedra@email.com',  @hash, '77710173', 'El Alto',     'Activo'),
(176,'Cintia',   'Urquizo Salinas',   'cintia.urquizo@email.com',     @hash, '77710174', 'Santa Cruz',  'Activo'),
(177,'Dante',    'Balderrama Revilla','dante.balderrama@email.com',   @hash, '77710175', 'Cochabamba',  'Activo'),
(178,'Estela',   'Montero Barriga',   'estela.montero@email.com',     @hash, '77710176', 'Sucre',       'Activo'),
(179,'Flavio',   'Ferrufino Rivas',   'flavio.ferrufino@email.com',   @hash, '77710177', 'Tarija',      'Activo'),
(180,'Georgina', 'Garcia Quispe',     'georgina.garcia@email.com',    @hash, '77710178', 'Potosi',      'Activo'),
(181,'Henry',    'Mamani Lopez',      'henry.mamani@email.com',       @hash, '77710179', 'Oruro',       'Activo'),
(182,'Iris',     'Condori Perez',     'iris.condori@email.com',       @hash, '77710180', 'La Paz',      'Activo'),
(183,'Jairo',    'Choque Flores',     'jairo.choque@email.com',       @hash, '77710181', 'Santa Cruz',  'Activo'),
(184,'Karla',    'Sanchez Morales',   'karla.sanchez@email.com',      @hash, '77710182', 'Cochabamba',  'Activo'),
(185,'Leandro',  'Gutierrez Rojas',   'leandro.gutierrez@email.com',  @hash, '77710183', 'La Paz',      'Activo'),
(186,'Mia',      'Lopez Suarez',      'mia.lopez@email.com',          @hash, '77710184', 'El Alto',     'Activo'),
(187,'Noe',      'Martinez Romero',   'noe.martinez@email.com',       @hash, '77710185', 'Santa Cruz',  'Activo'),
(188,'Olga',     'Rivero Torrez',     'olga.rivero@email.com',        @hash, '77710186', 'Cochabamba',  'Activo'),
(189,'Pascual',  'Vargas Rojas',      'pascual.vargas@email.com',     @hash, '77710187', 'Sucre',       'Activo'),
(190,'Raquel',   'Cruz Castro',       'raquel.cruz@email.com',        @hash, '77710188', 'Tarija',      'Activo'),
(191,'Saul',     'Santos Mendoza',    'saul.santos@email.com',        @hash, '77710189', 'Potosi',      'Activo'),
(192,'Tamara',   'Ramos Paredes',     'tamara.ramos@email.com',       @hash, '77710190', 'Oruro',       'Activo'),
(193,'Ubaldo',   'Miranda Aguilar',   'ubaldo.miranda@email.com',     @hash, '77710191', 'La Paz',      'Activo'),
(194,'Vanina',   'Medina Salinas',    'vanina.medina@email.com',      @hash, '77710192', 'Santa Cruz',  'Activo'),
(195,'Wilfredo', 'Campos Vargas',     'wilfredo.campos@email.com',    @hash, '77710193', 'Cochabamba',  'Activo'),
(196,'Xiomara',  'Paredes Vallejos',  'xiomara.paredes@email.com',    @hash, '77710194', 'La Paz',      'Activo'),
(197,'Yonatan',  'Carrasco Rios',     'yonatan.carrasco@email.com',   @hash, '77710195', 'El Alto',     'Activo'),
(198,'Zoe',      'Padilla Delgado',   'zoe.padilla@email.com',        @hash, '77710196', 'Santa Cruz',  'Activo'),
(199,'Abigail',  'Cabrera Toledo',    'abigail.cabrera@email.com',    @hash, '77710197', 'Cochabamba',  'Activo'),
(200,'Braulio',  'Guzman Pena',       'braulio.guzman@email.com',     @hash, '77710198', 'Sucre',       'Activo'),
(201,'Celeste',  'Quiroga Saavedra',  'celeste.quiroga@email.com',    @hash, '77710199', 'Tarija',      'Activo'),
(202,'Damian',   'Antezana Montero',  'damian.antezana@email.com',    @hash, '77710200', 'Potosi',      'Activo');

-- ============================================================
-- 3. ROLES de usuarios
-- ============================================================
-- Emprendedores (id_rol=2): 50 usuarios
INSERT INTO usuario_roles (id_usuario, id_rol) VALUES
(3,2),(4,2),(5,2),(6,2),(7,2),(10,2),(11,2),(14,2),(15,2),(18,2),
(19,2),(22,2),(23,2),(26,2),(27,2),(30,2),(31,2),(34,2),(35,2),(38,2),
(39,2),(42,2),(43,2),(46,2),(47,2),(50,2),(51,2),(54,2),(55,2),(58,2),
(59,2),(62,2),(63,2),(66,2),(67,2),(70,2),(71,2),(74,2),(75,2),(78,2),
(79,2),(82,2),(83,2),(86,2),(87,2),(90,2),(91,2),(94,2),(95,2),(98,2);

-- Repartidores (id_rol=4): 20 usuarios
INSERT INTO usuario_roles (id_usuario, id_rol) VALUES
(8,4),(9,4),(13,4),(17,4),(21,4),(25,4),(29,4),(33,4),(37,4),(41,4),
(45,4),(49,4),(53,4),(57,4),(61,4),(65,4),(69,4),(73,4),(77,4),(81,4);

-- Clientes (id_rol=3): TODOS los usuarios (excepto admin)
INSERT INTO usuario_roles (id_usuario, id_rol)
SELECT u.id_usuario, 3 FROM usuarios u WHERE u.id_usuario > 2;

-- ============================================================
-- 4. EMPRENDIMIENTOS (40 negocios)
-- ============================================================
INSERT INTO emprendimientos (id_emprendimiento, id_propietario, nombre_comercial, nit, telefono, descripcion, estado) VALUES
(1,  3,  'TecnoMarket LP',        '102938012', '77720001', 'Venta de telefonos, audifonos y accesorios tecnologicos.', 'Aprobado'),
(2,  4,  'Moda Boliviana',        '102938013', '77720002', 'Ropa y accesorios hechos por talento boliviano.', 'Aprobado'),
(3,  5,  'Sabores Crucenos',      '102938014', '77720003', 'Comida tipica cruzena y snacks artesanales.', 'Aprobado'),
(4,  6,  'Hogar y Estilo',        '102938015', '77720004', 'Muebles, decoracion y articulos para el hogar.', 'Aprobado'),
(5,  7,  'Gadget Store',          '102938016', '77720005', 'Tienda de gadgets, cargadores y accesorios.', 'Aprobado'),
(6,  10, 'Belleza Glow',          '102938017', '77720006', 'Maquillaje y productos de cuidado personal.', 'Aprobado'),
(7,  11, 'ElectroHogar',          '102938018', '77720007', 'Electrodomesticos para el hogar con envio a todo Bolivia.', 'Aprobado'),
(8,  14, 'Deportes Bolivia',      '102938019', '77720008', 'Ropa deportiva, calzado y accesorios.', 'Aprobado'),
(9,  15, 'Reposteria Dona Rosa',  '102938020', '77720009', 'Pasteles, tortas y postres artesanales por encargo.', 'Aprobado'),
(10, 18, 'Ferremundo',            '102938021', '77720010', 'Ferreteria con herramientas para construccion y hogar.', 'Aprobado'),
(11, 19, 'Mundo Mascotas',        '102938022', '77720011', 'Alimento, juguetes y accesorios para mascotas.', 'Aprobado'),
(12, 22, 'Libreria El Escritor',  '102938023', '77720012', 'Libros, utiles escolares y material de oficina.', 'Aprobado'),
(13, 23, 'Zapateria Velasco',     '102938024', '77720013', 'Calzado para toda la familia, cuero nacional.', 'Aprobado'),
(14, 26, 'Tienda Natural',        '102938025', '77720014', 'Productos naturales, organicos y sin gluten.', 'Aprobado'),
(15, 27, 'Photo Studio',          '102938026', '77720015', 'Servicios fotograficos, impresion y marcos.', 'Aprobado'),
(16, 30, 'Bebidas del Valle',     '102938027', '77720016', 'Bebidas artesanales, jugos naturales y refrescos.', 'Aprobado'),
(17, 31, 'Rincon del Cafe',       '102938028', '77720017', 'Cafe de especialidad tostado artesanalmente.', 'Aprobado'),
(18, 34, 'Artesanias LP',         '102938029', '77720018', 'Artesania boliviana hecha a mano: tejidos, ceramica, madera.', 'Aprobado'),
(19, 35, 'TecnoWorld SC',         '102938030', '77720019', 'Computadoras, laptops y equipos de oficina.', 'Aprobado'),
(20, 38, 'Moda Juvenil',          '102938031', '77720020', 'Ropa moderna para jovenes, jeans, camisetas y mas.', 'Aprobado'),
(21, 39, 'Salud y Bienestar',     '102938032', '77720021', 'Vitaminas, suplementos y productos de bienestar.', 'Aprobado'),
(22, 42, 'Joyeria Fina',          '102938033', '77720022', 'Joyas de plata, oro y bisuteria fina boliviana.', 'Aprobado'),
(23, 43, 'Cosmetica Natural',     '102938034', '77720023', 'Jabones, cremas y cosmeticos 100% naturales.', 'Aprobado'),
(24, 46, 'Muebles El Arte',       '102938035', '77720024', 'Muebles de madera maciza, rusticos y modernos.', 'Aprobado'),
(25, 47, 'Frutos del Campo',      '102938036', '77720025', 'Fruta fresca, verduras y productos agricolas.', 'Aprobado'),
(26, 50, 'Mundo Fit',             '102938037', '77720026', 'Suplementos deportivos, barras proteicas y accesorios fit.', 'Aprobado'),
(27, 51, 'Jugueteria Bambino',    '102938038', '77720027', 'Juguetes educativos y didacticos para ninos.', 'Aprobado'),
(28, 54, 'Pinturas y Mas',        '102938039', '77720028', 'Pinturas, brochas y materiales para decoracion.', 'Aprobado'),
(29, 55, 'Carniceria Don Pedro',  '102938040', '77720029', 'Carnes frescas de res, cerdo y pollo.', 'Aprobado'),
(30, 58, 'Smart Store',           '102938041', '77720030', 'Celulares inteligentes, tablets y accesorios.', 'Aprobado'),
(31, 59, 'Bordados y Tejidos',    '102938042', '77720031', 'Bordados personalizados, tejidos a mano y ponchos.', 'Aprobado'),
(32, 62, 'Cerveza Artesanal LP',  '102938043', '77720032', 'Cerveza artesanal boliviana de alta calidad.', 'Aprobado'),
(33, 63, 'Panaderia El Trigal',   '102938044', '77720033', 'Pan artesanal, masas, empanadas y galletas.', 'Aprobado'),
(34, 66, 'Muebles Metalicos',     '102938045', '77720034', 'Muebles de metal y hierro forjado.', 'Aprobado'),
(35, 67, 'Tienda Eco',            '102938046', '77720035', 'Productos ecologicos, bolsas reutilizables y compostables.', 'Aprobado'),
(36, 70, 'Audio Profesional',     '102938047', '77720036', 'Equipos de sonido, parlantes y microfonos.', 'Aprobado'),
(37, 71, 'Flores y Ramos',        '102938048', '77720037', 'Arreglos florales, ramos y plantas ornamentales.', 'Aprobado'),
(38, 74, 'Motores SC',            '102938049', '77720038', 'Autopartes, accesorios para auto y moto.', 'Aprobado'),
(39, 75, 'Peluqueria Canina',     '102938050', '77720039', 'Corte, bano y cuidado estetico para mascotas.', 'Aprobado'),
(40, 78, 'Bazar Boliviano',       '102938051', '77720040', 'Articulos variados para hogar, cocina y regalos.', 'Aprobado');

-- ============================================================
-- 5. SUCURSALES (59 sucursales)
-- ============================================================
INSERT INTO sucursales (id_sucursal, id_emprendimiento, nombre_sucursal, direccion, ciudad) VALUES
(1,1,'Casa Matriz','Av. 16 de Julio #1542','La Paz'),
(2,1,'Sucursal El Alto','Calle 3 #120, Zona 16 de Julio','El Alto'),
(3,2,'Tienda Central','Calle Potosi #345','La Paz'),
(4,2,'Sucursal Sopocachi','Av. Sanchez Lima #789','La Paz'),
(5,3,'Local Principal','Av. Cristo Redentor #567','Santa Cruz'),
(6,3,'Sucursal Equipetrol','Calle San Martin #123','Santa Cruz'),
(7,4,'Showroom Cochabamba','Av. Heroinas #890','Cochabamba'),
(8,4,'Sucursal Quillacollo','Plaza Principal #45','Quillacollo'),
(9,5,'Local La Paz','Calle Mercado #234','La Paz'),
(10,5,'Local El Alto','Av. Panoramica #567','El Alto'),
(11,6,'Boutique Central','Av. Ballivian #890','La Paz'),
(12,7,'Tienda Principal','Av. Barrientos #345','Santa Cruz'),
(13,7,'Sucursal Montero','Calle Comercio #123','Montero'),
(14,8,'Local Cochabamba','Av. Ayacucho #678','Cochabamba'),
(15,8,'Sucursal Sacaba','Calle Gral. Perez #90','Sacaba'),
(16,9,'Pasteleria Central','Calle Colon #456','La Paz'),
(17,10,'Ferreteria Principal','Av. Buenos Aires #789','La Paz'),
(18,10,'Sucursal Viacha','Calle Murillo #234','Viacha'),
(19,11,'Tienda La Paz','Calle Sagarnaga #567','La Paz'),
(20,11,'Sucursal Sopocachi','Av. 20 de Octubre #890','La Paz'),
(21,12,'Libreria Central','Av. America #345','Cochabamba'),
(22,13,'Local Sucre','Calle Audiencia #678','Sucre'),
(23,13,'Sucursal Central','Plaza 25 de Mayo #90','Sucre'),
(24,14,'Tienda Central','Calle Linares #123','La Paz'),
(25,15,'Estudio Central','Av. Arce #456','La Paz'),
(26,15,'Sucursal Miraflores','Calle Diaz #789','La Paz'),
(27,16,'Local Principal','Av. Barrientos #234','Cochabamba'),
(28,17,'Cafeteria Central','Calle Ecuador #567','La Paz'),
(29,17,'Sucursal Calacoto','Av. Costanera #890','La Paz'),
(30,18,'Mercado de las Brujas','Calle Jimenez #123','La Paz'),
(31,19,'Local Principal','Av. San Martin #456','Santa Cruz'),
(32,19,'Sucursal 3er Anillo','Av. Cristo Redentor #789','Santa Cruz'),
(33,20,'Tienda Central','Calle 21 de Mayo #234','Santa Cruz'),
(34,21,'Local Central','Av. 16 de Julio #567','La Paz'),
(35,22,'Joyeria Central','Calle Comercio #890','Potosi'),
(36,23,'Tienda Central','Av. America #345','Cochabamba'),
(37,24,'Showroom Principal','Av. Petrolera #678','Santa Cruz'),
(38,24,'Sucursal Warnes','Calle Principal #123','Warnes'),
(39,25,'Puesto Central','Mercado Campesino #456','La Paz'),
(40,26,'Tienda Central','Av. America #789','Cochabamba'),
(41,27,'Local Central','Calle Bolivar #234','La Paz'),
(42,28,'Local Principal','Av. Buenos Aires #567','La Paz'),
(43,29,'Local Central','Mercado Rodriguez #890','La Paz'),
(44,29,'Sucursal Villa Fatima','Av. Las Americas #345','La Paz'),
(45,30,'Local Principal','Av. Irala #678','Santa Cruz'),
(46,30,'Sucursal 4to Anillo','Av. Santos Dumont #123','Santa Cruz'),
(47,31,'Taller Central','Calle Linares #456','La Paz'),
(48,32,'Fabrica y Tienda','Av. Kantutani #789','La Paz'),
(49,33,'Panaderia Central','Av. 6 de Agosto #234','La Paz'),
(50,33,'Sucursal Sopocachi','Calle Guachalla #567','La Paz'),
(51,34,'Taller Principal','Av. Periferica #890','El Alto'),
(52,35,'Tienda Central','Calle 21 #345','Santa Cruz'),
(53,36,'Local Central','Av. Ballivian #678','La Paz'),
(54,37,'Floreria Central','Calle Yanacocha #123','La Paz'),
(55,38,'Local Principal','Av. Grigota #456','Santa Cruz'),
(56,38,'Sucursal Plan 3000','Av. Moscu #789','Santa Cruz'),
(57,39,'Local Central','Av. Kantutani #234','La Paz'),
(58,40,'Bazar Central','Calle Comercio #567','La Paz'),
(59,40,'Sucursal El Alto','Av. 6 de Marzo #890','El Alto');

-- ============================================================
-- 6. PERSONALIZACION de cada emprendimiento
-- ============================================================
INSERT INTO personalizacion_emprendimiento (id_emprendimiento, id_plantilla, color_primario, color_secundario, color_fondo, color_texto, tipografia, modo_oscuro)
SELECT e.id_emprendimiento,
       FLOOR(1 + RAND() * 12),
       CASE FLOOR(RAND() * 6)
           WHEN 0 THEN '#C0392B' WHEN 1 THEN '#2980B9'
           WHEN 2 THEN '#27AE60' WHEN 3 THEN '#8E44AD'
           WHEN 4 THEN '#E67E22' WHEN 5 THEN '#1ABC9C'
       END,
       CASE FLOOR(RAND() * 6)
           WHEN 0 THEN '#2C3E50' WHEN 1 THEN '#34495E'
           WHEN 2 THEN '#1A252F' WHEN 3 THEN '#7F8C8D'
           WHEN 4 THEN '#95A5A6' WHEN 5 THEN '#BDC3C7'
       END,
       '#FDFBF7', '#2D2D2D', 'Inter',
       CASE WHEN RAND() > 0.6 THEN TRUE ELSE FALSE END
FROM emprendimientos e;

-- ============================================================
-- 7. PRODUCTOS (160+)
-- ============================================================
-- Emprendimiento 1: TecnoMarket LP
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(1,1,11,'iPhone 13 128GB','iPhone 13 Apple, pantalla OLED 6.1\", camara dual 12MP, 128GB.', 4500.00, 15, 'Publicado'),
(2,1,11,'Samsung Galaxy S23','Samsung Galaxy S23, pantalla Dynamic AMOLED 6.1\", 256GB.', 4200.00, 20, 'Publicado'),
(3,1,11,'Xiaomi Redmi Note 12','Xiaomi Redmi Note 12, pantalla AMOLED 6.67\", 128GB.', 1800.00, 30, 'Publicado'),
(4,1,13,'Audifonos Sony WH-1000XM5','Audifonos inalambricos Sony con cancelacion de ruido activa.', 2500.00, 10, 'Publicado'),
(5,1,13,'Audifonos JBL Tune 510BT','Audifonos JBL inalambricos, sonido Pure Bass, 40h bateria.', 500.00, 25, 'Publicado'),
(6,1,14,'Cargador Samsung 25W','Cargador Samsung original 25W Super Fast Charging.', 150.00, 50, 'Publicado'),
(7,1,14,'Cargador iPhone 20W','Cargador Apple 20W USB-C con cable Lightning oficial.', 200.00, 40, 'Publicado'),
(8,1,11,'Funda iPhone 13','Funda de silicona para iPhone 13, varios colores.', 80.00, 100, 'Publicado'),
(9,1,11,'Mica iPhone 13','Protector de vidrio templado para iPhone 13 premium.', 40.00, 200, 'Publicado'),
(10,1,13,'Audifonos Xiaomi Buds 3','Audifonos True Wireless Xiaomi, cancelacion de ruido, 28h.', 350.00, 30, 'Publicado');

-- Emprendimiento 2: Moda Boliviana
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(11,2,21,'Chaqueta de Cuero','Chaqueta de cuero genuino para hombre, clasica, tallas S-XXL.', 850.00, 20, 'Publicado'),
(12,2,21,'Camisa Algodon','Camisa manga larga de algodon peruano, colores solidos.', 250.00, 35, 'Publicado'),
(13,2,22,'Vestido Floral','Vestido floral de verano, tela ligera, tallas S-XL.', 320.00, 25, 'Publicado'),
(14,2,22,'Blusa Seda','Blusa de seda natural para mujer, elegante, varios colores.', 400.00, 18, 'Publicado'),
(15,2,23,'Zapatos Cuero Hombre','Zapatos de cuero formal para caballero, suela antideslizante.', 600.00, 15, 'Publicado'),
(16,2,24,'Bufanda Alpaca','Bufanda tejida a mano con lana de alpaca, suave y calida.', 180.00, 40, 'Publicado'),
(17,2,21,'Pantalon Jean','Jeans clasico de corte recto para hombre, denim premium.', 280.00, 30, 'Publicado'),
(18,2,22,'Chompa Lana','Chompa tejida de lana de oveja para mujer, diseno tradicional.', 350.00, 22, 'Publicado');

-- Emprendimiento 3: Sabores Crucenos
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(19,3,31,'Empanadas de Queso (12u)','Docena de empanadas de queso horneadas, masa crujiente.', 60.00, 100, 'Publicado'),
(20,3,31,'Cunape (24u)','Cunapes de queso, paquete de 24 unidades, tipicos crucenos.', 75.00, 80, 'Publicado'),
(21,3,32,'Miel de Cana','Miel de cana natural, botella 500ml, endulzante natural.', 25.00, 60, 'Publicado'),
(22,3,33,'Mani Crocante','Mani crocante con miel, paquete 200g, snack tradicional.', 15.00, 200, 'Publicado'),
(23,3,33,'Galletas de Arroz','Galletas de arroz inflado, paquete 300g, saludables.', 12.00, 150, 'Publicado');

-- Emprendimiento 4: Hogar y Estilo
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(24,4,41,'Sofa 3 Cuerpos','Sofa de 3 cuerpos tapizado en tela premium, color gris.', 3200.00, 5, 'Publicado'),
(25,4,41,'Mesa de Centro','Mesa de centro de madera maciza con cajones, moderno.', 1200.00, 8, 'Publicado'),
(26,4,41,'Estanteria 5 Niveles','Estanteria metalica de 5 niveles, 180x90cm, negro.', 650.00, 10, 'Publicado'),
(27,4,42,'Lampara Colgante','Lampara colgante de vidrio soplado, diseno minimalista.', 350.00, 15, 'Publicado'),
(28,4,43,'Set Ollas Acero','Set de 5 ollas de acero inoxidable con tapa de vidrio.', 800.00, 12, 'Publicado'),
(29,4,43,'Juego Cubiertos 24pz','Juego de cubiertos de acero inoxidable, 24 piezas.', 250.00, 20, 'Publicado');

-- Emprendimiento 5: Gadget Store
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(30,5,14,'Power Bank 20000mAh','Bateria portatil 20000mAh con carga rapida PD 20W.', 250.00, 40, 'Publicado'),
(31,5,14,'Cable USB-C 2m','Cable USB-C a USB-A trenzado, 2 metros, carga rapida.', 35.00, 100, 'Publicado'),
(32,5,13,'Parlante Bluetooth','Parlante portatil Bluetooth 5.0, 20W, resistente al agua.', 300.00, 25, 'Publicado'),
(33,5,14,'Adaptador Corriente','Adaptador universal con 4 puertos USB, 40W total.', 120.00, 50, 'Publicado'),
(34,5,11,'Soporte Celular Auto','Soporte magnetico para celular en auto, ajustable.', 60.00, 80, 'Publicado');
-- Emprendimiento 6: Belleza Glow
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(35,6,51,'Base Liquida 24H','Base de maquillaje liquida de cobertura total, 30ml, 12 tonos.', 120.00, 30, 'Publicado'),
(36,6,51,'Paleta Sombras 12 colores','Paleta de sombras con 12 tonos mate y brillantes.', 150.00, 25, 'Publicado'),
(37,6,52,'Crema Hidratante Facial','Crema hidratante con acido hialuronico, 50ml.', 90.00, 40, 'Publicado'),
(38,6,52,'Protector Solar SPF50','Protector solar facial SPF50+, resistente al agua, 50ml.', 80.00, 50, 'Publicado'),
(39,6,51,'Labial Mate','Labial mate de larga duracion, 6 tonos disponibles.', 45.00, 60, 'Publicado');

-- Emprendimiento 7: ElectroHogar
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(40,7,10,'Refrigerador Samsung','Refrigerador Samsung 300L, No Frost, digital inverter.', 4500.00, 8, 'Publicado'),
(41,7,10,'Lavadora LG','Lavadora LG 18kg, carga frontal, 6 Motion, Smart Diagnosis.', 3800.00, 6, 'Publicado'),
(42,7,10,'Microondas','Microondas 25L con grill, panel digital, 8 programas.', 800.00, 15, 'Publicado'),
(43,7,10,'Licuadora Oster','Licuadora Oster 3 velocidades, vaso de vidrio 1.5L.', 350.00, 20, 'Publicado'),
(44,7,10,'Plancha Tefal','Plancha Tefal a vapor, suela de ceramica, 2400W.', 280.00, 25, 'Publicado');

-- Emprendimiento 8: Deportes Bolivia
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(45,8,21,'Short Deportivo','Short deportivo para hombre, tela dry-fit, tallas S-XXL.', 120.00, 50, 'Publicado'),
(46,8,23,'Zapatillas Running','Zapatillas para running con amortiguacion, suela antideslizante.', 450.00, 30, 'Publicado'),
(47,8,24,'Mochila Deportiva','Mochila deportiva 30L, compartimento para laptop, impermeable.', 250.00, 20, 'Publicado'),
(48,8,21,'Polo Deportivo','Polo deportivo manga corta, tela transpirable.', 100.00, 60, 'Publicado'),
(49,8,24,'Botella Deportiva','Botella deportiva 750ml, acero inoxidable, termica.', 80.00, 100, 'Publicado');

-- Emprendimiento 9: Reposteria Dona Rosa
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(50,9,34,'Torta Tres Leches','Torta tres leches clasica, merengue, 12 porciones.', 150.00, 10, 'Publicado'),
(51,9,34,'Torta de Chocolate','Torta de chocolate belga con ganache, 12 porciones.', 180.00, 8, 'Publicado'),
(52,9,34,'Alfajores de Maicena','Docena de alfajores de maicena con dulce de leche.', 50.00, 30, 'Publicado'),
(53,9,34,'Cupcakes Decorados','6 cupcakes decorados con buttercream, varios sabores.', 80.00, 15, 'Publicado');

-- Emprendimiento 10: Ferremundo
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(54,10,10,'Taladro Percutor','Taladro percutor electrico 650W, 13mm, velocidad variable.', 600.00, 15, 'Publicado'),
(55,10,10,'Juego Llaves Mixtas','Juego de llaves mixtas 10 piezas, acero cromo-vanadio.', 250.00, 20, 'Publicado'),
(56,10,10,'Martillo Carpintero','Martillo de carpintero 450g, mango de goma antideslizante.', 80.00, 40, 'Publicado'),
(57,10,10,'Cinta Metrica 5m','Cinta metrica 5m, carcasa de acero, freno automatico.', 35.00, 60, 'Publicado'),
(58,10,10,'Nivel Laser','Nivel laser cruzado, auto-nivelante, alcance 20m.', 350.00, 10, 'Publicado');

-- Emprendimiento 11: Mundo Mascotas
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(59,11,10,'Alimento Perro 15kg','Alimento balanceado para perro adulto, raza mediana.', 280.00, 30, 'Publicado'),
(60,11,10,'Alimento Gato 7kg','Alimento premium para gato adulto, bolsa 7kg, pollo.', 200.00, 25, 'Publicado'),
(61,11,10,'Juguete Perro','Juguete interactivo para perro, goma resistente.', 45.00, 50, 'Publicado'),
(62,11,10,'Cama Perro Mediana','Cama acolchada para perro mediano, lavable.', 180.00, 15, 'Publicado'),
(63,11,10,'Correa Retractil','Correa retractil para perro, 5m, soporta hasta 25kg.', 90.00, 40, 'Publicado');

-- Emprendimiento 12: Libreria El Escritor
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(64,12,10,'Set Cuadernos 5pz','Set de 5 cuadernos universitarios, 100 hojas, tapa dura.', 80.00, 60, 'Publicado'),
(65,12,10,'Mochila Escolar','Mochila escolar 25L, compartimentos multiples.', 200.00, 20, 'Publicado'),
(66,12,10,'Lapices Colombianas','Caja de 12 lapices grafito HB, triangulares, ergonomicos.', 25.00, 100, 'Publicado'),
(67,12,10,'Juego Geometria','Juego de geometria profesional con compas, 6 piezas.', 35.00, 80, 'Publicado'),
(68,12,10,'Agenda 2026','Agenda 2026, tapa dura, organizador semanal.', 90.00, 40, 'Publicado');

-- Emprendimiento 13: Zapateria Velasco
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(69,13,23,'Zapatos Casual Hombre','Zapatos casual de cuero para hombre, suela de goma.', 380.00, 25, 'Publicado'),
(70,13,23,'Botines Mujer','Botines de cuero para mujer, taco bajo, colores.', 420.00, 18, 'Publicado'),
(71,13,23,'Sandalias Verano','Sandalias de cuero para verano, ajustables.', 150.00, 30, 'Publicado');

-- Emprendimiento 14: Tienda Natural
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(72,14,30,'Quinoa Real 1kg','Quinoa real boliviana organica, bolsa 1kg.', 45.00, 80, 'Publicado'),
(73,14,30,'Chia Organica 500g','Semillas de chia organicas, 500g, ricas en omega-3.', 35.00, 60, 'Publicado'),
(74,14,30,'Amaranto 500g','Amaranto organico boliviano, 500g, fuente de proteina.', 25.00, 70, 'Publicado');

-- Emprendimiento 15: Photo Studio
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(75,15,10,'Marco Photo 20x25','Marco para fotografia 20x25cm, aluminio, vidrio.', 80.00, 40, 'Publicado'),
(76,15,10,'Album 100 Fotos','Album de fotos 100 espacios, tapa dura, proteccion UV.', 120.00, 25, 'Publicado'),
(77,15,10,'Lienzo Impreso 40x60','Lienzo impreso en alta calidad, 40x60cm.', 200.00, 15, 'Publicado');
-- Emprendimiento 16: Bebidas del Valle
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(78,16,32,'Jugo Natural Mango','Jugo natural de mango, 1L, sin conservantes.', 18.00, 100, 'Publicado'),
(79,16,32,'Jugo Natural Naranja','Jugo natural de naranja, 1L, prensado en frio.', 15.00, 100, 'Publicado'),
(80,16,32,'Refresco Gaseosa 2L','Gaseosa artesanal sabor cola, 2L, ingredientes naturales.', 20.00, 80, 'Publicado');

-- Emprendimiento 17: Rincon del Cafe
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(81,17,30,'Cafe Molido 250g','Cafe de especialidad molido, tueste medio, 250g.', 55.00, 50, 'Publicado'),
(82,17,30,'Cafe Grano 500g','Cafe en grano 500g, tueste oscuro, 100% arabica.', 95.00, 30, 'Publicado'),
(83,17,30,'Taza Ceramica','Taza de ceramica con diseno, 300ml, apta microondas.', 45.00, 60, 'Publicado');

-- Emprendimiento 18: Artesanias LP
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(84,18,10,'Poncho Alpaca','Poncho tejido a mano con lana de alpaca, diseno tradicional.', 450.00, 10, 'Publicado'),
(85,18,10,'Aguayo Decorativo','Aguayo boliviano tejido, 1x1.5m, decorativo.', 180.00, 20, 'Publicado'),
(86,18,10,'Ceramica Tipica','Set de 3 piezas de ceramica pintada a mano, colonial.', 150.00, 15, 'Publicado');

-- Emprendimiento 19: TecnoWorld SC
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(87,19,12,'Laptop HP Pavilion','HP Pavilion 15.6\", i5, 8GB RAM, 512GB SSD, Windows 11.', 5200.00, 10, 'Publicado'),
(88,19,12,'Monitor LG 24','Monitor LG 24\" Full HD, IPS, 75Hz, HDMI+VGA.', 1500.00, 15, 'Publicado'),
(89,19,12,'Teclado Mecanico','Teclado mecanico RGB, switches red, layout US.', 350.00, 25, 'Publicado'),
(90,19,11,'Mouse Inalambrico','Mouse inalambrico 2.4GHz, sensor optico, silencioso.', 80.00, 40, 'Publicado'),
(91,19,12,'Disco SSD 1TB','Disco SSD 1TB NVMe M.2, lectura 3500MB/s.', 600.00, 20, 'Publicado');

-- Emprendimiento 20: Moda Juvenil
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(92,20,21,'Camiseta Estampada','Camiseta de algodon con estampado, tallas S-XXL.', 120.00, 50, 'Publicado'),
(93,20,21,'Jean Skinny Hombre','Jean skinny para hombre, stretch, tallas 28-40.', 250.00, 35, 'Publicado'),
(94,20,22,'Top Deportivo','Top deportivo para mujer, tela dry-fit, varios colores.', 90.00, 40, 'Publicado');

-- Emprendimiento 21: Salud y Bienestar
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(95,21,52,'Vitamina C 1000mg','Vitamina C efervescente 1000mg, 30 tabletas.', 60.00, 80, 'Publicado'),
(96,21,52,'Multivitaminico','Multivitaminico completo, 60 capsulas, 15 vitaminas.', 120.00, 50, 'Publicado'),
(97,21,52,'Colageno Hidrolizado','Colageno hidrolizado 300g, sabor neutro, polvo soluble.', 90.00, 40, 'Publicado');

-- Emprendimiento 22: Joyeria Fina
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(98,22,10,'Anillo Plata 925','Anillo de plata 925 con piedra agata, talla ajustable.', 350.00, 15, 'Publicado'),
(99,22,10,'Collar Alpaca','Collar artesanal de alpaca con dije de corazon.', 180.00, 20, 'Publicado'),
(100,22,10,'Pulsera Tejida','Pulsera tejida a mano con hilo encerado y cierre de plata.', 80.00, 40, 'Publicado');

-- Emprendimiento 23: Cosmetica Natural
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(101,23,52,'Jabon Artesanal','Jabon artesanal de avena y miel, 100g, natural.', 25.00, 60, 'Publicado'),
(102,23,52,'Crema Corporal','Crema corporal de coco y manteca de karite, 200ml.', 70.00, 35, 'Publicado'),
(103,23,52,'Aceite Esencial','Aceite esencial de lavanda 100% puro, 15ml.', 60.00, 25, 'Publicado');

-- Emprendimiento 24: Muebles El Arte
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(104,24,41,'Sillon Madera','Sillon de madera cedro con tapizado de lino, clasico.', 2500.00, 5, 'Publicado'),
(105,24,41,'Mesa Comedor 6pz','Mesa de comedor para 6 personas, madera de mara, 1.80m.', 3800.00, 3, 'Publicado'),
(106,24,41,'Cama Queen','Cama queen size con cabecera tapizada, colchon incluido.', 4200.00, 4, 'Publicado');

-- Emprendimiento 25: Frutos del Campo
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(107,25,30,'Manzana Roja 1kg','Manzana roja fresca, kg, directo del valle.', 12.00, 200, 'Publicado'),
(108,25,30,'Papaya x kg','Papaya fresca, kg, dulce y jugosa.', 10.00, 100, 'Publicado'),
(109,25,30,'Durazno 1kg','Durazno fresco de temporada, kg, cosecha local.', 15.00, 80, 'Publicado');

-- Emprendimiento 26: Mundo Fit
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(110,26,10,'Proteina Whey 1kg','Proteina whey isolate 1kg, sabor vainilla, 25g proteina.', 280.00, 20, 'Publicado'),
(111,26,10,'Barra Energetica','Barra energetica de avena y miel, 60g, sin azucar.', 15.00, 100, 'Publicado'),
(112,26,10,'Batidora Shaker','Shaker 700ml con mezclador, libre de BPA.', 45.00, 50, 'Publicado');

-- Emprendimiento 27: Jugueteria Bambino
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(113,27,10,'Bloques Construccion','Set 100 bloques de construccion de madera, colores.', 120.00, 20, 'Publicado'),
(114,27,10,'Muneca Tela','Muneca de tela artesanal, 40cm, ropa removable.', 90.00, 15, 'Publicado'),
(115,27,10,'Carro Madera','Carro de madera con figuras de animales, didactico.', 80.00, 25, 'Publicado');
-- Emprendimiento 28: Pinturas y Mas
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(116,28,10,'Pintura Blanca 4L','Pintura latex blanca, 4L, lavable, mate.', 120.00, 30, 'Publicado'),
(117,28,10,'Brocha 2','Brocha profesional 2\", cerdas sinteticas, mango madera.', 25.00, 50, 'Publicado'),
(118,28,10,'Rodillo 9','Rodillo para pintar 9\" con mango, cubre facil.', 35.00, 40, 'Publicado');

-- Emprendimiento 29: Carniceria Don Pedro
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(119,29,30,'Carne Res x kg','Carne de res premium, kg, cortes especiales.', 60.00, 100, 'Publicado'),
(120,29,30,'Carne Cerdo x kg','Carne de cerdo, kg, pierna y lomo.', 45.00, 80, 'Publicado'),
(121,29,30,'Pollo Entero','Pollo entero fresco, 2.5kg aprox, criado libre.', 55.00, 60, 'Publicado');

-- Emprendimiento 30: Smart Store
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(122,30,11,'Samsung S24 Ultra','Samsung Galaxy S24 Ultra, 512GB, 12GB RAM, S Pen.', 8200.00, 10, 'Publicado'),
(123,30,11,'iPhone 15 Pro Max','iPhone 15 Pro Max 256GB, titanio, camara 48MP.', 9500.00, 8, 'Publicado'),
(124,30,11,'Motorola Edge 40','Motorola Edge 40, 256GB, pantalla OLED 144Hz.', 3200.00, 15, 'Publicado'),
(125,30,14,'Cargador Inalambrico','Cargador inalambrico rapido 15W, compatible.', 180.00, 30, 'Publicado'),
(126,30,14,'Funda Silicona','Funda de silicona para celular, varios modelos.', 60.00, 100, 'Publicado');

-- Emprendimiento 31: Bordados y Tejidos
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(127,31,10,'Chamarra Tejida','Chamarra tejida a mano con lana de alpaca, unico.', 650.00, 8, 'Publicado'),
(128,31,10,'Mantel Bordado','Mantel bordado a mano, 1.5x2m, algodon.', 350.00, 10, 'Publicado'),
(129,31,10,'Gorro Alpaca','Gorro tejido de alpaca con pompon, talla unica.', 80.00, 30, 'Publicado');

-- Emprendimiento 32: Cerveza Artesanal LP
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(130,32,32,'Cerveza Rubia 6pz','Pack 6 botellas de cerveza rubia artesanal, 330ml.', 90.00, 50, 'Publicado'),
(131,32,32,'Cerveza Negra 6pz','Pack 6 botellas de cerveza negra artesanal, 330ml.', 100.00, 40, 'Publicado'),
(132,32,32,'Cerveza IPA 6pz','Pack 6 botellas de cerveza IPA artesanal, 330ml.', 110.00, 30, 'Publicado');

-- Emprendimiento 33: Panaderia El Trigal
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(133,33,34,'Pan de Molde','Pan de molde integral, 500g, horneado fresco.', 18.00, 60, 'Publicado'),
(134,33,34,'Marraqueta (6u)','6 marraquetas crujientes, masa madre.', 12.00, 100, 'Publicado'),
(135,33,34,'Empanada Queso (8u)','8 empanadas de queso, masa hojaldrada.', 40.00, 40, 'Publicado'),
(136,33,34,'Galleta Avena 500g','Galletas de avena y pasas, 500g, caseras.', 25.00, 50, 'Publicado');

-- Emprendimiento 34: Muebles Metalicos
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(137,34,41,'Mesa Ratona Metalica','Mesa ratona de metal forjado con tapa de vidrio.', 900.00, 8, 'Publicado'),
(138,34,41,'Silla Jardin','Silla de jardin metalica pintada electrostatica, 2pz.', 600.00, 10, 'Publicado'),
(139,34,41,'Estante Metalico','Estante metalico 4 niveles, 150x80cm, resistente.', 500.00, 12, 'Publicado');

-- Emprendimiento 35: Tienda Eco
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(140,35,10,'Bolsa Ecologica','Bolsa reutilizable de tela, 40x45cm, resistente.', 15.00, 200, 'Publicado'),
(141,35,10,'Set Cubiertos Bambu','Set de cubiertos de bambu, portatil, 3 piezas.', 35.00, 60, 'Publicado'),
(142,35,10,'Cepillo Dientes Bambu','Cepillo dental de bambu biodegradable, mango natural.', 18.00, 100, 'Publicado');

-- Emprendimiento 36: Audio Profesional
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(143,36,13,'Parlante 200W','Parlante activo 200W, 2 vias, bluetooth, USB, SD.', 1200.00, 8, 'Publicado'),
(144,36,13,'Microfono Inalambrico','Microfono inalambrico UHF, doble canal, 50m.', 800.00, 6, 'Publicado'),
(145,36,13,'Audifonos Diadema','Audifonos diadema profesionales, monitoreo, 40mm.', 350.00, 15, 'Publicado');

-- Emprendimiento 37: Flores y Ramos
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(146,37,10,'Ramo Rosas 12','Ramo de 12 rosas rojas, envueltas, con tarjeta.', 180.00, 20, 'Publicado'),
(147,37,10,'Orquidea Maceta','Orquidea phalaenopsis en maceta decorativa.', 120.00, 15, 'Publicado'),
(148,37,10,'Planta Suculenta','Set de 3 suculentas en macetas de barro.', 60.00, 30, 'Publicado');

-- Emprendimiento 38: Motores SC
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(149,38,10,'Aceite Motor 5W30','Aceite para motor 5W30, 1L, sintetico.', 60.00, 40, 'Publicado'),
(150,38,10,'Bateria Auto 12V','Bateria para auto 12V 60Ah, libre mantenimiento.', 650.00, 15, 'Publicado'),
(151,38,10,'Limpiabrisas 1L','Liquido limpiabrisas concentrado, 1L.', 20.00, 80, 'Publicado'),
(152,38,10,'Cubierta Auto','Cubierta para auto universal, poliester, UV.', 350.00, 10, 'Publicado');

-- Emprendimiento 39: Peluqueria Canina
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(153,39,10,'Shampoo Canino','Shampoo especial para perro, pH neutro, 500ml.', 45.00, 30, 'Publicado');

-- Emprendimiento 40: Bazar Boliviano
INSERT INTO productos (id_producto, id_emprendimiento, id_categoria, nombre, descripcion_larga, precio_base, stock, estado) VALUES
(154,40,43,'Set Vasos 6pz','Set de 6 vasos de vidrio 300ml, resistentes.', 60.00, 40, 'Publicado'),
(155,40,43,'Plato Llano 12pz','Set 12 platos llanos de ceramica, 25cm, blancos.', 150.00, 20, 'Publicado'),
(156,40,43,'Taza Desayuno 6pz','Set 6 tazas de desayuno con platillo, porcelana.', 120.00, 25, 'Publicado'),
(157,40,10,'Portarretratos 4x6','Portarretratos de madera 4x6\", colores variados.', 25.00, 60, 'Publicado');

-- ============================================================
-- 8. VARIANTES DE PRODUCTO
-- ============================================================
INSERT INTO variantes_producto (id_variante, id_producto, sku, atributo_1, valor_1, atributo_2, valor_2, precio_adicional) VALUES
(1,1,'IP13-BLK','Color','Negro',NULL,NULL,0.00),
(2,1,'IP13-WHT','Color','Blanco',NULL,NULL,0.00),
(3,1,'IP13-BLU','Color','Azul',NULL,NULL,0.00),
(4,3,'RN12-BLK','Color','Negro',NULL,NULL,0.00),
(5,3,'RN12-BLU','Color','Azul',NULL,NULL,0.00),
(6,8,'F13-SIL','Color','Transparente',NULL,NULL,0.00),
(7,8,'F13-BLK','Color','Negro',NULL,NULL,0.00),
(8,8,'F13-RED','Color','Rojo',NULL,NULL,0.00),
(9,17,'JN28-32','Talle','28',NULL,NULL,0.00),
(10,17,'JN30-32','Talle','30',NULL,NULL,0.00),
(11,17,'JN32-32','Talle','32',NULL,NULL,0.00),
(12,17,'JN34-32','Talle','34',NULL,NULL,0.00),
(13,92,'CAM-S','Talle','S',NULL,NULL,0.00),
(14,92,'CAM-M','Talle','M',NULL,NULL,0.00),
(15,92,'CAM-L','Talle','L',NULL,NULL,0.00),
(16,92,'CAM-XL','Talle','XL',NULL,NULL,0.00),
(17,35,'BASE-M','Tono','Medio',NULL,NULL,0.00),
(18,35,'BASE-O','Tono','Oscuro',NULL,NULL,0.00),
(19,35,'BASE-C','Tono','Claro',NULL,NULL,0.00),
(20,39,'LAB-R','Tono','Rojo',NULL,NULL,0.00),
(21,39,'LAB-P','Tono','Rosa',NULL,NULL,0.00),
(22,39,'LAB-M','Tono','Marsala',NULL,NULL,0.00);

-- ============================================================
-- 9. INVENTARIO (stock por variante y sucursal)
-- ============================================================
INSERT INTO inventario (id_variante, id_sucursal, cantidad_actual, alerta_minima) VALUES
(1,1,30,5),(1,2,20,5),(2,1,25,5),(2,2,15,5),(3,1,15,5),(3,2,10,5),
(4,1,40,5),(4,2,25,5),(5,1,35,5),(5,2,20,5),
(6,1,80,10),(6,2,50,10),(7,1,60,10),(7,2,40,10),(8,1,45,10),(8,2,30,10),
(9,3,12,3),(10,3,18,3),(11,3,15,3),(12,3,10,3),
(13,33,35,5),(14,33,40,5),(15,33,30,5),(16,33,20,5),
(17,11,20,5),(18,11,15,5),(19,11,25,5),
(20,11,30,5),(21,11,25,5),(22,11,20,5);

-- ============================================================
-- 10. REACTIVAR FOREIGN KEYS
-- ============================================================
SET FOREIGN_KEY_CHECKS = 1;

SELECT CONCAT('INSERCION COMPLETA: 200 usuarios, 40 emprendimientos, 59 sucursales, ', COUNT(*), ' productos insertados.') AS resultado FROM productos;
