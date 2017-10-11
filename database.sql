CREATE TABLE coctel (
    cc_codigo bigint NOT NULL,
    cc_direccion character varying(100),
    cc_fecha timestamp without time zone,
    rd_codigo bigint NOT NULL
);


ALTER TABLE coctel OWNER TO postgres;

--
-- Name: comuna; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comuna (
    co_codigo integer NOT NULL,
    co_nombre character varying(100),
    re_codigo integer NOT NULL
);


ALTER TABLE comuna OWNER TO postgres;

--
-- Name: costos_operativos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE costos_operativos (
    ct_codigo integer NOT NULL,
    ct_nombre character varying(256),
    ct_unitario integer,
    ct_adicional integer,
    ct_subtotal integer,
    ct_detalle character varying(256),
    ct_cantidad smallint,
    ct_porcentaje smallint,
    pr_codigo integer
);


ALTER TABLE costos_operativos OWNER TO postgres;

--
-- Name: cronograma; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cronograma (
    cr_codigo bigint NOT NULL,
    cr_fecha date,
    cr_hora_inicio_d time without time zone,
    cr_hora_fin_d time without time zone,
    cr_hora_inicio_t time without time zone,
    cr_hora_fin_t time without time zone,
    cr_obs text,
    ef_codigo bigint NOT NULL
);


ALTER TABLE cronograma OWNER TO postgres;

--
-- Name: curso; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE curso (
    cu_codigo integer NOT NULL,
    cu_nombre character varying(256),
    cu_fecha_emision date,
    cu_fecha_vencimiento date,
    cu_horas smallint,
    cu_alumnos smallint,
    cu_sence integer,
    cu_valor_alumno integer
);


ALTER TABLE curso OWNER TO postgres;

--
-- Name: empresa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE empresa (
    em_codigo integer NOT NULL,
    em_rut character varying(12),
    em_razon_social character varying(256),
    em_direccion character varying(256),
    em_email character varying(100),
    gi_codigo integer NOT NULL,
    co_codigo integer NOT NULL
);


ALTER TABLE empresa OWNER TO postgres;

--
-- Name: empresa_estudio; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE empresa_estudio (
    ef_codigo bigint NOT NULL,
    em_codigo integer NOT NULL
);


ALTER TABLE empresa_estudio OWNER TO postgres;

--
-- Name: estudio_factibilidad; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE estudio_factibilidad (
    ef_codigo bigint NOT NULL,
    ef_fecha_emision date,
    ef_nombre_diploma character varying(100),
    ef_direccion_realizacion character varying(100),
    ef_fecha_inicio date,
    ef_fecha_termino date,
    ef_obs text,
    tm_codigo integer NOT NULL,
    cu_codigo integer NOT NULL,
    tc_codigo integer NOT NULL,
    us_codigo integer NOT NULL,
    ef_estado boolean,
    ef_visado boolean,
    su_codigo integer
);


ALTER TABLE estudio_factibilidad OWNER TO postgres;

--
-- Name: giro; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE giro (
    gi_codigo integer NOT NULL,
    gi_nombre character varying(100)
);


ALTER TABLE giro OWNER TO postgres;

--
-- Name: perfil; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE perfil (
    pe_codigo integer NOT NULL,
    pe_nombre character varying(50)
);


ALTER TABLE perfil OWNER TO postgres;

--
-- Name: presupuesto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE presupuesto (
    pr_codigo integer NOT NULL,
    pr_ingreso_ventas integer,
    pr_costos_directos integer,
    pr_costos_fijos integer,
    pr_comision_asesor integer,
    pr_utilidad_bruta integer,
    pr_utilidad_bruta_porcentaje integer,
    pr_valor_hora_relator integer,
    pr_beneficio_neto integer,
    pr_costos_fijos_porcentaje integer,
    pr_comision_asesor_porcentaje integer,
    ef_codigo integer
);


ALTER TABLE presupuesto OWNER TO postgres;

--
-- Name: region; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE region (
    re_codigo integer NOT NULL,
    re_nombre character varying(100),
    re_orden integer
);


ALTER TABLE region OWNER TO postgres;

--
-- Name: relatores; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE relatores (
    ra_codigo bigint NOT NULL,
    us_codigo integer NOT NULL
);


ALTER TABLE relatores OWNER TO postgres;

--
-- Name: requerimiento_academico; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE requerimiento_academico (
    ra_codigo bigint NOT NULL,
    ra_obs text,
    ra_respuesta text,
    ef_codigo bigint NOT NULL
);


ALTER TABLE requerimiento_academico OWNER TO postgres;

--
-- Name: requerimiento_adquisicion; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE requerimiento_adquisicion (
    rd_codigo bigint NOT NULL,
    rd_obs text,
    rd_respuesta text,
    ef_codigo bigint NOT NULL
);


ALTER TABLE requerimiento_adquisicion OWNER TO postgres;

--
-- Name: requerimiento_tecnico; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE requerimiento_tecnico (
    rt_codigo bigint NOT NULL,
    rt_obs text,
    rt_respuesta text,
    rt_computadores boolean,
    rt_proyector boolean,
    rt_pizarra boolean,
    rt_arriendo boolean,
    rt_sala smallint,
    rt_vb boolean,
    ef_codigo bigint NOT NULL
);


ALTER TABLE requerimiento_tecnico OWNER TO postgres;

--
-- Name: sucursal; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sucursal (
    su_codigo integer NOT NULL,
    su_nombre character varying(50)
);


ALTER TABLE sucursal OWNER TO postgres;

--
-- Name: tipo_curso; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_curso (
    tc_codigo integer NOT NULL,
    tc_nombre character varying(100)
);


ALTER TABLE tipo_curso OWNER TO postgres;

--
-- Name: tipo_manual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_manual (
    tm_codigo integer NOT NULL,
    tm_nombre character varying(100)
);


ALTER TABLE tipo_manual OWNER TO postgres;

--
-- Name: usuario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuario (
    us_codigo integer NOT NULL,
    us_rut character varying(12),
    us_nombres character varying(100),
    us_apellido_paterno character varying(100),
    us_apellido_materno character varying(100),
    pe_codigo integer NOT NULL,
    su_codigo integer NOT NULL,
    co_codigo integer NOT NULL,
    us_password character varying(256),
    us_estado boolean,
    us_email character varying(100)
);


