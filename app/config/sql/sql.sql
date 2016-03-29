-- phpMyAdmin SQL Dump
-- version 3.3.7deb5build0.10.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2011 at 03:19 PM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `pacv2`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `bids` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `accounts`
--


-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_address_type_id` int(11) NOT NULL,
  `name` varchar(80) NOT NULL,
  `address_1` varchar(255) NOT NULL,
  `address_2` varchar(255) NOT NULL,
  `suburb` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL,
  `phone` varchar(80) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `address_type_id` (`user_address_type_id`),
  KEY `user_id` (`user_id`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `addresses`
--


-- --------------------------------------------------------

--
-- Table structure for table `auctions`
--

CREATE TABLE IF NOT EXISTS `auctions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `price` decimal(30,2) NOT NULL,
  `autolist` tinyint(1) NOT NULL,
  `autolist_time` varchar(5) NOT NULL,
  `autolist_minutes` int(11) NOT NULL,
  `featured` tinyint(1) NOT NULL,
  `peak_only` tinyint(1) NOT NULL,
  `nail_biter` tinyint(1) NOT NULL,
  `penny` tinyint(1) NOT NULL,
  `beginner` tinyint(1) NOT NULL,
  `autobid` tinyint(1) NOT NULL,
  `autobids` int(11) NOT NULL,
  `realbids` int(11) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `winner_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `bid_debit` int(11) NOT NULL,
  `bid_time` int(11) NOT NULL,
  `max_time` int(11) NOT NULL,
  `serverload` decimal(30,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `winner_id` (`winner_id`),
  KEY `status_id` (`status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `auctions`
--


-- --------------------------------------------------------

--
-- Table structure for table `auction_emails`
--

CREATE TABLE IF NOT EXISTS `auction_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_id` (`auction_id`),
  KEY `auction_id_2` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `auction_emails`
--


-- --------------------------------------------------------

--
-- Table structure for table `autobids`
--

CREATE TABLE IF NOT EXISTS `autobids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL,
  `deploy` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `autobids`
--


-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE IF NOT EXISTS `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `code` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `banner_location_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `banners`
--


-- --------------------------------------------------------

--
-- Table structure for table `banner_locations`
--

CREATE TABLE IF NOT EXISTS `banner_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `banner_locations`
--

INSERT INTO `banner_locations` (`id`, `name`) VALUES
(1, 'Horizontal'),
(2, 'Vertical'),
(3, 'Home Page Featured');

-- --------------------------------------------------------

--
-- Table structure for table `bidbutlers`
--

CREATE TABLE IF NOT EXISTS `bidbutlers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `minimum_price` decimal(30,2) NOT NULL,
  `maximum_price` decimal(30,2) NOT NULL,
  `bids` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_id` (`auction_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bidbutlers`
--


-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE IF NOT EXISTS `bids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `credit` int(11) NOT NULL,
  `debit` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_id` (`auction_id`),
  KEY `user_id` (`user_id`),
  KEY `credit` (`credit`),
  KEY `debit` (`debit`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bids`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rght` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text CHARACTER SET utf8 NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `comments`
--


-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(2) NOT NULL,
  `name` varchar(80) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `code`, `name`, `created`, `modified`) VALUES
(1, 'US', 'United States', '2011-06-08 12:45:15', '2011-06-08 12:45:15');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE IF NOT EXISTS `coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `saving` decimal(30,2) NOT NULL,
  `coupon_type_id` int(11) NOT NULL,
  `expire` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `coupons`
--


-- --------------------------------------------------------

--
-- Table structure for table `coupon_types`
--

CREATE TABLE IF NOT EXISTS `coupon_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `coupon_types`
--

INSERT INTO `coupon_types` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Percentage', '2008-12-10 15:18:06', '2008-12-10 15:18:06'),
(2, 'Total Off', '2008-12-10 15:18:06', '2008-12-10 15:18:06'),
(3, 'Free Bids', '2008-12-10 15:18:06', '2008-12-10 15:18:06'),
(4, 'Percentage Free Bids', '2009-03-01 20:53:03', '0000-00-00 00:00:00'),
(5, 'Free Rewards', '2009-03-06 18:24:03', '2009-03-06 18:24:07');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE IF NOT EXISTS `currencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(255) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `rate` decimal(30,4) NOT NULL,
  `bid_price` decimal(30,2) NOT NULL,
  `default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `currency`, `country_code`, `rate`, `bid_price`, `default`) VALUES
(1, 'USD', 'US', '1.0000', '0.50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `departments`
--


-- --------------------------------------------------------

--
-- Table structure for table `exchanges`
--

CREATE TABLE IF NOT EXISTS `exchanges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `price` decimal(30,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `exchanges`
--


-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE IF NOT EXISTS `genders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`id`, `name`) VALUES
(1, 'Male'),
(2, 'Female');

-- --------------------------------------------------------

--
-- Table structure for table `i18n`
--

CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `i18n`
--

