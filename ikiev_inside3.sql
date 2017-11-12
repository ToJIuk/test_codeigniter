-- phpMyAdmin SQL Dump
-- version 4.0.10.12
-- http://www.phpmyadmin.net
--
-- Хост: ikiev.mysql.ukraine.com.ua
-- Время создания: Окт 03 2017 г., 01:53
-- Версия сервера: 5.6.27-75.0-log
-- Версия PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `ikiev_inside3`
--

-- --------------------------------------------------------

--
-- Структура таблицы `demo_inputs`
--

CREATE TABLE IF NOT EXISTS `demo_inputs` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `select_input` int(2) NOT NULL,
  `text` varchar(128) NOT NULL,
  `text_ext` varchar(256) NOT NULL,
  `select_checkbox` int(1) NOT NULL,
  `user_select` int(8) NOT NULL,
  `date` date NOT NULL,
  `ac_select_from_table` int(8) NOT NULL,
  `checkbox` int(1) NOT NULL,
  `html` text NOT NULL,
  `image` varchar(256) DEFAULT NULL,
  `ip` varbinary(16) NOT NULL,
  `link` varchar(256) NOT NULL,
  `password` varchar(128) NOT NULL,
  `text_noedit` varchar(256) NOT NULL,
  `unix_time` int(128) NOT NULL,
  `textarea` varchar(1024) NOT NULL,
  `serialize_arr` varchar(1024) NOT NULL,
  `parent_select_custom` int(8) NOT NULL,
  `select_from_table` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `demo_inputs`
--

INSERT INTO `demo_inputs` (`id`, `select_input`, `text`, `text_ext`, `select_checkbox`, `user_select`, `date`, `ac_select_from_table`, `checkbox`, `html`, `image`, `ip`, `link`, `password`, `text_noedit`, `unix_time`, `textarea`, `serialize_arr`, `parent_select_custom`, `select_from_table`) VALUES
(1, 1, 'fsdfds', '', 0, 0, '2017-03-15', 0, 0, '', '', '0', '', '', '', 0, '', 's:0:"";', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'content', 'Content Manager'),
(4, 'owner', 'Owner'),
(5, 'partner', 'Partner'),
(6, 'client', 'Client'),
(7, 'staff', 'Wisdom System Team'),
(8, 'demo', 'Demo');

-- --------------------------------------------------------

--
-- Структура таблицы `groups_access`
--