ALTER TABLE usuario OWNER TO postgres;

--
-- Data for Name: coctel; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO coctel VALUES (1, '', '2065-05-20 17:00:00', 1);


--
-- Data for Name: comuna; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO comuna VALUES (1, 'Iquique', 1);
INSERT INTO comuna VALUES (2, 'Alto Hospicio', 1);
INSERT INTO comuna VALUES (3, 'Pozo Almonte', 1);
INSERT INTO comuna VALUES (4, 'Camiña', 1);
INSERT INTO comuna VALUES (5, 'Colchane', 1);
INSERT INTO comuna VALUES (6, 'Huara', 1);
INSERT INTO comuna VALUES (7, 'Pica', 1);
INSERT INTO comuna VALUES (8, 'Antofagasta', 2);
INSERT INTO comuna VALUES (9, 'Mejillones', 2);
INSERT INTO comuna VALUES (10, 'Sierra Gorda', 2);
INSERT INTO comuna VALUES (11, 'Taltal', 2);
INSERT INTO comuna VALUES (12, 'Calama', 2);
INSERT INTO comuna VALUES (13, 'Ollague', 2);
INSERT INTO comuna VALUES (14, 'San Pedro de Atacama', 2);
INSERT INTO comuna VALUES (15, 'Tocopilla', 2);
INSERT INTO comuna VALUES (16, 'María Elena', 2);
INSERT INTO comuna VALUES (17, 'Copiapó', 3);
INSERT INTO comuna VALUES (18, 'Caldera', 3);
INSERT INTO comuna VALUES (19, 'Tierra Amarilla', 3);
INSERT INTO comuna VALUES (20, 'Chañaral', 3);
INSERT INTO comuna VALUES (21, 'Diego de Almagro', 3);
INSERT INTO comuna VALUES (22, 'Vallenar', 3);
INSERT INTO comuna VALUES (23, 'Alto del Carmen', 3);
INSERT INTO comuna VALUES (24, 'Freirina', 3);
INSERT INTO comuna VALUES (25, 'Huasco', 3);
INSERT INTO comuna VALUES (26, 'La Serena', 4);
INSERT INTO comuna VALUES (27, 'Coquimbo', 4);
INSERT INTO comuna VALUES (28, 'Andacollo', 4);
INSERT INTO comuna VALUES (29, 'La Higuera', 4);
INSERT INTO comuna VALUES (30, 'Paihuano', 4);
INSERT INTO comuna VALUES (31, 'Vicuña', 4);
INSERT INTO comuna VALUES (32, 'Illapel', 4);
INSERT INTO comuna VALUES (33, 'Canela', 4);
INSERT INTO comuna VALUES (34, 'Los Vilos', 4);
INSERT INTO comuna VALUES (35, 'Salamanca', 4);
INSERT INTO comuna VALUES (36, 'Ovalle', 4);
INSERT INTO comuna VALUES (37, 'Combarbalá', 4);
INSERT INTO comuna VALUES (38, 'Monte Patria', 4);
INSERT INTO comuna VALUES (39, 'Punitaqui', 4);
INSERT INTO comuna VALUES (40, 'Río Hurtado', 4);
INSERT INTO comuna VALUES (41, 'Valparaíso', 5);
INSERT INTO comuna VALUES (42, 'Casablanca', 5);
INSERT INTO comuna VALUES (43, 'Concón', 5);
INSERT INTO comuna VALUES (44, 'Juan Fernández', 5);
INSERT INTO comuna VALUES (45, 'Puchuncaví', 5);
INSERT INTO comuna VALUES (46, 'Quilpué', 5);
INSERT INTO comuna VALUES (47, 'Quintero', 5);
INSERT INTO comuna VALUES (48, 'Villa Alemana', 5);
INSERT INTO comuna VALUES (49, 'Viña del Mar', 5);
INSERT INTO comuna VALUES (50, 'Isla de Pascua', 5);
INSERT INTO comuna VALUES (51, 'Los Andes', 5);
INSERT INTO comuna VALUES (52, 'Calle Larga', 5);
INSERT INTO comuna VALUES (53, 'Rinconada', 5);
INSERT INTO comuna VALUES (54, 'San Esteban', 5);
INSERT INTO comuna VALUES (55, 'La Ligua', 5);
INSERT INTO comuna VALUES (56, 'Cabildo', 5);
INSERT INTO comuna VALUES (57, 'Papudo', 5);
INSERT INTO comuna VALUES (58, 'Petorca', 5);
INSERT INTO comuna VALUES (59, 'Zapallar', 5);
INSERT INTO comuna VALUES (60, 'Quillota', 5);
INSERT INTO comuna VALUES (61, 'Calera', 5);
INSERT INTO comuna VALUES (62, 'Hijuelas', 5);
INSERT INTO comuna VALUES (63, 'La Cruz', 5);
INSERT INTO comuna VALUES (64, 'Limache', 5);
INSERT INTO comuna VALUES (65, 'Nogales', 5);
INSERT INTO comuna VALUES (66, 'Olmué', 5);
INSERT INTO comuna VALUES (67, 'San Antonio', 5);
INSERT INTO comuna VALUES (68, 'Algarrobo', 5);
INSERT INTO comuna VALUES (69, 'Cartagena', 5);
INSERT INTO comuna VALUES (70, 'El Quisco', 5);
INSERT INTO comuna VALUES (71, 'El Tabo', 5);
INSERT INTO comuna VALUES (72, 'Santo Domingo', 5);
INSERT INTO comuna VALUES (73, 'San Felipe', 5);
INSERT INTO comuna VALUES (74, 'Catemu', 5);
INSERT INTO comuna VALUES (75, 'Llay Llay', 5);
INSERT INTO comuna VALUES (76, 'Panquehue', 5);
INSERT INTO comuna VALUES (77, 'Putaendo', 5);
INSERT INTO comuna VALUES (78, 'Santa María', 5);
INSERT INTO comuna VALUES (79, 'Rancagua', 6);
INSERT INTO comuna VALUES (80, 'Codegua', 6);
INSERT INTO comuna VALUES (81, 'Coinco', 6);
INSERT INTO comuna VALUES (82, 'Coltauco', 6);
INSERT INTO comuna VALUES (83, 'Doñihue', 6);
INSERT INTO comuna VALUES (84, 'Graneros', 6);
INSERT INTO comuna VALUES (85, 'Las Cabras', 6);
INSERT INTO comuna VALUES (86, 'Machalí', 6);
INSERT INTO comuna VALUES (87, 'Malloa', 6);
INSERT INTO comuna VALUES (88, 'Mostazal', 6);
INSERT INTO comuna VALUES (89, 'Olivar', 6);
INSERT INTO comuna VALUES (90, 'Peumo', 6);
INSERT INTO comuna VALUES (91, 'Pichidegua', 6);
INSERT INTO comuna VALUES (92, 'Quinta de Tilcoco', 6);
INSERT INTO comuna VALUES (93, 'Rengo', 6);
INSERT INTO comuna VALUES (94, 'Requinoa', 6);
INSERT INTO comuna VALUES (95, 'San Vicente', 6);
INSERT INTO comuna VALUES (96, 'Pichilemu', 6);
INSERT INTO comuna VALUES (97, 'La Estrella', 6);
INSERT INTO comuna VALUES (98, 'Litueche', 6);
INSERT INTO comuna VALUES (99, 'Marchihue', 6);
INSERT INTO comuna VALUES (100, 'Navidad', 6);
INSERT INTO comuna VALUES (101, 'Paredones', 6);
INSERT INTO comuna VALUES (102, 'San Fernando', 6);
INSERT INTO comuna VALUES (103, 'Chépica', 6);
INSERT INTO comuna VALUES (104, 'Chimbarongo', 6);
INSERT INTO comuna VALUES (105, 'Lolol', 6);
INSERT INTO comuna VALUES (106, 'Nancagua', 6);
INSERT INTO comuna VALUES (107, 'Palmilla', 6);
INSERT INTO comuna VALUES (108, 'Peralillo', 6);
INSERT INTO comuna VALUES (109, 'Placilla', 6);
INSERT INTO comuna VALUES (110, 'Pumanque', 6);
INSERT INTO comuna VALUES (111, 'Santa Cruz', 6);
INSERT INTO comuna VALUES (112, 'Talca', 7);
INSERT INTO comuna VALUES (113, 'Constitución', 7);
INSERT INTO comuna VALUES (114, 'Curepto', 7);
INSERT INTO comuna VALUES (115, 'Empedrado', 7);
INSERT INTO comuna VALUES (116, 'Maule', 7);
INSERT INTO comuna VALUES (117, 'Pelarco', 7);
INSERT INTO comuna VALUES (118, 'Pencahue', 7);
INSERT INTO comuna VALUES (119, 'Río Claro', 7);
INSERT INTO comuna VALUES (120, 'San Clemente', 7);
INSERT INTO comuna VALUES (121, 'San Rafael', 7);
INSERT INTO comuna VALUES (122, 'Cauquenes', 7);
INSERT INTO comuna VALUES (123, 'Chanco', 7);
INSERT INTO comuna VALUES (124, 'Pelluhue', 7);
INSERT INTO comuna VALUES (125, 'Curicó', 7);
INSERT INTO comuna VALUES (126, 'Hualañé', 7);
INSERT INTO comuna VALUES (127, 'Licantén', 7);
INSERT INTO comuna VALUES (128, 'Molina', 7);
INSERT INTO comuna VALUES (129, 'Rauco', 7);
INSERT INTO comuna VALUES (130, 'Romeral', 7);
INSERT INTO comuna VALUES (131, 'Sagrada Familia', 7);
INSERT INTO comuna VALUES (132, 'Teno', 7);
INSERT INTO comuna VALUES (133, 'Vichuquén', 7);
INSERT INTO comuna VALUES (134, 'Linares', 7);
INSERT INTO comuna VALUES (135, 'Colbún', 7);
INSERT INTO comuna VALUES (136, 'Longaví', 7);
INSERT INTO comuna VALUES (137, 'Parral', 7);
INSERT INTO comuna VALUES (138, 'Retiro', 7);
INSERT INTO comuna VALUES (139, 'San Javier', 7);
INSERT INTO comuna VALUES (140, 'Villa Alegre', 7);
INSERT INTO comuna VALUES (141, 'Yerbas Buenas', 7);
INSERT INTO comuna VALUES (142, 'Concepción', 8);
INSERT INTO comuna VALUES (143, 'Coronel', 8);
INSERT INTO comuna VALUES (144, 'Chiguayante', 8);
INSERT INTO comuna VALUES (145, 'Florida', 8);
INSERT INTO comuna VALUES (146, 'Hualqui', 8);
INSERT INTO comuna VALUES (147, 'Lota', 8);
INSERT INTO comuna VALUES (148, 'Penco', 8);
INSERT INTO comuna VALUES (149, 'San Pedro De La Paz', 8);
INSERT INTO comuna VALUES (150, 'Santa Juana', 8);
INSERT INTO comuna VALUES (151, 'Talcahuano', 8);
INSERT INTO comuna VALUES (152, 'Tomé', 8);
INSERT INTO comuna VALUES (153, 'Hualpén', 8);
INSERT INTO comuna VALUES (154, 'Lebu', 8);
INSERT INTO comuna VALUES (155, 'Arauco', 8);
INSERT INTO comuna VALUES (156, 'Cañete', 8);
INSERT INTO comuna VALUES (157, 'Contulmo', 8);
INSERT INTO comuna VALUES (158, 'Curanilahue', 8);
INSERT INTO comuna VALUES (159, 'Los Alamos', 8);
INSERT INTO comuna VALUES (160, 'Tirua', 8);
INSERT INTO comuna VALUES (161, 'Los Angeles', 8);
INSERT INTO comuna VALUES (162, 'Antuco', 8);
INSERT INTO comuna VALUES (163, 'Cabrero', 8);
INSERT INTO comuna VALUES (164, 'Laja', 8);
INSERT INTO comuna VALUES (165, 'Mulchén', 8);
INSERT INTO comuna VALUES (166, 'Nacimiento', 8);
INSERT INTO comuna VALUES (167, 'Negrete', 8);
INSERT INTO comuna VALUES (168, 'Quilaco', 8);
INSERT INTO comuna VALUES (169, 'Quilleco', 8);
INSERT INTO comuna VALUES (170, 'San Rosendo', 8);
INSERT INTO comuna VALUES (171, 'Santa Bárbara', 8);
INSERT INTO comuna VALUES (172, 'Tucapel', 8);
INSERT INTO comuna VALUES (173, 'Yumbel', 8);
INSERT INTO comuna VALUES (174, 'Alto Biobío', 8);
INSERT INTO comuna VALUES (175, 'Chillán', 8);
INSERT INTO comuna VALUES (176, 'Bulnes', 8);
INSERT INTO comuna VALUES (177, 'Cobquecura', 8);
INSERT INTO comuna VALUES (178, 'Coelemu', 8);
INSERT INTO comuna VALUES (179, 'Coihueco', 8);
INSERT INTO comuna VALUES (180, 'Chillán Viejo', 8);
INSERT INTO comuna VALUES (181, 'El Carmen', 8);
INSERT INTO comuna VALUES (182, 'Ninhue', 8);
INSERT INTO comuna VALUES (183, 'Ñiquén', 8);
INSERT INTO comuna VALUES (184, 'Pemuco', 8);
INSERT INTO comuna VALUES (185, 'Pinto', 8);
INSERT INTO comuna VALUES (186, 'Portezuelo', 8);
INSERT INTO comuna VALUES (187, 'Quillón', 8);
INSERT INTO comuna VALUES (188, 'Quirihue', 8);
INSERT INTO comuna VALUES (189, 'Ranquil', 8);
INSERT INTO comuna VALUES (190, 'San Carlos', 8);
INSERT INTO comuna VALUES (191, 'San Fabián', 8);
INSERT INTO comuna VALUES (192, 'San Ignacio', 8);
INSERT INTO comuna VALUES (193, 'San Nicolás', 8);
INSERT INTO comuna VALUES (194, 'Trehuaco', 8);
INSERT INTO comuna VALUES (195, 'Yungay', 8);
INSERT INTO comuna VALUES (196, 'Temuco', 9);
INSERT INTO comuna VALUES (197, 'Carahue', 9);
INSERT INTO comuna VALUES (198, 'Cunco', 9);
INSERT INTO comuna VALUES (199, 'Curarrehue', 9);
INSERT INTO comuna VALUES (200, 'Freire', 9);
INSERT INTO comuna VALUES (201, 'Galvarino', 9);
INSERT INTO comuna VALUES (202, 'Gorbea', 9);
INSERT INTO comuna VALUES (203, 'Lautaro', 9);
INSERT INTO comuna VALUES (204, 'Loncoche', 9);
INSERT INTO comuna VALUES (205, 'Melipeuco', 9);
INSERT INTO comuna VALUES (206, 'Nueva Imperial', 9);
INSERT INTO comuna VALUES (207, 'Padre Las Casas', 9);
INSERT INTO comuna VALUES (208, 'Perquenco', 9);
INSERT INTO comuna VALUES (209, 'Pitrufquén', 9);
INSERT INTO comuna VALUES (210, 'Pucón', 9);
INSERT INTO comuna VALUES (211, 'Saavedra', 9);
INSERT INTO comuna VALUES (212, 'Teodoro Schmidt', 9);
INSERT INTO comuna VALUES (213, 'Toltén', 9);
INSERT INTO comuna VALUES (214, 'Vilcún', 9);
INSERT INTO comuna VALUES (215, 'Villarrica', 9);
INSERT INTO comuna VALUES (216, 'Cholchol', 9);
INSERT INTO comuna VALUES (217, 'Angol', 9);
INSERT INTO comuna VALUES (218, 'Collipulli', 9);
INSERT INTO comuna VALUES (219, 'Curacautín', 9);
INSERT INTO comuna VALUES (220, 'Ercilla', 9);
INSERT INTO comuna VALUES (221, 'Lonquimay', 9);
INSERT INTO comuna VALUES (222, 'Los Sauces', 9);
INSERT INTO comuna VALUES (223, 'Lumaco', 9);
INSERT INTO comuna VALUES (224, 'Purén', 9);
INSERT INTO comuna VALUES (225, 'Renaico', 9);
INSERT INTO comuna VALUES (226, 'Traiguén', 9);
INSERT INTO comuna VALUES (227, 'Victoria', 9);
INSERT INTO comuna VALUES (228, 'Puerto Montt', 10);
INSERT INTO comuna VALUES (229, 'Calbuco', 10);
INSERT INTO comuna VALUES (230, 'Cochamó', 10);
INSERT INTO comuna VALUES (231, 'Fresia', 10);
INSERT INTO comuna VALUES (232, 'Frutillar', 10);
INSERT INTO comuna VALUES (233, 'Los Muermos', 10);
INSERT INTO comuna VALUES (234, 'Llanquihue', 10);
INSERT INTO comuna VALUES (235, 'Maullín', 10);
INSERT INTO comuna VALUES (236, 'Puerto Varas', 10);
INSERT INTO comuna VALUES (237, 'Castro', 10);
INSERT INTO comuna VALUES (238, 'Ancud', 10);
INSERT INTO comuna VALUES (239, 'Chonchi', 10);
INSERT INTO comuna VALUES (240, 'Curaco de Vélez', 10);
INSERT INTO comuna VALUES (241, 'Dalcahue', 10);
INSERT INTO comuna VALUES (242, 'Puqueldón', 10);
INSERT INTO comuna VALUES (243, 'Queilén', 10);
INSERT INTO comuna VALUES (244, 'Quellón', 10);
INSERT INTO comuna VALUES (245, 'Quemchi', 10);
INSERT INTO comuna VALUES (246, 'Quinchao', 10);
INSERT INTO comuna VALUES (247, 'Osorno', 10);
INSERT INTO comuna VALUES (248, 'Puerto Octay', 10);
INSERT INTO comuna VALUES (249, 'Purranque', 10);
INSERT INTO comuna VALUES (250, 'Puyehue', 10);
INSERT INTO comuna VALUES (251, 'Río Negro', 10);
INSERT INTO comuna VALUES (252, 'San Juan de la Costa', 10);
INSERT INTO comuna VALUES (253, 'San Pablo', 10);
INSERT INTO comuna VALUES (254, 'Chaitén', 10);
INSERT INTO comuna VALUES (255, 'Futaleufú', 10);
INSERT INTO comuna VALUES (256, 'Hualaihue', 10);
INSERT INTO comuna VALUES (257, 'Palena', 10);
INSERT INTO comuna VALUES (258, 'Coihaique', 11);
INSERT INTO comuna VALUES (259, 'Lago Verde', 11);
INSERT INTO comuna VALUES (260, 'Puerto Aysén', 11);
INSERT INTO comuna VALUES (261, 'Cisnes', 11);
INSERT INTO comuna VALUES (262, 'Guaitecas', 11);
INSERT INTO comuna VALUES (263, 'Cochrane', 11);
INSERT INTO comuna VALUES (264, 'Ohiggins', 11);
INSERT INTO comuna VALUES (265, 'Tortel', 11);
INSERT INTO comuna VALUES (266, 'Chile Chico', 11);
INSERT INTO comuna VALUES (267, 'Río Ibáñez', 11);
INSERT INTO comuna VALUES (268, 'Punta Arenas', 12);
INSERT INTO comuna VALUES (269, 'Laguna Blanca', 12);
INSERT INTO comuna VALUES (270, 'Río Verde', 12);
INSERT INTO comuna VALUES (271, 'San Gregorio', 12);
INSERT INTO comuna VALUES (272, 'Cabo de Hornos', 12);
INSERT INTO comuna VALUES (273, 'Porvenir', 12);
INSERT INTO comuna VALUES (274, 'Primavera', 12);
INSERT INTO comuna VALUES (275, 'Timaukel', 12);
INSERT INTO comuna VALUES (276, 'Puerto Natales', 12);
INSERT INTO comuna VALUES (277, 'Torres del Paine', 12);
INSERT INTO comuna VALUES (278, 'Santiago', 13);
INSERT INTO comuna VALUES (279, 'Cerrillos', 13);
INSERT INTO comuna VALUES (280, 'Cerro Navia', 13);
INSERT INTO comuna VALUES (281, 'Conchalí', 13);
INSERT INTO comuna VALUES (282, 'El Bosque', 13);
INSERT INTO comuna VALUES (283, 'Estación Central', 13);
INSERT INTO comuna VALUES (284, 'Huechuraba', 13);
INSERT INTO comuna VALUES (285, 'Independencia', 13);
INSERT INTO comuna VALUES (286, 'La Cisterna', 13);
INSERT INTO comuna VALUES (287, 'La Florida', 13);
INSERT INTO comuna VALUES (288, 'La Granja', 13);
INSERT INTO comuna VALUES (289, 'La Pintana', 13);
INSERT INTO comuna VALUES (290, 'La Reina', 13);
INSERT INTO comuna VALUES (291, 'Las Condes', 13);
INSERT INTO comuna VALUES (292, 'Lo Barnechea', 13);
INSERT INTO comuna VALUES (293, 'Lo Espejo', 13);
INSERT INTO comuna VALUES (294, 'Lo Prado', 13);
INSERT INTO comuna VALUES (295, 'Macul', 13);
INSERT INTO comuna VALUES (296, 'Maipú', 13);
INSERT INTO comuna VALUES (297, 'Ñuñoa', 13);
INSERT INTO comuna VALUES (298, 'Pedro Aguirre Cerda', 13);
INSERT INTO comuna VALUES (299, 'Peñalolén', 13);
INSERT INTO comuna VALUES (300, 'Providencia', 13);
INSERT INTO comuna VALUES (301, 'Pudahuel', 13);
INSERT INTO comuna VALUES (302, 'Quilicura', 13);
INSERT INTO comuna VALUES (303, 'Quinta Normal', 13);
INSERT INTO comuna VALUES (304, 'Recoleta', 13);
INSERT INTO comuna VALUES (305, 'Renca', 13);
INSERT INTO comuna VALUES (306, 'San Joaquín', 13);
INSERT INTO comuna VALUES (307, 'San Miguel', 13);
INSERT INTO comuna VALUES (308, 'San Ramón', 13);
INSERT INTO comuna VALUES (309, 'Vitacura', 13);
INSERT INTO comuna VALUES (310, 'Puente Alto', 13);
INSERT INTO comuna VALUES (311, 'Pirque', 13);
INSERT INTO comuna VALUES (312, 'San José de Maipo', 13);
INSERT INTO comuna VALUES (313, 'Colina', 13);
INSERT INTO comuna VALUES (314, 'Lampa', 13);
INSERT INTO comuna VALUES (315, 'Til til', 13);
INSERT INTO comuna VALUES (316, 'San Bernardo', 13);
INSERT INTO comuna VALUES (317, 'Buin', 13);
INSERT INTO comuna VALUES (318, 'Calera de Tango', 13);
INSERT INTO comuna VALUES (319, 'Paine', 13);
INSERT INTO comuna VALUES (320, 'Melipilla', 13);
INSERT INTO comuna VALUES (321, 'Alhué', 13);
INSERT INTO comuna VALUES (322, 'Curacaví', 13);
INSERT INTO comuna VALUES (323, 'María Pinto', 13);
INSERT INTO comuna VALUES (324, 'San Pedro', 13);
INSERT INTO comuna VALUES (325, 'Talagante', 13);
INSERT INTO comuna VALUES (326, 'El Monte', 13);
INSERT INTO comuna VALUES (327, 'Isla de Maipo', 13);
INSERT INTO comuna VALUES (328, 'Padre Hurtado', 13);
INSERT INTO comuna VALUES (329, 'Peñaflor', 13);
INSERT INTO comuna VALUES (330, 'Valdivia', 15);
INSERT INTO comuna VALUES (331, 'Corral', 15);
INSERT INTO comuna VALUES (332, 'Lanco', 15);
INSERT INTO comuna VALUES (333, 'Los Lagos', 15);
INSERT INTO comuna VALUES (334, 'Máfil', 15);
INSERT INTO comuna VALUES (335, 'Mariquina', 15);
INSERT INTO comuna VALUES (336, 'Paillaco', 15);
INSERT INTO comuna VALUES (337, 'Panguipulli', 15);
INSERT INTO comuna VALUES (338, 'La Unión', 15);
INSERT INTO comuna VALUES (339, 'Futrono', 15);
INSERT INTO comuna VALUES (340, 'Lago Ranco', 15);
INSERT INTO comuna VALUES (341, 'Río Bueno', 15);
INSERT INTO comuna VALUES (342, 'Arica', 14);
INSERT INTO comuna VALUES (343, 'Camarones', 14);
INSERT INTO comuna VALUES (344, 'Putre', 14);
INSERT INTO comuna VALUES (345, 'General Lagos', 14);
INSERT INTO comuna VALUES (346, 'Chicureo', 13);