INSERT INTO `i18n` (`id`, `locale`, `model`, `foreign_key`, `field`, `content`) VALUES
(1, 'eng', 'Status', 1, 'name', 'Non confirmed'),
(2, 'eng', 'Status', 1, 'message', 'This auction has not been confirmed.  Please login and confirm this auction.'),
(3, 'eng', 'Status', 2, 'name', 'Confirmed, Awaiting Shipment'),
(4, 'eng', 'Status', 2, 'message', 'Your details have been confirmed and will be shipping the item shortly.'),
(5, 'eng', 'Status', 3, 'name', 'Shipped & Completed'),
(6, 'eng', 'Status', 3, 'message', 'Your auction has been shipped.'),
(7, 'eng', 'Status', 4, 'name', 'Refunded'),
(8, 'eng', 'Status', 4, 'message', 'This auction has been refunded.'),
(9, 'eng', 'Status', 5, 'name', 'Declined'),
(10, 'eng', 'Status', 5, 'message', 'This auction has been declined.'),
(11, 'eng', 'Status', 6, 'name', 'Credit Check'),
(12, 'eng', 'Status', 6, 'message', 'We are currently doing a quick credit check to ensure your bid packages were paid for legitimately.  We are required to do this to ensure that we don''t send you high value goods when bids were paid for using a stolen credit card.  Please allow 2 to 3 days for us to complete this check.'),
(13, 'eng', 'Status', 7, 'name', 'Free Bids Accepted'),
(14, 'eng', 'Status', 7, 'message', 'You have accepted free bids in exchange for this auction and they are now in your account.'),
(15, 'eng', 'Source', 1, 'name', 'Yahoo'),
(16, 'eng', 'Source', 2, 'name', 'Google'),
(17, 'eng', 'Gender', 1, 'name', 'Male'),
(18, 'eng', 'Gender', 2, 'name', 'Female'),
(19, 'eng', 'UserAddressType', 1, 'name', 'Billing'),
(20, 'eng', 'UserAddressType', 2, 'name', 'Shipping'),
(21, 'eng', 'Page', 1, 'name', 'How it Works'),
(22, 'eng', 'Page', 1, 'title', 'How it Works'),
(23, 'eng', 'Page', 1, 'meta_description', ''),
(24, 'eng', 'Page', 1, 'meta_keywords', ''),
(25, 'eng', 'Page', 1, 'content', '<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>'),
(26, 'eng', 'Page', 2, 'name', 'Terms and Conditions'),
(27, 'eng', 'Page', 2, 'title', 'Terms and Conditions'),
(28, 'eng', 'Page', 2, 'meta_description', ''),
(29, 'eng', 'Page', 2, 'meta_keywords', ''),
(30, 'eng', 'Page', 2, 'content', '<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>'),
(31, 'eng', 'Page', 3, 'name', 'Help'),
(32, 'eng', 'Page', 3, 'title', 'Help'),
(33, 'eng', 'Page', 3, 'meta_description', ''),
(34, 'eng', 'Page', 3, 'meta_keywords', ''),
(35, 'eng', 'Page', 3, 'content', '<p>This is used for the help section module.</p>\r\n<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>'),
(36, 'eng', 'Page', 4, 'name', 'Contact Us'),
(37, 'eng', 'Page', 4, 'title', 'Contact Us'),
(38, 'eng', 'Page', 4, 'meta_description', ''),
(39, 'eng', 'Page', 4, 'meta_keywords', ''),
(40, 'eng', 'Page', 4, 'content', '<p>This is used as the content on the Contact Us page.</p>\r\n<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_default_id` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `images`
--


-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE IF NOT EXISTS `languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(3) NOT NULL,
  `default` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `default`) VALUES
(1, 'English', 'eng', 1),
(2, 'French', 'fre', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `show_active` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `show_active`, `active`) VALUES
(1, 'coupons', 1, 1),
(2, 'registration_sources', 0, 1),
(3, 'gateways', 0, 1),
(4, 'auction_types', 0, 1),
(5, 'forum', 1, 0),
(6, 'buy_now', 1, 1),
(7, 'geo_tracking', 1, 0),
(8, 'banners', 1, 0),
(9, 'testimonials', 1, 0),
(10, 'help_section', 1, 1),
(11, 'latest_news', 1, 1),
(12, 'contact_form', 1, 1),
(13, 'reward_credits', 1, 0),
(14, 'max_auction_time', 1, 0),
(15, 'images', 0, 1),
(16, 'database_cleaner', 1, 1),
(17, 'email_sending', 0, 1),
(18, 'multi_languages', 1, 0),
(19, 'testing_mode', 1, 0),
(20, 'autolisting', 1, 1),
(21, 'bid_butler', 1, 1),
(22, 'free_bids', 0, 1),
(23, 'referrals', 1, 1),
(24, 'win_limits', 1, 0),
(25, 'newsletters', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `brief` text NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `news`
--


-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `sent` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `newsletters`
--


-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE IF NOT EXISTS `packages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `bids` int(11) NOT NULL,
  `price` decimal(30,2) NOT NULL,
  `special` tinyint(1) NOT NULL,
  `contract` varchar(255) NOT NULL,
  `points` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `packages`
--


-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `top_show` tinyint(1) NOT NULL,
  `top_order` int(11) NOT NULL,
  `bottom_show` tinyint(1) NOT NULL,
  `bottom_order` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `title`, `meta_description`, `meta_keywords`, `content`, `slug`, `top_show`, `top_order`, `bottom_show`, `bottom_order`, `created`, `modified`) VALUES
(1, 'How it Works', 'How it Works', '', '', '<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>', 'how-it-works', 0, 0, 0, 0, '2011-06-08 14:15:59', '2011-06-08 14:15:59'),
(2, 'Terms and Conditions', 'Terms and Conditions', '', '', '<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>', 'terms-and-conditions', 0, 0, 1, 0, '2011-06-08 14:16:23', '2011-06-08 14:16:23'),
(3, 'Help', 'Help', '', '', '<p>This is used for the help section module.</p>\r\n<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>', 'help', 0, 0, 0, 0, '2011-06-08 14:16:46', '2011-06-08 14:16:46'),
(4, 'Contact Us', 'Contact Us', '', '', '<p>This is used as the content on the Contact Us page.</p>\r\n<p>Go to Admin -&gt;&nbsp;Manage Content -&gt; Pages to edit this page content.</p>', 'contact-us', 0, 0, 0, 0, '2011-06-08 14:17:18', '2011-06-08 14:22:34');

-- --------------------------------------------------------

--
-- Table structure for table `points`
--

CREATE TABLE IF NOT EXISTS `points` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `credit` int(11) NOT NULL,
  `debit` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `points`
--


