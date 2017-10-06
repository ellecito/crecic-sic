--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.12
-- Dumped by pg_dump version 9.4.12
-- Started on 2017-10-06 01:24:49 -03

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 1 (class 3079 OID 11935)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2273 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 173 (class 1259 OID 16675)
-- Name: coctel; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE coctel (
    cc_codigo bigint NOT NULL,
    cc_direccion character varying(100),
    cc_fecha timestamp without time zone,
    rd_codigo bigint NOT NULL
);


ALTER TABLE coctel OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16681)
-- Name: comuna; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE comuna (
    co_codigo integer NOT NULL,
    co_nombre character varying(100),
    re_codigo integer NOT NULL
);


ALTER TABLE comuna OWNER TO postgres;

--
-- TOC entry 192 (class 1259 OID 16963)
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
-- TOC entry 175 (class 1259 OID 16688)
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
-- TOC entry 176 (class 1259 OID 16698)
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
-- TOC entry 177 (class 1259 OID 16704)
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
-- TOC entry 178 (class 1259 OID 16715)
-- Name: empresa_estudio; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE empresa_estudio (
    ef_codigo bigint NOT NULL,
    em_codigo integer NOT NULL
);


ALTER TABLE empresa_estudio OWNER TO postgres;

--
-- TOC entry 179 (class 1259 OID 16723)
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
-- TOC entry 180 (class 1259 OID 16736)
-- Name: giro; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE giro (
    gi_codigo integer NOT NULL,
    gi_nombre character varying(100)
);


ALTER TABLE giro OWNER TO postgres;

--
-- TOC entry 181 (class 1259 OID 16742)
-- Name: perfil; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE perfil (
    pe_codigo integer NOT NULL,
    pe_nombre character varying(50)
);


ALTER TABLE perfil OWNER TO postgres;

--
-- TOC entry 191 (class 1259 OID 16958)
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
-- TOC entry 182 (class 1259 OID 16748)
-- Name: region; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE region (
    re_codigo integer NOT NULL,
    re_nombre character varying(100),
    re_orden integer
);


ALTER TABLE region OWNER TO postgres;

--
-- TOC entry 183 (class 1259 OID 16754)
-- Name: relatores; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE relatores (
    ra_codigo bigint NOT NULL,
    us_codigo integer NOT NULL
);


ALTER TABLE relatores OWNER TO postgres;

--
-- TOC entry 190 (class 1259 OID 16938)
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
-- TOC entry 184 (class 1259 OID 16772)
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
-- TOC entry 185 (class 1259 OID 16782)
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
-- TOC entry 186 (class 1259 OID 16792)
-- Name: sucursal; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE sucursal (
    su_codigo integer NOT NULL,
    su_nombre character varying(50)
);


ALTER TABLE sucursal OWNER TO postgres;

--
-- TOC entry 187 (class 1259 OID 16798)
-- Name: tipo_curso; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_curso (
    tc_codigo integer NOT NULL,
    tc_nombre character varying(100)
);


ALTER TABLE tipo_curso OWNER TO postgres;

--
-- TOC entry 188 (class 1259 OID 16804)
-- Name: tipo_manual; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_manual (
    tm_codigo integer NOT NULL,
    tm_nombre character varying(100)
);


ALTER TABLE tipo_manual OWNER TO postgres;

--
-- TOC entry 189 (class 1259 OID 16810)
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
-- TOC entry 2246 (class 0 OID 16675)
-- Dependencies: 173
-- Data for Name: coctel; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY coctel (cc_codigo, cc_direccion, cc_fecha, rd_codigo) FROM stdin;
1		2065-05-20 17:00:00	1
\.