--
-- Data for Name: costos_operativos; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: cronograma; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO cronograma VALUES (11, '2017-09-02', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 3);
INSERT INTO cronograma VALUES (12, '2017-09-03', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 3);
INSERT INTO cronograma VALUES (13, '2017-09-09', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 3);
INSERT INTO cronograma VALUES (14, '2017-09-10', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 3);
INSERT INTO cronograma VALUES (15, '2017-09-16', '08:00:00', '11:00:00', '12:00:00', '13:00:00', '', 3);
INSERT INTO cronograma VALUES (2, '2017-09-03', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 1);
INSERT INTO cronograma VALUES (1, '2017-09-02', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 1);
INSERT INTO cronograma VALUES (3, '2017-09-09', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 1);
INSERT INTO cronograma VALUES (4, '2017-09-10', '08:00:00', '11:00:00', '12:00:00', '14:00:00', '', 1);
INSERT INTO cronograma VALUES (5, '2017-09-16', '08:00:00', '11:00:00', '12:00:00', '13:00:00', '', 1);


--
-- Data for Name: curso; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO curso VALUES (1, 'Legislación Laboral', '2005-04-11', '2021-04-11', 24, 30, 1237741940, 96000);


--
-- Data for Name: empresa; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO empresa VALUES (2, '11.111.111-1', 'Prueba', 'Prueba', 'prueba@prueba.cl', 1, 1);
INSERT INTO empresa VALUES (1, '78.174.010-1', 'CRECIC', 'Lincoyan 164', 'crecic@crecic.cl', 1, 1);
INSERT INTO empresa VALUES (3, '22.222.222-2', 'Prueba Editada', 'Prueba 123, Prueba', 'prueba@prueba.cl', 1, 2);


