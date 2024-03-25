-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2019 at 08:49 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `educationalappsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `name`) VALUES
(1, 'Mr Paddington\'s Quiz-a-thon');

-- --------------------------------------------------------

--
-- Table structure for table `activity_assignment`
--

CREATE TABLE `activity_assignment` (
  `id` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `activityid` int(11) NOT NULL,
  `attempts` int(11) DEFAULT '0',
  `time` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_assignment`
--

INSERT INTO `activity_assignment` (`id`, `teacherid`, `studentid`, `activityid`, `attempts`, `time`) VALUES
(8, 1, 1, 1, 13, 176),
(10, 1, 6, 1, 1, 156),
(11, 2, 34, 1, 1, 160);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `usertype`) VALUES
(1, 'admin', '$2y$10$fK7Tus8YZoXdVOvb3C5p.uD7QrvJ1t2ZxTl1yP4YkfbFkF7iBBILS', 1);

-- --------------------------------------------------------

--
-- Table structure for table `results_storage`
--

CREATE TABLE `results_storage` (
  `id` int(11) NOT NULL,
  `assignmentid` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `correct` tinyint(1) DEFAULT NULL,
  `attempts` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `choices` varchar(255) NOT NULL,
  `picked` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `results_storage`
--

INSERT INTO `results_storage` (`id`, `assignmentid`, `question`, `correct`, `attempts`, `time`, `type`, `choices`, `picked`, `title`, `answer`) VALUES
(14, 8, 0, 0, 3, 62, 'Spelling', 'Switch, Sweetch, Swich, Switche', 'Switche, Sweetch, Swich', 'Remember to _____ off the light', 'Switch'),
(15, 8, 1, 1, 1, 49, 'Understanding', 'The floor was wet, The food was too hot, He didn\'t like the food, He tripped on a sign', 'The floor was wet', 'Why did Micheal drop his tray?', 'The floor was wet'),
(16, 8, 2, 0, 3, 1, 'Understanding', 'She missed her bus and had to walk, She decided to run to school, Her school was very far away, School is so boring', 'Her school was very far away, Her school was very far away, Her school was very far away', 'Why was Jamila tired when she got to school?', 'She missed her bus and had to walk'),
(17, 8, 3, 0, 3, 1, 'Spelling', 'Brovor, Brother, Brudduh, Bruvver', 'Brudduh, Brudduh, Brudduh', 'I love my older _____', 'Brother'),
(18, 8, 4, 0, 3, 1, 'Spelling', 'P, N, B, Y', 'B, B, B', 'A _ _ L E', 'P'),
(19, 8, 5, 0, 3, 1, 'Spelling', 'Fraction, Frahction, Fraktion, Fuhracksion', 'Fraktion, Fraktion, Fraktion', 'In maths, we learnt what a _____ is', 'Fraction'),
(20, 8, 6, 0, 3, 1, 'Punctuation', 'This puzzle is hard, Where is my puzzle, That puzzle is mine, I hate puzzles', 'That puzzle is mine, That puzzle is mine, That puzzle is mine', 'Which sentence is a question?', 'Where is my puzzle'),
(21, 8, 7, 0, 3, 1, 'Grammar', 'cool, girl, Mayesha, friend', 'Mayesha, Mayesha, Mayesha', 'My friend, Mayesha, is a cool girl', 'cool'),
(22, 8, 8, 0, 3, 1, 'Grammar', 'so, when, where, if', 'where, where, where', 'We will make it on time _____ we leave right now', 'if'),
(23, 8, 9, 1, 1, 1, 'Grammar', 'Dirtly, Dirted, Dirty, Dirt', 'Dirty', 'Jason\'s clothes were _____ after football practice', 'Dirty'),
(24, 10, 0, 1, 2, 12, 'Grammar', 'if, when, where, so', 'so, if', 'We will make it on time _____ we leave right now', 'if'),
(25, 10, 1, 0, 3, 13, 'Understanding', 'She missed her bus and had to walk, School is so boring, Her school was very far away, She decided to run to school', 'School is so boring, She decided to run to school, Her school was very far away', 'Why was Jamila tired when she got to school?', 'She missed her bus and had to walk'),
(26, 10, 2, 1, 2, 11, 'Spelling', 'Brudduh, Brother, Bruvver, Brovor', 'Brudduh, Brother', 'I love my older _____', 'Brother'),
(27, 10, 3, 1, 1, 33, 'Understanding', 'The floor was wet, The food was too hot, He tripped on a sign, He didn\'t like the food', 'The floor was wet', 'Why did Micheal drop his tray?', 'The floor was wet'),
(28, 10, 4, 1, 3, 14, 'Spelling', 'Switch, Switche, Sweetch, Swich', 'Swich, Switche, Switch', 'Remember to _____ off the light', 'Switch'),
(29, 10, 5, 1, 1, 7, 'Punctuation', 'I hate puzzles, That puzzle is mine, Where is my puzzle, This puzzle is hard', 'Where is my puzzle', 'Which sentence is a question?', 'Where is my puzzle'),
(30, 10, 6, 1, 1, 7, 'Spelling', 'P, N, B, Y', 'P', 'A _ _ L E', 'P'),
(31, 10, 7, 0, 3, 18, 'Understanding', '8 years, 500 years, 5 years, 10 years', '8 years, 5 years, 10 years', 'How long have ducks been living as pets for?', '500 years'),
(32, 10, 8, 1, 3, 27, 'Spelling', 'Fuhracksion, Fraktion, Fraction, Frahction', 'Fuhracksion, Frahction, Fraction', 'In maths, we learnt what a _____ is', 'Fraction'),
(33, 10, 9, 1, 1, 9, 'Punctuation', '!, ?, ,, *', '!', 'Simon\'s cat is so cute', '!'),
(34, 11, 0, 1, 1, 5, 'Spelling', 'N, Y, B, A', 'A', 'B _ N _ N _', 'A'),
(35, 11, 1, 1, 2, 11, 'Spelling', 'P, N, Y, B', 'Y, P', 'A _ _ L E', 'P'),
(36, 11, 2, 0, 3, 17, 'Punctuation', 'a question mark, a capital letter, a comma, an apostrophe', 'a question mark, an apostrophe, a comma', 'the boys raced to the park.', 'a capital letter'),
(37, 11, 3, 1, 1, 8, 'Grammar', 'Adverb, Verb, Adjective, Noun', 'Adverb', 'Milo lightly tapped me on the shoulder', 'Adverb'),
(38, 11, 4, 1, 3, 19, 'Grammar', 'so, when, if, where', 'when, so, if', 'We will make it on time _____ we leave right now', 'if'),
(39, 11, 5, 1, 1, 10, 'Grammar', 'Runner, Runned, Running, Ran', 'Ran', 'Zahir \'run\' to his house because it was raining', 'Ran'),
(40, 11, 6, 0, 3, 20, 'Punctuation', 'James, JAMES, jaMes, jAmes', 'JAMES, jaMes, jAmes', 'my friend _____ just loves to dance', 'James'),
(41, 11, 7, 1, 2, 26, 'Understanding', 'He didn\'t like the food, He tripped on a sign, The food was too hot, The floor was wet', 'He tripped on a sign, The floor was wet', 'Why did Micheal drop his tray?', 'The floor was wet'),
(42, 11, 8, 1, 1, 4, 'Spelling', 'Bruvver, Brother, Brudduh, Brovor', 'Brother', 'I love my older _____', 'Brother'),
(43, 11, 9, 0, 3, 20, 'Grammar', 'Dirty, Dirted, Dirtly, Dirt', 'Dirted, Dirt, Dirtly', 'Jason\'s clothes were _____ after football practice', 'Dirty');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` int(11) NOT NULL,
  `teacherid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `firstname`, `lastname`, `username`, `password`, `usertype`, `teacherid`) VALUES