--
-- TOC entry 2247 (class 0 OID 16681)
-- Dependencies: 174
-- Data for Name: comuna; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY comuna (co_codigo, co_nombre, re_codigo) FROM stdin;
1	Iquique	1
2	Alto Hospicio	1
3	Pozo Almonte	1
4	Camiña	1
5	Colchane	1
6	Huara	1
7	Pica	1
8	Antofagasta	2
9	Mejillones	2
10	Sierra Gorda	2
11	Taltal	2
12	Calama	2
13	Ollague	2
14	San Pedro de Atacama	2
15	Tocopilla	2
16	María Elena	2
17	Copiapó	3
18	Caldera	3
19	Tierra Amarilla	3
20	Chañaral	3
21	Diego de Almagro	3
22	Vallenar	3
23	Alto del Carmen	3
24	Freirina	3
25	Huasco	3
26	La Serena	4
27	Coquimbo	4
28	Andacollo	4
29	La Higuera	4
30	Paihuano	4
31	Vicuña	4
32	Illapel	4
33	Canela	4
34	Los Vilos	4
35	Salamanca	4
36	Ovalle	4
37	Combarbalá	4
38	Monte Patria	4
39	Punitaqui	4
40	Río Hurtado	4
41	Valparaíso	5
42	Casablanca	5
43	Concón	5
44	Juan Fernández	5
45	Puchuncaví	5
46	Quilpué	5
47	Quintero	5
48	Villa Alemana	5
49	Viña del Mar	5
50	Isla de Pascua	5
51	Los Andes	5
52	Calle Larga	5
53	Rinconada	5
54	San Esteban	5
55	La Ligua	5
56	Cabildo	5
57	Papudo	5
58	Petorca	5
59	Zapallar	5
60	Quillota	5
61	Calera	5
62	Hijuelas	5
63	La Cruz	5
64	Limache	5
65	Nogales	5
66	Olmué	5
67	San Antonio	5
68	Algarrobo	5
69	Cartagena	5
70	El Quisco	5
71	El Tabo	5
72	Santo Domingo	5
73	San Felipe	5
74	Catemu	5
75	Llay Llay	5
76	Panquehue	5
77	Putaendo	5
78	Santa María	5
79	Rancagua	6
80	Codegua	6
81	Coinco	6
82	Coltauco	6
83	Doñihue	6
84	Graneros	6
85	Las Cabras	6
86	Machalí	6
87	Malloa	6
88	Mostazal	6
89	Olivar	6
90	Peumo	6
91	Pichidegua	6
92	Quinta de Tilcoco	6
93	Rengo	6
94	Requinoa	6
95	San Vicente	6
96	Pichilemu	6
97	La Estrella	6
98	Litueche	6
99	Marchihue	6
100	Navidad	6
101	Paredones	6
102	San Fernando	6
103	Chépica	6
104	Chimbarongo	6
105	Lolol	6
106	Nancagua	6
107	Palmilla	6
108	Peralillo	6
109	Placilla	6
110	Pumanque	6
111	Santa Cruz	6
112	Talca	7
113	Constitución	7
114	Curepto	7
115	Empedrado	7
116	Maule	7
117	Pelarco	7
118	Pencahue	7
119	Río Claro	7
120	San Clemente	7
121	San Rafael	7
122	Cauquenes	7
123	Chanco	7
124	Pelluhue	7
125	Curicó	7
126	Hualañé	7
127	Licantén	7
128	Molina	7
129	Rauco	7
130	Romeral	7
131	Sagrada Familia	7
132	Teno	7
133	Vichuquén	7
134	Linares	7
135	Colbún	7
136	Longaví	7
137	Parral	7
138	Retiro	7
139	San Javier	7
140	Villa Alegre	7
141	Yerbas Buenas	7
142	Concepción	8
143	Coronel	8
144	Chiguayante	8
145	Florida	8
146	Hualqui	8
147	Lota	8
148	Penco	8
149	San Pedro De La Paz	8
150	Santa Juana	8
151	Talcahuano	8
152	Tomé	8
153	Hualpén	8
154	Lebu	8
155	Arauco	8
156	Cañete	8
157	Contulmo	8
158	Curanilahue	8
159	Los Alamos	8
160	Tirua	8
161	Los Angeles	8
162	Antuco	8
163	Cabrero	8
164	Laja	8
165	Mulchén	8
166	Nacimiento	8
167	Negrete	8
168	Quilaco	8
169	Quilleco	8
170	San Rosendo	8
171	Santa Bárbara	8
172	Tucapel	8
173	Yumbel	8
174	Alto Biobío	8
175	Chillán	8
176	Bulnes	8
177	Cobquecura	8
178	Coelemu	8
179	Coihueco	8
180	Chillán Viejo	8
181	El Carmen	8
182	Ninhue	8
183	Ñiquén	8
184	Pemuco	8
185	Pinto	8
186	Portezuelo	8
187	Quillón	8
188	Quirihue	8
189	Ranquil	8
190	San Carlos	8
191	San Fabián	8
192	San Ignacio	8
193	San Nicolás	8
194	Trehuaco	8
195	Yungay	8
196	Temuco	9
197	Carahue	9
198	Cunco	9
199	Curarrehue	9
200	Freire	9
201	Galvarino	9
202	Gorbea	9
203	Lautaro	9
204	Loncoche	9
205	Melipeuco	9
206	Nueva Imperial	9
207	Padre Las Casas	9
208	Perquenco	9
209	Pitrufquén	9
210	Pucón	9
211	Saavedra	9
212	Teodoro Schmidt	9
213	Toltén	9
214	Vilcún	9
215	Villarrica	9
216	Cholchol	9
217	Angol	9
218	Collipulli	9
219	Curacautín	9
220	Ercilla	9
221	Lonquimay	9
222	Los Sauces	9
223	Lumaco	9
224	Purén	9
225	Renaico	9
226	Traiguén	9
227	Victoria	9
228	Puerto Montt	10
229	Calbuco	10
230	Cochamó	10
231	Fresia	10
232	Frutillar	10
233	Los Muermos	10
234	Llanquihue	10
235	Maullín	10
236	Puerto Varas	10
237	Castro	10
238	Ancud	10
239	Chonchi	10
240	Curaco de Vélez	10
241	Dalcahue	10
242	Puqueldón	10
243	Queilén	10
244	Quellón	10
245	Quemchi	10
246	Quinchao	10
247	Osorno	10
248	Puerto Octay	10
249	Purranque	10
250	Puyehue	10
251	Río Negro	10
252	San Juan de la Costa	10
253	San Pablo	10
254	Chaitén	10
255	Futaleufú	10
256	Hualaihue	10
257	Palena	10
258	Coihaique	11
259	Lago Verde	11
260	Puerto Aysén	11
261	Cisnes	11
262	Guaitecas	11
263	Cochrane	11
264	Ohiggins	11
265	Tortel	11
266	Chile Chico	11
267	Río Ibáñez	11
268	Punta Arenas	12
269	Laguna Blanca	12
270	Río Verde	12
271	San Gregorio	12
272	Cabo de Hornos	12
273	Porvenir	12
274	Primavera	12
275	Timaukel	12
276	Puerto Natales	12
277	Torres del Paine	12
278	Santiago	13
279	Cerrillos	13
280	Cerro Navia	13
281	Conchalí	13
282	El Bosque	13
283	Estación Central	13
284	Huechuraba	13
285	Independencia	13
286	La Cisterna	13
287	La Florida	13
288	La Granja	13
289	La Pintana	13
290	La Reina	13
291	Las Condes	13
292	Lo Barnechea	13
293	Lo Espejo	13
294	Lo Prado	13
295	Macul	13
296	Maipú	13
297	Ñuñoa	13
298	Pedro Aguirre Cerda	13
299	Peñalolén	13
300	Providencia	13
301	Pudahuel	13
302	Quilicura	13
303	Quinta Normal	13
304	Recoleta	13
305	Renca	13
306	San Joaquín	13
307	San Miguel	13
308	San Ramón	13
309	Vitacura	13
310	Puente Alto	13
311	Pirque	13
312	San José de Maipo	13
313	Colina	13
314	Lampa	13
315	Til til	13
316	San Bernardo	13
317	Buin	13
318	Calera de Tango	13
319	Paine	13
320	Melipilla	13
321	Alhué	13
322	Curacaví	13
323	María Pinto	13
324	San Pedro	13
325	Talagante	13
326	El Monte	13
327	Isla de Maipo	13
328	Padre Hurtado	13
329	Peñaflor	13
330	Valdivia	15
331	Corral	15
332	Lanco	15
333	Los Lagos	15
334	Máfil	15
335	Mariquina	15
336	Paillaco	15
337	Panguipulli	15
338	La Unión	15
339	Futrono	15
340	Lago Ranco	15
341	Río Bueno	15
342	Arica	14
343	Camarones	14
344	Putre	14
345	General Lagos	14
346	Chicureo	13
\.