--
-- Data for Name: empresa_estudio; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: estudio_factibilidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO estudio_factibilidad VALUES (1, '2017-09-23', 'Prueba?', 'Prueba?', '2017-09-03', '2017-09-16', 'Prueba', 1, 1, 1, 1, NULL, NULL, NULL);
INSERT INTO estudio_factibilidad VALUES (3, '2017-09-22', 'Prueba', 'Prueba', '2017-09-02', '2017-09-16', 'Prueba', 1, 1, 1, 1, true, NULL, NULL);


--
-- Data for Name: giro; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO giro VALUES (1, 'Camiones');
INSERT INTO giro VALUES (2, 'Prueba?');
INSERT INTO giro VALUES (3, 'eh');
INSERT INTO giro VALUES (4, 'asdsad');


--
-- Data for Name: perfil; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO perfil VALUES (1, 'ADMINISTRADOR');
INSERT INTO perfil VALUES (2, 'GERENTE GENERAL');
INSERT INTO perfil VALUES (3, 'JEFE SUCURSAL');
INSERT INTO perfil VALUES (4, 'ACADEMICO');
INSERT INTO perfil VALUES (5, 'ADMINISTRACION');
INSERT INTO perfil VALUES (6, 'SOPORTE');
INSERT INTO perfil VALUES (7, 'ASESOR');
INSERT INTO perfil VALUES (8, 'ASESOR ESPECIAL');
INSERT INTO perfil VALUES (9, 'RELATOR');
INSERT INTO perfil VALUES (10, 'CLIENTE');
INSERT INTO perfil VALUES (11, 'ASESOR ANTIGUO');