-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `topic_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `posts`
--


-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `brief` text NOT NULL,
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `rrp` decimal(30,2) NOT NULL,
  `start_price` decimal(30,2) NOT NULL,
  `fixed` tinyint(1) NOT NULL,
  `fixed_price` decimal(30,2) NOT NULL,
  `delivery_cost` decimal(30,2) NOT NULL,
  `delivery_information` text NOT NULL,
  `bids` int(11) NOT NULL,
  `cash` tinyint(1) NOT NULL,
  `exchange` decimal(30,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `products`
--


-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `order` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `questions`
--


-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE IF NOT EXISTS `referrals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `referrer_id` int(11) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `referrer_id` (`referrer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `referrals`
--


-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sections`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `options` varchar(255) NOT NULL,
  `show_terms` tinyint(1) NOT NULL,
  `terms` tinyint(1) NOT NULL,
  `allow_empty` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `module_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES
(1, 0, 'bid_debit', '1', 'The number of bids taken from the users account for each bid placed.', '', 0, 0, 0),
(2, 0, 'price_increment', '0.01', 'The amount the price increases each time a bid is placed.', '', 0, 0, 0),
(3, 0, 'time_increment', '10', 'The number of seconds added to the time each time a bid is placed.', '', 0, 0, 0),
(4, 21, 'bid_butler_time', '30', 'The number of seconds from the auction closing that the bid butler bids should be placed.  We recommend setting this to at least 30 seconds.', '', 0, 0, 0),
(5, 23, 'free_referral_bids', '10', 'The number of free bids a user receives for referring another user.  This only gets given when the new user purchase bids.', '', 0, 0, 0),
(6, 0, 'site_live', 'yes', 'Use this setting to turn off the website for any reason.  Change the value to ''no'' to turn off the website, and ''yes'' to turn the website on.', '', 0, 0, 0),
(7, 22, 'free_registration_bids', '3', 'The number of free bids a user gets for registering on the website (given once their account is activated.)', '', 0, 0, 0),
(8, 22, 'free_bid_packages_bids', '0', 'The number of free bids a user gets the first time they purchase a bid package.  Alternatively make this a % for the user to receive x% more bids instead.', '', 0, 0, 0),
(9, 22, 'free_won_auction_bids', '0', 'The number of free bids a user gets for paying for an auction.', '', 0, 0, 0),
(10, 0, 'offline_message', 'We are currently experiencing a higher number of visitors that usual. The website is currently down, please try again later.', 'The message that should be displayed when the website is offline.', '', 0, 0, 0),
(11, 0, 'default_meta_title', 'Penny Auctions', 'Used as part of Search Engine Optimisation, this is the default meta title.', '', 0, 0, 0),
(12, 0, 'default_meta_description', '', 'Used as part of Search Engine Optimisation, this is the default meta description.', '', 0, 0, 0),
(13, 0, 'default_meta_keywords', '', 'Used as part of Search Engine Optimisation, this is the default meta keywords.', '', 0, 0, 0),
(14, 23, 'user_invite_message', 'Hi There\\n\\nSign up at SITENAME to receive great deals on products.\\n\\nURL\\n\\nCheck it out if you can!\\nSENDER', 'This is the default message that the user will send when inviting friends to the website.', '', 0, 0, 0),
(15, 19, 'autobid_time', '30', 'The number of seconds from the auction closing that the autobidders should start bidding.  Set this to 0 to make them always bid.', '', 0, 0, 0),
(16, 20, 'autolist_delay_time', '0', 'Use the autolist delay time to delay the start time of auto relisting auctions.  This feature will delay the start time of the new auction by the number of minutes set here.', '', 0, 0, 0),
(17, 0, 'theme', '', 'The theme of the website.  This should match the folder name in: app/views/themed and app/webroot/themed.  Leave empty to show the default theme.', '', 0, 0, 1),
(18, 0, 'page_limit', '20', 'The number of auctions which will show per page.', '', 0, 0, 0),
(19, 0, 'products_order', 'title', 'The order in which the products show on the shop page.  The options are:\r\ntitle, rrp, exchange', '', 0, 0, 0),
(20, 0, 'license_code', '', 'The license code supplied by PennyAuctionCode.com.  Without this, the website will not run!', '', 0, 0, 0),
(21, 0, 'site_name', 'Your Website Name', 'The name of the website.', '', 0, 0, 0),
(22, 0, 'site_url', 'http://www.yourdomainname.com', 'The website URL.', '', 0, 0, 0),
(23, 0, 'time_zone', 'Europe/London', 'The timezone the website should be in.  Refer to http://php.net/manual/en/timezones.php for example timezones.', '', 0, 0, 0),
(24, 0, 'site_email', 'your@email.com', 'The master website email address.', '', 0, 0, 0),
(25, 0, 'admin_page_limit', '100', 'The number of rows in the CMS (Admin Section) for each module.', '', 0, 0, 0),
(26, 0, 'bid_history_limit', '10', 'The number of rows in the bidding history column.', '', 0, 0, 0),
(27, 0, 'cron_time', '1', 'The time a cron job should run for. This should match your cron jobs, in most cases this should be set to 1.', '', 0, 0, 0),
(28, 0, 'home_ending_limit', '8', 'The number of auctions ending on the home page.', '', 0, 0, 0),
(29, 0, 'home_featured_limit', '4', 'The number of featured auctions to show on the home page.', '', 0, 0, 0),
(30, 0, 'closed_ended_auctions', '30', 'The number of auctions showing on the ended auctions page.  Set to 0 to show all the auctions.', '', 0, 0, 0),
(31, 17, 'email_winner', '1', 'Set whether or not to email the winners when the auction closes.', '1, 0', 0, 0, 0),
(32, 0, 'debug', '0', 'Set debug to Yes to show errors.  If the website is live and NOT in development mode, set the debug to N0.', '0, 1', 0, 0, 0),
(33, 7, 'blocked_countries', '', 'A list of blocked countries, in the following format: US, CA, GB, ETC, ETC.  Leave blank to turn off country blocking.', '', 0, 0, 1),
(34, 11, 'news_comments', '0', 'Allow news comments on articles.', '1, 0', 0, 0, 0),
(35, 2, 'registration_options', '1', 'Turn on the registration options, i.e. the "How did you find us options".', '1, 0', 0, 0, 0),
(36, 12, 'departments', '1', 'Turn on different departments for the contact form.  This will show a dropdown with different departments.  The contact email will then be sent to different email addresses.', '1, 0', 0, 0, 0),
(37, 4, 'fixed_priced_auctions', '1', 'Have the option to run fixed priced auctions.  The user pays a fixed price rather than a variable price, and minimum and maximum prices are not required on the bid butler for this auction type.', '1, 0', 0, 0, 0),
(38, 14, 'max_counter_time', '0', 'Only allow auctions to extend by a certain time after x time is reached.  For example, setting this to 15 will mean that once an auction time is less than 15 seconds, the max the time can be set to is 15 seconds.  Setting it to zero disables this feature.', '', 0, 0, 0),
(39, 14, 'max_auction_time', '1', 'This works the same as the Max Counter Time, except it allows you to enter a different value per auction.  Set to Yes to enable, No to disable.', '1, 0', 0, 0, 0),
(40, 2, 'registration_tracking', '0', 'Turning this on will automatically record the website the user came from when they register. This will only work if they visited the website from a referral website.', '1, 0', 0, 0, 0),
(41, 16, 'bids_archive', '14', 'The number of days that bids should remain in the database.  The lower this is set, the more optimised your database will be.  Set it to 0 to turn this off.', '', 0, 0, 0),
(42, 17, 'email_delivery', 'mail', 'The method of sending the site wide emails.', 'mail, smtp', 0, 0, 0),
(43, 17, 'email_send_as', 'both', 'The type of emails that should be sent.', 'text, html, both', 0, 0, 0),
(44, 17, 'email_host', 'localhost', 'The email host for sending.  You may which to use www.authsmtp.com (mail.authsmtp.com).', '', 0, 0, 0),
(45, 17, 'email_port', '25', 'The email port for email sending.', '', 0, 0, 0),
(46, 17, 'email_timeout', '60', 'The email timeout.', '', 0, 0, 0),
(47, 17, 'email_username', '', 'Used for SMTP sending when authentication is required.', '', 0, 0, 1),
(48, 17, 'email_password', '', 'Used for SMTP sending when authentication is required.', '', 0, 0, 1),
(49, 15, 'thumb_image_width', '100', 'This is the max width that the thumbnail image should be.  The thumbnail image shows on the home page auctions for example.', '', 0, 0, 0),
(50, 15, 'thumb_image_height', '100', 'This is the max height that the thumbnail image should be.  The thumbnail image shows on the home page auctions for example.', '', 0, 0, 0),
(51, 15, 'max_image_width', '250', 'This is the max width that the larger max image should be.  This image shows on the auction detail page for example.', '', 0, 0, 0),
(52, 15, 'max_image_height', '250', 'This is the max height that the larger max image should be.  This image shows on the auction detail page for example.', '', 0, 0, 0),
(53, 11, 'comments_free_bids', '1', 'The number of free bids that should be issued for every approved comment on a news article. Set to 0 to turn off.', '', 0, 0, 0),
(54, 9, 'testimonial_free_bids', '2', 'The number of bids the user receives for submitting a testmonial', '', 0, 0, 0),
(55, 9, 'testimonial_images', '1', 'Should the user be able to upload images with there testimonial.', '1, 0', 0, 0, 0),
(56, 9, 'testimonial_videos', '1', 'Should the user be able to copy in embedded YouTube HTML with there testimonial.', '1, 0', 0, 0, 0),
(57, 9, 'testimonial_testing_mode', '1', 'When turned on, the admin can add testimonials from the Admin Section under Manage Content -> Testimonials -> Add.', '1, 0', 1, 1, 0),
(58, 4, 'nail_biters', '1', 'Run nail biter auctions on the website - auctions which allow single bids only - no bid butlers are on this auction type.', '1, 0', 0, 0, 0),
(59, 4, 'beginner_auctions', '1', 'Run beginner auctions - only users who have not won any auctions yet can bid on these auctions.', '1, 0', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `smartbids`
--

CREATE TABLE IF NOT EXISTS `smartbids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auction_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auction_id` (`auction_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `smartbids`
--


-- --------------------------------------------------------

--
-- Table structure for table `sources`
--

CREATE TABLE IF NOT EXISTS `sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `extra` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sources`
--

INSERT INTO `sources` (`id`, `name`, `order`, `extra`) VALUES
(1, 'Google', 1, 0),
(2, 'Facebook', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`, `message`) VALUES
(1, 'Non confirmed', 'This auction has not been confirmed.  Please login and confirm this auction.'),
(2, 'Confirmed, Awaiting Shipment', 'Your details have been confirmed and will be shipping the item shortly.'),
(3, 'Shipped & Completed', 'Your auction has been shipped.'),
(4, 'Refunded', 'This auction has been refunded.'),
(5, 'Declined', 'This auction has been declined.'),
(6, 'Credit Check', 'We are currently doing a quick credit check to ensure your bid packages were paid for legitimately.  We are required to do this to ensure that we don''t send you high value goods when bids were paid for using a stolen credit card.  Please allow 2 to 3 days for us to complete this check.'),
(7, 'Free Bids Accepted', 'You have accepted free bids in exchange for this auction and they are now in your account.');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE IF NOT EXISTS `testimonials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `testimonial` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `video` text NOT NULL,
  `approved` tinyint(1) NOT NULL,
  `order` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`,`auction_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=ucs2 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `testimonials`
--


-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `topics`
--


-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msgid` text NOT NULL,
  `msgstr` text NOT NULL,
  `reference` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `last_used` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `translations`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `paypal` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender_id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `key` varchar(40) NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `newsletter_id` int(11) NOT NULL,
  `translator` tinyint(1) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `autobidder` tinyint(1) NOT NULL,
  `source_id` int(11) NOT NULL,
  `source_extra` varchar(255) NOT NULL,
  `bid_balance` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `followup` tinyint(1) NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `gender_id` (`gender_id`),
  KEY `language_id` (`language_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`, `mobile`, `paypal`, `date_of_birth`, `gender_id`, `email`, `active`, `key`, `newsletter`, `newsletter_id`, `translator`, `admin`, `autobidder`, `source_id`, `source_extra`, `bid_balance`, `ip`, `language_id`, `currency_id`, `followup`, `deleted`, `created`, `modified`) VALUES
(1, 'admin', 'a193a95db94cd44089953d0c4535119fdf102f19', 'Admin', 'Admin', '', '', '1994-04-15', 1, 'info@egeeked.com', 1, '9fadf9ab888cf5b587830ce462aa3fe0751d2682', 0, 0, 0, 1, 0, 1, '', 0, '127.1.0.0', 0, 0, 0, 0, '2011-04-15 13:32:52', '2011-04-15 13:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `user_address_types`
--

CREATE TABLE IF NOT EXISTS `user_address_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_address_types`
--

INSERT INTO `user_address_types` (`id`, `name`) VALUES
(1, 'Billing'),
(2, 'Shipping');

-- --------------------------------------------------------

--
-- Table structure for table `watchlists`
--

CREATE TABLE IF NOT EXISTS `watchlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `auction_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `auction_id` (`auction_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `watchlists`
--

ALTER TABLE `auctions` DROP `penny`;

-- Added 9th June 2011

ALTER TABLE `settings` ADD `setting_id` INT( 11 ) NOT NULL AFTER `module_id` ,
ADD INDEX ( `setting_id` );

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '0', 'demo_gateway', '0', 'Turn on the demo gateway. Great if you are wanting to test purchasing bids and paying for auctions.', '1, 0', '', '', '');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '0', 'paypal', '0', 'Set to yes to active the paypal gateway', '1, 0', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '61', 'paypal_url', 'https://www.paypal.com/cgi-bin/webscr', 'The URL to Paypal. This may be changed to the sandbox URL for testing.', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '61', 'paypal_email', '', 'Your paypal email address. This is the account that you will be paid into.', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '61', 'paypal_locale', 'GB', 'The Paypal locale variable.', '', '', '', '');

