-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2023-05-03 21:31:11
-- サーバのバージョン： 10.4.27-MariaDB
-- PHP のバージョン: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `nippou`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `zaiseki_id` int(11) NOT NULL,
  `user_portrait` blob DEFAULT NULL,
  `user_no` int(11) NOT NULL,
  `user_screen_name` varchar(30) NOT NULL,
  `family_register_name` varchar(30) NOT NULL,
  `furigana` varchar(50) NOT NULL,
  `gender_id` int(11) NOT NULL,
  `blood_type_id` int(11) NOT NULL,
  `user_birthday` date NOT NULL,
  `user_age` varchar(30) NOT NULL,
  `honseki_id` int(11) NOT NULL,
  `emergency_relationship_id` int(11) NOT NULL,
  `emergency_contactname` varchar(200) NOT NULL,
  `emergency_contact_phonenumber` varchar(200) NOT NULL,
  `user_address` varchar(200) NOT NULL,
  `joining_company_day` date NOT NULL,
  `work_age` varchar(200) NOT NULL,
  `business_office_id` int(11) NOT NULL,
  `business_car1_id` int(11) NOT NULL,
  `business_car2_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `official_position_id` int(11) NOT NULL,
  `occupation_id` int(11) NOT NULL,
  `user_phone_number` varchar(200) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_password` varchar(30) NOT NULL,
  `usercar_id` int(11) NOT NULL,
  `kenkou_hoken_id` int(11) NOT NULL,
  `nenkin_hoken_id` int(11) NOT NULL,
  `koyou_hoken_id` int(11) NOT NULL,
  `kyosai_id` int(11) NOT NULL,
  `syaryo_hoken_id` int(11) NOT NULL,
  `seiyaku_kimitu_id` int(11) NOT NULL,
  `delivery_hour` int(11) NOT NULL,
  `auth_type` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `user`
--

