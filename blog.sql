SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE IF NOT EXISTS `attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(39) NOT NULL,
  `count` int(11) NOT NULL,
  `expiredate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO `attempts` (`id`, `ip`, `count`, `expiredate`) VALUES
(1, '::1', 10, '2020-02-24 19:59:49'),
(2, '192.168.1.155', 1, '2020-02-24 20:01:55');

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `text`, `created_at`) VALUES
(1, 7, 5, 'text', '2020-02-24 19:58:28'),
(2, 7, 2, 'Nejaky komentar k tomuto clanku', '2020-02-25 07:22:29'),
(3, 7, 5, 'Toto je komentár...', '2020-02-25 07:55:59'),
(4, 7, 5, 'Paradne to funguje, a skusim pridat aj nieco ako link a to ze kukni na http://nieco.com/', '2020-02-25 07:56:48'),
(5, 6, 5, 'Komentare sa nedaju upravovat, co si myslis?? Admin naprav to a hned!! a tiez chcem odpovedat na komentar Ako napr.  na tu paradu by som vedel nieco trefne napisat. A napis uz nejaky poriadny clanok.', '2020-02-25 08:30:21'),
(6, 6, 5, 'Mozem teraz pridat?', '2020-02-25 08:39:26');

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting` varchar(100) NOT NULL,
  `value` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

INSERT INTO `config` (`id`, `setting`, `value`) VALUES
(1, 'site_name', 'Blog'),
(2, 'site_url', 'http://localhost/blog'),
(3, 'site_email', ''),
(4, 'cookie_name', 'authID'),
(5, 'cookie_path', '/'),
(6, 'cookie_domain', NULL),
(7, 'cookie_secure', '0'),
(8, 'cookie_http', '0'),
(9, 'site_key', 'fghuior.)/!/jdUkd8s2!7HVHG7777ghg'),
(10, 'cookie_remember', '+1 month'),
(11, 'cookie_forget', '+30 minutes'),
(12, 'bcrypt_cost', '10'),
(13, 'table_attempts', 'attempts'),
(14, 'table_requests', 'requests'),
(15, 'table_sessions', 'sessions'),
(16, 'table_users', 'users'),
(17, 'site_timezone', 'Europe/Paris'),
(18, 'site_activation_page', 'activate'),
(19, 'site_password_reset_page', 'reset'),
(20, 'smtp', '1'),
(21, 'smtp_host', ''),
(22, 'smtp_auth', '1'),
(23, 'smtp_username', ''),
(24, 'smtp_password', ''),
(25, 'smtp_port', ''),
(26, 'smtp_security', '');

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(200) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `slug` varchar(200) NOT NULL DEFAULT '',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

INSERT INTO `posts` (`id`, `user_id`, `title`, `text`, `slug`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'This is a title', 'Marzipan sweet roll muffin biscuit candy sugar plum. Candy canes soufflé sesame snaps muffin jelly-o jelly macaroon carrot cake. Biscuit sweet roll dragée. Sweet jujubes chupa chups chupa chups tiramisu sweet roll. Biscuit bear claw topping cake macaroon cookie tiramisu marzipan croissant. Fruitcake macaroon cake brownie oat cake dessert chocolate bar pudding biscuit.\r\n\r\nhttps://www.youtube.com/watch?v=vORsKyopHyM&index=48&list=FLa2etvvyIFz8mULUSeACJnA\r\n\r\nPie bear claw cheesecake wafer pie jujubes dessert. Jelly-o lollipop dessert cake brownie jelly-o muffin tiramisu oat cake. Marshmallow carrot cake jujubes marshmallow chocolate cake sesame snaps muffin. Muffin icing marshmallow lemon drops dessert danish cake halvah muffin. Icing chocolate cake. Pudding pie macaroon fruitcake bear claw cheesecake pudding soufflé. Pie donut carrot cake cupcake muffin.\r\n\r\nhttps://youtu.be/LKxWl4PcBY4\r\n\r\nPudding tootsie roll wafer candy croissant cake dessert. Jelly-o croissant ice cream sesame snaps bear claw tiramisu. Caramels marzipan sugar plum sweet roll donut dragée. Fruitcake cupcake cake.', 'this-is-a-title', '5e5ec8e38ecd2-zombie_367517_1280.jpg', '2020-03-03 17:12:26', '2020-03-03 21:15:15'),
(2, 1, 'Ego Tripping At The Gates Of Hell', 'I was waiting on a moment\r\nBut the moment never came\r\nAll the billion other moments\r\nWere just slipping all away\r\n(I must have been tripping) Were just slipping all away\r\n(Just ego tripping)\r\n\r\nI was wanting you to love me\r\nBut your love, it never came\r\nAll the other love around me\r\nWas just wasting all away\r\n(I must have been tripping) Was just wasting all away\r\n(Just ego tripping) Was just wasting all away\r\n(Must have been trip—)\r\n\r\nI was waiting on a moment\r\nBut the moment never came\r\nBut the moment never came\r\n\r\n(Must have been tripping) But the moment never came\r\n(Just ego tripping) But the moment never came\r\n\r\nhttp://genius.com/The-flaming-lips-ego-tripping-at-the-gates-of-hell-lyrics', 'ego-tripping-at-the-gates-of-hell', '5e5ec944b92d1-field_1728099_1280.jpg', '2020-03-03 17:12:26', '2020-03-03 21:16:53'),
(3, 1, 'The Prince and the Pauper', 'In the ancient city of London, on a certain autumn day in the second quarter of the sixteenth century, a boy was born to a poor family of the name of Canty, who did not want him. On the same day another English child was born to a rich family of the name of Tudor, who did want him. All England wanted him too. England had so longed for him, and hoped for him, and prayed God for him, that, now that he was really come, the people went nearly mad for joy. Mere acquaintances hugged and kissed each other and cried. Everybody took a holiday, and high and low, rich and poor, feasted and danced and sang, and got very mellow; and they kept this up for days and nights together.\n\nBy day, London was a sight to see, with gay banners waving from every balcony and housetop, and splendid pageants marching along. By night, it was again a sight to see, with its great bonfires at every corner, and its troops of revellers making merry around them. There was no talk in all England but of the new baby, Edward Tudor, Prince of Wales, who lay lapped in silks and satins, unconscious of all this fuss, and not knowing that great lords and ladies were tending him and watching over him—and not caring, either.  But there was no talk about the other baby, Tom Canty, lapped in his poor rags, except among the family of paupers whom he had just come to trouble with his presence.\n\nLet us skip a number of years.\n\nLondon was fifteen hundred years old, and was a great town—for that day. It had a hundred thousand inhabitants—some think double as many.  The streets were very narrow, and crooked, and dirty, especially in the part where Tom Canty lived, which was not far from London Bridge.  The houses were of wood, with the second story projecting over the first, and the third sticking its elbows out beyond the second.  The higher the houses grew, the broader they grew.  They were skeletons of strong criss-cross beams, with solid material between, coated with plaster.  The beams were painted red or blue or black, according to the owner\'s taste, and this gave the houses a very picturesque look.  The windows were small, glazed with little diamond-shaped panes, and they opened outward, on hinges, like doors.\n\nThe house which Tom\'s father lived in was up a foul little pocket called Offal Court, out of Pudding Lane.  It was small, decayed, and rickety, but it was packed full of wretchedly poor families. Canty\'s tribe occupied a room on the third floor.  The mother and father had a sort of bedstead in the corner; but Tom, his grandmother, and his two sisters, Bet and Nan, were not restricted—they had all the floor to themselves, and might sleep where they chose.  There were the remains of a blanket or two, and some bundles of ancient and dirty straw, but these could not rightly be called beds, for they were not organised; they were kicked into a general pile, mornings, and selections made from the mass at night, for service.', 'the-prince-the-pauper', NULL, '2020-03-03 17:12:26', '2020-03-03 17:12:26'),
(4, 6, 'This is the new Shit', 'Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione ab aliquid deserunt nisi, vitae ipsum vero minus molestiae voluptatibus perspiciatis est dolore at, expedita accusamus dignissimos quasi quia? Consequatur, officia!', 'this-is-the-new-shit', NULL, '2020-03-03 17:12:26', '2020-03-03 17:12:26'),
(5, 1, 'New post', 'Nieco velmi zaujimave', 'new-post', NULL, '2020-03-03 17:12:26', '2020-03-03 17:12:26'),
(6, 1, 'New post with image', 'some text', 'new-post-with-image', '5e5ec55892418-illustration_1736462_1280.png', '2020-03-03 17:59:51', '2020-03-03 21:00:11');
DELIMITER $$
CREATE TRIGGER `posts_create` BEFORE INSERT ON `posts` FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `posts_update` BEFORE UPDATE ON `posts` FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at
$$
DELIMITER ;

CREATE TABLE IF NOT EXISTS `posts_tags` (
  `post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tag_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`,`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `posts_tags` (`post_id`, `tag_id`) VALUES