-- Added 10th June 2011

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '0', 'dalpay', '0', 'Set to yes to active the Dalpay gateway', '1, 0', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '65', 'dalpay_url', 'https://secure.dalpay.is/cgi-bin/order2/processorder1.pl', 'The URL to Paypal. This may be changed to the sandbox URL for testing.', 'https://secure.dalpay.is/cgi-bin/order2/processorder1.pl', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '65', 'dalpay_merchant_id', '', 'Your Dalpay merchant ID.', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '65', 'dalpay_package_order_page', '', 'The order ID page for the bid packages Dalpay page.', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '3', '65', 'dalpay_auction_order_page', '', 'The order ID page for the won auctions Dalpay page.', '', '', '', ''), (NULL, '3', '65', 'dalpay_buy_now_order_page', '', 'The order ID page for the buy_now Dalpay page.', '', '', '', '');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '0', '29', 'home_featured_image_size', 'thumbs', 'Specify the image size of the featured auctions.  Thumbs is the standard auction thumb size, whereas used Max if you would like to use a bigger image size.', 'thumbs, max', '', '', ''), (NULL, '0', '29', 'home_featured_auto_fill', '1', 'When set to yes, if there are no featured auctions, the nearest ending soon auctions will be show as featured auctions.  If set to no, the featured auctions simply will not show if there are no featured auctions.', '1, 0', '', '', '');
UPDATE `settings` SET `description` = 'The number of featured auctions to show on the home page. Set to 0 to not show any featured auctions.' WHERE `settings`.`id` =29;

