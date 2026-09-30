--
-- PostgreSQL database dump
--

\restrict JGTkKfqNKYH1uRzJy6tkOXkf3H1MM9jQJd1HnPgTNBrfwlfvY0JsLex0NkClmjN

-- Dumped from database version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)
-- Dumped by pg_dump version 18.6 (Ubuntu 18.6-0ubuntu0.26.04.1)

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
-- Name: fotos_viagem; Type: TABLE; Schema: public; Owner: travely
--

CREATE TABLE public.fotos_viagem (
    id integer NOT NULL,
    id_viagem integer NOT NULL,
    nome_arquivo character varying(255) NOT NULL
);


ALTER TABLE public.fotos_viagem OWNER TO travely;

--
-- Name: fotos_viagem_id_seq; Type: SEQUENCE; Schema: public; Owner: travely
--

CREATE SEQUENCE public.fotos_viagem_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fotos_viagem_id_seq OWNER TO travely;

--
-- Name: fotos_viagem_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: travely
--

ALTER SEQUENCE public.fotos_viagem_id_seq OWNED BY public.fotos_viagem.id;


--
-- Name: usuarios; Type: TABLE; Schema: public; Owner: travely
--

CREATE TABLE public.usuarios (
    id integer NOT NULL,
    nome character varying(100) NOT NULL,
    email character varying(100) NOT NULL,
    senha character varying(255) NOT NULL
);


ALTER TABLE public.usuarios OWNER TO travely;

--
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: travely
--

CREATE SEQUENCE public.usuarios_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.usuarios_id_seq OWNER TO travely;

--
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: travely
--

ALTER SEQUENCE public.usuarios_id_seq OWNED BY public.usuarios.id;


--
-- Name: viagens; Type: TABLE; Schema: public; Owner: travely
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


ALTER TABLE public.viagens OWNER TO travely;

--
-- Name: viagens_id_seq; Type: SEQUENCE; Schema: public; Owner: travely
--

CREATE SEQUENCE public.viagens_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.viagens_id_seq OWNER TO travely;

--
-- Name: viagens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: travely
--

ALTER SEQUENCE public.viagens_id_seq OWNED BY public.viagens.id;


--
-- Name: fotos_viagem id; Type: DEFAULT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.fotos_viagem ALTER COLUMN id SET DEFAULT nextval('public.fotos_viagem_id_seq'::regclass);


--
-- Name: usuarios id; Type: DEFAULT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.usuarios ALTER COLUMN id SET DEFAULT nextval('public.usuarios_id_seq'::regclass);


--
-- Name: viagens id; Type: DEFAULT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.viagens ALTER COLUMN id SET DEFAULT nextval('public.viagens_id_seq'::regclass);


--
-- Data for Name: fotos_viagem; Type: TABLE DATA; Schema: public; Owner: travely
--

COPY public.fotos_viagem (id, id_viagem, nome_arquivo) FROM stdin;
\.


--
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: travely
--

COPY public.usuarios (id, nome, email, senha) FROM stdin;
1	Luna	luna@gmail.com	$2y$12$rk.UQBk286aXI6JW21VBLOz2EfsGoyyLgpByLGnizZQazd938ZefO
2	Luna	teste@gmail.com	$2y$12$5CZUVhukfASgqZr94P.aAukgt8YUpgoIm721pGMXmPvO8BzABXi8W
\.


--
-- Data for Name: viagens; Type: TABLE DATA; Schema: public; Owner: travely
--

COPY public.viagens (id, id_usuario, titulo, destino, data_inicio, data_fim, relato, avaliacao) FROM stdin;
\.


--
-- Name: fotos_viagem_id_seq; Type: SEQUENCE SET; Schema: public; Owner: travely
--

SELECT pg_catalog.setval('public.fotos_viagem_id_seq', 1, false);


--
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: travely
--

SELECT pg_catalog.setval('public.usuarios_id_seq', 3, true);


--
-- Name: viagens_id_seq; Type: SEQUENCE SET; Schema: public; Owner: travely
--

SELECT pg_catalog.setval('public.viagens_id_seq', 1, false);


--
-- Name: fotos_viagem fotos_viagem_pkey; Type: CONSTRAINT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.fotos_viagem
    ADD CONSTRAINT fotos_viagem_pkey PRIMARY KEY (id);


--
-- Name: usuarios usuarios_email_key; Type: CONSTRAINT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_email_key UNIQUE (email);


--
-- Name: usuarios usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- Name: viagens viagens_pkey; Type: CONSTRAINT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.viagens
    ADD CONSTRAINT viagens_pkey PRIMARY KEY (id);


--
-- Name: fotos_viagem fk_fotos_viagem; Type: FK CONSTRAINT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.fotos_viagem
    ADD CONSTRAINT fk_fotos_viagem FOREIGN KEY (id_viagem) REFERENCES public.viagens(id) ON DELETE CASCADE;


--
-- Name: viagens fk_viagens_usuario; Type: FK CONSTRAINT; Schema: public; Owner: travely
--

ALTER TABLE ONLY public.viagens
    ADD CONSTRAINT fk_viagens_usuario FOREIGN KEY (id_usuario) REFERENCES public.usuarios(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict JGTkKfqNKYH1uRzJy6tkOXkf3H1MM9jQJd1HnPgTNBrfwlfvY0JsLex0NkClmjN

