-- phpMyAdmin SQL Dump
-- version 3.2.2
-- http://www.phpmyadmin.net
--
-- Poèítaè: localhost
-- Vygenerováno: Pondìlí 29. listopadu 2010, 00:52
-- Verze MySQL: 5.0.32
-- Verze PHP: 5.2.0-8+etch15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Databáze: `zamekstrazovice`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL auto_increment,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `auth` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `galerie`
--

CREATE TABLE IF NOT EXISTS `galerie` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `title` text NOT NULL,
  `parent` int(11) NOT NULL,
  `show` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `html`
--

CREATE TABLE IF NOT EXISTS `html` (
  `id` int(11) NOT NULL auto_increment,
  `content` text NOT NULL,
  `parent` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `style` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=587 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `html_style`
--

CREATE TABLE IF NOT EXISTS `html_style` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `css` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL auto_increment COMMENT 'id',
  `name` text NOT NULL COMMENT 'název',
  `parent` int(11) NOT NULL COMMENT 'rodiè menu',
  `order` int(11) NOT NULL COMMENT 'tøídìní',
  `link` varchar(50) NOT NULL,
  `visible` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=446 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `menu_in`
--

CREATE TABLE IF NOT EXISTS `menu_in` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `target` int(11) NOT NULL,
  `href` varchar(50) NOT NULL,
  `parent` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `link` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=99 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(11) NOT NULL auto_increment,
  `first` int(50) NOT NULL,
  `width` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=631 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `page_parts`
--

CREATE TABLE IF NOT EXISTS `page_parts` (
  `id` int(11) NOT NULL auto_increment,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2 AUTO_INCREMENT=675 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `plan_akci`
--

CREATE TABLE IF NOT EXISTS `plan_akci` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  `kdy` date NOT NULL,
  `do` date NOT NULL,
  `kde` varchar(50) NOT NULL,
  `co` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `time` datetime NOT NULL,
  `parent` int(11) NOT NULL,
  `limit_lidi` int(11) NOT NULL,
  `cena` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `plan_akci_prihlaseni`
--

CREATE TABLE IF NOT EXISTS `plan_akci_prihlaseni` (
  `id` int(11) NOT NULL auto_increment,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `akce` int(11) NOT NULL,
  `vs` varchar(50) NOT NULL,
  `zaplatil` int(11) NOT NULL,
  `telefonni_cislo` varchar(13) NOT NULL,
  `adresa` text NOT NULL,
  `poznamka` text NOT NULL,
  `mailed` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop`
--

CREATE TABLE IF NOT EXISTS `shop` (
  `id` int(11) NOT NULL auto_increment,
  `nazev` varchar(50) NOT NULL,
  `popis` text NOT NULL,
  `cena` double NOT NULL,
  `dph` double NOT NULL,
  `skladem` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  `vyrobce` varchar(50) NOT NULL,
  `doporucujeme` int(11) NOT NULL,
  `show` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_kosik`
--

CREATE TABLE IF NOT EXISTS `shop_kosik` (
  `id` int(11) NOT NULL auto_increment,
  `id_produkt` int(11) NOT NULL,
  `pocet` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_menu`
--

CREATE TABLE IF NOT EXISTS `shop_menu` (
  `id` int(11) NOT NULL auto_increment,
  `nazev` varchar(50) NOT NULL,
  `link` varchar(50) NOT NULL,
  `parent` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `shop_objednavky`
--

CREATE TABLE IF NOT EXISTS `shop_objednavky` (
  `id` int(11) NOT NULL auto_increment,
  `cislo` int(11) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `ulice` varchar(50) NOT NULL,
  `obec` varchar(50) NOT NULL,
  `psc` varchar(50) NOT NULL,
  `stat` varchar(50) NOT NULL,
  `poznamka` text NOT NULL,
  `doprava` varchar(50) NOT NULL,
  `cena_bez_dph` double NOT NULL,
  `cena_s_dph` double NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL auto_increment,
  `hash` varchar(50) NOT NULL,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `ulice` varchar(50) NOT NULL,
  `obec` varchar(50) NOT NULL,
  `psc` varchar(50) NOT NULL,
  `stat` varchar(50) NOT NULL,
  `last` datetime NOT NULL,
  `useragent` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;