UPDATE `settings` SET `description` = 'The order in which the products show on the shop page. Title is the product title, rrp is the recommended retail price and exchange is the buy now price.',
`options` = 'title, rrp, exchange' WHERE `settings`.`id` =19;

UPDATE `settings` SET `value` = '1', `options` = '1, 0' WHERE `settings`.`id` =6;

CREATE TABLE `limits` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`limit` INT( 11 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL
) ENGINE = MYISAM ;

ALTER TABLE `auctions` ADD `limit_id` INT( 11 ) NOT NULL AFTER `realbids` ,
ADD INDEX ( `limit_id` );

ALTER TABLE `limits` ADD `days` INT( 11 ) NOT NULL AFTER `limit`;

INSERT INTO `modules` (`id`, `name`, `show_active`, `active`) VALUES (26, 'home_page', '0', '1');
UPDATE `settings` SET `module_id` = '26' WHERE `settings`.`id` =28;
UPDATE `settings` SET `module_id` = '26' WHERE `settings`.`id` =72;
UPDATE `settings` SET `module_id` = '26' WHERE `settings`.`id` =71;
UPDATE `settings` SET `module_id` = '26' WHERE `settings`.`id` =29;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '26', '0', 'home_coming_soon_limit', '12', 'The number of coming soon auctions to show on the home page.  Set to 0 to not show any coming soon auctions', '12', '', '', '');

-- Added 14th June 2011

ALTER TABLE `auctions` ADD `min_autobids` INT( 11 ) NOT NULL AFTER `autobids` ,
ADD `max_autobids` INT( 11 ) NOT NULL AFTER `min_autobids`;

ALTER TABLE `auctions` ADD `min_realbids` INT( 11 ) NOT NULL AFTER `realbids` ,
ADD `max_realbids` INT( 11 ) NOT NULL AFTER `min_realbids`;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '19', '', 'randomize_autobids', '0', 'Allow for random autobid and real bids per auction.  This setting will allow you to set a range for the autobidding settings rather than a specific number of autobids.  This will randomize the autobids and real bids for each auction, including when an auction is auto listed.', '1, 0', '1', '0', '0');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '19', '', 'max_autobidders', '4', 'The max number of autobidders that should bid on an auction.  Set to zero to make this unlimited, although this option is not recommended.', '', '1', '', '');

ALTER TABLE `auction_emails` DROP INDEX `auction_id_2`;

INSERT INTO `modules` (`id`, `name`, `show_active`, `active`) VALUES (NULL, 'auction_search', '1', '1');

ALTER TABLE `products` ADD `status_id` INT( 11 ) NOT NULL AFTER `exchange` ,
ADD INDEX ( `status_id` );

ALTER TABLE `languages` ADD `theme` VARCHAR( 255 ) NOT NULL AFTER `code`;

-- Added 12th July 2011

INSERT INTO `modules` (`id`, `name`, `show_active`, `active`) VALUES (NULL, 'live_support', '1', '0');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '28', '', 'live_support_license', '', 'You need to order a license for the live support from www.pennyauctioncode.com to be able to use this module.', '', '', '', '1');

UPDATE `settings` SET `options` = '' WHERE `settings`.`id` =73;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '0', '0', 'limit_registration', '0', 'Ensure that registration is limited to one user per household by installing a tracking cookie to ensure the user doesn''t sign up with more than one account.', '1, 0', '', '', '');

-- Added 2nd August 2011

INSERT INTO `modules` (`id`, `name`, `show_active`, `active`) VALUES (NULL, 'idle_timeout', '1', '1');
INSERT INTO `modules` (`id`, `name`, `show_active`, `active`) VALUES (NULL, 'facebook_login', '1', '0');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '29', '0', 'timeout', '600', 'The number of seconds the user should be idle for before the session times out.  Default is 10 minutes (600 seconds).', '', '', '', '');

UPDATE `modules` SET `name` = 'reward_points' WHERE `modules`.`id` =13;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '13', '', 'rewards_store', '1', 'Allow users to redeem Reward Points through a rewards store.', '1, 0', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '13', '0', 'redeemable_won_auctions', '0', 'Allow users to redeem points on won auctions. The value here is the number of points per won auction which will be debited.  Set to zero to turn this feature off.', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '13', '0', 'bid_points', '0', 'The number of reward points earned for each bid that is placed. This is credited when the auction closes. Set to zero to turn this feature off.', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '13', '', 'win_points', '0', 'The number of reward points that a user gets when they win an auction. Set to zero to turn this feature off.', '', '', '', '');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '13', '0', 'refer_points', '0', 'The number of points given when a user is referred to the website by another user. Requires the Referral module to be on. Set to zero to turn this feature off.', '', '', '', ''), (NULL, '13', '', 'refer_purchase_points', '0', 'The number of points given when a referred user purchases a bid pack for the first time. Given as a bonus on top of the sign up points. Requires the Referral module to be on. Set to zero to turn this feature off.', '', '', '', '');