--
-- Data for Name: presupuesto; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: region; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO region VALUES (2, 'Antofagasta', 3);
INSERT INTO region VALUES (3, 'Atacama', 4);
INSERT INTO region VALUES (4, 'Coquimbo', 5);
INSERT INTO region VALUES (5, 'Valparaíso', 6);
INSERT INTO region VALUES (7, 'Maule', 9);
INSERT INTO region VALUES (8, 'Biobío', 10);
INSERT INTO region VALUES (9, 'Araucanía', 11);
INSERT INTO region VALUES (10, 'Los Lagos', 13);
INSERT INTO region VALUES (11, 'Aysén', 14);
INSERT INTO region VALUES (12, 'Magallanes', 15);
INSERT INTO region VALUES (13, 'Metropolitana', 7);
INSERT INTO region VALUES (14, 'Arica y Parinacota', 1);
INSERT INTO region VALUES (15, 'Los Ríos', 12);
INSERT INTO region VALUES (1, 'Tarapacá', 2);
INSERT INTO region VALUES (6, 'Libertador General Bernardo O''Higgins', 8);


--
-- Data for Name: relatores; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO relatores VALUES (2, 3);
INSERT INTO relatores VALUES (2, 1);
INSERT INTO relatores VALUES (3, 1);
INSERT INTO relatores VALUES (3, 2);
INSERT INTO relatores VALUES (1, 1);
INSERT INTO relatores VALUES (1, 2);