INSERT INTO `user` (`id`, `zaiseki_id`, `user_portrait`, `user_no`, `user_screen_name`, `family_register_name`, `furigana`, `gender_id`, `blood_type_id`, `user_birthday`, `user_age`, `honseki_id`, `emergency_relationship_id`, `emergency_contactname`, `emergency_contact_phonenumber`, `user_address`, `joining_company_day`, `work_age`, `business_office_id`, `business_car1_id`, `business_car2_id`, `department_id`, `official_position_id`, `occupation_id`, `user_phone_number`, `user_email`, `user_password`, `usercar_id`, `kenkou_hoken_id`, `nenkin_hoken_id`, `koyou_hoken_id`, `kyosai_id`, `syaryo_hoken_id`, `seiyaku_kimitu_id`, `delivery_hour`, `auth_type`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 202112, '岡本由規', '岡本由規', 'オカモトユキ', 2, 4, '1978-10-06', '44歳', 2, 2, 'ハハ', '0123456', '千々賀626-1', '2021-05-01', '1年11ヶ月', 1, 0, 0, 5, 11, 5, '0123456', '', '00', 0, 0, 0, 0, 1, 0, 0, 99, 1, '2023-04-03 12:59:57', '2023-04-03 12:59:57'),
(2, 1, '', 200258, '吉川 英治', '', 'よしかわ えいじ', 0, 0, '0000-00-00', '66', 8, 3, '', '03-3313-7040', '東京都渋谷区千駄ヶ谷3-1-5', '0000-00-00', '', 4, 0, 0, 5, 3, 0, '070-2913-9558', 'yoshikawa_63@example.net', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 2, '', 203954, '塚本 枝里子', '', 'つかもと えりこ', 0, 0, '0000-00-00', '55', 8, 4, '', '0493-34-7362', '埼玉県川口市本蓮2-1-3', '0000-00-00', '', 5, 0, 0, 1, 2, 0, '080-2312-4215', 'erikotsukamoto@example.com', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 2, '', 200079, '佐野 かおり', '', 'さの かおり', 0, 0, '0000-00-00', '64', 10, 4, '', '0463-47-2884', '神奈川県相模原市緑区相原1-1-10ネオライフマンション502', '0000-00-00', '', 1, 0, 0, 6, 5, 0, '090-0247-6765', 'sano97@example.com', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 2, '', 202405, '具志堅 雅夫', '', 'ぐしけん まさお', 0, 0, '2028-07-09', '46', 24, 1, '', '0897-97-3545', '愛媛県松山市竹原3-3-7', '0000-00-00', '', 1, 0, 0, 4, 7, 0, '070-3156-9395', 'gushikenmasao@example.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 1, '', 200896, '西本 勝', '', 'にしもと まさる', 0, 0, '0000-00-00', '45', 43, 2, '', '0799-34-6863', '兵庫県神戸市中央区北長狭通2-3-10グルーブ201', '0000-00-00', '', 4, 0, 0, 3, 5, 0, '070-9548-2269', 'masarunishimoto@example.co.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 1, '', 202267, '木村 直実', '', 'きむら なおみ', 0, 0, '0000-00-00', '65', 7, 2, '', '0493-18-4416', '埼玉県新座市野火止1-3-1103', '0000-00-00', '', 5, 0, 0, 4, 1, 0, '070-8333-9325', 'kimura_618@example.ne.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 2, '', 203324, '小澤 義規', '', 'おざわ よしのり', 0, 0, '0000-00-00', '26', 36, 3, '', '0845-54-3746', '広島県広島市西区庚午中3-1-9', '0000-00-00', '', 9, 0, 0, 8, 1, 0, '070-0996-0758', 'ozawa_218@example.net', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 2, '', 200241, '前田 伸吾', '', 'まえだ しんご', 0, 0, '0000-00-00', '43', 22, 2, '', '0551-78-7692', '山梨県富士吉田市中曽根2-3-1104', '2020-02-01', '', 4, 0, 0, 8, 11, 0, '050-3116-6262', 'maeda_26@example.org', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 1, '', 204918, '佐藤 英一郎', '', 'さとう えいいちろう', 0, 0, '0000-00-00', '53', 42, 3, '', '092-766-7270', '福岡県宗像市田熊2-1-6', '2021-09-06', '', 8, 0, 0, 3, 12, 0, '080-3527-5014', 'sato1115@example.ne.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 1, '', 204757, '大塚 大介', '', 'おおつか だいすけ', 0, 0, '0000-00-00', '35', 35, 4, '', '06-3525-7176', '大阪府大阪市東住吉区山坂3-3-8', '0000-00-00', '', 6, 0, 0, 5, 10, 0, '050-5619-5326', 'daisukeotsuka@example.ne.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 1, '', 204018, '松倉 恵', '', 'まつくら めぐみ', 0, 0, '0000-00-00', '20', 34, 1, '', '049-777-7266', '埼玉県草加市旭町2-1-3', '2010-04-04', '', 1, 0, 0, 2, 9, 0, '090-7000-6632', 'matsukura_97@example.co.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 1, '', 202236, '大崎 圭司', '', 'おおさき けいじ', 0, 0, '0000-00-00', '31', 32, 3, '', '03-3295-3872', '東京都渋谷区神宮前2-1-13', '0000-00-00', '', 9, 0, 0, 2, 11, 0, '050-4219-3702', 'osakikeiji@example.co.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 1, '', 201675, '松岡 枝里', '', 'まつおか えり', 0, 0, '0000-00-00', '65', 19, 3, '', '03-6566-6127', '東京都港区高輪1-1-17', '0000-00-00', '', 1, 0, 0, 8, 1, 0, '070-7614-5323', 'matsuokaeri@example.co.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 2, '', 200660, '金子 志保', '', 'かねこ しほ', 0, 0, '0000-00-00', '44', 28, 2, '', '03-5812-8692', '東京都中央区八丁堀2-3-908', '0000-00-00', '', 1, 0, 0, 2, 10, 0, '070-7924-7781', 'shiho_kaneko@example.org', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 1, '', 201886, '井口 敏博', '', 'いぐち としひろ', 0, 0, '0000-00-00', '71', 34, 3, '', '0228-73-3408', '宮城県仙台市太白区長町南4-1-9', '2040-04-09', '', 10, 0, 0, 1, 8, 0, '070-5157-4163', 'iguchitoshihiro@example.org', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 1, '', 202670, '佐藤 鉄兵', '', 'さとう てっぺい', 0, 0, '0000-00-00', '25', 6, 4, '', '03-1202-6646', '東京都墨田区墨田2-2-19', '0000-00-00', '', 7, 0, 0, 2, 9, 0, '050-6932-9205', 'sato116@example.com', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 1, '', 204031, '原 京子', '', 'はら きょうこ', 0, 0, '0000-00-00', '27', 15, 3, '', '0463-87-8657', '神奈川県相模原市中央区千代田2-2-7', '0000-00-00', '', 5, 0, 0, 3, 11, 0, '090-2445-6556', 'hara_kyouko@example.net', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 1, '', 203278, '岩元 ひとみ', '', 'いわもと ひとみ', 0, 0, '0000-00-00', '39', 14, 4, '', '0949-01-8124', '福岡県福岡市博多区堅粕1-3-4', '0000-00-00', '', 6, 0, 0, 6, 8, 0, '080-3763-4305', 'iwamoto924@example.net', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 1, '', 201989, '福井 竜太郎', '', 'ふくい りゅうたろう', 0, 0, '0000-00-00', '28', 7, 2, '', '0145-35-6388', '北海道浦河郡浦河町大通3-2-18', '0000-00-00', '', 4, 0, 0, 2, 3, 0, '080-3376-2645', 'fukui27@example.co.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 2, '', 200408, '早川 敦子', '', 'はやかわ あつこ', 0, 0, '0000-00-00', '58', 17, 2, '', '03-4453-8703', '東京都豊島区長崎3-3-5', '0000-00-00', '', 2, 0, 0, 3, 5, 0, '090-7811-6984', 'hayakawaatsuko@example.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 1, '', 203344, '太田 邦彦', '', 'おおた くにひこ', 0, 0, '2018-08-02', '73', 15, 4, '', '06-8396-4153', '大阪府大阪市住之江区新北島2-2-1201', '0000-00-00', '', 5, 0, 0, 4, 3, 0, '050-9906-9741', 'kunihiko_ota@example.net', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 2, '', 200882, '木村 菜摘', '', 'きむら なつみ', 0, 0, '0000-00-00', '55', 3, 3, '', '0157-02-6980', '北海道札幌市中央区南一条西3-4-1208', '0000-00-00', '', 5, 0, 0, 5, 10, 0, '070-2415-7442', 'kimuranatsumi@example.ne.jp', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 2, '', 202432, '上村 栄太郎', '', 'うえむら えいたろう', 0, 0, '0000-00-00', '41', 7, 4, '', '03-0653-7392', '東京都世田谷区経堂3-3-506', '0000-00-00', '', 6, 0, 0, 4, 4, 0, '080-7589-6815', 'eitarou_uemura@example.org', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 2, '', 202459, '松浦 佳恵', '', 'まつうら よしえ', 0, 0, '0000-00-00', '58', 6, 1, '', '042-331-0193', '埼玉県草加市松原2-3-7', '2023-02-02', '', 1, 0, 0, 7, 14, 0, '080-4419-9374', 'yoshie_matsuura@example.net', '', 0, 0, 0, 0, 0, 0, 0, 0, 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(502, 0, NULL, 111111, 'テスト社員１', '', '', 0, 0, '2000-01-01', '', 0, 0, '', '', '', '2000-01-01', '', 0, 0, 0, 0, 0, 0, '', '', '00', 0, 0, 0, 0, 0, 0, 0, 99, NULL, '2023-04-24 13:03:32', '2023-04-24 13:03:32'),
(503, 0, NULL, 222222, 'テスト社員２', '', '', 0, 0, '2000-01-01', '', 0, 0, '', '', '', '2000-01-01', '', 0, 0, 0, 0, 0, 0, '', '', '00', 0, 0, 0, 0, 0, 0, 0, 99, NULL, '2023-04-24 16:58:00', '2023-04-24 16:58:00');

-- --------------------------------------------------------

--
-- テーブルの構造 `work`
--

CREATE TABLE `work` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `start_mater` varchar(20) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_mater` varchar(20) DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `hour_mater_start` varchar(20) DEFAULT NULL,
  `hour_mater_end` varchar(20) DEFAULT NULL,
  `break_time` time DEFAULT NULL,
  `client` text DEFAULT NULL,
  `project_name` text DEFAULT NULL,
  `comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `work`
--

INSERT INTO `work` (`id`, `user_id`, `date`, `start_mater`, `start_time`, `end_mater`, `end_time`, `hour_mater_start`, `hour_mater_end`, `break_time`, `client`, `project_name`, `comment`) VALUES
(1, 1, '2023-05-01', '123', '09:00:00', '123', '00:00:10', '123', '123', '01:00:00', '風車', '風車サイト', '荷下ろし'),
(2, 1, '2023-05-03', '123', '21:30:00', '', '21:30:00', '', NULL, NULL, '顧客名', '現場名', '');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `work`
--
ALTER TABLE `work`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=504;

--
-- テーブルの AUTO_INCREMENT `work`
--
ALTER TABLE `work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
