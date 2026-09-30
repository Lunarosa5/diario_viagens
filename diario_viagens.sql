--
-- PostgreSQL database dump
--

\restrict eGSZ9Ik2yzXMkAUNAqB8uhEiWIKCLksmM1hmUEC1wDe9lMriuyufQLBKtCC6LZk

-- Dumped from database version 18.6
-- Dumped by pg_dump version 18.6

-- Started on 2026-09-29 17:08:42

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 224 (class 1259 OID 16449)
-- Name: fotos_viagem; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fotos_viagem (
    id integer NOT NULL,
    id_viagem integer NOT NULL,
    nome_arquivo character varying(255) NOT NULL
);


ALTER TABLE public.fotos_viagem OWNER TO postgres;

--
-- TOC entry 223 (class 1259 OID 16448)
-- Name: fotos_viagem_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fotos_viagem_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fotos_viagem_id_seq OWNER TO postgres;

--
-- TOC entry 4936 (class 0 OID 0)
-- Dependencies: 223
-- Name: fotos_viagem_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fotos_viagem_id_seq OWNED BY public.fotos_viagem.id;


--
-- TOC entry 220 (class 1259 OID 16415)
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 219 (class 1259 OID 16414)
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO postgres;

--
-- TOC entry 4937 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- TOC entry 222 (class 1259 OID 16428)
-- Name: viagens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.viagens (
    id integer NOT NULL,
    id_usuario integer NOT NULL,
    titulo character varying(150) NOT NULL,
    destino character varying(150) NOT NULL,
    data_inicio date NOT NULL,
    data_fim date NOT NULL,
    relato text NOT NULL,
    avaliacao integer
);


ALTER TABLE public.viagens OWNER TO postgres;

--
-- TOC entry 221 (class 1259 OID 16427)
-- Name: viagens_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.viagens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.viagens_id_seq OWNER TO postgres;

--
-- TOC entry 4938 (class 0 OID 0)
-- Dependencies: 221
-- Name: viagens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.viagens_id_seq OWNED BY public.viagens.id;


--
-- TOC entry 4767 (class 2604 OID 16452)
-- Name: fotos_viagem id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fotos_viagem ALTER COLUMN id SET DEFAULT nextval('public.fotos_viagem_id_seq'::regclass);


--
-- TOC entry 4765 (class 2604 OID 16418)
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- TOC entry 4766 (class 2604 OID 16431)
-- Name: viagens id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.viagens ALTER COLUMN id SET DEFAULT nextval('public.viagens_id_seq'::regclass);


--
-- TOC entry 4930 (class 0 OID 16449)
-- Dependencies: 224
-- Data for Name: fotos_viagem; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fotos_viagem (id, id_viagem, nome_arquivo) FROM stdin;
\.


--
-- TOC entry 4926 (class 0 OID 16415)
-- Dependencies: 220
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.usuarios (id, nome, email, senha) FROM stdin;
\.


--
-- TOC entry 4928 (class 0 OID 16428)
-- Dependencies: 222
-- Data for Name: viagens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.viagens (id, id_usuario, titulo, destino, data_inicio, data_fim, relato, avaliacao) FROM stdin;
\.


--
-- TOC entry 4939 (class 0 OID 0)
-- Dependencies: 223
-- Name: fotos_viagem_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fotos_viagem_id_seq', 1, false);


--
-- TOC entry 4940 (class 0 OID 0)
-- Dependencies: 219
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 1, false);


--
-- TOC entry 4941 (class 0 OID 0)
-- Dependencies: 221
-- Name: viagens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.viagens_id_seq', 1, false);


--
-- TOC entry 4775 (class 2606 OID 16457)
-- Name: fotos_viagem fotos_viagem_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fotos_viagem
    ADD CONSTRAINT fotos_viagem_pkey PRIMARY KEY (id);


--
-- TOC entry 4769 (class 2606 OID 16426)
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- TOC entry 4771 (class 2606 OID 16424)
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 4773 (class 2606 OID 16442)
-- Name: viagens viagens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.viagens
    ADD CONSTRAINT viagens_pkey PRIMARY KEY (id);


--
-- TOC entry 4777 (class 2606 OID 16458)
-- Name: fotos_viagem fotos_viagem_id_viagem_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fotos_viagem
    ADD CONSTRAINT fotos_viagem_id_viagem_fkey FOREIGN KEY (id_viagem) REFERENCES public.viagens(id) ON DELETE CASCADE;


--
-- TOC entry 4776 (class 2606 OID 16443)
-- Name: viagens viagens_id_usuario_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.viagens
    ADD CONSTRAINT viagens_id_usuario_fkey FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id) ON DELETE CASCADE;


-- Completed on 2026-09-29 17:08:42

--
-- PostgreSQL database dump complete
--

\unrestrict eGSZ9Ik2yzXMkAUNAqB8uhEiWIKCLksmM1hmUEC1wDe9lMriuyufQLBKtCC6LZk