--
-- Data for Name: requerimiento_academico; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO requerimiento_academico VALUES (3, 'Prueba', NULL, 3);
INSERT INTO requerimiento_academico VALUES (1, 'Prueba', NULL, 1);


--
-- Data for Name: requerimiento_adquisicion; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO requerimiento_adquisicion VALUES (1, 'Prueba', NULL, 1);


--
-- Data for Name: requerimiento_tecnico; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO requerimiento_tecnico VALUES (3, 'Prueba', NULL, true, true, true, false, 22, NULL, 3);
INSERT INTO requerimiento_tecnico VALUES (1, 'Prueba', NULL, true, true, true, false, 22, NULL, 1);


--
-- Data for Name: sucursal; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO sucursal VALUES (1, 'CONCEPCION');
INSERT INTO sucursal VALUES (2, 'CHILLAN');
INSERT INTO sucursal VALUES (3, 'TEMUCO');
INSERT INTO sucursal VALUES (4, 'PUERTO MONTT');
INSERT INTO sucursal VALUES (5, 'SANTIAGO');


--
-- Data for Name: tipo_curso; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_curso VALUES (1, 'Prueba?');


--
-- Data for Name: tipo_manual; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO tipo_manual VALUES (1, 'Pendrive');
INSERT INTO tipo_manual VALUES (2, 'Anillado');
INSERT INTO tipo_manual VALUES (3, 'Archivador');