CREATE TABLE IF NOT EXISTS `groups_access` (
  `groups_access_rel_id` int(8) NOT NULL DEFAULT '0',
  `group_id` int(8) NOT NULL,
  `module_id` int(4) NOT NULL,
  `module_init` int(1) NOT NULL,
  `module_view` int(1) NOT NULL,
  `module_edit` int(1) NOT NULL,
  `access_code` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups_access`
--

INSERT INTO `groups_access` (`groups_access_rel_id`, `group_id`, `module_id`, `module_init`, `module_view`, `module_edit`, `access_code`) VALUES
(0, 7, 2, 1, 1, 0, ''),
(0, 7, 5, 1, 1, 0, ''),
(0, 7, 79, 1, 1, 0, ''),
(0, 7, 80, 1, 1, 0, ''),
(0, 7, 81, 1, 1, 0, ''),
(0, 7, 4, 1, 1, 0, ''),
(0, 7, 36, 1, 1, 0, ''),
(0, 7, 58, 1, 1, 1, ''),
(0, 7, 62, 1, 1, 1, ''),
(0, 7, 74, 1, 1, 1, ''),
(0, 7, 88, 1, 1, 1, ''),
(0, 7, 89, 1, 1, 1, ''),
(0, 7, 90, 1, 1, 1, ''),
(0, 7, 37, 1, 1, 1, ''),
(0, 7, 3, 1, 1, 1, ''),
(0, 3, 4, 1, 1, 1, ''),
(0, 3, 36, 1, 1, 1, ''),
(0, 3, 40, 1, 1, 1, ''),
(0, 3, 41, 1, 1, 1, ''),
(0, 3, 42, 1, 1, 1, ''),
(0, 3, 60, 1, 1, 1, ''),
(0, 3, 61, 1, 1, 1, ''),
(0, 3, 63, 1, 1, 1, ''),
(0, 3, 37, 1, 1, 1, ''),
(0, 3, 3, 1, 1, 1, ''),
(0, 1, 2, 1, 1, 1, ''),
(0, 1, 76, 1, 1, 1, ''),
(0, 1, 5, 1, 1, 1, ''),
(0, 1, 7, 1, 1, 1, ''),
(0, 1, 14, 1, 1, 1, ''),
(0, 1, 15, 1, 1, 1, ''),
(0, 1, 1, 1, 1, 1, ''),
(0, 1, 8, 1, 1, 1, ''),
(0, 1, 79, 1, 1, 1, ''),
(0, 1, 80, 1, 1, 1, ''),
(0, 1, 81, 1, 1, 1, ''),
(0, 1, 4, 1, 1, 1, ''),
(0, 1, 71, 1, 1, 1, ''),
(0, 1, 70, 1, 1, 1, ''),
(0, 1, 69, 1, 1, 1, ''),
(0, 1, 64, 1, 1, 1, ''),
(0, 1, 65, 1, 1, 1, ''),
(0, 1, 68, 1, 1, 1, ''),
(0, 1, 36, 1, 1, 1, ''),
(0, 1, 57, 1, 1, 1, ''),
(0, 1, 40, 1, 1, 1, ''),
(0, 1, 41, 1, 1, 1, ''),
(0, 1, 42, 1, 1, 1, ''),
(0, 1, 60, 1, 1, 1, ''),
(0, 1, 61, 1, 1, 1, ''),
(0, 1, 63, 1, 1, 1, ''),
(0, 1, 66, 1, 1, 1, ''),
(0, 1, 67, 1, 1, 1, ''),
(0, 1, 94, 1, 1, 1, ''),
(0, 1, 95, 1, 1, 1, ''),
(0, 1, 96, 1, 1, 1, ''),
(0, 1, 58, 1, 1, 1, ''),
(0, 1, 62, 1, 1, 1, ''),
(0, 1, 74, 1, 1, 1, ''),
(0, 1, 88, 1, 1, 1, ''),
(0, 1, 89, 1, 1, 1, ''),
(0, 1, 90, 1, 1, 1, ''),
(0, 1, 75, 1, 1, 1, ''),
(0, 1, 85, 1, 1, 1, ''),
(0, 1, 86, 1, 1, 1, ''),
(0, 1, 87, 1, 1, 1, ''),
(0, 1, 59, 1, 1, 1, ''),
(0, 1, 77, 1, 1, 1, ''),
(0, 1, 84, 1, 1, 1, ''),
(0, 1, 82, 1, 1, 1, ''),
(0, 1, 83, 1, 1, 1, ''),
(0, 1, 37, 1, 1, 1, ''),
(0, 1, 3, 1, 1, 1, ''),
(0, 2, 2, 1, 1, 0, ''),
(0, 2, 79, 1, 1, 0, ''),
(0, 2, 80, 1, 1, 0, ''),
(0, 2, 81, 1, 1, 0, ''),
(0, 2, 4, 1, 1, 0, ''),
(0, 2, 71, 1, 1, 0, ''),
(0, 2, 70, 1, 1, 0, ''),
(0, 2, 69, 1, 1, 0, ''),
(0, 2, 64, 1, 1, 0, ''),
(0, 2, 65, 1, 1, 0, ''),
(0, 2, 68, 1, 1, 0, ''),
(0, 2, 36, 1, 1, 0, ''),
(0, 2, 57, 1, 1, 0, ''),
(0, 2, 40, 1, 1, 0, ''),
(0, 2, 41, 1, 1, 0, ''),
(0, 2, 42, 1, 1, 0, ''),
(0, 2, 60, 1, 1, 0, ''),
(0, 2, 61, 1, 1, 0, ''),
(0, 2, 63, 1, 1, 0, ''),
(0, 2, 66, 1, 1, 0, ''),
(0, 2, 67, 1, 1, 0, ''),
(0, 2, 94, 1, 1, 0, ''),
(0, 2, 95, 1, 1, 0, ''),
(0, 2, 96, 1, 1, 0, ''),
(0, 2, 58, 1, 1, 0, ''),
(0, 2, 62, 1, 1, 0, ''),
(0, 2, 74, 1, 1, 0, ''),
(0, 2, 88, 1, 1, 0, ''),
(0, 2, 89, 1, 1, 0, ''),
(0, 2, 90, 1, 1, 0, ''),
(0, 2, 75, 1, 1, 0, ''),
(0, 2, 85, 1, 1, 0, ''),
(0, 2, 86, 1, 1, 0, ''),
(0, 2, 87, 1, 1, 0, ''),
(0, 2, 59, 1, 1, 0, ''),
(0, 2, 77, 1, 1, 0, ''),
(0, 2, 82, 1, 1, 0, ''),
(0, 2, 37, 1, 1, 0, ''),
(0, 2, 3, 1, 1, 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `inside_log`
--

CREATE TABLE IF NOT EXISTS `inside_log` (
  `log_id` int(16) NOT NULL AUTO_INCREMENT,
  `log_datetime` int(32) NOT NULL,
  `log_sql` varchar(2048) NOT NULL,
  `log_table` varchar(64) NOT NULL,
  `log_user_id` int(16) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Дамп данных таблицы `inside_log`
--

INSERT INTO `inside_log` (`log_id`, `log_datetime`, `log_sql`, `log_table`, `log_user_id`) VALUES
(1, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  96', 'inside_top_menu', 1),
(2, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  90', 'inside_top_menu', 1),
(3, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  89', 'inside_top_menu', 1),
(4, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  88', 'inside_top_menu', 1),
(5, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  87', 'inside_top_menu', 1),
(6, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  86', 'inside_top_menu', 1),
(7, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  85', 'inside_top_menu', 1),
(8, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  84', 'inside_top_menu', 1),
(9, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  83', 'inside_top_menu', 1),
(10, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  82', 'inside_top_menu', 1),
(11, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  77', 'inside_top_menu', 1),
(12, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  74', 'inside_top_menu', 1),
(13, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  59', 'inside_top_menu', 1),
(14, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  56', 'inside_top_menu', 1),
(15, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  31', 'inside_top_menu', 1),
(16, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  29', 'inside_top_menu', 1),
(17, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  28', 'inside_top_menu', 1),
(18, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  27', 'inside_top_menu', 1),
(19, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  26', 'inside_top_menu', 1),
(20, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  25', 'inside_top_menu', 1),
(21, 1494022912, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  24', 'inside_top_menu', 1),
(22, 1494022956, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  15', 'inside_top_menu', 1),
(23, 1494022956, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  14', 'inside_top_menu', 1),
(24, 1494022956, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  12', 'inside_top_menu', 1),
(25, 1494022956, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  11', 'inside_top_menu', 1),
(26, 1494022956, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  10', 'inside_top_menu', 1),
(27, 1494022956, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  9', 'inside_top_menu', 1),
(28, 1494022956, 'DELETE FROM `inside_top_menu`\nWHERE `top_menu_id` =  8', 'inside_top_menu', 1),
(29, 1494023001, 'UPDATE `inside_top_menu` SET `top_menu_parent_id` = '''', `top_menu_haschild` = ''1'', `top_menu_name` = ''Management'', `top_menu_url` = '''', `top_menu_icon` = ''fa fa-industry'', `top_menu_icon_url` = '''', `top_menu_module_name` = '''', `top_menu_invisible` = ''1'', `top_menu_priority` = ''5'' WHERE `top_menu_id` =  ''58''', 'inside_top_menu', 1),
(30, 1494023031, 'UPDATE `inside_top_menu` SET `top_menu_parent_id` = '''', `top_menu_haschild` = ''1'', `top_menu_name` = ''Languages'', `top_menu_url` = '''', `top_menu_icon` = ''fa fa-book'', `top_menu_icon_url` = ''/inside/table/wm_vocabulary'', `top_menu_module_name` = '''', `top_menu_invisible` = ''1'', `top_menu_priority` = ''4'' WHERE `top_menu_id` =  ''79''', 'inside_top_menu', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `inside_row_chat`
--

CREATE TABLE IF NOT EXISTS `inside_row_chat` (
  `row_chat_id` int(8) NOT NULL AUTO_INCREMENT,
  `row_chat_table` varchar(32) NOT NULL,
  `row_chat_row_id` int(8) NOT NULL,
  `row_chat_user_id` int(8) NOT NULL,
  `row_chat_user_name` varchar(32) NOT NULL,
  `row_chat_content` varchar(2048) NOT NULL,
  `row_chat_datetime` datetime NOT NULL,
  `row_chat_invisible` int(1) NOT NULL,
  PRIMARY KEY (`row_chat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `inside_row_chat`
--

INSERT INTO `inside_row_chat` (`row_chat_id`, `row_chat_table`, `row_chat_row_id`, `row_chat_user_id`, `row_chat_user_name`, `row_chat_content`, `row_chat_datetime`, `row_chat_invisible`) VALUES
(1, 'it_orders', 9, 19, ' ', 'test', '2017-03-14 22:06:05', 0),
(2, 'it_orders', 9, 19, ' ', 'what need to do?', '2017-03-14 22:06:16', 0),
(3, 'inside_top_menu', 5, 19, ' ', 'Top-Menu =)', '2017-03-16 04:39:40', 0),
(4, 'inside_top_menu', 5, 19, ' ', 'Message...', '2017-03-16 04:40:46', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `inside_top_menu`
--

CREATE TABLE IF NOT EXISTS `inside_top_menu` (
  `top_menu_id` int(8) NOT NULL AUTO_INCREMENT,
  `top_menu_parent_id` int(8) NOT NULL,
  `top_menu_haschild` int(1) NOT NULL,
  `top_menu_name` varchar(64) NOT NULL,
  `top_menu_module_name` varchar(64) NOT NULL,
  `top_menu_url` varchar(128) NOT NULL,
  `top_menu_invisible` int(1) NOT NULL COMMENT '=1 invisible',
  `top_menu_priority` int(3) NOT NULL,
  `top_menu_width` int(8) NOT NULL,
  `top_menu_widthchild` int(8) NOT NULL,
  `top_menu_icon` varchar(64) NOT NULL,
  `top_menu_icon_url` varchar(128) NOT NULL,
  PRIMARY KEY (`top_menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=99 ;

--
-- Дамп данных таблицы `inside_top_menu`
--

INSERT INTO `inside_top_menu` (`top_menu_id`, `top_menu_parent_id`, `top_menu_haschild`, `top_menu_name`, `top_menu_module_name`, `top_menu_url`, `top_menu_invisible`, `top_menu_priority`, `top_menu_width`, `top_menu_widthchild`, `top_menu_icon`, `top_menu_icon_url`) VALUES
(1, 2, 0, 'Groups', '', '/inside/table/groups', 0, 51, 0, 0, '', ''),
(2, 0, 1, 'Settings', '', '', 0, 2, 0, 0, 'fa fa-tachometer', '/admin/dashboard/'),
(3, 0, 0, 'LogOut', '', '/inside_auth/logout', 0, 70, 0, 0, 'fa fa-sign-out', '/inside_auth/logout'),
(4, 0, 1, 'Web-Site CMS', '', '', 0, 4, 0, 0, 'fa fa-file-text-o', '/inside/table/it_content'),
(5, 2, 0, 'Inside-menu', 'inside2_inside_top_menu', '/inside/table/inside_top_menu', 0, 1, 0, 0, '', ''),
(7, 2, 0, 'Users', 'inside2_users', '/inside/table/users', 0, 2, 0, 0, '', ''),
(16, 8, 1, 'Access System', '', '', 0, 200, 0, 200, '', ''),
(17, 8, 1, 'System Parts', '', '', 0, -1, 0, 200, '', ''),
(18, 8, 1, 'LOGing System', '', '', 0, 210, 0, 200, '', ''),
(19, 18, 0, 'Rows Chat log', '', '/inside/table/inside_row_chat', 0, 0, 0, 0, '', ''),
(30, 8, 1, 'Tests', '', '', 0, 500, 0, 0, '', ''),
(35, 8, 0, 'Demo Inside Inputs', '', '/inside/table/demo_inputs', 0, 0, 0, 0, '', ''),
(36, 4, 0, 'Content', 'inside2_it_content', '/inside/table/it_content', 0, -5, 0, 0, '', ''),
(37, 0, 0, 'Exit', '', '/', 0, 6, 0, 0, 'fa fa-road', '/'),
(40, 4, 0, 'Categories', '', '/inside/table/it_categories', 0, 0, 0, 0, '', ''),
(41, 4, 0, 'Tags', '', '/inside/table/it_tags', 0, 4, 0, 0, '', ''),
(42, 4, 0, 'Comments', '', '/inside/table/it_comments', 0, 8, 0, 0, '', ''),
(57, 4, 0, 'Menu', '', '/inside/table/it_menu', 0, -3, 0, 0, '', ''),
(58, 0, 1, 'Management', '', '', 1, 5, 0, 0, 'fa fa-industry', ''),
(60, 4, 0, 'Banners', '', '/inside/table/it_banners', 0, 11, 0, 0, '', ''),
(61, 4, 0, 'Brands/Partners', '', '/inside/table/it_brands', 0, 14, 0, 0, '', ''),
(62, 58, 0, 'Contacts', '', '/inside/table/it_contacts', 0, -5, 0, 0, '', ''),
(63, 4, 0, 'Images/Gallery', '', '/inside/table/it_images', 0, 17, 0, 0, '', ''),
(64, 71, 0, 'Info Blocks', '', '/inside/table/it_info_block', 0, 21, 0, 0, '', ''),
(65, 71, 0, 'Links', '', '/inside/table/it_links', 0, 25, 0, 0, '', ''),
(66, 4, 0, 'Orders', '', '/inside/table/it_orders', 0, 31, 0, 0, '', ''),
(67, 4, 0, 'Requests', '', '/inside/table/it_requests', 0, 35, 0, 0, '', ''),
(68, 71, 0, 'SEO Blocks', '', '/inside/table/it_seo_blocks', 0, 41, 0, 0, '', ''),
(69, 71, 0, 'Content Options', '', '/inside/table/it_content_options', 0, 21, 0, 0, '', ''),
(70, 71, 0, 'Buy Blocks', '', '/inside/table/it_buy_block', 0, 21, 0, 0, '', ''),
(71, 4, 1, 'Advanced', '', '', 0, -10, 0, 0, '', ''),
(75, 58, 0, 'Tasks', '', '/inside/table/it_tasks', 0, 0, 0, 0, '', ''),
(76, 2, 0, 'Inside Log', '', '/inside/table/inside_log', 0, 0, 0, 0, '', ''),
(78, 77, 0, 'Landing Pages', '', '/inside/table/wm_landing', 1, 4, 0, 0, '', ''),
(79, 0, 1, 'Languages', '', '', 1, 4, 0, 0, 'fa fa-book', '/inside/table/wm_vocabulary'),
(80, 79, 0, 'Lang Names', 'inside2_wm_lang', '/inside/table/wm_lang', 0, 4, 0, 0, '', ''),
(81, 79, 0, 'Vocabulary', 'inside2_wm_vocabulary', '/inside/table/wm_vocabulary', 0, 4, 0, 0, '', ''),
(94, 0, 1, 'Advanced', '', '', 0, 5, 0, 0, 'fa fa-cog', ''),
(95, 94, 0, 'Crud Demo', 'crud_demo', '/crud/demo/', 0, 0, 0, 0, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `it_banners`
--

CREATE TABLE IF NOT EXISTS `it_banners` (
  `banners_id` int(11) NOT NULL AUTO_INCREMENT,
  `banners_link` varchar(128) NOT NULL,
  `banners_img` varchar(256) NOT NULL,
  `banners_text` varchar(512) NOT NULL,
  `banners_invisible` int(1) NOT NULL,
  `banners_type` int(2) NOT NULL,
  `banners_priority` int(2) NOT NULL,
  `banners_name` varchar(128) NOT NULL,
  PRIMARY KEY (`banners_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_brands`
--

CREATE TABLE IF NOT EXISTS `it_brands` (
  `brands_id` int(8) NOT NULL AUTO_INCREMENT,
  `brands_priority` int(4) NOT NULL,
  `brands_invisible` int(1) NOT NULL,
  `brands_name` varchar(255) NOT NULL,
  `brands_img` varchar(256) NOT NULL,
  PRIMARY KEY (`brands_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_buy_block`
--

CREATE TABLE IF NOT EXISTS `it_buy_block` (
  `buy_block_id` int(8) NOT NULL AUTO_INCREMENT,
  `buy_block_name` varchar(512) NOT NULL,
  `buy_block_button_text` varchar(128) NOT NULL,
  `buy_block_html` varchar(2048) NOT NULL,
  `buy_block_video` varchar(512) NOT NULL,
  `buy_block_img` varchar(256) NOT NULL,
  `buy_block_priority` int(3) NOT NULL,
  `buy_block_invisible` int(1) NOT NULL,
  PRIMARY KEY (`buy_block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_categories`
--

CREATE TABLE IF NOT EXISTS `it_categories` (
  `categories_id` int(11) NOT NULL AUTO_INCREMENT,
  `categories_name` varchar(128) NOT NULL,
  `categories_alias` varchar(128) NOT NULL,
  `categories_img` varchar(256) NOT NULL,
  `categories_small_img` varchar(256) NOT NULL,
  `categories_desc` varchar(2048) NOT NULL,
  `categories_html` text,
  `categories_landing` int(1) NOT NULL,
  `categories_invisible` int(1) NOT NULL,
  `categories_priority` int(2) NOT NULL,
  `categories_seo_title` varchar(512) NOT NULL,
  `categories_seo_description` varchar(512) NOT NULL,
  `categories_seo_keywords` varchar(512) NOT NULL,
  `categories_pid` int(8) NOT NULL,
  `categories_haschild` int(1) NOT NULL,
  PRIMARY KEY (`categories_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_comments`
--

CREATE TABLE IF NOT EXISTS `it_comments` (
  `comments_id` int(8) NOT NULL AUTO_INCREMENT,
  `comments_fio` varchar(128) NOT NULL,
  `comments_email` varchar(64) NOT NULL,
  `comments_link` varchar(512) NOT NULL,
  `comments_user_id` int(8) NOT NULL,
  `comments_text` varchar(2048) NOT NULL,
  `comments_date` date NOT NULL,
  `comments_time` varchar(256) NOT NULL,
  `comments_datetime` int(16) NOT NULL,
  `comments_source` varchar(64) NOT NULL,
  `comments_source_id` int(8) NOT NULL,
  `comments_invisible` int(1) NOT NULL,
  `comments_parent_id` int(8) NOT NULL,
  PRIMARY KEY (`comments_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_content`
--

CREATE TABLE IF NOT EXISTS `it_content` (
  `content_id` int(11) NOT NULL AUTO_INCREMENT,
  `content_alias` varchar(255) DEFAULT NULL COMMENT 'URL alias',
  `content_priority` int(11) DEFAULT NULL COMMENT 'Sorting rank',
  `content_invisible` int(1) NOT NULL,
  `content_name` varchar(255) DEFAULT NULL,
  `content_user_id` int(8) NOT NULL,
  `content_create_date` date NOT NULL,
  `content_type` int(11) DEFAULT NULL COMMENT 'Content type from $config[''page_cats'']',
  `content_order` int(1) NOT NULL,
  `content_price` int(8) NOT NULL,
  `content_time` int(8) NOT NULL,
  `content_lang` varchar(4) DEFAULT NULL COMMENT 'Content language',
  `content_desc` text COMMENT 'Short description',
  `content_html` text COMMENT 'HTML data',
  `content_img` varchar(45) DEFAULT NULL COMMENT 'Image filename',
  `content_seo_title` varchar(255) NOT NULL COMMENT '1',
  `content_seo_description` varchar(255) NOT NULL COMMENT '1',
  `content_seo_keywords` varchar(255) NOT NULL COMMENT '1',
  PRIMARY KEY (`content_id`),
  KEY `fk_nravo_page_nravo_pcat` (`content_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `it_content`
--

INSERT INTO `it_content` (`content_id`, `content_alias`, `content_priority`, `content_invisible`, `content_name`, `content_user_id`, `content_create_date`, `content_type`, `content_order`, `content_price`, `content_time`, `content_lang`, `content_desc`, `content_html`, `content_img`, `content_seo_title`, `content_seo_description`, `content_seo_keywords`) VALUES
(8, 'test', 0, 0, '111', 0, '2017-03-19', 1, 0, 0, 0, NULL, '<p>short dp</p>\n', '<p>text</p>\n', '', '', '', ''),
(21, 'test', 0, 0, 'Название', 0, '2017-03-22', 1, 0, 0, 0, NULL, '<p>Краткое описание</p>\n', '<p>Текст</p>\n', 'copy3_sunflower.jpg', '', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `it_content_options`
--

CREATE TABLE IF NOT EXISTS `it_content_options` (
  `options_id` int(8) NOT NULL AUTO_INCREMENT,
  `options_name` varchar(128) NOT NULL,
  `options_html` varchar(1024) NOT NULL,
  `options_priority` int(3) NOT NULL,
  `options_invisible` int(1) NOT NULL,
  PRIMARY KEY (`options_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `it_content_options`
--

INSERT INTO `it_content_options` (`options_id`, `options_name`, `options_html`, `options_priority`, `options_invisible`) VALUES
(1, 'Опция 1', '<p>Это дополнительные опции, очень полезны при разложении товара на составляющие.</p>\n', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `it_content_translate`
--

CREATE TABLE IF NOT EXISTS `it_content_translate` (
  `content_id` int(8) NOT NULL,
  `content_name` varchar(512) NOT NULL,
  `content_desc` varchar(2048) NOT NULL,
  `content_html` text NOT NULL,
  `content_lang_alias` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_images`
--

CREATE TABLE IF NOT EXISTS `it_images` (
  `images_id` int(8) NOT NULL AUTO_INCREMENT,
  `images_name` varchar(256) NOT NULL,
  `images_desc` varchar(1024) NOT NULL,
  `images_img` varchar(256) NOT NULL,
  `images_mini_img` varchar(256) NOT NULL,
  `images_priority` int(3) NOT NULL,
  `images_invisible` int(1) NOT NULL,
  PRIMARY KEY (`images_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_info_block`
--

CREATE TABLE IF NOT EXISTS `it_info_block` (
  `info_block_id` int(8) NOT NULL AUTO_INCREMENT,
  `info_block_name` varchar(64) NOT NULL,
  `info_block_html` varchar(512) NOT NULL,
  `info_block_link` varchar(256) NOT NULL,
  `info_block_img` varchar(256) NOT NULL,
  `info_block_priority` int(3) NOT NULL,
  `info_block_invisible` int(1) NOT NULL,
  PRIMARY KEY (`info_block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `it_info_block`
--

INSERT INTO `it_info_block` (`info_block_id`, `info_block_name`, `info_block_html`, `info_block_link`, `info_block_img`, `info_block_priority`, `info_block_invisible`) VALUES
(1, 'Демо Блок', '<p>Демо блок, которых может быть несколько. Удобен для фокуса на важной информации и ссылках.</p>\n', '', 'vizitka.png', 0, 0),
(2, 'Демо Блок 2', '<p>Демо блок, которых может быть несколько. Удобен для фокуса на важной информации и ссылках.</p>\n', '', 'copy0_vizitka.png', 0, 0),
(3, 'Демо Блок 3', '<p>Демо блок, которых может быть несколько. Удобен для фокуса на важной информации и ссылках.</p>\n', '', 'copy1_vizitka.png', 0, 0),
(4, 'Демо Блок 4', '<p>Демо блок, которых может быть несколько. Удобен для фокуса на важной информации и ссылках.</p>\n', '', 'copy2_vizitka.png', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `it_links`
--

CREATE TABLE IF NOT EXISTS `it_links` (
  `links_id` int(8) NOT NULL AUTO_INCREMENT,
  `links_name` varchar(256) NOT NULL,
  `links_url` varchar(1024) NOT NULL,
  `links_desc` varchar(1024) NOT NULL,
  `links_priority` int(3) NOT NULL,
  `links_invisible` int(1) NOT NULL,
  PRIMARY KEY (`links_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_menu`
--

CREATE TABLE IF NOT EXISTS `it_menu` (
  `menu_id` int(8) NOT NULL AUTO_INCREMENT,
  `menu_pid` int(8) NOT NULL,
  `menu_haschild` int(1) NOT NULL,
  `menu_name` varchar(256) NOT NULL,
  `menu_url` varchar(256) NOT NULL,
  `menu_invisible` int(1) NOT NULL,
  `menu_priority` int(3) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_orders`
--

CREATE TABLE IF NOT EXISTS `it_orders` (
  `orders_id` int(8) NOT NULL AUTO_INCREMENT,
  `orders_name` varchar(64) NOT NULL,
  `orders_email` varchar(32) NOT NULL,
  `orders_user_id` int(8) NOT NULL,
  `orders_cname` varchar(128) NOT NULL,
  `orders_phone` varchar(64) NOT NULL,
  `orders_advanced_info` varchar(2048) NOT NULL,
  `orders_info` varchar(2048) NOT NULL,
  `orders_full_address` varchar(256) NOT NULL,
  `orders_lat` varchar(16) NOT NULL,
  `orders_lng` varchar(16) NOT NULL,
  `orders_street` varchar(64) NOT NULL,
  `orders_number` varchar(32) NOT NULL,
  `orders_city` varchar(64) NOT NULL,
  `orders_district` varchar(64) NOT NULL,
  `orders_country` varchar(64) NOT NULL,
  `orders_datetime` int(32) NOT NULL,
  `orders_status` int(2) NOT NULL,
  PRIMARY KEY (`orders_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Дамп данных таблицы `it_orders`
--

INSERT INTO `it_orders` (`orders_id`, `orders_name`, `orders_email`, `orders_user_id`, `orders_cname`, `orders_phone`, `orders_advanced_info`, `orders_info`, `orders_full_address`, `orders_lat`, `orders_lng`, `orders_street`, `orders_number`, `orders_city`, `orders_district`, `orders_country`, `orders_datetime`, `orders_status`) VALUES
(9, 'test', '', 0, '', '', '', '', '', '', '', '', '', '', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_buy_block_content`
--

CREATE TABLE IF NOT EXISTS `it_rel_buy_block_content` (
  `buy_block_id` int(8) NOT NULL,
  `content_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_content_categories`
--

CREATE TABLE IF NOT EXISTS `it_rel_content_categories` (
  `content_id` int(8) NOT NULL,
  `category_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_content_options_ext`
--

CREATE TABLE IF NOT EXISTS `it_rel_content_options_ext` (
  `content_id` int(16) NOT NULL,
  `options_id` int(16) NOT NULL,
  `content_options_price` int(8) NOT NULL,
  `content_options_time` int(8) NOT NULL,
  `content_options_info` varchar(1024) NOT NULL,
  `content_options_priority` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_content_similar`
--

CREATE TABLE IF NOT EXISTS `it_rel_content_similar` (
  `content_id` int(8) NOT NULL,
  `content_similar_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_content_tags`
--

CREATE TABLE IF NOT EXISTS `it_rel_content_tags` (
  `content_id` int(8) NOT NULL,
  `tags_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_images_content`
--

CREATE TABLE IF NOT EXISTS `it_rel_images_content` (
  `images_id` int(8) NOT NULL,
  `content_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_info_block_content`
--

CREATE TABLE IF NOT EXISTS `it_rel_info_block_content` (
  `info_block_id` int(8) NOT NULL,
  `content_id` int(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_rel_links_content`
--

CREATE TABLE IF NOT EXISTS `it_rel_links_content` (
  `links_id` int(8) NOT NULL,
  `content_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `it_requests`
--

CREATE TABLE IF NOT EXISTS `it_requests` (
  `requests_id` int(8) NOT NULL AUTO_INCREMENT,
  `requests_user_name` varchar(64) NOT NULL,
  `requests_user_email` varchar(64) NOT NULL,
  `requests_user_id` int(8) NOT NULL,
  `requests_user_city` varchar(64) NOT NULL,
  `requests_user_phone` varchar(32) NOT NULL,
  `requests_user_site` varchar(64) NOT NULL,
  `requests_datetime` int(32) NOT NULL,
  `requests_message` varchar(2048) NOT NULL,
  `requests_invisible` int(1) NOT NULL,
  `requests_priority` int(3) NOT NULL,
  `requests_type` int(2) NOT NULL,
  `requests_result` int(2) NOT NULL,
  `requests_url` varchar(512) NOT NULL,
  PRIMARY KEY (`requests_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_seo_blocks`
--

CREATE TABLE IF NOT EXISTS `it_seo_blocks` (
  `seo_blocks_id` int(8) NOT NULL AUTO_INCREMENT,
  `seo_blocks_name` varchar(256) NOT NULL,
  `seo_blocks_url` varchar(256) NOT NULL,
  `seo_blocks_html` varchar(2048) NOT NULL,
  `seo_blocks_invisible` int(1) NOT NULL,
  PRIMARY KEY (`seo_blocks_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `it_tags`
--

CREATE TABLE IF NOT EXISTS `it_tags` (
  `tags_id` int(8) NOT NULL AUTO_INCREMENT,
  `tags_pid` int(8) NOT NULL,
  `tags_haschild` int(1) NOT NULL,
  `tags_invisible` int(1) NOT NULL,
  `tags_name` varchar(64) NOT NULL,
  `tags_desc` varchar(2048) NOT NULL,
  `tags_html` text NOT NULL,
  `tags_landing` int(1) NOT NULL,
  `tags_create_time` datetime NOT NULL,
  PRIMARY KEY (`tags_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `m_tasks`
--

CREATE TABLE IF NOT EXISTS `m_tasks` (
  `tasks_id` int(8) NOT NULL AUTO_INCREMENT,
  `tasks_name` varchar(256) NOT NULL,
  `tasks_time_add` int(32) NOT NULL,
  `tasks_time_edit` int(32) NOT NULL,
  `tasks_time_start` int(32) NOT NULL,
  `tasks_time_finish` int(32) NOT NULL,
  `tasks_time_check` int(32) NOT NULL,
  `tasks_dotime` varchar(64) NOT NULL,
  `tasks_contact_id` int(12) NOT NULL,
  `tasks_contact` varchar(128) NOT NULL,
  `tasks_creator_id` int(12) NOT NULL,
  `tasks_user_id` int(12) NOT NULL,
  `tasks_priority` int(8) NOT NULL,
  `tasks_info` text NOT NULL,
  `tasks_result` varchar(1024) NOT NULL,
  `tasks_outcome` varchar(64) NOT NULL,
  `tasks_income` varchar(64) NOT NULL,
  `tasks_status` int(4) NOT NULL,
  `tasks_access_type` int(4) NOT NULL,
  `tasks_log` text NOT NULL,
  `tasks_chat` text NOT NULL,
  PRIMARY KEY (`tasks_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `adv_info` varchar(1024) NOT NULL,
  `img` varchar(256) NOT NULL,
  `full_address` varchar(512) NOT NULL,
  `street` varchar(512) NOT NULL,
  `h_number` varchar(32) NOT NULL,
  `city` varchar(256) NOT NULL,
  `district` varchar(64) NOT NULL,
  `country` varchar(128) NOT NULL,
  `country_code` varchar(8) NOT NULL,
  `admin_area` varchar(256) NOT NULL,
  `social_vk` varchar(256) NOT NULL,
  `social_fb` varchar(256) NOT NULL,
  `our_partner` int(1) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `position` varchar(64) NOT NULL,
  `skype` varchar(32) NOT NULL,
  `birthday` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `adv_info`, `img`, `full_address`, `street`, `h_number`, `city`, `district`, `country`, `country_code`, `admin_area`, `social_vk`, `social_fb`, `our_partner`, `full_name`, `position`, `skype`, `birthday`) VALUES
(1, '4278255872', 'Admin', '$2y$08$xTNDE9rz51GMVMcNcqd8xehWjvyYd0E3PbqzEHRqwpeJyv19/FIuW', '9462e8eee0', 'root', '', NULL, NULL, 'rpfzYrdUkJ6UGe8pwpOiE.', 931338000, 1493991519, 1, 'root', '', '0', '0', '0', '1.jpg', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', 0, '', '', '', '0000-00-00'),
(19, '93.72.184.100', '', '', NULL, 'torrison1@gmail.com', NULL, NULL, NULL, NULL, 1399592811, 1506984242, 1, NULL, NULL, '0', '0', '0', '', '0', '0', '0', '0', '0', '0', '0', '0', '', '', 0, '', '', '', '0000-00-00'),
(24, '93.74.110.226', '', '$2y$08$xTNDE9rz51GMVMcNcqd8xehWjvyYd0E3PbqzEHRqwpeJyv19/FIuW', NULL, 'test@aaa.com', NULL, NULL, NULL, NULL, 1493991454, 1493991454, 1, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '0000-00-00'),
(25, '93.74.101.48', '', '$2y$08$7pZNZTww91x.c9HyCDf7zOZl4979PzfbxyvROTQEeojD33fzhHPxK', NULL, 'admin@inside3.ikiev.biz', NULL, NULL, NULL, NULL, 1504635995, 1506533188, 1, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '0000-00-00'),
(26, '93.74.101.48', '', '$2y$08$Uf0SDc1EUEzs/U.X1U1AiuGk4xwb4JNbDuenDuG4nRCQcFXxXmDRG', NULL, 'cd99@mail.ru', NULL, NULL, NULL, NULL, 1506618063, 1506618431, 1, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '0000-00-00'),
(27, '94.244.57.112', '', '$2y$08$UQgnnEYpQjl/EqEP/T2rbOA6kAE3UyxuIriwg8YjzowMmbLFqPcrK', NULL, 'a@mylo.ua', NULL, NULL, NULL, NULL, 1506669831, 1506669831, 1, NULL, NULL, NULL, NULL, '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=100 ;

--
-- Дамп данных таблицы `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(71, 19, 1),
(72, 19, 2),
(73, 19, 3),
(74, 19, 4),
(75, 19, 5),
(76, 19, 6),
(77, 19, 7),
(95, 24, 2),
(97, 25, 1),
(96, 25, 2),
(98, 26, 2),
(99, 27, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `wm_lang`
--

CREATE TABLE IF NOT EXISTS `wm_lang` (
  `lang_id` int(4) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(64) NOT NULL,
  `lang_alias` varchar(64) NOT NULL,
  `lang_img` varchar(246) NOT NULL,
  `lang_priority` int(2) NOT NULL,
  PRIMARY KEY (`lang_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `wm_lang`
--

INSERT INTO `wm_lang` (`lang_id`, `lang_name`, `lang_alias`, `lang_img`, `lang_priority`) VALUES
(1, 'lang_ru', 'ru', 'russian.png', 0),
(2, 'lang_en', 'en', 'en_flag.png', 0),
(9, 'lang_ua', 'ua', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `wm_vocabulary`
--

CREATE TABLE IF NOT EXISTS `wm_vocabulary` (
  `vocabulary_id` int(8) NOT NULL AUTO_INCREMENT,
  `vocabulary_name` text NOT NULL,
  `vocabulary_alias` varchar(64) NOT NULL,
  `vocabulary_lang` varchar(8) NOT NULL,
  `vocabulary_type` int(2) NOT NULL,
  PRIMARY KEY (`vocabulary_id`),
  KEY `vocabulary_lang` (`vocabulary_lang`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=170 ;

--
-- Дамп данных таблицы `wm_vocabulary`
--

INSERT INTO `wm_vocabulary` (`vocabulary_id`, `vocabulary_name`, `vocabulary_alias`, `vocabulary_lang`, `vocabulary_type`) VALUES
(1, 'Сохранить', 'save_data', 'ru', 0),
(2, 'Save data', 'save_data', 'en', 0),
(3, 'Номер телефона', 'phone_number', 'ru', 0),
(4, 'Доп. информация', 'about_info', 'ru', 0),
(20, 'Язык', 'language', 'ru', 0),
(21, 'Мова', 'language', 'ua', 0),
(22, 'Language', 'language', 'en', 0),
(7, 'Сменить Email или Пароль', 'pass_email_change', 'ru', 0),
(8, 'Ваш пароль', 'current_password', 'ru', 0),
(9, 'Новый пароль', 'new_password', 'ru', 0),
(10, 'Новый пароль еще раз', 'repeat_new_password', 'ru', 0),
(11, 'Обновить', 'update', 'ru', 0),
(23, 'Russian', 'lang_ru', 'en', 0),
(24, 'Російська', 'lang_ru', 'ua', 0),
(25, 'Русский', 'lang_ru', 'ru', 0),
(26, 'Ukrainian', 'lang_ua', 'en', 0),
(16, 'Данные сохранены!', 'data_saved', 'ru', 0),
(27, 'Українська', 'lang_ua', 'ua', 0),
(28, 'Украинский', 'lang_ua', 'ru', 0),
(29, 'English', 'lang_en', 'en', 0),
(30, 'Англійська', 'lang_en', 'ua', 0),
(31, 'Английский', 'lang_en', 'ru', 0),
(32, 'My Profile', 'my_profile', 'en', 0),
(33, 'Личный кабинет', 'my_profile', 'ru', 0),
(34, 'Вход / Регистрация', 'login_reg_top', 'ru', 0),
(35, 'Login / Sing Up', 'login_reg_top', 'en', 0),
(36, 'Change email or password', 'pass_email_change', 'en', 3),
(37, 'Сменить email или пароль', 'pass_email_change', 'ru', 3),
(38, 'Ваш пароль', 'current_password', 'ru', 3),
(39, 'Сurrent password', 'current_password', 'en', 3),
(40, 'New password', 'new_password', 'en', 3),
(41, 'Новый пароль', 'new_password', 'ru', 3),
(42, 'New password again', 'repeat_new_password', 'en', 3),
(43, 'Новый пароль еще раз', 'repeat_new_password', 'ru', 3),
(44, 'Сохранить изменения', 'save_changes', 'ru', 3),
(45, 'Save changes', 'save_changes', 'en', 3),
(46, 'Перейти на объект описания системы', 'wisdom_manual', 'ru', 3),
(47, 'Wisdom Tree manual', 'wisdom_manual', 'en', 3),
(76, 'Login to system', 'login_h1', 'en', 3),
(77, 'Вход в личный кабинет', 'login_h1', 'ru', 3),
(78, 'Password', 'password', 'en', 3),
(50, 'You can use the quick search line for find needed information', 'profile_search_h1', 'en', 3),
(51, 'Используйте строку быстрого поиска по базе знаний', 'profile_search_h1', 'ru', 3),
(52, 'Fast information search, for example: Marketing, SEO, Startup, Project Management, SMM, Outsourcing, Digital, Education, Business, How to do anything well? ...', 'fast_search_placeholder', 'en', 3),
(53, 'Быстрый поиск по универсальной базе знаний, например: Маркетинг, SEO, Стартапы, Project Management, SMM, Outsourcing, Digital, Education, Business...', 'fast_search_placeholder', 'ru', 3),
(54, 'You can mark all object which you know', 'profile_help_text1', 'en', 3),
(55, 'Отмечайте изученные объекты, нажимая на значок изучения', 'profile_help_text1', 'ru', 3),
(56, 'See the last 500 information objects', 'show_last_500_info', 'en', 3),
(57, 'Посмотреть последние 500 добавленных объектов', 'show_last_500_info', 'ru', 3),
(58, 'Parent and Child are the most popular objects', 'profile_help_text4', 'en', 3),
(59, 'Parent и Child самые популярные связи объектов', 'profile_help_text4', 'ru', 3),
(60, 'Сформируйте структуру знаний для обучения и работы с данными', 'profile_help_text3', 'ru', 3),
(61, 'Create the structure of knowledge for teaching and working with data', 'profile_help_text3', 'en', 3),
(62, 'Добавляйте свои объекты в систему (ограниченный доступ)', 'profile_help_text2', 'ru', 3),
(63, 'Add new objects in the system (needs special access)', 'profile_help_text2', 'en', 3),
(64, 'Базовая версия Inside 3.1 для установки', 'wisdom_base_h1', 'ru', 2),
(65, 'Inside 3.1 Base Install Demo', 'wisdom_base_h1', 'en', 2),
(66, 'Go to Search page', 'go_to_search_btn', 'en', 2),
(67, 'Перейти на страницу поиска', 'go_to_search_btn', 'ru', 2),
(68, 'Добавляйте информацию в систему', 'index_img_block1', 'ru', 2),
(69, 'Add your information', 'index_img_block1', 'en', 2),
(70, 'Создавайте оптимальную структуру', 'index_img_block2', 'ru', 2),
(71, 'Make optimal structure', 'index_img_block2', 'en', 2),
(72, 'Изучайте и анализируйте информацию', 'index_img_block3', 'ru', 2),
(73, 'Find new ideas in big system', 'index_img_block3', 'en', 2),
(74, 'Перейти в базу знаний', 'wisdom_main', 'ru', 3),
(75, 'Go to Wisdom Tree List', 'wisdom_main', 'en', 3),
(79, 'Пароль', 'password', 'ru', 3),
(80, 'Forget password', 'forget_password', 'en', 3),
(81, 'Забыли пароль', 'forget_password', 'ru', 3),
(82, 'Войти', 'login_btn', 'ru', 3),
(83, 'Sign In', 'login_btn', 'en', 3),
(84, 'Восстановление пароля', 'pass_recovery_h1', 'ru', 3),
(85, 'Password recovery', 'pass_recovery_h1', 'en', 3),
(86, 'Отмена', 'cancel', 'ru', 3),
(87, 'Cancel', 'cancel', 'en', 3),
(88, 'Send instructions', 'send_instructions', 'en', 3),
(89, 'Выслать инструкции', 'send_instructions', 'ru', 3),
(90, 'Изменить отметку изучения?', 'iknow_ch_alert', 'ru', 3),
(91, 'Do you want to change I_know mark?', 'iknow_ch_alert', 'en', 5),
(92, 'I_know mark is only available for registered users!', 'iknow_only_for_reg', 'en', 5),
(93, 'Отметка изучения доступна только зарегистрированным пользователям!', 'iknow_only_for_reg', 'ru', 3),
(94, 'No data for your request!', 'search_no_data', 'en', 4),
(95, 'По вашему запросу нет данных!', 'search_no_data', 'ru', 4),
(96, 'Быстрый поиск', 'fast_search_placeholder_short', 'ru', 4),
(97, 'Quick search', 'fast_search_placeholder_short', 'en', 4),
(98, 'Быстрый поиск по базе знаний Wisdom System...', 'fast_search_placeholder_middle', 'ru', 4),
(99, 'Quick search by text ...', 'fast_search_placeholder_middle', 'en', 4),
(100, 'Update', 'update', 'ru', 0),
(101, 'View All/WorkGroup can Add only', 'info_access_rule_1', 'en', 4),
(102, 'Видят все/Сотрудники могут добавлять', 'info_access_rule_1', 'ru', 4),
(103, 'Видят все/Все могут добавлять', 'info_access_rule_2', 'ru', 4),
(104, 'View All/Any can Add', 'info_access_rule_2', 'en', 4),
(105, 'View WorkGroup/Others can&#8217;t Add', 'info_access_rule_3', 'en', 4),
(106, 'Видно сотрудникам/Никто не может добавлять', 'info_access_rule_3', 'ru', 4),
(107, 'Видно сотрудникам/Сотрудники могут добавлять', 'info_access_rule_4', 'ru', 4),
(108, 'View WorkGroup/WorkGroup can Add only', 'info_access_rule_4', 'en', 4),
(109, 'Видно только мне (Скрытый)', 'info_access_rule_5', 'ru', 4),
(110, 'View Only Me (Private)', 'info_access_rule_5', 'en', 4),
(111, 'Видят все/Никто не может добавлять', 'info_access_rule_0', 'ru', 4),
(112, 'View All/Others can&#8217;t Add', 'info_access_rule_0', 'en', 4),
(113, 'Description', 'description', 'en', 4),
(114, 'Описание', 'description', 'ru', 4),
(115, 'Название', 'obj_name', 'ru', 4),
(116, 'Object name', 'obj_name', 'en', 4),
(117, 'Редактировать объект', 'edit_object', 'ru', 4),
(118, 'Edit object', 'edit_object', 'en', 4),
(119, 'Вид связи', 'rel_type', 'ru', 4),
(120, 'Relation type', 'rel_type', 'en', 4),
(121, 'Видно только мне (Скрытый)', 'rel_access_rule_2', 'ru', 4),
(122, 'View Only Me (Private)', 'rel_access_rule_2', 'en', 4),
(123, 'Видно сотрудникам', 'rel_access_rule_1', 'ru', 4),
(124, 'View WorkGroup', 'rel_access_rule_1', 'en', 4),
(125, 'Видно всем', 'rel_access_rule_0', 'ru', 4),
(126, 'View All', 'rel_access_rule_0', 'en', 4),
(127, 'Add object', 'add_btn', 'en', 4),
(128, 'Добавить', 'add_btn', 'ru', 4),
(129, 'Go to added', 'go_to_added', 'en', 4),
(130, 'Перейти к добавленному', 'go_to_added', 'ru', 4),
(131, 'Delete', 'delete', 'en', 4),
(132, 'Удалить', 'delete', 'ru', 4),
(133, 'Редактировать', 'edit_toggle_btn', 'ru', 4),
(134, 'Edit information', 'edit_toggle_btn', 'en', 4),
(135, 'Other information views', 'other_info_views', 'en', 4),
(136, 'Другие виды списка знаний', 'other_info_views', 'ru', 4),
(137, 'Добавить новый объект', 'add_new_object', 'ru', 4),
(138, 'Add new object', 'add_new_object', 'en', 4),
(139, 'Добавить только связь', 'add_new_rel', 'ru', 4),
(140, 'Add new relation', 'add_new_rel', 'en', 4),
(141, 'Manage relations', 'relations_control', 'en', 4),
(142, 'Управление связями', 'relations_control', 'ru', 4),
(143, 'Manage this object', 'object_control', 'en', 4),
(144, 'Управление объектом', 'object_control', 'ru', 4),
(146, 'Доступно мне и исполнителю', 'access_1', 'ru', 4),
(147, 'Idea', 'task_idea', 'en', 4),
(148, 'Available to me and the performer', 'access_1', 'en', 0),
(149, 'Доступно мне и исполнителю', 'access_1', 'ru', 0),
(150, 'Idea', 'task_idea', 'en', 0),
(151, 'Идея', 'task_idea', 'ru', 0),
(152, 'Postponed', 'task_postponed', 'en', 0),
(153, 'На потом', 'task_postponed', 'ru', 0),
(154, 'Regular', 'task_regular', 'en', 0),
(155, 'Регулярная', 'task_regular', 'ru', 0),
(156, 'Отменена', 'task_cancel', 'ru', 0),
(157, 'Canceled', 'task_cancel', 'en', 0),
(158, 'Выполнена', 'task_done', 'ru', 0),
(159, 'Done', 'task_done', 'en', 0),
(160, 'Приостановлена', 'task_hold', 'ru', 0),
(161, 'On Hold', 'task_hold', 'en', 0),
(162, 'In Progress', 'task_progress', 'en', 0),
(163, 'В работе', 'task_progress', 'ru', 0),
(164, 'New', 'task_new', 'en', 0),
(165, 'Новая', 'task_new', 'ru', 0),
(166, 'Available for view to all', 'access_2', 'en', 0),
(167, 'Доступно всем на просмотр', 'access_2', 'ru', 0),
(168, 'Available for edit to all', 'access_3', 'en', 0),
(169, 'Доступно всем на редактирование', 'access_3', 'ru', 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