(1, 1),
(2, 1),
(5, 1),
(1, 3),
(4, 3),
(5, 3),
(2, 4),
(4, 4),
(5, 4),
(6, 7);

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `rkey` varchar(20) NOT NULL,
  `expire` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `hash` varchar(40) NOT NULL,
  `expiredate` datetime NOT NULL,
  `ip` varchar(39) NOT NULL,
  `agent` varchar(200) NOT NULL,
  `cookie_crc` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `sessions` (`id`, `uid`, `hash`, `expiredate`, `ip`, `agent`, `cookie_crc`) VALUES
(1, 1, 'd14f25a416f93b2503603cef82d59b2e35193290', '2020-04-03 17:17:04', '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_3) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.5 Safari/605.1.15', '245adc78999217df5fbb4a3e292796e4f96794d0');

CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag` varchar(60) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'big ballss'),
(2, 'tits'),
(3, 'judicial branch'),
(4, 'trippin'),
(7, 'great balls'),
(8, 'balls');

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT '0',
  `dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_roles` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

INSERT INTO `users` (`id`, `email`, `username`, `password`, `isactive`, `dt`, `user_roles`) VALUES
(1, 'email@email.com', 'Admin', '$2y$10$c4mdngHWfvWte2XGO/y6aO/AJgOrV0gOcDiFXGUArQGjf/oRU0rkK', 1, '2020-02-17 19:40:53', 'admin'),
(3, 'example@email.com', 'e-johny', '$2y$10$QrgOVF3V48mOLyzicRtntulCtXhK4UGw3UHqjH5mDqNX8BEsZwbGO', 1, '2020-02-18 19:01:40', 'user'),
(6, 'noone@email.com', 'Oknaj', '$2y$10$gERNOh87.7Q9JLlVU6L2PedBkUD/x6sc2hZ4Sy6rzZoC7frGJnOWC', 1, '2020-02-18 18:49:49', 'editor'),
(7, 'email@email.sk', 'adminko', '$2y$10$vhlh.jndPbQEPUM9hS9Ba..ps5W.tpMm07DCTQO5GA493zM84bWgy', 1, '2020-02-24 18:15:52', 'user');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