--
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO usuario VALUES (1, '18.433.269-8', 'VICTOR ADRIAN', 'JARPA', 'HERMOSILLA', 1, 1, 1, 'c152b479523a3eca99c2861dd0f1c3db', true, NULL);
INSERT INTO usuario VALUES (2, '22.222.222-2', 'Prueba Prueba2', 'Prueba', 'Prueba', 1, 1, 1, 'c893bad68927b457dbed39460e6afd62', NULL, 'prueba@prueba.cl');
INSERT INTO usuario VALUES (3, '33.333.333-3', 'Prueba 3', 'Prueba', 'Prueba', 2, 1, 232, 'c893bad68927b457dbed39460e6afd62', NULL, 'prueba3@prueba.cl');
INSERT INTO usuario VALUES (4, '44.444.444-4', 'Prueba 4', 'prueba', 'prueba', 2, 1, 155, 'c893bad68927b457dbed39460e6afd62', NULL, 'prueba@prueba.cl');


--
-- Name: pk_coctel; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY coctel
    ADD CONSTRAINT pk_coctel PRIMARY KEY (cc_codigo);


--
-- Name: pk_comuna; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comuna
    ADD CONSTRAINT pk_comuna PRIMARY KEY (co_codigo);


--
-- Name: pk_costos_operativos; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY costos_operativos
    ADD CONSTRAINT pk_costos_operativos PRIMARY KEY (ct_codigo);


--
-- Name: pk_cronograma; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cronograma
    ADD CONSTRAINT pk_cronograma PRIMARY KEY (cr_codigo);


--
-- Name: pk_curso; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curso
    ADD CONSTRAINT pk_curso PRIMARY KEY (cu_codigo);


--
-- Name: pk_empresa; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY empresa
    ADD CONSTRAINT pk_empresa PRIMARY KEY (em_codigo);


--
-- Name: pk_empresa_estudio; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY empresa_estudio
    ADD CONSTRAINT pk_empresa_estudio PRIMARY KEY (ef_codigo, em_codigo);


--
-- Name: pk_estudio_factibilidad; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT pk_estudio_factibilidad PRIMARY KEY (ef_codigo);


--
-- Name: pk_giro; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY giro
    ADD CONSTRAINT pk_giro PRIMARY KEY (gi_codigo);


--
-- Name: pk_perfil; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY perfil
    ADD CONSTRAINT pk_perfil PRIMARY KEY (pe_codigo);


--
-- Name: pk_presupuesto; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY presupuesto
    ADD CONSTRAINT pk_presupuesto PRIMARY KEY (pr_codigo);


--
-- Name: pk_region; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY region
    ADD CONSTRAINT pk_region PRIMARY KEY (re_codigo);


--
-- Name: pk_relatores; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY relatores
    ADD CONSTRAINT pk_relatores PRIMARY KEY (ra_codigo, us_codigo);


--
-- Name: pk_requerimiento_academico; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY requerimiento_academico
    ADD CONSTRAINT pk_requerimiento_academico PRIMARY KEY (ra_codigo);


--
-- Name: pk_requerimiento_adquisicion; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY requerimiento_adquisicion
    ADD CONSTRAINT pk_requerimiento_adquisicion PRIMARY KEY (rd_codigo);


--
-- Name: pk_requerimiento_tecnico; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY requerimiento_tecnico
    ADD CONSTRAINT pk_requerimiento_tecnico PRIMARY KEY (rt_codigo);


--
-- Name: pk_sucursal; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sucursal
    ADD CONSTRAINT pk_sucursal PRIMARY KEY (su_codigo);


--
-- Name: pk_tipo_curso; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_curso
    ADD CONSTRAINT pk_tipo_curso PRIMARY KEY (tc_codigo);


--
-- Name: pk_tipo_manual; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_manual
    ADD CONSTRAINT pk_tipo_manual PRIMARY KEY (tm_codigo);


--
-- Name: pk_usuario; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT pk_usuario PRIMARY KEY (us_codigo);


--
-- Name: coctel_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX coctel_pk ON coctel USING btree (cc_codigo);


--
-- Name: comuna_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX comuna_pk ON comuna USING btree (co_codigo);


--
-- Name: cronograma_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX cronograma_pk ON cronograma USING btree (cr_codigo);


--
-- Name: cronogramas_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX cronogramas_fk ON cronograma USING btree (ef_codigo);


--
-- Name: curso_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX curso_pk ON curso USING btree (cu_codigo);


--
-- Name: curso_sence_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX curso_sence_fk ON estudio_factibilidad USING btree (cu_codigo);


--
-- Name: empresa_comuna_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX empresa_comuna_fk ON empresa USING btree (co_codigo);


--
-- Name: empresa_estudio2_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX empresa_estudio2_fk ON empresa_estudio USING btree (em_codigo);


--
-- Name: empresa_estudio_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX empresa_estudio_fk ON empresa_estudio USING btree (ef_codigo);


--
-- Name: empresa_estudio_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX empresa_estudio_pk ON empresa_estudio USING btree (ef_codigo, em_codigo);