--
-- TOC entry 2265 (class 0 OID 16963)
-- Dependencies: 192
-- Data for Name: costos_operativos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY costos_operativos (ct_codigo, ct_nombre, ct_unitario, ct_adicional, ct_subtotal, ct_detalle, ct_cantidad, ct_porcentaje, pr_codigo) FROM stdin;
\.


--
-- TOC entry 2248 (class 0 OID 16688)
-- Dependencies: 175
-- Data for Name: cronograma; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY cronograma (cr_codigo, cr_fecha, cr_hora_inicio_d, cr_hora_fin_d, cr_hora_inicio_t, cr_hora_fin_t, cr_obs, ef_codigo) FROM stdin;
11	2017-09-02	08:00:00	11:00:00	12:00:00	14:00:00		3
12	2017-09-03	08:00:00	11:00:00	12:00:00	14:00:00		3
13	2017-09-09	08:00:00	11:00:00	12:00:00	14:00:00		3
14	2017-09-10	08:00:00	11:00:00	12:00:00	14:00:00		3
15	2017-09-16	08:00:00	11:00:00	12:00:00	13:00:00		3
2	2017-09-03	08:00:00	11:00:00	12:00:00	14:00:00		1
1	2017-09-02	08:00:00	11:00:00	12:00:00	14:00:00		1
3	2017-09-09	08:00:00	11:00:00	12:00:00	14:00:00		1
4	2017-09-10	08:00:00	11:00:00	12:00:00	14:00:00		1
5	2017-09-16	08:00:00	11:00:00	12:00:00	13:00:00		1
\.