(1, 'Wilfredo', 'Dunn', 'wdunn001', '$2y$10$nU3pThkHbtmbB7EeVrCbl.so/bq7Ebu1lTj3Pwj6VJCHk/MhEA2kS', 3, 1),
(2, 'Micheal', 'Miles', 'mmile001', '$2y$10$rAWgsc77RGL2Xmavpdx7uOIzmv6X61ulwg6nyf1.is06vw3iWJgeq', 3, 1),
(3, 'Lou', 'Fletcher', 'lflet001', '$2y$10$G2JwWKEkFxttvTddYQo4FO/RWbXqpXS/dGAVy1HY3u.j2lvwIQZA.', 3, 1),
(4, 'Erwin', 'Dixon', 'edixo001', '$2y$10$jsLe2rr4E2QaoOZpmUmrVudveyjKemKMRZXztOPWhojacdcSKp.c6', 3, 1),
(5, 'Booker', 'Phillips', 'bphil001', '$2y$10$e0m3OVbOMe2WKsxqAahGq.bXQVA087qrnTavyyNcNmP7YKhECcnwu', 3, 1),
(6, 'Tuan', 'Blackburn', 'tblac001', '$2y$10$q4e64DsjnEBrS6595DZb8uA9mMudt634ymGYrT1hdWsj1/3XqbNlO', 3, 1),
(7, 'Logan', 'Mason', 'lmaso001', '$2y$10$1zn0BAx.YKCXikNagIEBVemaIE7dhBgG3GdZwx54p8yoUWPUP/wbq', 3, 1),
(8, 'Carey', 'Duarte', 'cduar001', '$2y$10$jK9Myai1gEL0FvbqrKqv5eacdkKqH8aumiGxt4AosU9./j/jAUv8i', 3, 1),
(9, 'Kim', 'Lutz', 'klutz001', '$2y$10$L.txNTPr5VfkreOpbjIgvOyMQLvQ5YDG3IcAeMks5KO4OGjaP8jGG', 3, 1),
(10, 'Seth', 'Shannon', 'sshan001', '$2y$10$cJieaFYiszUr1CX9RMHgv.2VeSEKkpgseMv5IBet4fCTNGJgXHMZC', 3, 1),
(11, 'Kraig', 'Orozco', 'koroz001', '$2y$10$S4srYqieHiCHVrklW0/TROW81bjiumgoq5pcu1etTZcdRx9fVXUay', 3, 1),
(12, 'Rodrigo', 'Holder', 'rhold001', '$2y$10$hVaYVQvjkVjdzYteTLCxde5V7tfjvrzTFZ/vWoSW6AZyRSrg6ZVYq', 3, 1),
(13, 'Lowell', 'Webster', 'lwebs001', '$2y$10$zCgEXf9LgUBcMtOzVM9BnOkoUQJ17LXdfcoU9XDTVsavCH8n9RT5a', 3, 1),
(14, 'Kerry', 'Strong', 'kstro001', '$2y$10$3F2okTQnwrFU5GhkLaLfc.6Z6B2nfUKw2cCa6U696MHI/LED2LAji', 3, 1),
(15, 'Brittney', 'Baxter', 'bbaxt001', '$2y$10$pn4Zb17S10QqYBTQ1A0MYe82UvjCtw44X53xBlRWlLD7x1M2GrImK', 3, 1),
(16, 'Lindsay', 'Marshall', 'lmars001', '$2y$10$H7m3s94v0Ahi01.33abccOSHj9A/6h77ULRdJvwwIQqrUszMB3kQ.', 3, 1),
(17, 'Araceli', 'Pena', 'apena001', '$2y$10$iHHXH0zDV5ckdTr2QiYcx.zQyYlT5EG2qLB9DgSmLWL48MoXpUWI2', 3, 1),
(18, 'Judith', 'Trujillo', 'jtruj001', '$2y$10$Wn4Lp5ihPaoct89rcEpgMexZmGOw3OOW5n.Vs.qD8Qu.ZS4bF/tde', 3, 1),
(19, 'Jenna', 'Bass', 'jbass001', '$2y$10$9wT1gPnwzhdGW1HcncE0r.V7NKVNJ3TuLGoJNqiDDYcWD1AZYIJ9q', 3, 1),
(20, 'Simone', 'Glenn', 'sglenn001', '$2y$10$GQdv2SCTLONfhrQrziIK1e5mnsLRNRqeFH9DxXHgJbttAAyhOIX7C', 3, 1),
(21, 'Chrystal', 'Whitney', 'cwhit001', '$2y$10$0pmQnstE9fVJj90IJclNB.Naj.7H/pUSG7hzzdbFVpx1.QAJe3f6i', 3, 1),
(22, 'Nicole', 'Mcknight', 'nmckn001', '$2y$10$TSYg38my22sdFnT72J7vq..3Mfh3QMFLBTN.qrI8Koc.Az5kw2r0i', 3, 1),
(23, 'Erna', 'Khan', 'ekhan001', '$2y$10$A3BR9iwZqzIgKWjhMeEspeyESzLjHc/YrC3jlI4gBkGRDWS29u1qq', 3, 1),
(24, 'Aida', 'Duarte', 'aduar001', '$2y$10$LuAX2Iqz33N132LMUwvB0.JgfzY5hg7JNhMl8kBfzzh.e.OttfLPe', 3, 1),
(25, 'Leigh', 'Nunez', 'lnune001', '$2y$10$HrFH5T0QQq5nae2CAzdRLu0PybFQx7JEV/ax9kIJirNqUaJoSxXqm', 3, 1),
(26, 'Alisa', 'Juarez', 'ajuar001', '$2y$10$iDcQwA9oL6.rtUL.pceKGu53n5pX/ztWfvYxbGU9DFLB36R0Ac5rq', 3, 1),
(27, 'Leonor', 'Oliver', 'loliv001', '$2y$10$qvIS6ynvQHng6CKGNZ8uk.CwMoOX6NqfNBG/LPDLXQV8Rsr8Q2JaK', 3, 1),
(28, 'Deirdre', 'Joyce', 'djoyc001', '$2y$10$VD9wkiqHPWrOZ.9.dCJOReTYmDNLb4WGI.g8yIGyZx3ITWqHjXbAe', 3, 1),
(29, 'Mae', 'Wiggins', 'mwigg001', '$2y$10$CkByh1w7JRn5TXWHqKQtTO9F.zbK7A7sPTldsqjw/CLfrOpPxX0cy', 3, 1),
(30, 'Diego', 'Hamilton', 'dhami001', '$2y$10$gB3zj93bc1i6X2yykOK9SOBH.6dE9zEuohGZRyjkAMLLzquN1LY3.', 3, 2),
(31, 'Benito', 'Pena', 'bpena001', '$2y$10$0m/ZHrp9XvEv6xrnawFqU.o/dRDICZA/r82HyF0aa0ngUB9DNolUG', 3, 2),
(32, 'Brooks', 'Lyons', 'blyon001', '$2y$10$6P0Aa//9ipkAyU0oWCkxR.B74MxhCeq2on3gPZpLPdzCPVymYxX4K', 3, 2),
(33, 'Lorenzo', 'Meza', 'lmeza001', '$2y$10$DrUHw2MxtxtMjMceTJ/Y3eiC7Wz7GvugXZ.mJpg7GI1EJVwIxf6RK', 3, 2),
(34, 'Werner', 'Gilbert', 'wgilb001', '$2y$10$QFafEmNtCXaZaFDRro9JnOvfurYtknnPSyv5aZu5cR4gKGEYr80Ba', 3, 2),
(35, 'Adrian', 'Huang', 'ahuan001', '$2y$10$YaqGqHxSO6AxPBQWmIf.7OjT92oNBHCqBepFEzSKYoVhEiscpnCFy', 3, 2),
(36, 'Jorge', 'Cameron', 'jcame001', '$2y$10$TOgNr1cyWRb9L1Bb6wSJ6OYjlS9zZHEBC8DRiEt0qA9qu2MMCNwAO', 3, 2),
(37, 'Minh', 'Bush', 'mbush001', '$2y$10$mC6pMia/qB6ZQGKYb2fO9OCIapn14rHQr5KrO59GRu/z7zQrBiEES', 3, 2),
(38, 'Gale', 'Salinas', 'gsali001', '$2y$10$oomKbSMhItw6quSVgsRAv.i.lxS5Hx/GF7wnEodIBDPkKmpl.MR2i', 3, 2),
(39, 'Faustino', 'Carroll', 'fcarr001', '$2y$10$Y72ptGXc8doqN9sTG4L7lOEZRDtWJQya9s.8anwrcvOjYzHcXSObe', 3, 2),
(40, 'Warren', 'Hansen', 'whans001', '$2y$10$h904USHdHg0uQTDfI4YXnOONOiFNZQMPdJu3eKYQM8kdWPwlvnMXS', 3, 2),
(41, 'Kim', 'Compton', 'kcomp001', '$2y$10$rrUuuG0bEkmdn3ZvYCcG8uXDcLcv1/yqSMJ11tmqnfoGubl9aTK0G', 3, 2),
(42, 'Cole', 'George', 'cgeor001', '$2y$10$eW0KWyNCeCeeGR0rhQNeoejRWqvV.XHLNGALpJkEHKGQs8g0gI/Hy', 3, 2),
(43, 'Granville', 'Cuevas', 'gcuev001', '$2y$10$6sH23k0nIx6k3s65HWCt2.8lnK//SKrPBwnM.LVa5VrXP0EE5bPbC', 3, 2),
(44, 'Gilberto', 'Carpenter', 'gcarp001', '$2y$10$W2B0L44yue5s4DNaVMlufesEAa371ZV2RpnD19RfjbB/4hZgLAHvS', 3, 2),
(45, 'Matilda', 'Serrano', 'mserr001', '$2y$10$WFSxEn8kK8CnQKXlkPc3m.r.e2y4miGpzaFWXQHOozpQAs4plqpiO', 3, 2),
(46, 'Barbra', 'Russell', 'bruss001', '$2y$10$sczxX.4zTSj7TRh2LLgtyO.RFVshsYO4T2vbAPrVg5vX/p7fxaoxS', 3, 2),
(47, 'Kelsey', 'Kemp', 'kkemp001', '$2y$10$2ArhUWtf8I8lTyGYcRSqCOFZdHt5HVTcmLmbxRykorknhznUBu.L2', 3, 2),
(48, 'Fern', 'Sims', 'fsims001', '$2y$10$PiLnJFieEphy9hbNQDk53OFwD.ujT40aItk6NceThW7V8hsvUGdXe', 3, 2),
(49, 'Dorthy', 'Beltran', 'dbelt001', '$2y$10$OV9OIHomhJ7CRCrv0E0TQOgRGlTZwyG3uZinoAUrkEyzXkFdLCGEm', 3, 2),
(50, 'Madeleine', 'Green', 'mgree001', '$2y$10$iQ.9je9vVoxCoDhJaaHtDeiO5CDf5Jsv5qvn7s3UOovjZw2dutRcC', 3, 2),
(51, 'Jordan', 'Choi', 'jchoi001', '$2y$10$Syibf2SqpvjZ8Y6cOjhH6udlFyNp1yZm34WZ34Oh2enWovUG1CazO', 3, 2),
(52, 'Margo', 'Rocha', 'mroch001', '$2y$10$pLxWnlmFerIUqpZ3vzeL.etznXPfbwEPlQPvv9bPj.ud515EwG7fy', 3, 2),
(53, 'Angela', 'Larson', 'alars001', '$2y$10$/b08qntvO0rUIHv2RzgbGeAeUTUmCGket3g1xdPovK.ogZdr0TUlq', 3, 2),
(54, 'Lynne', 'Zamora', 'lzamo001', '$2y$10$6xR1CK.cBkn.374dX8b4xeSjbnEc2VyARTbmImhT8rzYFgV8YhCc.', 3, 2),
(55, 'Debora', 'Hood', 'dhood001', '$2y$10$K7RwpTwxRV2zrqVTRS7ZKuiOEfNACIUH2iXrMhSVoZx/za0Rgf26C', 3, 2),
(56, 'Alicia', 'Mitchell', 'amitc001', '$2y$10$6b38.FABgkMmSV189FzGUOHjfk8Jbip7p9DX4uB4EWe1uW1gGBVzi', 3, 2),
(57, 'Rhonda', 'Wilkinson', 'rwilk001', '$2y$10$iC7jw3ZHrZYo0LMypXlM/uq8cpGmg2EkPqaHupy1RG2ThpGCOlpoW', 3, 2),
(58, 'Melody', 'Velez', 'mvele001', '$2y$10$Ga3h2dVtvdXC6m9Dquk0eOmiWkZbJgwRCUhNmeI8n.UBBoBAuncXe', 3, 2),
(59, 'Brandie', 'Glenn', 'bglen001', '$2y$10$M5JkZid5HEa4estJ68rXi.ksM7W5US6FOCinu4K/SVKDhMRUYP8Ny', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `firstname`, `lastname`, `username`, `password`, `usertype`) VALUES
(1, 'Kate', 'Gardner', 'kgard001', '$2y$10$rEgYjesHLDDlQ09zMTLIfeJR6YAXRJ2tT2rfb2.maOcGldRDVYQNS', 2),
(2, 'Bradley', 'Morgon', 'bmorg001', '$2y$10$KB6WHsY5WJtN82qQSS7hwuvs5xQVcenPZy13lEABajSC7yCe5jXGu', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_assignment`
--
ALTER TABLE `activity_assignment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacherid` (`teacherid`),
  ADD KEY `studentid` (`studentid`),
  ADD KEY `activityid` (`activityid`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `results_storage`
--
ALTER TABLE `results_storage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignmentid` (`assignmentid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher` (`teacherid`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `activity_assignment`
--
ALTER TABLE `activity_assignment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `results_storage`
--
ALTER TABLE `results_storage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_assignment`
--
ALTER TABLE `activity_assignment`
  ADD CONSTRAINT `activity_assignment_ibfk_1` FOREIGN KEY (`teacherid`) REFERENCES `teachers` (`id`),
  ADD CONSTRAINT `activity_assignment_ibfk_2` FOREIGN KEY (`studentid`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `activity_assignment_ibfk_3` FOREIGN KEY (`activityid`) REFERENCES `activities` (`id`);

--
-- Constraints for table `results_storage`
--
ALTER TABLE `results_storage`
  ADD CONSTRAINT `results_storage_ibfk_1` FOREIGN KEY (`assignmentid`) REFERENCES `activity_assignment` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`teacherid`) REFERENCES `teachers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
