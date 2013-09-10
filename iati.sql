--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: model_idx; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE model_idx
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.model_idx OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: models; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE models (
    map text,
    filename character varying(255),
    ts timestamp without time zone DEFAULT now(),
    modelname character varying(255),
    orgdata text,
    id integer NOT NULL,
    updatets timestamp without time zone DEFAULT now(),
    userid integer
);


ALTER TABLE public.models OWNER TO postgres;

--
-- Name: models_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE models_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.models_id_seq OWNER TO postgres;

--
-- Name: models_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE models_id_seq OWNED BY models.id;


--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    username character varying(255) NOT NULL,
    first character varying(255),
    last character varying(255),
    organization character varying(500),
    reference character varying(500),
    orgtype character varying(500),
    password character varying(32),
    currency character varying(255),
    language character varying(255),
    phone character varying(255),
    address character varying(255),
    regts timestamp without time zone DEFAULT now(),
    updatets timestamp without time zone DEFAULT now(),
    id integer DEFAULT nextval('users_id_seq'::regclass) NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY models ALTER COLUMN id SET DEFAULT nextval('models_id_seq'::regclass);


--
-- Name: model_idx; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('model_idx', 1, false);


--
-- Data for Name: models; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY models (map, filename, ts, modelname, orgdata, id, updatets, userid) FROM stdin;
%7B%0A%20%20%22title.4480%22%3A%20%7B%0A%20%20%20%20%22text%22%3A%20%22Project%20Title%22%0A%20%20%7D%0A%7D	upload/1378415242-1851565066.csv	2013-09-05 14:07:39.392887	testing	a:11:{s:7:"orgname";s:33:"Spatial Development International";s:6:"orgref";s:21:"http://spatialdev.com";s:7:"orgtype";s:2:"21";s:11:"orgcurrency";s:3:"USD";s:11:"orglanguage";s:2:"en";s:10:"orgcontact";s:14:"Grant McKenzie";s:8:"orgphone";s:12:"555-324-5325";s:8:"orgemail";s:14:"grantdmckenzie";s:10:"orgaddress";s:13:"123 Home Ave.";s:1:"u";s:1:"1";s:6:"submit";s:11:"Next Step >";}	46	2013-09-05 14:10:46.309608	2
%7B%0A%20%20%22title.1116%22%3A%20%7B%0A%20%20%20%20%22text%22%3A%20%22GeoId%22%0A%20%20%7D%0A%7D	upload/1378415462-21414020.csv	2013-09-05 14:11:10.186604	asdf	a:11:{s:7:"orgname";s:33:"Spatial Development International";s:6:"orgref";s:21:"http://spatialdev.com";s:7:"orgtype";s:2:"21";s:11:"orgcurrency";s:3:"USD";s:11:"orglanguage";s:2:"en";s:10:"orgcontact";s:14:"Grant McKenzie";s:8:"orgphone";s:12:"555-324-5325";s:8:"orgemail";s:14:"grantdmckenzie";s:10:"orgaddress";s:13:"123 Home Ave.";s:1:"u";s:1:"1";s:6:"submit";s:11:"Next Step >";}	47	2013-09-05 14:11:10.186604	2
%7B%0A%20%20%22title.3525%22%3A%20%7B%0A%20%20%20%20%22text%22%3A%20%22Project%20Title%22%0A%20%20%7D%2C%0A%20%20%22iati-identifier.3919%22%3A%20%7B%0A%20%20%20%20%22text%22%3A%20%22Activity%20Id%22%0A%20%20%7D%2C%0A%20%20%22location.6210%22%3A%20%7B%0A%20%20%20%20%22name%22%3A%20%7B%0A%20%20%20%20%20%20%22text%22%3A%20%22Name%22%0A%20%20%20%20%7D%2C%0A%20%20%20%20%22coordinates%22%3A%20%7B%0A%20%20%20%20%20%20%22latitude%22%3A%20%22Latitude%22%2C%0A%20%20%20%20%20%20%22longitude%22%3A%20%22Longitude%22%0A%20%20%20%20%7D%2C%0A%20%20%20%20%22administrative%22%3A%20%7B%0A%20%20%20%20%20%20%22text%22%3A%20%22Name%22%2C%0A%20%20%20%20%20%20%22country%22%3A%20%22CountryCode%20%28ISO-2%29%22%0A%20%20%20%20%7D%0A%20%20%7D%2C%0A%20%20%22description.4573%22%3A%20%7B%0A%20%20%20%20%22text%22%3A%20%22Outputs%22%0A%20%20%7D%0A%7D	upload/1378774277-688426983.csv	2013-09-09 17:51:30.945768	test2	a:11:{s:7:"orgname";s:33:"Spatial Development International";s:6:"orgref";s:21:"http://spatialdev.com";s:7:"orgtype";s:2:"21";s:11:"orgcurrency";s:3:"USD";s:11:"orglanguage";s:2:"en";s:10:"orgcontact";s:14:"Grant McKenzie";s:8:"orgphone";s:12:"555-324-5325";s:8:"orgemail";s:14:"grantdmckenzie";s:10:"orgaddress";s:13:"123 Home Ave.";s:1:"u";s:1:"1";s:6:"submit";s:11:"Next Step >";}	48	2013-09-09 19:02:38.122225	2
\.


--
-- Name: models_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('models_id_seq', 48, true);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (username, first, last, organization, reference, orgtype, password, currency, language, phone, address, regts, updatets, id) FROM stdin;
jharpster	Jubal	Harpster	Spatial Development International	http://spatialdev.com	21	31d7b7c5fc176f023e42a33377d4b470	\N	\N	\N	\N	2013-08-31 21:02:42.737125	2013-08-31 21:02:50.536084	1
grantdmckenzie	Grant	McKenzie	Ministry%20for%20Agriculture%20and%20Environment	AT-10	21	74d186de7fa2f444067e76e7abab1a02	USD	English	555-324-5325	123%20Home%20Ave.	2013-08-31 21:02:42.737125	2013-08-31 21:02:50.536084	2
\.


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 2, true);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- Name: models; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE models FROM PUBLIC;
REVOKE ALL ON TABLE models FROM postgres;
GRANT ALL ON TABLE models TO postgres;
GRANT ALL ON TABLE models TO iati;


--
-- Name: models_id_seq; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON SEQUENCE models_id_seq FROM PUBLIC;
REVOKE ALL ON SEQUENCE models_id_seq FROM postgres;
GRANT ALL ON SEQUENCE models_id_seq TO postgres;
GRANT ALL ON SEQUENCE models_id_seq TO iati;


--
-- Name: users; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE users FROM PUBLIC;
REVOKE ALL ON TABLE users FROM postgres;
GRANT ALL ON TABLE users TO postgres;
GRANT ALL ON TABLE users TO iati;


--
-- PostgreSQL database dump complete
--