--
-- TOC entry 2249 (class 0 OID 16698)
-- Dependencies: 176
-- Data for Name: curso; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY curso (cu_codigo, cu_nombre, cu_fecha_emision, cu_fecha_vencimiento, cu_horas, cu_alumnos, cu_sence, cu_valor_alumno) FROM stdin;
1	Legislación Laboral	2005-04-11	2021-04-11	24	30	1237741940	96000
\.


--
-- TOC entry 2250 (class 0 OID 16704)
-- Dependencies: 177
-- Data for Name: empresa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY empresa (em_codigo, em_rut, em_razon_social, em_direccion, em_email, gi_codigo, co_codigo) FROM stdin;
2	11.111.111-1	Prueba	Prueba	prueba@prueba.cl	1	1
1	78.174.010-1	CRECIC	Lincoyan 164	crecic@crecic.cl	1	1
3	22.222.222-2	Prueba Editada	Prueba 123, Prueba	prueba@prueba.cl	1	2
\.


--
-- TOC entry 2251 (class 0 OID 16715)
-- Dependencies: 178
-- Data for Name: empresa_estudio; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY empresa_estudio (ef_codigo, em_codigo) FROM stdin;
\.


--
-- TOC entry 2252 (class 0 OID 16723)
-- Dependencies: 179
-- Data for Name: estudio_factibilidad; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY estudio_factibilidad (ef_codigo, ef_fecha_emision, ef_nombre_diploma, ef_direccion_realizacion, ef_fecha_inicio, ef_fecha_termino, ef_obs, tm_codigo, cu_codigo, tc_codigo, us_codigo, ef_estado, ef_visado, su_codigo) FROM stdin;
1	2017-09-23	Prueba?	Prueba?	2017-09-03	2017-09-16	Prueba	1	1	1	1	\N	\N	\N
3	2017-09-22	Prueba	Prueba	2017-09-02	2017-09-16	Prueba	1	1	1	1	t	\N	\N
\.


--
-- TOC entry 2253 (class 0 OID 16736)
-- Dependencies: 180
-- Data for Name: giro; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY giro (gi_codigo, gi_nombre) FROM stdin;
1	Camiones
2	Prueba?
3	eh
4	asdsad
\.


--
-- TOC entry 2254 (class 0 OID 16742)
-- Dependencies: 181
-- Data for Name: perfil; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY perfil (pe_codigo, pe_nombre) FROM stdin;
1	ADMINISTRADOR
2	GERENTE GENERAL
3	JEFE SUCURSAL
4	ACADEMICO
5	ADMINISTRACION
6	SOPORTE
7	ASESOR
8	ASESOR ESPECIAL
9	RELATOR
10	CLIENTE
11	ASESOR ANTIGUO
\.


--
-- TOC entry 2264 (class 0 OID 16958)
-- Dependencies: 191
-- Data for Name: presupuesto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY presupuesto (pr_codigo, pr_ingreso_ventas, pr_costos_directos, pr_costos_fijos, pr_comision_asesor, pr_utilidad_bruta, pr_utilidad_bruta_porcentaje, pr_valor_hora_relator, pr_beneficio_neto, pr_costos_fijos_porcentaje, pr_comision_asesor_porcentaje, ef_codigo) FROM stdin;
\.


--
-- TOC entry 2255 (class 0 OID 16748)
-- Dependencies: 182
-- Data for Name: region; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY region (re_codigo, re_nombre, re_orden) FROM stdin;
2	Antofagasta	3
3	Atacama	4
4	Coquimbo	5
5	Valparaíso	6
7	Maule	9
8	Biobío	10
9	Araucanía	11
10	Los Lagos	13
11	Aysén	14
12	Magallanes	15
13	Metropolitana	7
14	Arica y Parinacota	1
15	Los Ríos	12
1	Tarapacá	2
6	Libertador General Bernardo O'Higgins	8
\.


--
-- TOC entry 2256 (class 0 OID 16754)
-- Dependencies: 183
-- Data for Name: relatores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY relatores (ra_codigo, us_codigo) FROM stdin;
2	3
2	1
3	1
3	2
1	1
1	2
\.