--
-- Name: empresa_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX empresa_pk ON empresa USING btree (em_codigo);


--
-- Name: estudio_factibilidad_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX estudio_factibilidad_pk ON estudio_factibilidad USING btree (ef_codigo);


--
-- Name: estudio_tipo_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX estudio_tipo_fk ON estudio_factibilidad USING btree (tc_codigo);


--
-- Name: factibilidad_academica_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX factibilidad_academica_fk ON requerimiento_academico USING btree (ef_codigo);


--
-- Name: factibilidad_tecnica_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX factibilidad_tecnica_fk ON requerimiento_tecnico USING btree (ef_codigo);


--
-- Name: factiblidad_adquisicion_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX factiblidad_adquisicion_fk ON requerimiento_adquisicion USING btree (ef_codigo);


--
-- Name: giro_empresarial_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX giro_empresarial_fk ON empresa USING btree (gi_codigo);


--
-- Name: giro_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX giro_pk ON giro USING btree (gi_codigo);


--
-- Name: manual_factibilidad_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX manual_factibilidad_fk ON estudio_factibilidad USING btree (tm_codigo);


--
-- Name: perfil_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX perfil_pk ON perfil USING btree (pe_codigo);


--
-- Name: perfil_usuario_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX perfil_usuario_fk ON usuario USING btree (pe_codigo);


--
-- Name: region_comuna_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX region_comuna_fk ON comuna USING btree (re_codigo);


--
-- Name: region_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX region_pk ON region USING btree (re_codigo);


--
-- Name: relatores2_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relatores2_fk ON relatores USING btree (us_codigo);


--
-- Name: relatores_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relatores_fk ON relatores USING btree (ra_codigo);


--
-- Name: relatores_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX relatores_pk ON relatores USING btree (ra_codigo, us_codigo);


--
-- Name: requerimiento_academico_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX requerimiento_academico_pk ON requerimiento_academico USING btree (ra_codigo);


--
-- Name: requerimiento_adquisicion_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX requerimiento_adquisicion_pk ON requerimiento_adquisicion USING btree (rd_codigo);


--
-- Name: requerimiento_tecnico_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX requerimiento_tecnico_pk ON requerimiento_tecnico USING btree (rt_codigo);


--
-- Name: sucursal_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX sucursal_pk ON sucursal USING btree (su_codigo);


--
-- Name: sucusal_usuario_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX sucusal_usuario_fk ON usuario USING btree (su_codigo);


--
-- Name: tipo_curso_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX tipo_curso_pk ON tipo_curso USING btree (tc_codigo);


--
-- Name: tipo_manual_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX tipo_manual_pk ON tipo_manual USING btree (tm_codigo);


--
-- Name: usuario_comuna_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX usuario_comuna_fk ON usuario USING btree (co_codigo);


--
-- Name: usuario_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX usuario_pk ON usuario USING btree (us_codigo);


--
-- Name: vendedor_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX vendedor_fk ON estudio_factibilidad USING btree (us_codigo);


--
-- Name: fk_coctel_entrega_d_requerim; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY coctel
    ADD CONSTRAINT fk_coctel_entrega_d_requerim FOREIGN KEY (rd_codigo) REFERENCES requerimiento_adquisicion(rd_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_comuna_region_co_region; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comuna
    ADD CONSTRAINT fk_comuna_region_co_region FOREIGN KEY (re_codigo) REFERENCES region(re_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_costos_presupuesto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY costos_operativos
    ADD CONSTRAINT fk_costos_presupuesto FOREIGN KEY (pr_codigo) REFERENCES presupuesto(pr_codigo);


--
-- Name: fk_cronogra_cronogram_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cronograma
    ADD CONSTRAINT fk_cronogra_cronogram_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_empresa__empresa_e_empresa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa_estudio
    ADD CONSTRAINT fk_empresa__empresa_e_empresa FOREIGN KEY (em_codigo) REFERENCES empresa(em_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_empresa__empresa_e_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa_estudio
    ADD CONSTRAINT fk_empresa__empresa_e_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_empresa_empresa_c_comuna; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa
    ADD CONSTRAINT fk_empresa_empresa_c_comuna FOREIGN KEY (co_codigo) REFERENCES comuna(co_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_empresa_giro_empr_giro; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa
    ADD CONSTRAINT fk_empresa_giro_empr_giro FOREIGN KEY (gi_codigo) REFERENCES giro(gi_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_estudio__curso_sen_curso; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__curso_sen_curso FOREIGN KEY (cu_codigo) REFERENCES curso(cu_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_estudio__estudio_t_tipo_cur; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__estudio_t_tipo_cur FOREIGN KEY (tc_codigo) REFERENCES tipo_curso(tc_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_estudio__manual_fa_tipo_man; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__manual_fa_tipo_man FOREIGN KEY (tm_codigo) REFERENCES tipo_manual(tm_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_estudio__vendedor_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__vendedor_usuario FOREIGN KEY (us_codigo) REFERENCES usuario(us_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_presupuesto_estudio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY presupuesto
    ADD CONSTRAINT fk_presupuesto_estudio FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo);


--
-- Name: fk_relatore_relatores_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY relatores
    ADD CONSTRAINT fk_relatore_relatores_usuario FOREIGN KEY (us_codigo) REFERENCES usuario(us_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_requerim_factibili_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY requerimiento_tecnico
    ADD CONSTRAINT fk_requerim_factibili_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_requerim_factibili_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY requerimiento_academico
    ADD CONSTRAINT fk_requerim_factibili_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_requerim_factiblid_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY requerimiento_adquisicion
    ADD CONSTRAINT fk_requerim_factiblid_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_usuario_perfil_us_perfil; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT fk_usuario_perfil_us_perfil FOREIGN KEY (pe_codigo) REFERENCES perfil(pe_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_usuario_sucusal_u_sucursal; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT fk_usuario_sucusal_u_sucursal FOREIGN KEY (su_codigo) REFERENCES sucursal(su_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: fk_usuario_usuario_c_comuna; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT fk_usuario_usuario_c_comuna FOREIGN KEY (co_codigo) REFERENCES comuna(co_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