CREATE TABLE IF NOT EXISTS `rewards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `rewards` ADD INDEX ( `product_id` , `user_id` , `status_id` ) ;
ALTER TABLE `exchanges` ADD INDEX ( `auction_id` , `user_id` , `status_id` ) ;

ALTER TABLE `products` ADD `reward` TINYINT( 1 ) NOT NULL AFTER `status_id` ,
ADD `reward_points` INT( 11 ) NOT NULL AFTER `reward`;

UPDATE `settings` SET `value` = '2',
`description` = 'The number of free bids a user receives for referring another user. Set to zero to turn this off.' WHERE `settings`.`id` =5;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '23', '0', 'free_purchase_bids ', '10', 'The number of bids the user receives when a referred user purchases bids for the first time. Set this to zero to turn this off.', '', '', '', '');

ALTER TABLE `referrals` CHANGE `confirmed` `verified` TINYINT( 1 ) NOT NULL;
ALTER TABLE `referrals` ADD `purchased` TINYINT( 1 ) NOT NULL AFTER `verified`;

UPDATE `settings` SET `name` = 'referral_purchase_points' WHERE `settings`.`id` =84;
UPDATE `settings` SET `name` = 'referral_points' WHERE `settings`.`id` =83;

UPDATE `settings` SET `description` = 'The number of reward points that a user gets when they win an auction. If set to yes, this is set per product in the Products Section.',
`options` = '1, 0' WHERE `settings`.`id` =82;

ALTER TABLE `products` ADD `win_points` INT( 11 ) NOT NULL AFTER `reward_points`;

-- Added 11th August 2011

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '23', '0', 'hide_registration_sources', '0', 'Hide the registration sources if a user has accessed the website from a referral link.', '0, 1', '', '', '');

-- Added 14th August 2011
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`) VALUES (NULL, '30', '0', 'facebook_app_id', '', 'Your Facebook App ID. Generated at http://www.facebook.com', '', '', '', ''), (NULL, '30', '', 'facebook_app_secret', '', 'The Facebook App Secret generated key.', '', '', '', '');
ALTER TABLE `modules` ADD `description` TEXT NOT NULL AFTER `name`;

ALTER TABLE `settings` ADD `dependant` TINYINT NOT NULL ,
ADD `disabled` TINYINT NOT NULL;

UPDATE `settings` SET `dependant` = '2' WHERE `settings`.`id` =86;

UPDATE `settings` SET `dependant` = '19',
`disabled` = '1' WHERE `settings`.`id` =57;
UPDATE `settings` SET `module_id` = '19',
`dependant` = '9' WHERE `settings`.`id` =57;

UPDATE `settings` SET `module_id` = '2', `setting_id` = '35', `dependant` = '23' WHERE `settings`.`id` = 86;
UPDATE `settings` SET `dependant` = '23' WHERE `settings`.`id` =83;
UPDATE `settings` SET `dependant` = '23' WHERE `settings`.`id` =84;

UPDATE `modules` SET `description` = 'The ability for your users to search for auctions by title and description.  Useful if you have a lot of auctions to filter through.' WHERE `modules`.`id` = 27; UPDATE `modules` SET `description` = 'Different auction types can be turned on and off at the click of a button.' WHERE `modules`.`id` = 4; UPDATE `modules` SET `description` = 'The ability to automatically relist auctions, saving you the hassle of needing to relist an auction everytime.' WHERE `modules`.`id` = 20; UPDATE `modules` SET `description` = 'The ability to run different banners across the website.  When turned on, banner codes can be uploaded (such as Google Adsense), to earn money through advertising on your website.' WHERE `modules`.`id` = 8; UPDATE `modules` SET `description` = 'Turn off / on the Bid Buddy on your website, as well as set the time which the bid buddy should be deployed, e.g. when the end time for an auction is 30 seconds or less.' WHERE `modules`.`id` = 21; UPDATE `modules` SET `description` = 'When enabled, the Buy Now allows users to purchase auctions.  When a user places a bid on an auction, they receive a discount off the buy now price.  This module gives the ability to guarantee their purchase, so even if they lose the auction, they will still be able to receive the product at a discounted price.' WHERE `modules`.`id` = 6; UPDATE `modules` SET `description` = 'Turn off / on the contact form as well as manage the various departments to send the results too.' WHERE `modules`.`id` = 12; UPDATE `modules` SET `description` = 'Allow users to receive discount codes which can be used to purchase packages at discount prices. Different coupon types include: a percentage off the total, a specified amount off the price or extra bids given to the package.' WHERE `modules`.`id` = 1; UPDATE `modules` SET `description` = 'Used to ensure the website remains stable as your website expands, use this module to keep the website as optimised as possible.  We recommend keeping bidding history for no more than 2 weeks after an auction has ended.' WHERE `modules`.`id` = 16; UPDATE `modules` SET `description` = 'Control the various options for sending server based emails.  We recommend signing up for, and using www.authsmtp.com.
The default option for sending emails is through your local mail server.  Only edit this module if you are an advanced user.' WHERE `modules`.`id` = 17; UPDATE `modules` SET `description` = 'Allow users to use there Facebook login details to register and login to the website.' WHERE `modules`.`id` = 30; UPDATE `modules` SET `description` = 'When turned on, users can interact in our built in website forum.  Allows users to post threads in various topics and reply to different posts.' WHERE `modules`.`id` = 5; UPDATE `modules` SET `description` = 'Give users free bids for doing various tasks on your website.' WHERE `modules`.`id` = 22; UPDATE `modules` SET `description` = 'Control the various payment gateways used.  Paypal and Dalpay are set up by default.  There is also a demo gateway which should be disabled when in live mode.' WHERE `modules`.`id` = 3; UPDATE `modules` SET `description` = 'Allows for more advanced tracking of users, including what country and city they are from.  Also useful when used with multi currencies or languages, as allows for automatic detection of currency and language per user.' WHERE `modules`.`id` = 7; UPDATE `modules` SET `description` = 'Various  topics, and FAQ''s can be imputed from the CMS.  This gives users an easy to use, full featured help section, where users can see questions and answers in different sections.' WHERE `modules`.`id` = 10; UPDATE `modules` SET `description` = 'Control the number of auctions show on the home page, including advanced features such as controlling the featured auctions and coming soon auctions on the home page.' WHERE `modules`.`id` = 26; UPDATE `modules` SET `description` = 'Times users out if they have not been on your active after a set amount of time.  We recommend timing users out after 10 minutes of no activity.' WHERE `modules`.`id` = 29; UPDATE `modules` SET `description` = 'Set the default height and width of the image resizer.  Should only be used by advanced users if custom changes have been made.' WHERE `modules`.`id` = 15; UPDATE `modules` SET `description` = 'The Latest News Module allows the Website Administrator to post news articles about new events on the website.  News comments can be turned on, which allows users to receive free bids for approved comments which show for each article.' WHERE `modules`.`id` = 11; UPDATE `modules` SET `description` = 'This paid module, allows users to contact you via a Live Support chat.  Contact us for more information about this setting as well as pricing.' WHERE `modules`.`id` = 28; UPDATE `modules` SET `description` = 'module ensures that when a time is reached (say 15 seconds), no matter how many bids are placed at the same time, the auction time will not exceed 15 seconds.  A useful module if you are wanting to run fast paced auctions.  An additional setting allows you to set a dynamic time per auction, or just run a site wide value.' WHERE `modules`.`id` = 14; UPDATE `modules` SET `description` = 'When turned on, the website will be able to run multi languages!  Set the languages you are wanting to run in the Settings → Languages module, as well as edit and translate any text on the website.