--
-- TOC entry 2263 (class 0 OID 16938)
-- Dependencies: 190
-- Data for Name: requerimiento_academico; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY requerimiento_academico (ra_codigo, ra_obs, ra_respuesta, ef_codigo) FROM stdin;
3	Prueba	\N	3
1	Prueba	\N	1
\.


--
-- TOC entry 2257 (class 0 OID 16772)
-- Dependencies: 184
-- Data for Name: requerimiento_adquisicion; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY requerimiento_adquisicion (rd_codigo, rd_obs, rd_respuesta, ef_codigo) FROM stdin;
1	Prueba	\N	1
\.


--
-- TOC entry 2258 (class 0 OID 16782)
-- Dependencies: 185
-- Data for Name: requerimiento_tecnico; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY requerimiento_tecnico (rt_codigo, rt_obs, rt_respuesta, rt_computadores, rt_proyector, rt_pizarra, rt_arriendo, rt_sala, rt_vb, ef_codigo) FROM stdin;
3	Prueba	\N	t	t	t	f	22	\N	3
1	Prueba	\N	t	t	t	f	22	\N	1
\.


--
-- TOC entry 2259 (class 0 OID 16792)
-- Dependencies: 186
-- Data for Name: sucursal; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY sucursal (su_codigo, su_nombre) FROM stdin;
1	CONCEPCION
2	CHILLAN
3	TEMUCO
4	PUERTO MONTT
5	SANTIAGO
\.


--
-- TOC entry 2260 (class 0 OID 16798)
-- Dependencies: 187
-- Data for Name: tipo_curso; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipo_curso (tc_codigo, tc_nombre) FROM stdin;
1	Prueba?
\.


--
-- TOC entry 2261 (class 0 OID 16804)
-- Dependencies: 188
-- Data for Name: tipo_manual; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipo_manual (tm_codigo, tm_nombre) FROM stdin;
1	Pendrive
2	Anillado
3	Archivador
\.


--
-- TOC entry 2262 (class 0 OID 16810)
-- Dependencies: 189
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY usuario (us_codigo, us_rut, us_nombres, us_apellido_paterno, us_apellido_materno, pe_codigo, su_codigo, co_codigo, us_password, us_estado, us_email) FROM stdin;
1	18.433.269-8	VICTOR ADRIAN	JARPA	HERMOSILLA	1	1	1	c152b479523a3eca99c2861dd0f1c3db	t	\N
2	22.222.222-2	Prueba Prueba2	Prueba	Prueba	1	1	1	c893bad68927b457dbed39460e6afd62	\N	prueba@prueba.cl
3	33.333.333-3	Prueba 3	Prueba	Prueba	2	1	232	c893bad68927b457dbed39460e6afd62	\N	prueba3@prueba.cl
4	44.444.444-4	Prueba 4	prueba	prueba	2	1	155	c893bad68927b457dbed39460e6afd62	\N	prueba@prueba.cl
\.


--
-- TOC entry 2043 (class 2606 OID 16679)
-- Name: pk_coctel; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY coctel
    ADD CONSTRAINT pk_coctel PRIMARY KEY (cc_codigo);


--
-- TOC entry 2046 (class 2606 OID 16685)
-- Name: pk_comuna; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY comuna
    ADD CONSTRAINT pk_comuna PRIMARY KEY (co_codigo);


--
-- TOC entry 2116 (class 2606 OID 16972)
-- Name: pk_costos_operativos; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY costos_operativos
    ADD CONSTRAINT pk_costos_operativos PRIMARY KEY (ct_codigo);


--
-- TOC entry 2051 (class 2606 OID 16695)
-- Name: pk_cronograma; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cronograma
    ADD CONSTRAINT pk_cronograma PRIMARY KEY (cr_codigo);


--
-- TOC entry 2054 (class 2606 OID 16702)
-- Name: pk_curso; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY curso
    ADD CONSTRAINT pk_curso PRIMARY KEY (cu_codigo);


--
-- TOC entry 2059 (class 2606 OID 16711)
-- Name: pk_empresa; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY empresa
    ADD CONSTRAINT pk_empresa PRIMARY KEY (em_codigo);


--
-- TOC entry 2064 (class 2606 OID 16719)
-- Name: pk_empresa_estudio; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY empresa_estudio
    ADD CONSTRAINT pk_empresa_estudio PRIMARY KEY (ef_codigo, em_codigo);


