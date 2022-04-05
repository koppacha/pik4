-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: pik4_db
-- 生成日時: 2021 年 8 月 28 日 04:09
-- サーバのバージョン： 5.7.35
-- PHP のバージョン: 7.4.11

-- ここからDocker用

DROP DATABASE IF EXISTS pik4;
CREATE DATABASE pik4;
USE pik4;

-- ここまでDocker用

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+09:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `pik4`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `area`
--

CREATE TABLE `area` (
  `id` int(4) NOT NULL,
  `lim` int(2) NOT NULL,
  `flag` int(2) NOT NULL,
  `stage_id` int(4) NOT NULL,
  `post_date` datetime NOT NULL,
  `mark` varchar(24) NOT NULL,
  `title` varchar(60) NOT NULL,
  `border_score` int(5) NOT NULL,
  `ex_border_score` int(6) NOT NULL,
  `top_score` int(5) NOT NULL,
  `user_name` varchar(14) NOT NULL,
  `border_rank` int(4) NOT NULL,
  `break_count` int(4) NOT NULL,
  `under_score` int(6) NOT NULL,
  `count` int(2) NOT NULL,
  `other` int(2) NOT NULL,
  `team_a` int(7) NOT NULL,
  `team_b` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `battle`
--

CREATE TABLE `battle` (
  `post_id` int(11) NOT NULL,
  `stage_id` int(7) NOT NULL,
  `unique_id` int(10) NOT NULL,
  `battle_id` int(6) NOT NULL,
  `post_date` datetime NOT NULL,
  `log` int(1) NOT NULL,
  `user_ip` varchar(128) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `post_comment` varchar(256) NOT NULL,
  `post_rank` int(4) NOT NULL,
  `post_count` int(6) NOT NULL,
  `playside` int(1) NOT NULL,
  `console` int(1) NOT NULL,
  `result` int(1) NOT NULL,
  `detail` int(2) NOT NULL,
  `rps` int(6) NOT NULL,
  `t_prev` double NOT NULL,
  `t_rate` double NOT NULL,
  `prev` double NOT NULL,
  `rate` double NOT NULL,
  `r_prev` double NOT NULL,
  `r_rate` double NOT NULL,
  `reague` int(3) NOT NULL,
  `pic_file` varchar(128) NOT NULL,
  `pic_file2` varchar(128) NOT NULL,
  `video_url` varchar(256) NOT NULL,
  `win` int(5) NOT NULL,
  `lose` int(5) NOT NULL,
  `draw` int(5) NOT NULL,
  `macaroon` int(1) NOT NULL,
  `leader` int(1) NOT NULL,
  `pikmin` int(3) NOT NULL,
  `post_memo` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `counter`
--

CREATE TABLE `counter` (
  `id` int(11) NOT NULL,
  `user_name` varchar(14) NOT NULL,
  `stage_id` int(8) NOT NULL,
  `date` datetime NOT NULL,
  `count` int(14) NOT NULL,
  `flag` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `limited_log`
--

CREATE TABLE `limited_log` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `stage_id` int(8) NOT NULL,
  `score` int(7) NOT NULL,
  `left_side` int(6) NOT NULL,
  `right_side` int(6) NOT NULL,
  `area` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `memo`
--

CREATE TABLE `memo` (
  `post_id` int(6) NOT NULL,
  `user_name` varchar(60) NOT NULL,
  `user_ip` varchar(60) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `meta`
--

CREATE TABLE `meta` (
  `id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `value` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `minites`
--

CREATE TABLE `minites` (
  `id` int(11) NOT NULL,
  `minites_count` int(11) NOT NULL,
  `egg` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `name` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `note`
--

CREATE TABLE `note` (
  `id` int(6) NOT NULL,
  `post_title` varchar(128) NOT NULL,
  `post_date` datetime NOT NULL,
  `post_mod` datetime NOT NULL,
  `tag` varchar(128) NOT NULL,
  `editor` varchar(128) NOT NULL,
  `flag` int(2) NOT NULL,
  `content` text NOT NULL,
  `other` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `object_list`
--

CREATE TABLE `object_list` (
  `object_id` int(6) NOT NULL,
  `stage_id` int(6) NOT NULL,
  `floor` int(2) NOT NULL,
  `object_name` varchar(256) NOT NULL,
  `count` int(2) NOT NULL,
  `price` int(5) NOT NULL,
  `sum_price` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `ranking`
--

CREATE TABLE `ranking` (
  `post_id` int(6) NOT NULL,
  `user_name` varchar(14) NOT NULL,
  `password` varchar(32) NOT NULL DEFAULT '0000',
  `score` int(11) NOT NULL,
  `prev_score` int(11) NOT NULL,
  `console` int(1) NOT NULL,
  `console_2p` int(7) NOT NULL,
  `stage_id` int(11) NOT NULL,
  `pic_file` varchar(128) NOT NULL,
  `pic_file2` varchar(128) NOT NULL,
  `unique_id` varchar(32) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `user_host` varchar(256) NOT NULL,
  `user_agent` varchar(256) NOT NULL,
  `post_date` datetime NOT NULL,
  `firstpost_date` datetime NOT NULL,
  `post_count` int(11) NOT NULL DEFAULT '0',
  `post_comment` text CHARACTER SET utf8mb4 NOT NULL,
  `post_memo` varchar(256) NOT NULL,
  `log` int(4) NOT NULL DEFAULT '0',
  `season` int(3) NOT NULL,
  `rps` int(6) NOT NULL,
  `rps2` int(11) NOT NULL,
  `post_rank` int(6) NOT NULL,
  `at_rank` int(4) NOT NULL,
  `video_url` varchar(1024) NOT NULL,
  `prev_rank` int(4) NOT NULL,
  `egg` int(4) NOT NULL,
  `days` int(3) NOT NULL,
  `correct` int(3) NOT NULL,
  `rta_time` int(7) NOT NULL,
  `pikmin` int(6) NOT NULL,
  `red_pikmin` int(5) NOT NULL,
  `blue_pikmin` int(5) NOT NULL,
  `yellow_pikmin` int(5) NOT NULL,
  `white_pikmin` int(5) NOT NULL,
  `purple_pikmin` int(5) NOT NULL,
  `rock_pikmin` int(5) NOT NULL,
  `winged_pikmin` int(5) NOT NULL,
  `death` int(5) NOT NULL,
  `lim` varchar(1024) NOT NULL,
  `story_pts` int(7) NOT NULL,
  `story_han` int(2) NOT NULL,
  `bulbmin` int(6) NOT NULL,
  `queen_candypop_bud` int(6) NOT NULL,
  `team` varchar(256) NOT NULL,
  `rate` int(4) NOT NULL,
  `user_name_2p` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `ranking_b`
--

CREATE TABLE `ranking_b` (
  `post_id` int(6) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `prev_score` int(11) NOT NULL,
  `console` int(1) NOT NULL,
  `stage_id` int(11) NOT NULL,
  `file_name` mediumblob NOT NULL,
  `unique_id` varchar(32) NOT NULL,
  `user_ip` varchar(100) NOT NULL,
  `post_date` varchar(20) NOT NULL,
  `post_count` int(11) NOT NULL,
  `post_comment` varchar(256) NOT NULL,
  `post_memo` varchar(256) NOT NULL,
  `mod_date` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `stage_title`
--

CREATE TABLE `stage_title` (
  `stage_id` int(8) NOT NULL,
  `stage_name` varchar(64) NOT NULL,
  `eng_stage_name` varchar(128) NOT NULL,
  `stage_sub` mediumtext NOT NULL,
  `parent` varchar(12) NOT NULL,
  `Time` int(4) NOT NULL,
  `Max_Treture` int(5) NOT NULL,
  `Total_Pikmin` int(3) NOT NULL,
  `Egg` int(1) NOT NULL,
  `Red_Pikmin` int(3) NOT NULL,
  `Blue_pikmin` int(3) NOT NULL,
  `Yellow_Pikmin` int(3) NOT NULL,
  `Purple_Pikmin` int(3) NOT NULL,
  `White_Pikmin` int(3) NOT NULL,
  `Winged_Pikmin` int(3) NOT NULL,
  `Rock_Pikmin` int(3) NOT NULL,
  `Bulbmin` int(3) NOT NULL,
  `Ultra_Spicy` int(2) NOT NULL,
  `Ultra_Bitter` int(2) NOT NULL,
  `wr` int(6) NOT NULL,
  `score_ave` float NOT NULL,
  `score_sd` float NOT NULL,
  `score_sum` float NOT NULL,
  `s01_top` int(6) NOT NULL,
  `s02_top` int(6) NOT NULL,
  `s03_top` int(6) NOT NULL,
  `s04_top` int(6) NOT NULL,
  `s05_top` int(6) NOT NULL,
  `s06_top` int(6) NOT NULL,
  `s07_top` int(6) NOT NULL,
  `s08_top` int(6) NOT NULL,
  `s09_top` int(6) NOT NULL,
  `s10_top` int(6) NOT NULL,
  `s11_top` int(6) NOT NULL,
  `s12_top` int(6) NOT NULL,
  `s13_top` int(11) NOT NULL,
  `s14_top` int(11) NOT NULL,
  `s15_top` int(7) NOT NULL,
  `border_line` int(6) NOT NULL,
  `border_line_701k` int(6) NOT NULL,
  `unexpected` int(6) NOT NULL,
  `post_count` int(6) NOT NULL,
  `player_count` int(6) NOT NULL,
  `terms` varchar(64) NOT NULL,
  `wrdx` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `total`
--

CREATE TABLE `total` (
  `post_id` int(11) NOT NULL,
  `user_name` varchar(24) NOT NULL,
  `score` int(11) NOT NULL,
  `rate` double NOT NULL,
  `rd` double NOT NULL,
  `mu` double NOT NULL,
  `phi` double NOT NULL,
  `win` int(5) NOT NULL,
  `lose` int(5) NOT NULL,
  `draw` int(5) NOT NULL,
  `post_rank` int(5) NOT NULL,
  `reague` int(5) NOT NULL,
  `post_date` datetime NOT NULL,
  `log` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `user_id` int(6) NOT NULL,
  `user_name` varchar(64) NOT NULL,
  `pass` varchar(256) NOT NULL,
  `twitter_access_key` varchar(64) NOT NULL,
  `twitter_access_skey` varchar(64) NOT NULL,
  `lastupdate` datetime NOT NULL,
  `egg` int(4) NOT NULL DEFAULT '0',
  `tp` int(8) NOT NULL,
  `other` varchar(256) NOT NULL,
  `post_count` int(4) NOT NULL,
  `user_comment` varchar(512) NOT NULL,
  `current_team` int(2) NOT NULL,
  `total_rps` int(10) NOT NULL,
  `total_all` int(11) NOT NULL,
  `total_sp` int(11) NOT NULL,
  `total_story` int(11) NOT NULL,
  `total_mix` int(11) NOT NULL,
  `total_point` int(8) NOT NULL,
  `total_pik1cha` int(4) NOT NULL,
  `total_pik2cha` int(6) NOT NULL,
  `total_pik3cha` int(6) NOT NULL,
  `total_pik2egg` int(6) NOT NULL,
  `total_pik2noegg` int(6) NOT NULL,
  `total_pik2cave` int(7) NOT NULL,
  `total_pik2_2p` int(7) NOT NULL,
  `total_pik3ct` int(6) NOT NULL,
  `total_pik3be` int(6) NOT NULL,
  `total_pik3db` int(6) NOT NULL,
  `total_pik3_2p` int(7) NOT NULL,
  `total_diary` int(7) NOT NULL,
  `total_new` int(6) NOT NULL,
  `total_new2` int(7) NOT NULL,
  `total_limited000` int(7) NOT NULL,
  `total_limited001` int(6) NOT NULL,
  `total_limited002` int(6) NOT NULL,
  `total_limited003` int(6) NOT NULL,
  `total_limited004` int(6) NOT NULL,
  `total_limited005` int(6) NOT NULL,
  `total_limited006` int(6) NOT NULL,
  `total_limited007` int(11) NOT NULL,
  `total_limited008` int(6) NOT NULL,
  `total_limited009` int(11) NOT NULL,
  `total_limited010` int(11) NOT NULL,
  `total_limited011` int(6) NOT NULL,
  `total_limited012` int(8) NOT NULL,
  `rate` int(4) NOT NULL,
  `limrate` float NOT NULL,
  `total_limited013` int(6) NOT NULL,
  `total_arealim013` int(7) NOT NULL,
  `total_uplan001` int(7) NOT NULL,
  `total_uplan001rps` int(7) NOT NULL,
  `total_uplan002` int(7) NOT NULL,
  `total_uplan002rps` int(7) NOT NULL,
  `season_pik2cha12` int(6) NOT NULL,
  `season_pik2cha` int(6) NOT NULL,
  `season_normal12` int(6) NOT NULL,
  `season_normal` int(6) NOT NULL,
  `total_lim` int(7) NOT NULL,
  `total_battle2` float NOT NULL,
  `total_battle3` float NOT NULL,
  `battle_rate` double NOT NULL,
  `battle_rd` float NOT NULL,
  `twitch` varchar(60) NOT NULL,
  `twitter` varchar(60) NOT NULL,
  `youtube` varchar(60) NOT NULL,
  `nicovideo` varchar(60) NOT NULL,
  `website` varchar(90) NOT NULL,
  `sitetitle` varchar(32) NOT NULL,
  `fav_stage_id` int(8) NOT NULL,
  `total_limited014` int(11) NOT NULL,
  `total_arealim014` int(11) NOT NULL,
  `total_unlimit` int(11) NOT NULL,
  `total_tas` int(11) NOT NULL,
  `total_limited015` int(7) NOT NULL,
  `total_arealim015` int(7) NOT NULL,
  `total_limited016` int(7) NOT NULL,
  `total_arealim016` int(7) NOT NULL,
  `total_pik3ss` int(7) NOT NULL,
  `total_uplan003` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `battle`
--
ALTER TABLE `battle`
  ADD PRIMARY KEY (`post_id`);

--
-- テーブルのインデックス `counter`
--
ALTER TABLE `counter`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `limited_log`
--
ALTER TABLE `limited_log`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`post_id`);

--
-- テーブルのインデックス `meta`
--
ALTER TABLE `meta`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `minites`
--
ALTER TABLE `minites`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `note`
--
ALTER TABLE `note`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `object_list`
--
ALTER TABLE `object_list`
  ADD PRIMARY KEY (`object_id`);

--
-- テーブルのインデックス `ranking`
--
ALTER TABLE `ranking`
  ADD PRIMARY KEY (`post_id`);

--
-- テーブルのインデックス `ranking_b`
--
ALTER TABLE `ranking_b`
  ADD PRIMARY KEY (`post_id`);

--
-- テーブルのインデックス `stage_title`
--
ALTER TABLE `stage_title`
  ADD PRIMARY KEY (`stage_id`);

--
-- テーブルのインデックス `total`
--
ALTER TABLE `total`
  ADD PRIMARY KEY (`post_id`);

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `area`
--
ALTER TABLE `area`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `battle`
--
ALTER TABLE `battle`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `counter`
--
ALTER TABLE `counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `limited_log`
--
ALTER TABLE `limited_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `memo`
--
ALTER TABLE `memo`
  MODIFY `post_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `meta`
--
ALTER TABLE `meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `minites`
--
ALTER TABLE `minites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `note`
--
ALTER TABLE `note`
  MODIFY `id` int(6) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `object_list`
--
ALTER TABLE `object_list`
  MODIFY `object_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `ranking`
--
ALTER TABLE `ranking`
  MODIFY `post_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `total`
--
ALTER TABLE `total`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(6) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