When listing products, and other items, simply edit an item to add translations in different languages.' WHERE `modules`.`id` = 18; UPDATE `modules` SET `description` = 'Turn off / on the newsletter system, which allows users to sign up for your newsletter, and the ability for you to not only send newsletters from the CMS, but also export the newsletter list for sending from your own newsletter software.' WHERE `modules`.`id` = 25; UPDATE `modules` SET `description` = 'Turn off / on the referrals system and allow users to receive free bids for referring other users to the website!' WHERE `modules`.`id` = 23; UPDATE `modules` SET `description` = 'Collect various information about how users found your website when registering.  Includes an advanced option of collecting this information automatically.' WHERE `modules`.`id` = 2; UPDATE `modules` SET `description` = 'Users can receive free bids when their testimonial are approved, as well as upload Youtube videos.  Set the number of free bids that are given as well as turn off/ on this feature.' WHERE `modules`.`id` = 9; UPDATE `modules` SET `description` = 'Testing mode allows you to run stress tests on your website by allowing auto bidders to bid on your auctions.  Autobidders will behave like normal bidders.  This module should be turned off on live websites and we WILL remove this module at the request of any client.' WHERE `modules`.`id` = 19; UPDATE `modules` SET `description` = 'Win limits allow you to limit the number of auctions that users can win within a certain number of days. Full win limits control, including creating different win limit categories and set the limit reset value.' WHERE `modules`.`id` = 24;

ALTER TABLE `users` ADD `facebook_id` INT( 11 ) NOT NULL AFTER `password`;
ALTER TABLE `users` ADD `facebook_username` VARCHAR( 255 ) NOT NULL AFTER `facebook_id` ,
ADD `facebook_location` VARCHAR( 255 ) NOT NULL AFTER `facebook_username` ,
ADD `facebook_hometown` VARCHAR( 255 ) NOT NULL AFTER `facebook_location` ,
ADD `facebook_timezone` VARCHAR( 255 ) NOT NULL AFTER `facebook_hometown` ,
ADD `facebook_locale` VARCHAR( 255 ) NOT NULL AFTER `facebook_timezone`;
ALTER TABLE `users` CHANGE `facebook_id` `facebook_id` BIGINT( 20 ) NOT NULL;

UPDATE `modules` SET `description` = 'Reward points allows users to earn points for various tasks such as purchasing bids, winning auctions, referring users and bidding on auctions. These points are redeemable for products, free bids, cash and as a credit against won auctions.' WHERE `modules`.`id` = 13;

CREATE TABLE `memberships` (`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(255) NOT NULL, `description` TEXT NOT NULL, `image` VARCHAR(255) NOT NULL, `points` INT(11) NOT NULL, `rewards` TINYINT(1) NOT NULL, `created` DATETIME NOT NULL, `modified` DATETIME NOT NULL) ENGINE = MyISAM;

INSERT INTO `modules` (`id`, `name`, `description`, `show_active`, `active`) VALUES (NULL, 'memberships', 'Enable users to have different memberships. Auctions can then be set to certain membership groups only. Also can be used with the Rewards Points module to set different membership groups by the reward points earned.', '1', '0');
ALTER TABLE `memberships` ADD `rank` INT( 11 ) NOT NULL AFTER `image`;

ALTER TABLE `auctions` ADD `membership_id` INT( 11 ) NOT NULL AFTER `status_id` ,
ADD INDEX ( `membership_id` );

ALTER TABLE `users` ADD `membership_id` INT( 11 ) NOT NULL AFTER `currency_id` ,
ADD INDEX ( `membership_id` );

ALTER TABLE `memberships` ADD `default` TINYINT( 1 ) NOT NULL AFTER `rank`;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '', 'bids_back_winner', '0', 'Run Bid Back Auctions - where the winner gets his bids back when the auction closes.', '1, 0', '', '', '', '', ''), (NULL, '4', '', 'bids_back_most_bids', '0', 'Run Bid Back Auctions - where the user who bid the most bids gets there bids back.', '1, 0', '', '', '', '', '');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '89', 'points_for_bids_back_winner', '0', 'An advanced setting if run with the Rewards Points.  When turned off, the winner will not receive reward points with there bids back.', '1, 0', '', '', '', '13', '1'), (NULL, '4', '90', 'points_for_bids_back_most_bids', '0', 'An advanced setting if run with the Rewards Points.  When turned off, the user with the most bids will not receive reward points with there bids back.', '1, 0', '', '', '', '13', '1');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '0', 'bids_back_random', '0', 'Run Bid Back Auctions - where a random users gets there bids back when the auction closes. ', '1, 0', '', '', '', '', ''), (NULL, '4', '91', 'points_for_bids_back_random', '0', 'An advanced setting if run with the Rewards Points. When turned off, the user who randomly received there bids back will not receive any reward points.', '1, 0', '', '', '', '', '');
UPDATE `settings` SET `description` = 'Run Bid Back Auctions - where the winner gets there bids back when the auction closes.' WHERE `settings`.`id` =89;

ALTER TABLE `auctions` ADD `bids_back_winner` TINYINT( 1 ) NOT NULL AFTER `beginner` ,
ADD `bids_back_most_bids` TINYINT( 1 ) NOT NULL AFTER `bids_back_winner` ,
ADD `bids_back_random` TINYINT( 1 ) NOT NULL AFTER `bids_back_most_bids`;

UPDATE `settings` SET `dependant` = '13' WHERE `settings`.`id` =94;
UPDATE `settings` SET `setting_id` = '93' WHERE `settings`.`id` =94;

CREATE TABLE IF NOT EXISTS `landings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `content` text NOT NULL,
  `footer` text NOT NULL,
  `show_auctions` tinyint(1) NOT NULL,
  `closed_price` decimal(30,2) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `modules` (`id`, `name`, `description`, `show_active`, `active`) VALUES (NULL, 'landing_pages', 'Create dynamic and targeted landing pages for advertising campaigns and for targeting new users.', '1', '0');

ALTER TABLE `memberships` ADD `beginner` TINYINT( 1 ) NOT NULL AFTER `rewards`;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '31', '0', 'automatic_memberships', '1', 'Automatically update user memberships when they reach enough reward points to go to the next level.', '1,0', '0', '0', '0', '13', '0');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '21', '', 'bid_butler_strict', '0', 'With strict mode on, the software will check the user has enough bids, taking into account other active bid buddies, before a bid butler can be placed.', '0, 1', '0', '0', '0', '0', '0');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '0', 'reverse_auctions', '0', 'Turn on the reverse auction format for bidding.', '1, 0', '0', '0', '0', '0', '0');
ALTER TABLE `auctions` ADD `reverse` TINYINT( 1 ) NOT NULL AFTER `beginner`;