--
-- TOC entry 2070 (class 2606 OID 16730)
-- Name: pk_estudio_factibilidad; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT pk_estudio_factibilidad PRIMARY KEY (ef_codigo);


--
-- TOC entry 2074 (class 2606 OID 16740)
-- Name: pk_giro; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY giro
    ADD CONSTRAINT pk_giro PRIMARY KEY (gi_codigo);


--
-- TOC entry 2077 (class 2606 OID 16746)
-- Name: pk_perfil; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY perfil
    ADD CONSTRAINT pk_perfil PRIMARY KEY (pe_codigo);


--
-- TOC entry 2114 (class 2606 OID 16974)
-- Name: pk_presupuesto; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY presupuesto
    ADD CONSTRAINT pk_presupuesto PRIMARY KEY (pr_codigo);


--
-- TOC entry 2079 (class 2606 OID 16752)
-- Name: pk_region; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY region
    ADD CONSTRAINT pk_region PRIMARY KEY (re_codigo);


--
-- TOC entry 2082 (class 2606 OID 16758)
-- Name: pk_relatores; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY relatores
    ADD CONSTRAINT pk_relatores PRIMARY KEY (ra_codigo, us_codigo);


--
-- TOC entry 2111 (class 2606 OID 16945)
-- Name: pk_requerimiento_academico; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY requerimiento_academico
    ADD CONSTRAINT pk_requerimiento_academico PRIMARY KEY (ra_codigo);


--
-- TOC entry 2088 (class 2606 OID 16779)
-- Name: pk_requerimiento_adquisicion; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY requerimiento_adquisicion
    ADD CONSTRAINT pk_requerimiento_adquisicion PRIMARY KEY (rd_codigo);


--
-- TOC entry 2092 (class 2606 OID 16789)
-- Name: pk_requerimiento_tecnico; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY requerimiento_tecnico
    ADD CONSTRAINT pk_requerimiento_tecnico PRIMARY KEY (rt_codigo);


--
-- TOC entry 2095 (class 2606 OID 16796)
-- Name: pk_sucursal; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY sucursal
    ADD CONSTRAINT pk_sucursal PRIMARY KEY (su_codigo);


--
-- TOC entry 2098 (class 2606 OID 16802)
-- Name: pk_tipo_curso; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_curso
    ADD CONSTRAINT pk_tipo_curso PRIMARY KEY (tc_codigo);


--
-- TOC entry 2101 (class 2606 OID 16808)
-- Name: pk_tipo_manual; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_manual
    ADD CONSTRAINT pk_tipo_manual PRIMARY KEY (tm_codigo);


--
-- TOC entry 2105 (class 2606 OID 16814)
-- Name: pk_usuario; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT pk_usuario PRIMARY KEY (us_codigo);


--
-- TOC entry 2041 (class 1259 OID 16680)
-- Name: coctel_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX coctel_pk ON coctel USING btree (cc_codigo);


--
-- TOC entry 2044 (class 1259 OID 16686)
-- Name: comuna_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX comuna_pk ON comuna USING btree (co_codigo);


--
-- TOC entry 2048 (class 1259 OID 16696)
-- Name: cronograma_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX cronograma_pk ON cronograma USING btree (cr_codigo);


--
-- TOC entry 2049 (class 1259 OID 16697)
-- Name: cronogramas_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX cronogramas_fk ON cronograma USING btree (ef_codigo);


--
-- TOC entry 2052 (class 1259 OID 16703)
-- Name: curso_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX curso_pk ON curso USING btree (cu_codigo);


--
-- TOC entry 2065 (class 1259 OID 16733)
-- Name: curso_sence_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX curso_sence_fk ON estudio_factibilidad USING btree (cu_codigo);


--
-- TOC entry 2055 (class 1259 OID 16714)
-- Name: empresa_comuna_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX empresa_comuna_fk ON empresa USING btree (co_codigo);


--
-- TOC entry 2060 (class 1259 OID 16722)
-- Name: empresa_estudio2_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX empresa_estudio2_fk ON empresa_estudio USING btree (em_codigo);


--
-- TOC entry 2061 (class 1259 OID 16721)
-- Name: empresa_estudio_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX empresa_estudio_fk ON empresa_estudio USING btree (ef_codigo);


--
-- TOC entry 2062 (class 1259 OID 16720)
-- Name: empresa_estudio_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX empresa_estudio_pk ON empresa_estudio USING btree (ef_codigo, em_codigo);


--
-- TOC entry 2056 (class 1259 OID 16712)
-- Name: empresa_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX empresa_pk ON empresa USING btree (em_codigo);