INSERT INTO `modules` (`id`, `name`, `description`, `show_active`, `active`) VALUES (NULL, 'auction_increments', 'This module allows the admin to set unique and dynamic auction increments for each auction.  Set unique bid, time and price increments.', '1', '0');

CREATE TABLE `increments` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`auction_id` INT( 11 ) NOT NULL ,
`bid` INT( 11 ) NOT NULL ,
`price` DECIMAL( 30, 2 ) NOT NULL ,
`time` INT( 11 ) NOT NULL ,
`low_price` DECIMAL( 30, 2 ) NOT NULL ,
`high_price` DECIMAL( 30, 2 ) NOT NULL ,
INDEX ( `auction_id` )
) ENGINE = MYISAM ;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '0', 'free_auctions', '1', 'Give the option for winners to not have to pay for won auctions. Shipping will still need to be paid, unless shipping is free.', '1, 0', '', '', '', '', '');
ALTER TABLE `auctions` ADD `free` TINYINT( 1 ) NOT NULL AFTER `beginner`;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '3', '0', 'bank_transfer', '0', 'Set to yes to active bank transfer as a  gateway ', '1, 0', '0', '0', '0', '0', '0');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '99', 'bank_details', '', 'Enter in the bank account details here.', '', '', '', '', '', '');

ALTER TABLE `auctions` ADD `bids_back_most_id` INT( 11 ) NOT NULL AFTER `winner_id` ,
ADD `bids_back_random_id` INT( 11 ) NOT NULL AFTER `bids_back_most_id` ,
ADD INDEX ( `bids_back_most_id` , `bids_back_random_id` );

ALTER TABLE `accounts` CHANGE `price` `price` DECIMAL( 30, 2 ) NOT NULL;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, 23, '', 'import_contacts', '1', 'Allow users to invite there contacts from Gmail, Hotmail, Yahoo, MSN etc and receive referrals for doing so.', '1, 0', '', '', '', '', '');

ALTER TABLE `auctions` ADD `reserve` TINYINT( 1 ) NOT NULL AFTER `price` ,
ADD `reserve_price` DECIMAL( 30, 2 ) NOT NULL AFTER `reserve`;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '', 'reserve_price', '0', 'Set a reserve price on the auction which must be met before the auction can sell.', '1,0', '', '', '', '', '');

ALTER TABLE `countries` ADD `show_first` TINYINT( 1 ) NOT NULL AFTER `name`;

ALTER TABLE `auctions` ADD `allow_zero` TINYINT( 1 ) NOT NULL AFTER `max_autobids` ;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '19', '', 'allow_zero', '0', 'Give the option to allow autobidders not to bid when no bids have been placed - this will mean that an auction may close if no real bids are placed on an auction initially!', '1, 0', '', '', '', '', '');

ALTER TABLE `auctions` ADD `bids_back_total` INT( 11 ) NOT NULL AFTER `bids_back_random`;

ALTER TABLE `auctions` ADD `reverse_extend` INT( 11 ) NOT NULL AFTER `reverse` ,
ADD `price_past_zero` TINYINT( 1 ) NOT NULL AFTER `reverse_extend` ,
ADD `charity` TINYINT( 1 ) NOT NULL AFTER `price_past_zero`;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '4', '0', 'charity_auctions', '0', 'Turn on charity auctions.', '0,1', '', '', '', '', '');

INSERT INTO `modules` (`id`, `name`, `description`, `show_active`, `active`) VALUES (NULL, 'payouts', 'Assign the different methods of payments when paying winners of cash auctions or reverse auctions below zero.', '0', '1');

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '34', '0', 'paypal', '1', 'Pay out using Paypal', '1,0', '', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '34', '0', 'amazon', '0', 'Pay out using Amazon', '1,0', '', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '34', '0', 'bank_transfer', '0', 'Pay out using Bank Transfer', '1,0', '', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '34', '0', 'bids', '0', 'Pay out as Bids', '1,0', '', '', '', '', '');
INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '34', '108', 'bid_value', '1', 'The number of bids per cent / penny that should be paid out.  For example, a sale price of $1.50 would pay out 150 bids if the rate is set to 1.  In this case, set it to 2 would pay out 300 bids etc.', '', '', '', '', '', '');

ALTER TABLE `auctions` ADD `payment` VARCHAR( 255 ) NOT NULL AFTER `price_past_zero`;

ALTER TABLE `users` ADD `amazon` VARCHAR( 255 ) NOT NULL AFTER `paypal` ,
ADD `bank_transfer` TEXT NOT NULL AFTER `amazon`;

INSERT INTO `settings` (`id`, `module_id`, `setting_id`, `name`, `value`, `description`, `options`, `show_terms`, `terms`, `allow_empty`, `dependant`, `disabled`) VALUES (NULL, '0', '0', 'time_price', 'time', 'The first column of the bidding history - can be set to show either the time or the price.', 'time, price', '0', '0', '0', '0', '0');

CREATE TABLE `subscriptions` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`months` INT( 11 ) NOT NULL ,
`price` DECIMAL( 30, 2 ) NOT NULL
) ENGINE = MYISAM ;

ALTER TABLE `landings` ADD `description` TEXT NOT NULL AFTER `title`;