--
-- TOC entry 2066 (class 1259 OID 16731)
-- Name: estudio_factibilidad_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX estudio_factibilidad_pk ON estudio_factibilidad USING btree (ef_codigo);


--
-- TOC entry 2067 (class 1259 OID 16734)
-- Name: estudio_tipo_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX estudio_tipo_fk ON estudio_factibilidad USING btree (tc_codigo);


--
-- TOC entry 2109 (class 1259 OID 16947)
-- Name: factibilidad_academica_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX factibilidad_academica_fk ON requerimiento_academico USING btree (ef_codigo);


--
-- TOC entry 2090 (class 1259 OID 16791)
-- Name: factibilidad_tecnica_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX factibilidad_tecnica_fk ON requerimiento_tecnico USING btree (ef_codigo);


--
-- TOC entry 2086 (class 1259 OID 16781)
-- Name: factiblidad_adquisicion_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX factiblidad_adquisicion_fk ON requerimiento_adquisicion USING btree (ef_codigo);


--
-- TOC entry 2057 (class 1259 OID 16713)
-- Name: giro_empresarial_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX giro_empresarial_fk ON empresa USING btree (gi_codigo);


--
-- TOC entry 2072 (class 1259 OID 16741)
-- Name: giro_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX giro_pk ON giro USING btree (gi_codigo);


--
-- TOC entry 2068 (class 1259 OID 16732)
-- Name: manual_factibilidad_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX manual_factibilidad_fk ON estudio_factibilidad USING btree (tm_codigo);


--
-- TOC entry 2075 (class 1259 OID 16747)
-- Name: perfil_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX perfil_pk ON perfil USING btree (pe_codigo);


--
-- TOC entry 2103 (class 1259 OID 16816)
-- Name: perfil_usuario_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX perfil_usuario_fk ON usuario USING btree (pe_codigo);


--
-- TOC entry 2047 (class 1259 OID 16687)
-- Name: region_comuna_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX region_comuna_fk ON comuna USING btree (re_codigo);


--
-- TOC entry 2080 (class 1259 OID 16753)
-- Name: region_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX region_pk ON region USING btree (re_codigo);


--
-- TOC entry 2083 (class 1259 OID 16761)
-- Name: relatores2_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relatores2_fk ON relatores USING btree (us_codigo);


--
-- TOC entry 2084 (class 1259 OID 16760)
-- Name: relatores_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX relatores_fk ON relatores USING btree (ra_codigo);


--
-- TOC entry 2085 (class 1259 OID 16759)
-- Name: relatores_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX relatores_pk ON relatores USING btree (ra_codigo, us_codigo);


--
-- TOC entry 2112 (class 1259 OID 16946)
-- Name: requerimiento_academico_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX requerimiento_academico_pk ON requerimiento_academico USING btree (ra_codigo);


--
-- TOC entry 2089 (class 1259 OID 16780)
-- Name: requerimiento_adquisicion_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX requerimiento_adquisicion_pk ON requerimiento_adquisicion USING btree (rd_codigo);


--
-- TOC entry 2093 (class 1259 OID 16790)
-- Name: requerimiento_tecnico_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX requerimiento_tecnico_pk ON requerimiento_tecnico USING btree (rt_codigo);


--
-- TOC entry 2096 (class 1259 OID 16797)
-- Name: sucursal_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX sucursal_pk ON sucursal USING btree (su_codigo);


--
-- TOC entry 2106 (class 1259 OID 16817)
-- Name: sucusal_usuario_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX sucusal_usuario_fk ON usuario USING btree (su_codigo);


--
-- TOC entry 2099 (class 1259 OID 16803)
-- Name: tipo_curso_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX tipo_curso_pk ON tipo_curso USING btree (tc_codigo);


--
-- TOC entry 2102 (class 1259 OID 16809)
-- Name: tipo_manual_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX tipo_manual_pk ON tipo_manual USING btree (tm_codigo);


--
-- TOC entry 2107 (class 1259 OID 16818)
-- Name: usuario_comuna_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX usuario_comuna_fk ON usuario USING btree (co_codigo);


--
-- TOC entry 2108 (class 1259 OID 16815)
-- Name: usuario_pk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX usuario_pk ON usuario USING btree (us_codigo);


--
-- TOC entry 2071 (class 1259 OID 16735)
-- Name: vendedor_fk; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX vendedor_fk ON estudio_factibilidad USING btree (us_codigo);


--
-- TOC entry 2117 (class 2606 OID 16819)
-- Name: fk_coctel_entrega_d_requerim; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY coctel
    ADD CONSTRAINT fk_coctel_entrega_d_requerim FOREIGN KEY (rd_codigo) REFERENCES requerimiento_adquisicion(rd_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2118 (class 2606 OID 16824)
-- Name: fk_comuna_region_co_region; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY comuna
    ADD CONSTRAINT fk_comuna_region_co_region FOREIGN KEY (re_codigo) REFERENCES region(re_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2136 (class 2606 OID 16980)
-- Name: fk_costos_presupuesto; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY costos_operativos
    ADD CONSTRAINT fk_costos_presupuesto FOREIGN KEY (pr_codigo) REFERENCES presupuesto(pr_codigo);


--
-- TOC entry 2119 (class 2606 OID 16829)
-- Name: fk_cronogra_cronogram_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cronograma
    ADD CONSTRAINT fk_cronogra_cronogram_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2123 (class 2606 OID 16849)
-- Name: fk_empresa__empresa_e_empresa; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa_estudio
    ADD CONSTRAINT fk_empresa__empresa_e_empresa FOREIGN KEY (em_codigo) REFERENCES empresa(em_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2122 (class 2606 OID 16844)
-- Name: fk_empresa__empresa_e_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa_estudio
    ADD CONSTRAINT fk_empresa__empresa_e_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2120 (class 2606 OID 16834)
-- Name: fk_empresa_empresa_c_comuna; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa
    ADD CONSTRAINT fk_empresa_empresa_c_comuna FOREIGN KEY (co_codigo) REFERENCES comuna(co_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2121 (class 2606 OID 16839)
-- Name: fk_empresa_giro_empr_giro; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY empresa
    ADD CONSTRAINT fk_empresa_giro_empr_giro FOREIGN KEY (gi_codigo) REFERENCES giro(gi_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2124 (class 2606 OID 16854)
-- Name: fk_estudio__curso_sen_curso; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__curso_sen_curso FOREIGN KEY (cu_codigo) REFERENCES curso(cu_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2125 (class 2606 OID 16859)
-- Name: fk_estudio__estudio_t_tipo_cur; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__estudio_t_tipo_cur FOREIGN KEY (tc_codigo) REFERENCES tipo_curso(tc_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2126 (class 2606 OID 16864)
-- Name: fk_estudio__manual_fa_tipo_man; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__manual_fa_tipo_man FOREIGN KEY (tm_codigo) REFERENCES tipo_manual(tm_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2127 (class 2606 OID 16869)
-- Name: fk_estudio__vendedor_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estudio_factibilidad
    ADD CONSTRAINT fk_estudio__vendedor_usuario FOREIGN KEY (us_codigo) REFERENCES usuario(us_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2135 (class 2606 OID 16975)
-- Name: fk_presupuesto_estudio; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY presupuesto
    ADD CONSTRAINT fk_presupuesto_estudio FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo);


--
-- TOC entry 2128 (class 2606 OID 16879)
-- Name: fk_relatore_relatores_usuario; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY relatores
    ADD CONSTRAINT fk_relatore_relatores_usuario FOREIGN KEY (us_codigo) REFERENCES usuario(us_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2130 (class 2606 OID 16894)
-- Name: fk_requerim_factibili_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY requerimiento_tecnico
    ADD CONSTRAINT fk_requerim_factibili_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2134 (class 2606 OID 16953)
-- Name: fk_requerim_factibili_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY requerimiento_academico
    ADD CONSTRAINT fk_requerim_factibili_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2129 (class 2606 OID 16889)
-- Name: fk_requerim_factiblid_estudio_; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY requerimiento_adquisicion
    ADD CONSTRAINT fk_requerim_factiblid_estudio_ FOREIGN KEY (ef_codigo) REFERENCES estudio_factibilidad(ef_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2131 (class 2606 OID 16899)
-- Name: fk_usuario_perfil_us_perfil; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT fk_usuario_perfil_us_perfil FOREIGN KEY (pe_codigo) REFERENCES perfil(pe_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2132 (class 2606 OID 16904)
-- Name: fk_usuario_sucusal_u_sucursal; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT fk_usuario_sucusal_u_sucursal FOREIGN KEY (su_codigo) REFERENCES sucursal(su_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2133 (class 2606 OID 16909)
-- Name: fk_usuario_usuario_c_comuna; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuario
    ADD CONSTRAINT fk_usuario_usuario_c_comuna FOREIGN KEY (co_codigo) REFERENCES comuna(co_codigo) ON UPDATE RESTRICT ON DELETE RESTRICT;


--
-- TOC entry 2272 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2017-10-06 01:24:49 -03

--
-- PostgreSQL database dump complete
--

