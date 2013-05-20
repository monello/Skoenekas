DROP TABLE IF EXISTS `#__dnagifts_user_activity`;
CREATE TABLE `#__dnagifts_user_activity` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `user_id` INT(11) NOT NULL COMMENT 'links this action to a user',
  `action_id` INT(11) NOT NULL COMMENT 'identifies the type of action',
  `action_DATETIME` DATETIME NOT NULL COMMENT 'the date and time the action was performed',
  `action_data_json` text NULL COMMENT 'any metadata related to the action in JSON object',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'A log of all the activities a user performed with DNA Gifts component';

DROP TABLE IF EXISTS `#__dnagifts_lst_action`;
CREATE TABLE `#__dnagifts_lst_action` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `label` VARCHAR(40) NOT NULL COMMENT 'displays in dropdown lists',
  `description` VARCHAR(255) NULL COMMENT 'more detailed description of the action',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'A log of all the activities a user performed with DNA Gifts component';

DROP TABLE IF EXISTS `#__dnagifts_institution`;
CREATE TABLE `#__dnagifts_institution` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `institution_type_id` INT(11) NOT NULL COMMENT 'Institution Type ID',
  `name` VARCHAR(100) NOT NULL COMMENT 'Institution Name',
  `description` VARCHAR(255) NULL COMMENT 'Institution Description',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'List of all institutions';

DROP TABLE IF EXISTS `#__dnagifts_lst_institution_type`;
CREATE TABLE `#__dnagifts_lst_institution_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `label` VARCHAR(50) NOT NULL COMMENT 'displays in dropdown lists',
  `description` VARCHAR(255) NULL COMMENT 'more detailed description of the institution type',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'List of all institution types';

DROP TABLE IF EXISTS `#__dnagifts_lnk_user_institution`;
CREATE TABLE `#__dnagifts_lnk_user_institution` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `user_id` INT(11) NOT NULL COMMENT 'Links this institution to a user',
  `institution_id` INT(11) NOT NULL COMMENT 'Links the user to an institution',
  `from_date` DATETIME NOT NULL COMMENT 'Date the user started being associated with this institution',
  `to_date`  DATETIME NULL COMMENT 'Date the user stopped being associated with this institution',
  `date_created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this record was added to this table',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Links between users and institutions';

DROP TABLE IF EXISTS `#__dnagifts_test`;
CREATE TABLE `#__dnagifts_test` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `test_name` VARCHAR(100) NOT NULL COMMENT 'The Name of the Test',
  `version` VARCHAR(10) NOT NULL DEFAULT '0.1' COMMENT 'Version number of the test. Creating a new version will duplicate the current test and all related links',
  `test_description` VARCHAR(255) NULL COMMENT 'Detailed description of the test',
  `test_reason` text NULL COMMENT 'More detailed discussion of the purpose of this test and what the user wishes to achive by it',
  `language` varchar(20) NOT NULL DEFAULT 'English' COMMENT 'The language the user does the test in',
  `ordering` int(11) NOT NULL DEFAULT 0 COMMENT 'The order that tests appear in lists by default',
  `hits` INT(11) NOT NULL DEFAULT 0 COMMENT 'The number of times the test was started',
  `complete` INT(11) NOT NULL DEFAULT 0 COMMENT 'The number of times the test was completed',
  `created_by` INT(11) NOT NULL COMMENT 'Who created the test',
  `created_by_alias` varchar(255) NULL COMMENT 'Alias for the author',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this version of the test was created',
  `published` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Current status of this test',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'List of all tests that users can take';

INSERT INTO `#__dnagifts_test` VALUES(NULL, 'Long Test', '1', 'This is the longest est.', '<p>This test will give you an in-depth analysis of your gift.</p>', 'English', 1, 0, 0, 42, '', NULL, 1);
INSERT INTO `#__dnagifts_test` VALUES(NULL, 'Lang Toets', '1', 'Hierdie is die lang toets', '<p>Hierdie toets doen ''n diep analiese op you andwoorde, om jou profiel so akuraat as moontlik te bepaal.</p>', 'Afrikaans', 2, 0, 0, 42, '', NULL, 1);
INSERT INTO `#__dnagifts_test` VALUES(NULL, 'Kort Toets', '1', 'Hierdie is die kort toets', '<p>Hierdie toets doen ''n standaard analiese op you andwoorde, om jou profiel so akuraat as moontlik te bepaal.</p>', 'Afrikaans', 3, 0, 0, 42, '', NULL, 1);
INSERT INTO `#__dnagifts_test` VALUES(NULL, 'Short Test', '1', 'This is the shortest test.', '<p>This test will give you a standard analysis of your gift.</p>', 'English', 4, 0, 0, 42, '', NULL, 1);

DROP TABLE IF EXISTS `#__dnagifts_lst_gift`;
CREATE TABLE `#__dnagifts_lst_gift` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `code` CHAR(3) NOT NULL COMMENT 'Short code used to identify categories',
  `name` VARCHAR(100) NOT NULL COMMENT 'Name',
  `description` VARCHAR(255) NULL COMMENT 'Description',
  `color_hex` CHAR(7) NULL COMMENT 'Hex/HTML code for the color',
  `color_rgb` VARCHAR(20) NULL COMMENT 'RGB settings for the color',
  `language` varchar(20) NOT NULL DEFAULT 'English' COMMENT 'The language the user does the test in',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The order that gift appear in lists by default',
  `created_by` INT(11) NOT NULL COMMENT 'Who created the gift',
  `created_by_alias` varchar(255) NULL COMMENT 'Alias for the author',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this version of the gift was created',
  `published` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Current status of this gift',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'List of all catergories that questions can belong to';

INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'P', 'Prophet', NULL, '#FF0000', '255,0,0', 'English', 1, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'S', 'Servant', NULL, '#FFC000', '255,192,0', 'English', 2, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'T', 'Teacher', NULL, '#FFFF00', '255,255,0', 'English', 3, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'E', 'Exhorter', NULL, '#00B050', '0,176,80', 'English', 4, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'G', 'Giver', NULL, '#538ED5', '83,142,213', 'English', 5, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'R', 'Ruler', NULL, '#333391', '51,51,153', 'English', 6, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'M', 'Mercy', NULL, '#990099', '153,0,153', 'English', 7, 42, NULL, NULL, 1);

INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'P', 'Profeet', NULL, '#FF0000', '255,0,0', 'Afrikaans', 1, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'S', 'Dienaar', NULL, '#FFC000', '255,192,0', 'Afrikaans', 2, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'T', 'Leraar', NULL, '#FFFF00', '255,255,0', 'Afrikaans', 3, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'E', 'Vermaner', NULL, '#00B050', '0,176,80', 'Afrikaans', 4, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'G', 'Gewer', NULL, '#538ED5', '83,142,213', 'Afrikaans', 5, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'R', 'Heerser', NULL, '#333391', '51,51,153', 'Afrikaans', 6, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_lst_gift` VALUES(NULL, 'M', 'Genade', NULL, '#990099', '153,0,153', 'Afrikaans', 7, 42, NULL, NULL, 1);

DROP TABLE IF EXISTS `#__dnagifts_question`;
CREATE TABLE `#__dnagifts_question` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `question_code` VARCHAR(10) NOT NULL COMMENT 'Short description/code to help ID the question',
  `question_text` VARCHAR(255) NOT NULL COMMENT 'Text as it will be displayed to the users',
  `question_hint` VARCHAR(255) NULL COMMENT 'Additional Tips/Hints as pop-ups etc to assist user in answering the question',
  `question_reason` VARCHAR(255) NULL COMMENT 'Here the Author can describe what he is trying to achieve with this question',
  `question_notes` VARCHAR(255) NULL COMMENT 'Any additional notes about this question',
  `gift_id` INT(11) NOT NULL COMMENT 'Which category (Gifting) is this question in',
  `language` varchar(20) NOT NULL DEFAULT 'English' COMMENT 'The language the user does the test in',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The order that question appear in lists by default',
  `created_by` INT(11) NOT NULL COMMENT 'admin_id of the author who created the question',
  `created_by_alias` varchar(255) NULL COMMENT 'Alias for the author',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this question was created',
  `published` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Current status of this question',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'List of all questions that can be used in tests';

DROP TABLE IF EXISTS `#__dnagifts_option_button`;
CREATE TABLE `#__dnagifts_option_button` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `button_name` varchar(20) NOT NULL COMMENT 'Name used in the back-end to link buttons to tests',
  `button_text` varchar(20) NOT NULL COMMENT 'The button text used to display to the user',
  `description` VARCHAR(255) NULL COMMENT 'Description',
  `button_hint` VARCHAR(255) NOT NULL COMMENT 'Additional Tips/Hints as pop-ups etc to assist user in answering the question',
  `score` int(11) NOT NULL DEFAULT '0'  COMMENT 'The score linked to this button',
  `css_class` varchar(20) NULL COMMENT 'The styling used for this button',
  `language` varchar(20) NOT NULL DEFAULT 'English' COMMENT 'The language the user does the test in',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The default order that option buttons appear in lists',
  `created_by` INT(11) NOT NULL COMMENT 'admin_id of the author who created the option button',
  `created_by_alias` varchar(255) NULL COMMENT 'Alias for the author',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this option button was created',
  `published` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Current status of this option button',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'List of available option buttons for test questions';
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'never', 'Never', 'The user clicks this button if they strongly dissagree with the statement, awards the lowests marks', 'Click this button if you feel the statement Never applies to you', 0, 'btnNever', 'English', 1, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'seldom', 'Seldom', 'The user clicks this button if they mostly dissagree with the statement, awards the 2nd lowests marks', 'Click this button if you feel the statement Seldom applies to you', 1, 'btnSeldom', 'English', 2, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'sometimes', 'Sometimes', 'The user clicks this button if they are unsure whether the statement applies to them or not, but leans towards No, awards the medium marks', 'Click this button if you feel the statement only Sometimes applies to you', 2, 'btnSometimes', 'English', 3, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'usually', 'Usually', 'The user clicks this button if they are unsure whether the statement applies to them or not, but leans to wards Yes, awards the medium marks', 'Click this button if you feel the statement Usually applies to you', 3, 'btnUsually', 'English', 4, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'mostly', 'Mostly', 'The user clicks this button if they are pretty sure the statement applies to them, but not always, awards the 2nd highest marks', 'Click this button if you feel the statement applies to you Most of the time', 4, 'btnMostly', 'English', 5, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'always', 'Always', 'The user clicks this button if they are are totally convinced the statement applies to them, awards the highest marks', 'Click this button if you feel the statement Always applies to you', 5, 'btnAlways', 'English', 6, 42, NULL, NULL, 1);

INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'nooit', 'Nooit', 'Die gebruiker kies die andwoord as hy glad nie met die stelling ooreenstem nie, die laagste punte word vir die andwoord toekegen', 'Kies die andwoord as jy voel dat die stelling Nooit van toepassing is op jou nie', 0, 'btnNever', 'Afrikaans', 1, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'selde', 'Selde', 'Die gebruiker kies die andwoord as hy in n groot mate me met die stelling saam stem nie', 'Kies die opsie as jy voel dat die stelling selde op jou van toepassing is', 1, 'btnSeldom', 'Afrikaans', 2, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'soms', 'Soms', 'Die gebruiker kies die andwoord as hy onseker is of die stelling op hom van toepassing is, maar as hy meer onseker as seker is, n medium getal punt word vir die andwoord toegeken', 'Kies die andwoord as jy onseker is of die stelling op jou van toepassing is, maar as jy meer onseker as seker is', 2, 'btnSometimes', 'Afrikaans', 3, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'gewoonlik', 'Gewoonlik', 'Die gebruiker kies die andwoord as hy onseker is of die stelling op hom van toepassing is, maar as hy meer seker as onseker is, n medium getal punt word vir die andwoord toegeken', 'Kies die andwoord as jy onseker is of die stelling op jou van toepassing is, maar as jy meer seker as onseker is', 3, 'btnUsually', 'Afrikaans', 4, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'meestal', 'Meestal', 'Die gebruiker kies die andwoord as hy redelik seker is dat dit op hom van toepassing is, die tweede hoogste punte word vir die andwoord toegeken', 'Kies die andwoord as jy redelik seker is dat die stelling op jou van toepassing is', 4, 'btnMostly', 'Afrikaans', 5, 42, NULL, NULL, 1);
INSERT INTO `#__dnagifts_option_button` VALUES(NULL, 'altyd', 'Altyd', 'Die gebruiker kies die andwoord as hy volkome oortuig is dat die stelling op hom van toepassing is, die hoogste punt word vir die andwoord toegeken', 'Kies die andwoord as jy volkome oortuig is dat die stelling op jou van toepassing is', 5, 'btnAlways', 'Afrikaans', 6, 42, NULL, NULL, 1);

DROP TABLE IF EXISTS `#__dnagifts_lnk_test_buttonset`;
CREATE TABLE `#__dnagifts_lnk_test_buttonset` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `test_id` INT(11) NOT NULL COMMENT 'Links this test to a button set',
  `button_id` INT(11) NOT NULL COMMENT 'Links this button set to a test',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The order that the option button appears in questions',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Link table between tests and a button set';

DROP TABLE IF EXISTS `#__dnagifts_lnk_test_question`;
CREATE TABLE `#__dnagifts_lnk_test_question` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `test_id` INT(11) NOT NULL COMMENT 'Links this question to a Test',
  `question_id` INT(11) NOT NULL COMMENT 'Links this test to a question',
  `show_duration` INT(11) NOT NULL COMMENT 'The number of seconds the user gets to read and answer the question',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'The order that question appear in tests',
  `created_by` INT(11) NOT NULL COMMENT 'admin_id of the author who created the test-question link',
  `created_by_alias` varchar(255) NULL COMMENT 'Alias for the author',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this link was created',
  `published` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'Current status of this link',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Link table between tests and its quesrtions';

DROP TABLE IF EXISTS `#__dnagifts_lst_user_type`;
CREATE TABLE `#__dnagifts_lst_user_type` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `label` VARCHAR(30) NOT NULL COMMENT 'Label',
  `description` VARCHAR(255) NULL COMMENT 'description',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'List of all user types';

DROP TABLE IF EXISTS `#__dnagifts_lnk_user_tests`;
CREATE TABLE `#__dnagifts_lnk_user_tests` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `user_id` INT(11) NOT NULL COMMENT 'Links this test to a user',
  `test_id` INT(11) NOT NULL COMMENT 'Links the user to a test',
  `started_datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Indicates the exact date and time the test was started',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Links the user to the tests, he has attempted';

DROP TABLE IF EXISTS `#__dnagifts_lnk_user_test_answers`;
CREATE TABLE `#__dnagifts_lnk_user_test_answers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `lnk_user_test_id` INT(11) NOT NULL COMMENT 'links this user to the exact session of the test he did. Users can do tests more than once.',
  `question_id` INT(11) NOT NULL COMMENT 'Links this answer-score to the question related to this test',
  `answer_score` INT(11) NOT NULL COMMENT  'The answer provided by the user (Score)',
  `answer_datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'The exact date and time the answer was given',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Lists all the answers (scores) a user has ever given to test-questions';

DROP TABLE IF EXISTS `#__dnagifts_lnk_user_gifts`;
CREATE TABLE `#__dnagifts_lnk_user_gifts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `lnk_user_test_id` INT(11) NOT NULL COMMENT 'Links this score to a test session',
  `gift_id` INT(11) NOT NULL COMMENT 'Links this score to a question-category (Gifting)',
  `score` INT(11) NOT NULL COMMENT 'Total score for this session, by this user for this question-category',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'Shows the history of the users gifting rankings over all tests completed';

DROP TABLE IF EXISTS `#__dnagifts_pretest_info`;
CREATE TABLE `#__dnagifts_pretest_info` (
  `id` INT( 11 ) NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each record in this table',
  `user_id` INT( 11 ) NOT NULL COMMENT 'Links this info to a user',
  `is_christian` BOOLEAN NOT NULL COMMENT 'Indicates if this person is a Christian',
  `in_church` BOOLEAN NOT NULL COMMENT 'Indicates if this person is in a Church',
  `church_name` VARCHAR( 50 ) NULL COMMENT 'The church this person attends, if he/she is a Christian',
  `your_city` VARCHAR( 50 ) NULL COMMENT 'The city this person lives in',
  `your_country` INT( 11 ) NULL COMMENT 'The country this person lives in',
  `pastor_reverend` VARCHAR( 50 ) NULL COMMENT 'Name of Pastor/Reverend',
  `believe_divine` BOOLEAN NULL COMMENT 'Indicates if this person believes in a devine purpose',
  `created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date this info was submitted',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT 'This table lists the additional questions that is asked of the users';

DROP TABLE IF EXISTS `#__dnagifts_lst_countries`;
CREATE TABLE IF NOT EXISTS `#__dnagifts_lst_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique row identifier',
  `ordering` int(11) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  `common_name` varchar(40) NOT NULL COMMENT 'Common Name',
  `formal_name` varchar(50) DEFAULT NULL COMMENT 'Formal Name',
  `type` varchar(30) NOT NULL COMMENT 'Type',
  `sub_type` varchar(40) DEFAULT NULL COMMENT 'Sub Type',
  `sovereignty` varchar(20) DEFAULT NULL COMMENT 'Sovereignty',
  `capital` varchar(70) DEFAULT NULL COMMENT 'Capital City',
  `iso_4217_currency_code` varchar(15) DEFAULT NULL COMMENT 'ISO 4217 Currency Code',
  `iso_4217_currency_name` varchar(15) DEFAULT NULL COMMENT 'ISO 4217 Currency Name',
  `itu-t_telephone_code` varchar(10) DEFAULT NULL COMMENT 'ITU-T Telephone Code',
  `iso_3166-1_2_letter_code` varchar(2) DEFAULT NULL COMMENT 'ISO 3166-1 2 Letter Code',
  `iso_3166-1_3_letter_code` varchar(3) DEFAULT NULL COMMENT 'ISO 3166-1 3 Letter Code',
  `iso_3166-1_number` varchar(3) DEFAULT NULL COMMENT 'ISO 3166-1 Number',
  `iana_country_code_tld` varchar(10) DEFAULT NULL COMMENT 'IANA Country Code TLD',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=269 COMMENT 'This table lists all the countries used in the database';

INSERT INTO `#__dnagifts_lst_countries` VALUES(1, 1, 'Afghanistan', 'Islamic State of Afghanistan', 'Independent State', '', '', 'Kabul', 'AFN', 'Afghani', '+93', 'AF', 'AFG', '004', '.af');
INSERT INTO `#__dnagifts_lst_countries` VALUES(2, 2, 'Albania', 'Republic of Albania', 'Independent State', '', '', 'Tirana', 'ALL', 'Lek', '+355', 'AL', 'ALB', '008', '.al');
INSERT INTO `#__dnagifts_lst_countries` VALUES(3, 3, 'Algeria', 'People''s Democratic Republic of Algeria', 'Independent State', '', '', 'Algiers', 'DZD', 'Dinar', '+213', 'DZ', 'DZA', '012', '.dz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(4, 4, 'Andorra', 'Principality of Andorra', 'Independent State', '', '', 'Andorra la Vella', 'EUR', 'Euro', '+376', 'AD', 'AND', '020', '.ad');
INSERT INTO `#__dnagifts_lst_countries` VALUES(5, 5, 'Angola', 'Republic of Angola', 'Independent State', '', '', 'Luanda', 'AOA', 'Kwanza', '+244', 'AO', 'AGO', '024', '.ao');
INSERT INTO `#__dnagifts_lst_countries` VALUES(6, 6, 'Antigua and Barbuda', '', 'Independent State', '', '', 'Saint John''s', 'XCD', 'Dollar', '+1-268', 'AG', 'ATG', '028', '.ag');
INSERT INTO `#__dnagifts_lst_countries` VALUES(7, 7, 'Argentina', 'Argentine Republic', 'Independent State', '', '', 'Buenos Aires', 'ARS', 'Peso', '+54', 'AR', 'ARG', '032', '.ar');
INSERT INTO `#__dnagifts_lst_countries` VALUES(8, 8, 'Armenia', 'Republic of Armenia', 'Independent State', '', '', 'Yerevan', 'AMD', 'Dram', '+374', 'AM', 'ARM', '051', '.am');
INSERT INTO `#__dnagifts_lst_countries` VALUES(9, 9, 'Australia', 'Commonwealth of Australia', 'Independent State', '', '', 'Canberra', 'AUD', 'Dollar', '+61', 'AU', 'AUS', '036', '.au');
INSERT INTO `#__dnagifts_lst_countries` VALUES(10, 10, 'Austria', 'Republic of Austria', 'Independent State', '', '', 'Vienna', 'EUR', 'Euro', '+43', 'AT', 'AUT', '040', '.at');
INSERT INTO `#__dnagifts_lst_countries` VALUES(11, 11, 'Azerbaijan', 'Republic of Azerbaijan', 'Independent State', '', '', 'Baku', 'AZN', 'Manat', '+994', 'AZ', 'AZE', '031', '.az');
INSERT INTO `#__dnagifts_lst_countries` VALUES(12, 12, 'Bahamas, The', 'Commonwealth of The Bahamas', 'Independent State', '', '', 'Nassau', 'BSD', 'Dollar', '+1-242', 'BS', 'BHS', '044', '.bs');
INSERT INTO `#__dnagifts_lst_countries` VALUES(13, 13, 'Bahrain', 'Kingdom of Bahrain', 'Independent State', '', '', 'Manama', 'BHD', 'Dinar', '+973', 'BH', 'BHR', '048', '.bh');
INSERT INTO `#__dnagifts_lst_countries` VALUES(14, 14, 'Bangladesh', 'People''s Republic of Bangladesh', 'Independent State', '', '', 'Dhaka', 'BDT', 'Taka', '+880', 'BD', 'BGD', '050', '.bd');
INSERT INTO `#__dnagifts_lst_countries` VALUES(15, 15, 'Barbados', '', 'Independent State', '', '', 'Bridgetown', 'BBD', 'Dollar', '+1-246', 'BB', 'BRB', '052', '.bb');
INSERT INTO `#__dnagifts_lst_countries` VALUES(16, 16, 'Belarus', 'Republic of Belarus', 'Independent State', '', '', 'Minsk', 'BYR', 'Ruble', '+375', 'BY', 'BLR', '112', '.by');
INSERT INTO `#__dnagifts_lst_countries` VALUES(17, 17, 'Belgium', 'Kingdom of Belgium', 'Independent State', '', '', 'Brussels', 'EUR', 'Euro', '+32', 'BE', 'BEL', '056', '.be');
INSERT INTO `#__dnagifts_lst_countries` VALUES(18, 18, 'Belize', '', 'Independent State', '', '', 'Belmopan', 'BZD', 'Dollar', '+501', 'BZ', 'BLZ', '084', '.bz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(19, 19, 'Benin', 'Republic of Benin', 'Independent State', '', '', 'Porto-Novo', 'XOF', 'Franc', '+229', 'BJ', 'BEN', '204', '.bj');
INSERT INTO `#__dnagifts_lst_countries` VALUES(20, 20, 'Bhutan', 'Kingdom of Bhutan', 'Independent State', '', '', 'Thimphu', 'BTN', 'Ngultrum', '+975', 'BT', 'BTN', '064', '.bt');
INSERT INTO `#__dnagifts_lst_countries` VALUES(21, 21, 'Bolivia', 'Republic of Bolivia', 'Independent State', '', '', 'La Paz (administrative/legislative) and Sucre (judical)', 'BOB', 'Boliviano', '+591', 'BO', 'BOL', '068', '.bo');
INSERT INTO `#__dnagifts_lst_countries` VALUES(22, 22, 'Bosnia and Herzegovina', '', 'Independent State', '', '', 'Sarajevo', 'BAM', 'Marka', '+387', 'BA', 'BIH', '070', '.ba');
INSERT INTO `#__dnagifts_lst_countries` VALUES(23, 23, 'Botswana', 'Republic of Botswana', 'Independent State', '', '', 'Gaborone', 'BWP', 'Pula', '+267', 'BW', 'BWA', '072', '.bw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(24, 24, 'Brazil', 'Federative Republic of Brazil', 'Independent State', '', '', 'Brasilia', 'BRL', 'Real', '+55', 'BR', 'BRA', '076', '.br');
INSERT INTO `#__dnagifts_lst_countries` VALUES(25, 25, 'Brunei', 'Negara Brunei Darussalam', 'Independent State', '', '', 'Bandar Seri Begawan', 'BND', 'Dollar', '+673', 'BN', 'BRN', '096', '.bn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(26, 26, 'Bulgaria', 'Republic of Bulgaria', 'Independent State', '', '', 'Sofia', 'BGN', 'Lev', '+359', 'BG', 'BGR', '100', '.bg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(27, 27, 'Burkina Faso', '', 'Independent State', '', '', 'Ouagadougou', 'XOF', 'Franc', '+226', 'BF', 'BFA', '854', '.bf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(28, 28, 'Burundi', 'Republic of Burundi', 'Independent State', '', '', 'Bujumbura', 'BIF', 'Franc', '+257', 'BI', 'BDI', '108', '.bi');
INSERT INTO `#__dnagifts_lst_countries` VALUES(29, 29, 'Cambodia', 'Kingdom of Cambodia', 'Independent State', '', '', 'Phnom Penh', 'KHR', 'Riels', '+855', 'KH', 'KHM', '116', '.kh');
INSERT INTO `#__dnagifts_lst_countries` VALUES(30, 30, 'Cameroon', 'Republic of Cameroon', 'Independent State', '', '', 'Yaounde', 'XAF', 'Franc', '+237', 'CM', 'CMR', '120', '.cm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(31, 31, 'Canada', '', 'Independent State', '', '', 'Ottawa', 'CAD', 'Dollar', '+1', 'CA', 'CAN', '124', '.ca');
INSERT INTO `#__dnagifts_lst_countries` VALUES(32, 32, 'Cape Verde', 'Republic of Cape Verde', 'Independent State', '', '', 'Praia', 'CVE', 'Escudo', '+238', 'CV', 'CPV', '132', '.cv');
INSERT INTO `#__dnagifts_lst_countries` VALUES(33, 33, 'Central African Republic', '', 'Independent State', '', '', 'Bangui', 'XAF', 'Franc', '+236', 'CF', 'CAF', '140', '.cf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(34, 34, 'Chad', 'Republic of Chad', 'Independent State', '', '', 'N''Djamena', 'XAF', 'Franc', '+235', 'TD', 'TCD', '148', '.td');
INSERT INTO `#__dnagifts_lst_countries` VALUES(35, 35, 'Chile', 'Republic of Chile', 'Independent State', '', '', 'Santiago (administrative/judical) and Valparaiso (legislative)', 'CLP', 'Peso', '+56', 'CL', 'CHL', '152', '.cl');
INSERT INTO `#__dnagifts_lst_countries` VALUES(36, 36, 'China, People''s Republic of', 'People''s Republic of China', 'Independent State', '', '', 'Beijing', 'CNY', 'Yuan Renminbi', '+86', 'CN', 'CHN', '156', '.cn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(37, 37, 'Colombia', 'Republic of Colombia', 'Independent State', '', '', 'Bogota', 'COP', 'Peso', '+57', 'CO', 'COL', '170', '.co');
INSERT INTO `#__dnagifts_lst_countries` VALUES(38, 38, 'Comoros', 'Union of Comoros', 'Independent State', '', '', 'Moroni', 'KMF', 'Franc', '+269', 'KM', 'COM', '174', '.km');
INSERT INTO `#__dnagifts_lst_countries` VALUES(39, 39, 'Congo, (Congo ', 'Democratic Republic of the Congo', 'Independent State', '', '', 'Kinshasa', 'CDF', 'Franc', '+243', 'CD', 'COD', '180', '.cd');
INSERT INTO `#__dnagifts_lst_countries` VALUES(40, 40, 'Congo, (Congo ', 'Republic of the Congo', 'Independent State', '', '', 'Brazzaville', 'XAF', 'Franc', '+242', 'CG', 'COG', '178', '.cg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(41, 41, 'Costa Rica', 'Republic of Costa Rica', 'Independent State', '', '', 'San Jose', 'CRC', 'Colon', '+506', 'CR', 'CRI', '188', '.cr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(42, 42, 'Cote d''Ivoire (Ivory Coast)', 'Republic of Cote d''Ivoire', 'Independent State', '', '', 'Yamoussoukro', 'XOF', 'Franc', '+225', 'CI', 'CIV', '384', '.ci');
INSERT INTO `#__dnagifts_lst_countries` VALUES(43, 43, 'Croatia', 'Republic of Croatia', 'Independent State', '', '', 'Zagreb', 'HRK', 'Kuna', '+385', 'HR', 'HRV', '191', '.hr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(44, 44, 'Cuba', 'Republic of Cuba', 'Independent State', '', '', 'Havana', 'CUP', 'Peso', '+53', 'CU', 'CUB', '192', '.cu');
INSERT INTO `#__dnagifts_lst_countries` VALUES(45, 45, 'Cyprus', 'Republic of Cyprus', 'Independent State', '', '', 'Nicosia', 'CYP', 'Pound', '+357', 'CY', 'CYP', '196', '.cy');
INSERT INTO `#__dnagifts_lst_countries` VALUES(46, 46, 'Czech Republic', '', 'Independent State', '', '', 'Prague', 'CZK', 'Koruna', '+420', 'CZ', 'CZE', '203', '.cz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(47, 47, 'Denmark', 'Kingdom of Denmark', 'Independent State', '', '', 'Copenhagen', 'DKK', 'Krone', '+45', 'DK', 'DNK', '208', '.dk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(48, 48, 'Djibouti', 'Republic of Djibouti', 'Independent State', '', '', 'Djibouti', 'DJF', 'Franc', '+253', 'DJ', 'DJI', '262', '.dj');
INSERT INTO `#__dnagifts_lst_countries` VALUES(49, 49, 'Dominica', 'Commonwealth of Dominica', 'Independent State', '', '', 'Roseau', 'XCD', 'Dollar', '+1-767', 'DM', 'DMA', '212', '.dm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(50, 50, 'Dominican Republic', '', 'Independent State', '', '', 'Santo Domingo', 'DOP', 'Peso', '+1-809 and', 'DO', 'DOM', '214', '.do');
INSERT INTO `#__dnagifts_lst_countries` VALUES(51, 51, 'Ecuador', 'Republic of Ecuador', 'Independent State', '', '', 'Quito', 'USD', 'Dollar', '+593', 'EC', 'ECU', '218', '.ec');
INSERT INTO `#__dnagifts_lst_countries` VALUES(52, 52, 'Egypt', 'Arab Republic of Egypt', 'Independent State', '', '', 'Cairo', 'EGP', 'Pound', '+20', 'EG', 'EGY', '818', '.eg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(53, 53, 'El Salvador', 'Republic of El Salvador', 'Independent State', '', '', 'San Salvador', 'USD', 'Dollar', '+503', 'SV', 'SLV', '222', '.sv');
INSERT INTO `#__dnagifts_lst_countries` VALUES(54, 54, 'Equatorial Guinea', 'Republic of Equatorial Guinea', 'Independent State', '', '', 'Malabo', 'XAF', 'Franc', '+240', 'GQ', 'GNQ', '226', '.gq');
INSERT INTO `#__dnagifts_lst_countries` VALUES(55, 55, 'Eritrea', 'State of Eritrea', 'Independent State', '', '', 'Asmara', 'ERN', 'Nakfa', '+291', 'ER', 'ERI', '232', '.er');
INSERT INTO `#__dnagifts_lst_countries` VALUES(56, 56, 'Estonia', 'Republic of Estonia', 'Independent State', '', '', 'Tallinn', 'EEK', 'Kroon', '+372', 'EE', 'EST', '233', '.ee');
INSERT INTO `#__dnagifts_lst_countries` VALUES(57, 57, 'Ethiopia', 'Federal Democratic Republic of Ethiopia', 'Independent State', '', '', 'Addis Ababa', 'ETB', 'Birr', '+251', 'ET', 'ETH', '231', '.et');
INSERT INTO `#__dnagifts_lst_countries` VALUES(58, 58, 'Fiji', 'Republic of the Fiji Islands', 'Independent State', '', '', 'Suva', 'FJD', 'Dollar', '+679', 'FJ', 'FJI', '242', '.fj');
INSERT INTO `#__dnagifts_lst_countries` VALUES(59, 59, 'Finland', 'Republic of Finland', 'Independent State', '', '', 'Helsinki', 'EUR', 'Euro', '+358', 'FI', 'FIN', '246', '.fi');
INSERT INTO `#__dnagifts_lst_countries` VALUES(60, 60, 'France', 'French Republic', 'Independent State', '', '', 'Paris', 'EUR', 'Euro', '+33', 'FR', 'FRA', '250', '.fr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(61, 61, 'Gabon', 'Gabonese Republic', 'Independent State', '', '', 'Libreville', 'XAF', 'Franc', '+241', 'GA', 'GAB', '266', '.ga');
INSERT INTO `#__dnagifts_lst_countries` VALUES(62, 62, 'Gambia, The', 'Republic of The Gambia', 'Independent State', '', '', 'Banjul', 'GMD', 'Dalasi', '+220', 'GM', 'GMB', '270', '.gm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(63, 63, 'Georgia', 'Republic of Georgia', 'Independent State', '', '', 'Tbilisi', 'GEL', 'Lari', '+995', 'GE', 'GEO', '268', '.ge');
INSERT INTO `#__dnagifts_lst_countries` VALUES(64, 64, 'Germany', 'Federal Republic of Germany', 'Independent State', '', '', 'Berlin', 'EUR', 'Euro', '+49', 'DE', 'DEU', '276', '.de');
INSERT INTO `#__dnagifts_lst_countries` VALUES(65, 65, 'Ghana', 'Republic of Ghana', 'Independent State', '', '', 'Accra', 'GHC', 'Cedi', '+233', 'GH', 'GHA', '288', '.gh');
INSERT INTO `#__dnagifts_lst_countries` VALUES(66, 66, 'Greece', 'Hellenic Republic', 'Independent State', '', '', 'Athens', 'EUR', 'Euro', '+30', 'GR', 'GRC', '300', '.gr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(67, 67, 'Grenada', '', 'Independent State', '', '', 'Saint George''s', 'XCD', 'Dollar', '+1-473', 'GD', 'GRD', '308', '.gd');
INSERT INTO `#__dnagifts_lst_countries` VALUES(68, 68, 'Guatemala', 'Republic of Guatemala', 'Independent State', '', '', 'Guatemala', 'GTQ', 'Quetzal', '+502', 'GT', 'GTM', '320', '.gt');
INSERT INTO `#__dnagifts_lst_countries` VALUES(69, 69, 'Guinea', 'Republic of Guinea', 'Independent State', '', '', 'Conakry', 'GNF', 'Franc', '+224', 'GN', 'GIN', '324', '.gn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(70, 70, 'Guinea-Bissau', 'Republic of Guinea-Bissau', 'Independent State', '', '', 'Bissau', 'XOF', 'Franc', '+245', 'GW', 'GNB', '624', '.gw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(71, 71, 'Guyana', 'Co-operative Republic of Guyana', 'Independent State', '', '', 'Georgetown', 'GYD', 'Dollar', '+592', 'GY', 'GUY', '328', '.gy');
INSERT INTO `#__dnagifts_lst_countries` VALUES(72, 72, 'Haiti', 'Republic of Haiti', 'Independent State', '', '', 'Port-au-Prince', 'HTG', 'Gourde', '+509', 'HT', 'HTI', '332', '.ht');
INSERT INTO `#__dnagifts_lst_countries` VALUES(73, 73, 'Honduras', 'Republic of Honduras', 'Independent State', '', '', 'Tegucigalpa', 'HNL', 'Lempira', '+504', 'HN', 'HND', '340', '.hn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(74, 74, 'Hungary', 'Republic of Hungary', 'Independent State', '', '', 'Budapest', 'HUF', 'Forint', '+36', 'HU', 'HUN', '348', '.hu');
INSERT INTO `#__dnagifts_lst_countries` VALUES(75, 75, 'Iceland', 'Republic of Iceland', 'Independent State', '', '', 'Reykjavik', 'ISK', 'Krona', '+354', 'IS', 'ISL', '352', '.is');
INSERT INTO `#__dnagifts_lst_countries` VALUES(76, 76, 'India', 'Republic of India', 'Independent State', '', '', 'New Delhi', 'INR', 'Rupee', '+91', 'IN', 'IND', '356', '.in');
INSERT INTO `#__dnagifts_lst_countries` VALUES(77, 77, 'Indonesia', 'Republic of Indonesia', 'Independent State', '', '', 'Jakarta', 'IDR', 'Rupiah', '+62', 'ID', 'IDN', '360', '.id');
INSERT INTO `#__dnagifts_lst_countries` VALUES(78, 78, 'Iran', 'Islamic Republic of Iran', 'Independent State', '', '', 'Tehran', 'IRR', 'Rial', '+98', 'IR', 'IRN', '364', '.ir');
INSERT INTO `#__dnagifts_lst_countries` VALUES(79, 79, 'Iraq', 'Republic of Iraq', 'Independent State', '', '', 'Baghdad', 'IQD', 'Dinar', '+964', 'IQ', 'IRQ', '368', '.iq');
INSERT INTO `#__dnagifts_lst_countries` VALUES(80, 80, 'Ireland', '', 'Independent State', '', '', 'Dublin', 'EUR', 'Euro', '+353', 'IE', 'IRL', '372', '.ie');
INSERT INTO `#__dnagifts_lst_countries` VALUES(81, 81, 'Israel', 'State of Israel', 'Independent State', '', '', 'Jerusalem', 'ILS', 'Shekel', '+972', 'IL', 'ISR', '376', '.il');
INSERT INTO `#__dnagifts_lst_countries` VALUES(82, 82, 'Italy', 'Italian Republic', 'Independent State', '', '', 'Rome', 'EUR', 'Euro', '+39', 'IT', 'ITA', '380', '.it');
INSERT INTO `#__dnagifts_lst_countries` VALUES(83, 83, 'Jamaica', '', 'Independent State', '', '', 'Kingston', 'JMD', 'Dollar', '+1-876', 'JM', 'JAM', '388', '.jm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(84, 84, 'Japan', '', 'Independent State', '', '', 'Tokyo', 'JPY', 'Yen', '+81', 'JP', 'JPN', '392', '.jp');
INSERT INTO `#__dnagifts_lst_countries` VALUES(85, 85, 'Jordan', 'Hashemite Kingdom of Jordan', 'Independent State', '', '', 'Amman', 'JOD', 'Dinar', '+962', 'JO', 'JOR', '400', '.jo');
INSERT INTO `#__dnagifts_lst_countries` VALUES(86, 86, 'Kazakhstan', 'Republic of Kazakhstan', 'Independent State', '', '', 'Astana', 'KZT', 'Tenge', '+7', 'KZ', 'KAZ', '398', '.kz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(87, 87, 'Kenya', 'Republic of Kenya', 'Independent State', '', '', 'Nairobi', 'KES', 'Shilling', '+254', 'KE', 'KEN', '404', '.ke');
INSERT INTO `#__dnagifts_lst_countries` VALUES(88, 88, 'Kiribati', 'Republic of Kiribati', 'Independent State', '', '', 'Tarawa', 'AUD', 'Dollar', '+686', 'KI', 'KIR', '296', '.ki');
INSERT INTO `#__dnagifts_lst_countries` VALUES(89, 89, 'Korea, North', 'Democratic People''s Republic of Korea', 'Independent State', '', '', 'Pyongyang', 'KPW', 'Won', '+850', 'KP', 'PRK', '408', '.kp');
INSERT INTO `#__dnagifts_lst_countries` VALUES(90, 90, 'Korea, South', 'Republic of Korea', 'Independent State', '', '', 'Seoul', 'KRW', 'Won', '+82', 'KR', 'KOR', '410', '.kr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(91, 91, 'Kuwait', 'State of Kuwait', 'Independent State', '', '', 'Kuwait', 'KWD', 'Dinar', '+965', 'KW', 'KWT', '414', '.kw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(92, 92, 'Kyrgyzstan', 'Kyrgyz Republic', 'Independent State', '', '', 'Bishkek', 'KGS', 'Som', '+996', 'KG', 'KGZ', '417', '.kg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(93, 93, 'Laos', 'Lao People''s Democratic Republic', 'Independent State', '', '', 'Vientiane', 'LAK', 'Kip', '+856', 'LA', 'LAO', '418', '.la');
INSERT INTO `#__dnagifts_lst_countries` VALUES(94, 94, 'Latvia', 'Republic of Latvia', 'Independent State', '', '', 'Riga', 'LVL', 'Lat', '+371', 'LV', 'LVA', '428', '.lv');
INSERT INTO `#__dnagifts_lst_countries` VALUES(95, 95, 'Lebanon', 'Lebanese Republic', 'Independent State', '', '', 'Beirut', 'LBP', 'Pound', '+961', 'LB', 'LBN', '422', '.lb');
INSERT INTO `#__dnagifts_lst_countries` VALUES(96, 96, 'Lesotho', 'Kingdom of Lesotho', 'Independent State', '', '', 'Maseru', 'LSL', 'Loti', '+266', 'LS', 'LSO', '426', '.ls');
INSERT INTO `#__dnagifts_lst_countries` VALUES(97, 97, 'Liberia', 'Republic of Liberia', 'Independent State', '', '', 'Monrovia', 'LRD', 'Dollar', '+231', 'LR', 'LBR', '430', '.lr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(98, 98, 'Libya', 'Great Socialist People''s Libyan Arab Jamahiriya', 'Independent State', '', '', 'Tripoli', 'LYD', 'Dinar', '+218', 'LY', 'LBY', '434', '.ly');
INSERT INTO `#__dnagifts_lst_countries` VALUES(99, 99, 'Liechtenstein', 'Principality of Liechtenstein', 'Independent State', '', '', 'Vaduz', 'CHF', 'Franc', '+423', 'LI', 'LIE', '438', '.li');
INSERT INTO `#__dnagifts_lst_countries` VALUES(100, 100, 'Lithuania', 'Republic of Lithuania', 'Independent State', '', '', 'Vilnius', 'LTL', 'Litas', '+370', 'LT', 'LTU', '440', '.lt');
INSERT INTO `#__dnagifts_lst_countries` VALUES(101, 101, 'Luxembourg', 'Grand Duchy of Luxembourg', 'Independent State', '', '', 'Luxembourg', 'EUR', 'Euro', '+352', 'LU', 'LUX', '442', '.lu');
INSERT INTO `#__dnagifts_lst_countries` VALUES(102, 102, 'Macedonia', 'Republic of Macedonia', 'Independent State', '', '', 'Skopje', 'MKD', 'Denar', '+389', 'MK', 'MKD', '807', '.mk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(103, 103, 'Madagascar', 'Republic of Madagascar', 'Independent State', '', '', 'Antananarivo', 'MGA', 'Ariary', '+261', 'MG', 'MDG', '450', '.mg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(104, 104, 'Malawi', 'Republic of Malawi', 'Independent State', '', '', 'Lilongwe', 'MWK', 'Kwacha', '+265', 'MW', 'MWI', '454', '.mw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(105, 105, 'Malaysia', '', 'Independent State', '', '', 'Kuala Lumpur (legislative/judical) and Putrajaya (administrative)', 'MYR', 'Ringgit', '+60', 'MY', 'MYS', '458', '.my');
INSERT INTO `#__dnagifts_lst_countries` VALUES(106, 106, 'Maldives', 'Republic of Maldives', 'Independent State', '', '', 'Male', 'MVR', 'Rufiyaa', '+960', 'MV', 'MDV', '462', '.mv');
INSERT INTO `#__dnagifts_lst_countries` VALUES(107, 107, 'Mali', 'Republic of Mali', 'Independent State', '', '', 'Bamako', 'XOF', 'Franc', '+223', 'ML', 'MLI', '466', '.ml');
INSERT INTO `#__dnagifts_lst_countries` VALUES(108, 108, 'Malta', 'Republic of Malta', 'Independent State', '', '', 'Valletta', 'MTL', 'Lira', '+356', 'MT', 'MLT', '470', '.mt');
INSERT INTO `#__dnagifts_lst_countries` VALUES(109, 109, 'Marshall Islands', 'Republic of the Marshall Islands', 'Independent State', '', '', 'Majuro', 'USD', 'Dollar', '+692', 'MH', 'MHL', '584', '.mh');
INSERT INTO `#__dnagifts_lst_countries` VALUES(110, 110, 'Mauritania', 'Islamic Republic of Mauritania', 'Independent State', '', '', 'Nouakchott', 'MRO', 'Ouguiya', '+222', 'MR', 'MRT', '478', '.mr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(111, 111, 'Mauritius', 'Republic of Mauritius', 'Independent State', '', '', 'Port Louis', 'MUR', 'Rupee', '+230', 'MU', 'MUS', '480', '.mu');
INSERT INTO `#__dnagifts_lst_countries` VALUES(112, 112, 'Mexico', 'United Mexican States', 'Independent State', '', '', 'Mexico', 'MXN', 'Peso', '+52', 'MX', 'MEX', '484', '.mx');
INSERT INTO `#__dnagifts_lst_countries` VALUES(113, 113, 'Micronesia', 'Federated States of Micronesia', 'Independent State', '', '', 'Palikir', 'USD', 'Dollar', '+691', 'FM', 'FSM', '583', '.fm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(114, 114, 'Moldova', 'Republic of Moldova', 'Independent State', '', '', 'Chisinau', 'MDL', 'Leu', '+373', 'MD', 'MDA', '498', '.md');
INSERT INTO `#__dnagifts_lst_countries` VALUES(115, 115, 'Monaco', 'Principality of Monaco', 'Independent State', '', '', 'Monaco', 'EUR', 'Euro', '+377', 'MC', 'MCO', '492', '.mc');
INSERT INTO `#__dnagifts_lst_countries` VALUES(116, 116, 'Mongolia', '', 'Independent State', '', '', 'Ulaanbaatar', 'MNT', 'Tugrik', '+976', 'MN', 'MNG', '496', '.mn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(117, 117, 'Montenegro', 'Republic of Montenegro', 'Independent State', '', '', 'Podgorica', 'EUR', 'Euro', '+382', 'ME', 'MNE', '499', '.me and .y');
INSERT INTO `#__dnagifts_lst_countries` VALUES(118, 118, 'Morocco', 'Kingdom of Morocco', 'Independent State', '', '', 'Rabat', 'MAD', 'Dirham', '+212', 'MA', 'MAR', '504', '.ma');
INSERT INTO `#__dnagifts_lst_countries` VALUES(119, 119, 'Mozambique', 'Republic of Mozambique', 'Independent State', '', '', 'Maputo', 'MZM', 'Meticail', '+258', 'MZ', 'MOZ', '508', '.mz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(120, 120, 'Myanmar (Burma)', 'Union of Myanmar', 'Independent State', '', '', 'Naypyidaw', 'MMK', 'Kyat', '+95', 'MM', 'MMR', '104', '.mm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(121, 121, 'Namibia', 'Republic of Namibia', 'Independent State', '', '', 'Windhoek', 'NAD', 'Dollar', '+264', 'NA', 'NAM', '516', '.na');
INSERT INTO `#__dnagifts_lst_countries` VALUES(122, 122, 'Nauru', 'Republic of Nauru', 'Independent State', '', '', 'Yaren', 'AUD', 'Dollar', '+674', 'NR', 'NRU', '520', '.nr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(123, 123, 'Nepal', '', 'Independent State', '', '', 'Kathmandu', 'NPR', 'Rupee', '+977', 'NP', 'NPL', '524', '.np');
INSERT INTO `#__dnagifts_lst_countries` VALUES(124, 124, 'Netherlands', 'Kingdom of the Netherlands', 'Independent State', '', '', 'Amsterdam (administrative) and The Hague (legislative/judical)', 'EUR', 'Euro', '+31', 'NL', 'NLD', '528', '.nl');
INSERT INTO `#__dnagifts_lst_countries` VALUES(125, 125, 'New Zealand', '', 'Independent State', '', '', 'Wellington', 'NZD', 'Dollar', '+64', 'NZ', 'NZL', '554', '.nz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(126, 126, 'Nicaragua', 'Republic of Nicaragua', 'Independent State', '', '', 'Managua', 'NIO', 'Cordoba', '+505', 'NI', 'NIC', '558', '.ni');
INSERT INTO `#__dnagifts_lst_countries` VALUES(127, 127, 'Niger', 'Republic of Niger', 'Independent State', '', '', 'Niamey', 'XOF', 'Franc', '+227', 'NE', 'NER', '562', '.ne');
INSERT INTO `#__dnagifts_lst_countries` VALUES(128, 128, 'Nigeria', 'Federal Republic of Nigeria', 'Independent State', '', '', 'Abuja', 'NGN', 'Naira', '+234', 'NG', 'NGA', '566', '.ng');
INSERT INTO `#__dnagifts_lst_countries` VALUES(129, 129, 'Norway', 'Kingdom of Norway', 'Independent State', '', '', 'Oslo', 'NOK', 'Krone', '+47', 'NO', 'NOR', '578', '.no');
INSERT INTO `#__dnagifts_lst_countries` VALUES(130, 130, 'Oman', 'Sultanate of Oman', 'Independent State', '', '', 'Muscat', 'OMR', 'Rial', '+968', 'OM', 'OMN', '512', '.om');
INSERT INTO `#__dnagifts_lst_countries` VALUES(131, 131, 'Pakistan', 'Islamic Republic of Pakistan', 'Independent State', '', '', 'Islamabad', 'PKR', 'Rupee', '+92', 'PK', 'PAK', '586', '.pk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(132, 132, 'Palau', 'Republic of Palau', 'Independent State', '', '', 'Melekeok', 'USD', 'Dollar', '+680', 'PW', 'PLW', '585', '.pw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(133, 133, 'Panama', 'Republic of Panama', 'Independent State', '', '', 'Panama', 'PAB', 'Balboa', '+507', 'PA', 'PAN', '591', '.pa');
INSERT INTO `#__dnagifts_lst_countries` VALUES(134, 134, 'Papua New Guinea', 'Independent State of Papua New Guinea', 'Independent State', '', '', 'Port Moresby', 'PGK', 'Kina', '+675', 'PG', 'PNG', '598', '.pg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(135, 135, 'Paraguay', 'Republic of Paraguay', 'Independent State', '', '', 'Asuncion', 'PYG', 'Guarani', '+595', 'PY', 'PRY', '600', '.py');
INSERT INTO `#__dnagifts_lst_countries` VALUES(136, 136, 'Peru', 'Republic of Peru', 'Independent State', '', '', 'Lima', 'PEN', 'Sol', '+51', 'PE', 'PER', '604', '.pe');
INSERT INTO `#__dnagifts_lst_countries` VALUES(137, 137, 'Philippines', 'Republic of the Philippines', 'Independent State', '', '', 'Manila', 'PHP', 'Peso', '+63', 'PH', 'PHL', '608', '.ph');
INSERT INTO `#__dnagifts_lst_countries` VALUES(138, 138, 'Poland', 'Republic of Poland', 'Independent State', '', '', 'Warsaw', 'PLN', 'Zloty', '+48', 'PL', 'POL', '616', '.pl');
INSERT INTO `#__dnagifts_lst_countries` VALUES(139, 139, 'Portugal', 'Portuguese Republic', 'Independent State', '', '', 'Lisbon', 'EUR', 'Euro', '+351', 'PT', 'PRT', '620', '.pt');
INSERT INTO `#__dnagifts_lst_countries` VALUES(140, 140, 'Qatar', 'State of Qatar', 'Independent State', '', '', 'Doha', 'QAR', 'Rial', '+974', 'QA', 'QAT', '634', '.qa');
INSERT INTO `#__dnagifts_lst_countries` VALUES(141, 141, 'Romania', '', 'Independent State', '', '', 'Bucharest', 'RON', 'Leu', '+40', 'RO', 'ROU', '642', '.ro');
INSERT INTO `#__dnagifts_lst_countries` VALUES(142, 142, 'Russia', 'Russian Federation', 'Independent State', '', '', 'Moscow', 'RUB', 'Ruble', '+7', 'RU', 'RUS', '643', '.ru and .s');
INSERT INTO `#__dnagifts_lst_countries` VALUES(143, 143, 'Rwanda', 'Republic of Rwanda', 'Independent State', '', '', 'Kigali', 'RWF', 'Franc', '+250', 'RW', 'RWA', '646', '.rw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(144, 144, 'Saint Kitts and Nevis', 'Federation of Saint Kitts and Nevis', 'Independent State', '', '', 'Basseterre', 'XCD', 'Dollar', '+1-869', 'KN', 'KNA', '659', '.kn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(145, 145, 'Saint Lucia', '', 'Independent State', '', '', 'Castries', 'XCD', 'Dollar', '+1-758', 'LC', 'LCA', '662', '.lc');
INSERT INTO `#__dnagifts_lst_countries` VALUES(146, 146, 'Saint Vincent and the Grenadines', '', 'Independent State', '', '', 'Kingstown', 'XCD', 'Dollar', '+1-784', 'VC', 'VCT', '670', '.vc');
INSERT INTO `#__dnagifts_lst_countries` VALUES(147, 147, 'Samoa', 'Independent State of Samoa', 'Independent State', '', '', 'Apia', 'WST', 'Tala', '+685', 'WS', 'WSM', '882', '.ws');
INSERT INTO `#__dnagifts_lst_countries` VALUES(148, 148, 'San Marino', 'Republic of San Marino', 'Independent State', '', '', 'San Marino', 'EUR', 'Euro', '+378', 'SM', 'SMR', '674', '.sm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(149, 149, 'Sao Tome and Principe', 'Democratic Republic of Sao Tome and Principe', 'Independent State', '', '', 'Sao Tome', 'STD', 'Dobra', '+239', 'ST', 'STP', '678', '.st');
INSERT INTO `#__dnagifts_lst_countries` VALUES(150, 150, 'Saudi Arabia', 'Kingdom of Saudi Arabia', 'Independent State', '', '', 'Riyadh', 'SAR', 'Rial', '+966', 'SA', 'SAU', '682', '.sa');
INSERT INTO `#__dnagifts_lst_countries` VALUES(151, 151, 'Senegal', 'Republic of Senegal', 'Independent State', '', '', 'Dakar', 'XOF', 'Franc', '+221', 'SN', 'SEN', '686', '.sn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(152, 152, 'Serbia', 'Republic of Serbia', 'Independent State', '', '', 'Belgrade', 'RSD', 'Dinar', '+381', 'RS', 'SRB', '688', '.rs and .y');
INSERT INTO `#__dnagifts_lst_countries` VALUES(153, 153, 'Seychelles', 'Republic of Seychelles', 'Independent State', '', '', 'Victoria', 'SCR', 'Rupee', '+248', 'SC', 'SYC', '690', '.sc');
INSERT INTO `#__dnagifts_lst_countries` VALUES(154, 154, 'Sierra Leone', 'Republic of Sierra Leone', 'Independent State', '', '', 'Freetown', 'SLL', 'Leone', '+232', 'SL', 'SLE', '694', '.sl');
INSERT INTO `#__dnagifts_lst_countries` VALUES(155, 155, 'Singapore', 'Republic of Singapore', 'Independent State', '', '', 'Singapore', 'SGD', 'Dollar', '+65', 'SG', 'SGP', '702', '.sg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(156, 156, 'Slovakia', 'Slovak Republic', 'Independent State', '', '', 'Bratislava', 'SKK', 'Koruna', '+421', 'SK', 'SVK', '703', '.sk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(157, 157, 'Slovenia', 'Republic of Slovenia', 'Independent State', '', '', 'Ljubljana', 'EUR', 'Euro', '+386', 'SI', 'SVN', '705', '.si');
INSERT INTO `#__dnagifts_lst_countries` VALUES(158, 158, 'Solomon Islands', '', 'Independent State', '', '', 'Honiara', 'SBD', 'Dollar', '+677', 'SB', 'SLB', '090', '.sb');
INSERT INTO `#__dnagifts_lst_countries` VALUES(159, 159, 'Somalia', '', 'Independent State', '', '', 'Mogadishu', 'SOS', 'Shilling', '+252', 'SO', 'SOM', '706', '.so');
INSERT INTO `#__dnagifts_lst_countries` VALUES(160, 160, 'South Africa', 'Republic of South Africa', 'Independent State', '', '', 'Pretoria (administrative), Cape Town (legislative), and Bloemfontein (', 'ZAR', 'Rand', '+27', 'ZA', 'ZAF', '710', '.za');
INSERT INTO `#__dnagifts_lst_countries` VALUES(161, 161, 'Spain', 'Kingdom of Spain', 'Independent State', '', '', 'Madrid', 'EUR', 'Euro', '+34', 'ES', 'ESP', '724', '.es');
INSERT INTO `#__dnagifts_lst_countries` VALUES(162, 162, 'Sri Lanka', 'Democratic Socialist Republic of Sri Lanka', 'Independent State', '', '', 'Colombo (administrative/judical) and Sri Jayewardenepura Kotte (legisl', 'LKR', 'Rupee', '+94', 'LK', 'LKA', '144', '.lk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(163, 163, 'Sudan', 'Republic of the Sudan', 'Independent State', '', '', 'Khartoum', 'SDD', 'Dinar', '+249', 'SD', 'SDN', '736', '.sd');
INSERT INTO `#__dnagifts_lst_countries` VALUES(164, 164, 'Suriname', 'Republic of Suriname', 'Independent State', '', '', 'Paramaribo', 'SRD', 'Dollar', '+597', 'SR', 'SUR', '740', '.sr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(165, 165, 'Swaziland', 'Kingdom of Swaziland', 'Independent State', '', '', 'Mbabane (administrative) and Lobamba (legislative)', 'SZL', 'Lilangeni', '+268', 'SZ', 'SWZ', '748', '.sz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(166, 166, 'Sweden', 'Kingdom of Sweden', 'Independent State', '', '', 'Stockholm', 'SEK', 'Kronoa', '+46', 'SE', 'SWE', '752', '.se');
INSERT INTO `#__dnagifts_lst_countries` VALUES(167, 167, 'Switzerland', 'Swiss Confederation', 'Independent State', '', '', 'Bern', 'CHF', 'Franc', '+41', 'CH', 'CHE', '756', '.ch');
INSERT INTO `#__dnagifts_lst_countries` VALUES(168, 168, 'Syria', 'Syrian Arab Republic', 'Independent State', '', '', 'Damascus', 'SYP', 'Pound', '+963', 'SY', 'SYR', '760', '.sy');
INSERT INTO `#__dnagifts_lst_countries` VALUES(169, 169, 'Tajikistan', 'Republic of Tajikistan', 'Independent State', '', '', 'Dushanbe', 'TJS', 'Somoni', '+992', 'TJ', 'TJK', '762', '.tj');
INSERT INTO `#__dnagifts_lst_countries` VALUES(170, 170, 'Tanzania', 'United Republic of Tanzania', 'Independent State', '', '', 'Dar es Salaam (administrative/judical) and Dodoma (legislative)', 'TZS', 'Shilling', '+255', 'TZ', 'TZA', '834', '.tz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(171, 171, 'Thailand', 'Kingdom of Thailand', 'Independent State', '', '', 'Bangkok', 'THB', 'Baht', '+66', 'TH', 'THA', '764', '.th');
INSERT INTO `#__dnagifts_lst_countries` VALUES(172, 172, 'Timor-Leste (East Timor)', 'Democratic Republic of Timor-Leste', 'Independent State', '', '', 'Dili', 'USD', 'Dollar', '+670', 'TL', 'TLS', '626', '.tp and .t');
INSERT INTO `#__dnagifts_lst_countries` VALUES(173, 173, 'Togo', 'Togolese Republic', 'Independent State', '', '', 'Lome', 'XOF', 'Franc', '+228', 'TG', 'TGO', '768', '.tg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(174, 174, 'Tonga', 'Kingdom of Tonga', 'Independent State', '', '', 'Nuku''alofa', 'TOP', 'Pa''anga', '+676', 'TO', 'TON', '776', '.to');
INSERT INTO `#__dnagifts_lst_countries` VALUES(175, 175, 'Trinidad and Tobago', 'Republic of Trinidad and Tobago', 'Independent State', '', '', 'Port-of-Spain', 'TTD', 'Dollar', '+1-868', 'TT', 'TTO', '780', '.tt');
INSERT INTO `#__dnagifts_lst_countries` VALUES(176, 176, 'Tunisia', 'Tunisian Republic', 'Independent State', '', '', 'Tunis', 'TND', 'Dinar', '+216', 'TN', 'TUN', '788', '.tn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(177, 177, 'Turkey', 'Republic of Turkey', 'Independent State', '', '', 'Ankara', 'TRY', 'Lira', '+90', 'TR', 'TUR', '792', '.tr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(178, 178, 'Turkmenistan', '', 'Independent State', '', '', 'Ashgabat', 'TMM', 'Manat', '+993', 'TM', 'TKM', '795', '.tm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(179, 179, 'Tuvalu', '', 'Independent State', '', '', 'Funafuti', 'AUD', 'Dollar', '+688', 'TV', 'TUV', '798', '.tv');
INSERT INTO `#__dnagifts_lst_countries` VALUES(180, 180, 'Uganda', 'Republic of Uganda', 'Independent State', '', '', 'Kampala', 'UGX', 'Shilling', '+256', 'UG', 'UGA', '800', '.ug');
INSERT INTO `#__dnagifts_lst_countries` VALUES(181, 181, 'Ukraine', '', 'Independent State', '', '', 'Kiev', 'UAH', 'Hryvnia', '+380', 'UA', 'UKR', '804', '.ua');
INSERT INTO `#__dnagifts_lst_countries` VALUES(182, 182, 'United Arab Emirates', 'United Arab Emirates', 'Independent State', '', '', 'Abu Dhabi', 'AED', 'Dirham', '+971', 'AE', 'ARE', '784', '.ae');
INSERT INTO `#__dnagifts_lst_countries` VALUES(183, 183, 'United Kingdom', 'United Kingdom of Great Britain and Northern Irela', 'Independent State', '', '', 'London', 'GBP', 'Pound', '+44', 'GB', 'GBR', '826', '.uk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(184, 184, 'United States', 'United States of America', 'Independent State', '', '', 'Washington', 'USD', 'Dollar', '+1', 'US', 'USA', '840', '.us');
INSERT INTO `#__dnagifts_lst_countries` VALUES(185, 185, 'Uruguay', 'Oriental Republic of Uruguay', 'Independent State', '', '', 'Montevideo', 'UYU', 'Peso', '+598', 'UY', 'URY', '858', '.uy');
INSERT INTO `#__dnagifts_lst_countries` VALUES(186, 186, 'Uzbekistan', 'Republic of Uzbekistan', 'Independent State', '', '', 'Tashkent', 'UZS', 'Som', '+998', 'UZ', 'UZB', '860', '.uz');
INSERT INTO `#__dnagifts_lst_countries` VALUES(187, 187, 'Vanuatu', 'Republic of Vanuatu', 'Independent State', '', '', 'Port-Vila', 'VUV', 'Vatu', '+678', 'VU', 'VUT', '548', '.vu');
INSERT INTO `#__dnagifts_lst_countries` VALUES(188, 188, 'Vatican City', 'State of the Vatican City', 'Independent State', '', '', 'Vatican City', 'EUR', 'Euro', '+379', 'VA', 'VAT', '336', '.va');
INSERT INTO `#__dnagifts_lst_countries` VALUES(189, 189, 'Venezuela', 'Bolivarian Republic of Venezuela', 'Independent State', '', '', 'Caracas', 'VEB', 'Bolivar', '+58', 'VE', 'VEN', '862', '.ve');
INSERT INTO `#__dnagifts_lst_countries` VALUES(190, 190, 'Vietnam', 'Socialist Republic of Vietnam', 'Independent State', '', '', 'Hanoi', 'VND', 'Dong', '+84', 'VN', 'VNM', '704', '.vn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(191, 191, 'Yemen', 'Republic of Yemen', 'Independent State', '', '', 'Sanaa', 'YER', 'Rial', '+967', 'YE', 'YEM', '887', '.ye');
INSERT INTO `#__dnagifts_lst_countries` VALUES(192, 192, 'Zambia', 'Republic of Zambia', 'Independent State', '', '', 'Lusaka', 'ZMK', 'Kwacha', '+260', 'ZM', 'ZMB', '894', '.zm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(193, 193, 'Zimbabwe', 'Republic of Zimbabwe', 'Independent State', '', '', 'Harare', 'ZWD', 'Dollar', '+263', 'ZW', 'ZWE', '716', '.zw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(194, 194, 'Abkhazia', 'Republic of Abkhazia', 'Proto Independent State', '', '', 'Sokhumi', 'RUB', 'Ruble', '+995', 'GE', 'GEO', '268', '.ge');
INSERT INTO `#__dnagifts_lst_countries` VALUES(195, 195, 'China, Republic of (Taiwan)', 'Republic of China', 'Proto Independent State', '', '', 'Taipei', 'TWD', 'Dollar', '+886', 'TW', 'TWN', '158', '.tw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(196, 196, 'Nagorno-Karabakh', 'Nagorno-Karabakh Republic', 'Proto Independent State', '', '', 'Stepanakert', 'AMD', 'Dram', '+374-97', 'AZ', 'AZE', '031', '.az');
INSERT INTO `#__dnagifts_lst_countries` VALUES(197, 197, 'Northern Cyprus', 'Turkish Republic of Northern Cyprus', 'Proto Independent State', '', '', 'Nicosia', 'TRY', 'Lira', '+90-392', 'CY', 'CYP', '196', '.nc.tr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(198, 198, 'Pridnestrovie (Transnistria)', 'Pridnestrovian Moldavian Republic', 'Proto Independent State', '', '', 'Tiraspol', '', 'Ruple', '+373-533', 'MD', 'MDA', '498', '.md');
INSERT INTO `#__dnagifts_lst_countries` VALUES(199, 199, 'Somaliland', 'Republic of Somaliland', 'Proto Independent State', '', '', 'Hargeisa', '', 'Shilling', '+252', 'SO', 'SOM', '706', '.so');
INSERT INTO `#__dnagifts_lst_countries` VALUES(200, 200, 'South Ossetia', 'Republic of South Ossetia', 'Proto Independent State', '', '', 'Tskhinvali', 'RUB and GEL', 'Ruble and Lari', '+995', 'GE', 'GEO', '268', '.ge');
INSERT INTO `#__dnagifts_lst_countries` VALUES(201, 201, 'Ashmore and Cartier Islands', 'Territory of Ashmore and Cartier Islands', 'Dependency', 'External Territory', 'Australia', '', '', '', '', 'AU', 'AUS', '036', '.au');
INSERT INTO `#__dnagifts_lst_countries` VALUES(202, 202, 'Christmas Island', 'Territory of Christmas Island', 'Dependency', 'External Territory', 'Australia', 'The Settlement (Flying Fish Cove)', 'AUD', 'Dollar', '+61', 'CX', 'CXR', '162', '.cx');
INSERT INTO `#__dnagifts_lst_countries` VALUES(203, 203, 'Cocos (Keeling) Islands', 'Territory of Cocos (Keeling) Islands', 'Dependency', 'External Territory', 'Australia', 'West Island', 'AUD', 'Dollar', '+61', 'CC', 'CCK', '166', '.cc');
INSERT INTO `#__dnagifts_lst_countries` VALUES(204, 204, 'Coral Sea Islands', 'Coral Sea Islands Territory', 'Dependency', 'External Territory', 'Australia', '', '', '', '', 'AU', 'AUS', '036', '.au');
INSERT INTO `#__dnagifts_lst_countries` VALUES(205, 205, 'Heard Island and McDonald Islands', 'Territory of Heard Island and McDonald Islands', 'Dependency', 'External Territory', 'Australia', '', '', '', '', 'HM', 'HMD', '334', '.hm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(206, 206, 'Norfolk Island', 'Territory of Norfolk Island', 'Dependency', 'External Territory', 'Australia', 'Kingston', 'AUD', 'Dollar', '+672', 'NF', 'NFK', '574', '.nf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(207, 207, 'New Caledonia', '', 'Dependency', 'Sui generis Collectivity', 'France', 'Noumea', 'XPF', 'Franc', '+687', 'NC', 'NCL', '540', '.nc');
INSERT INTO `#__dnagifts_lst_countries` VALUES(208, 208, 'French Polynesia', 'Overseas Country of French Polynesia', 'Dependency', 'Overseas Collectivity', 'France', 'Papeete', 'XPF', 'Franc', '+689', 'PF', 'PYF', '258', '.pf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(209, 209, 'Mayotte', 'Departmental Collectivity of Mayotte', 'Dependency', 'Overseas Collectivity', 'France', 'Mamoudzou', 'EUR', 'Euro', '+262', 'YT', 'MYT', '175', '.yt');
INSERT INTO `#__dnagifts_lst_countries` VALUES(210, 210, 'Saint Barthelemy', 'Collectivity of Saint Barthelemy', 'Dependency', 'Overseas Collectivity', 'France', 'Gustavia', 'EUR', 'Euro', '+590', 'GP', 'GLP', '312', '.gp');
INSERT INTO `#__dnagifts_lst_countries` VALUES(211, 211, 'Saint Martin', 'Collectivity of Saint Martin', 'Dependency', 'Overseas Collectivity', 'France', 'Marigot', 'EUR', 'Euro', '+590', 'GP', 'GLP', '312', '.gp');
INSERT INTO `#__dnagifts_lst_countries` VALUES(212, 212, 'Saint Pierre and Miquelon', 'Territorial Collectivity of Saint Pierre and Mique', 'Dependency', 'Overseas Collectivity', 'France', 'Saint-Pierre', 'EUR', 'Euro', '+508', 'PM', 'SPM', '666', '.pm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(213, 213, 'Wallis and Futuna', 'Collectivity of the Wallis and Futuna Islands', 'Dependency', 'Overseas Collectivity', 'France', 'Mata''utu', 'XPF', 'Franc', '+681', 'WF', 'WLF', '876', '.wf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(214, 214, 'French Southern and Antarctic Lands', 'Territory of the French Southern and Antarctic Lan', 'Dependency', 'Overseas Territory', 'France', 'Martin-de-ViviFs', '', '', '', 'TF', 'ATF', '260', '.tf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(215, 215, 'Clipperton Island', '', 'Dependency', 'Possession', 'France', '', '', '', '', 'PF', 'PYF', '258', '.pf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(216, 216, 'Bouvet Island', '', 'Dependency', 'Territory', 'Norway', '', '', '', '', 'BV', 'BVT', '074', '.bv');
INSERT INTO `#__dnagifts_lst_countries` VALUES(217, 217, 'Cook Islands', '', 'Dependency', 'Self-Governing in Free Association', 'New Zealand', 'Avarua', 'NZD', 'Dollar', '+682', 'CK', 'COK', '184', '.ck');
INSERT INTO `#__dnagifts_lst_countries` VALUES(218, 218, 'Niue', '', 'Dependency', 'Self-Governing in Free Association', 'New Zealand', 'Alofi', 'NZD', 'Dollar', '+683', 'NU', 'NIU', '570', '.nu');
INSERT INTO `#__dnagifts_lst_countries` VALUES(219, 219, 'Tokelau', '', 'Dependency', 'Territory', 'New Zealand', '', 'NZD', 'Dollar', '+690', 'TK', 'TKL', '772', '.tk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(220, 220, 'Guernsey', 'Bailiwick of Guernsey', 'Dependency', 'Crown Dependency', 'United Kingdom', 'Saint Peter Port', 'GGP', 'Pound', '+44', 'GG', 'GGY', '831', '.gg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(221, 221, 'Isle of Man', '', 'Dependency', 'Crown Dependency', 'United Kingdom', 'Douglas', 'IMP', 'Pound', '+44', 'IM', 'IMN', '833', '.im');
INSERT INTO `#__dnagifts_lst_countries` VALUES(222, 222, 'Jersey', 'Bailiwick of Jersey', 'Dependency', 'Crown Dependency', 'United Kingdom', 'Saint Helier', 'JEP', 'Pound', '+44', 'JE', 'JEY', '832', '.je');
INSERT INTO `#__dnagifts_lst_countries` VALUES(223, 223, 'Anguilla', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'The Valley', 'XCD', 'Dollar', '+1-264', 'AI', 'AIA', '660', '.ai');
INSERT INTO `#__dnagifts_lst_countries` VALUES(224, 224, 'Bermuda', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Hamilton', 'BMD', 'Dollar', '+1-441', 'BM', 'BMU', '060', '.bm');
INSERT INTO `#__dnagifts_lst_countries` VALUES(225, 225, 'British Indian Ocean Territory', '', 'Dependency', 'Overseas Territory', 'United Kingdom', '', '', '', '+246', 'IO', 'IOT', '086', '.io');
INSERT INTO `#__dnagifts_lst_countries` VALUES(226, 226, 'British Sovereign Base Areas', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Episkopi', 'CYP', 'Pound', '+357', '', '', '', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(227, 227, 'British Virgin Islands', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Road Town', 'USD', 'Dollar', '+1-284', 'VG', 'VGB', '092', '.vg');
INSERT INTO `#__dnagifts_lst_countries` VALUES(228, 228, 'Cayman Islands', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'George Town', 'KYD', 'Dollar', '+1-345', 'KY', 'CYM', '136', '.ky');
INSERT INTO `#__dnagifts_lst_countries` VALUES(229, 229, 'Falkland Islands (Islas Malvinas)', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Stanley', 'FKP', 'Pound', '+500', 'FK', 'FLK', '238', '.fk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(230, 230, 'Gibraltar', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Gibraltar', 'GIP', 'Pound', '+350', 'GI', 'GIB', '292', '.gi');
INSERT INTO `#__dnagifts_lst_countries` VALUES(231, 231, 'Montserrat', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Plymouth', 'XCD', 'Dollar', '+1-664', 'MS', 'MSR', '500', '.ms');
INSERT INTO `#__dnagifts_lst_countries` VALUES(232, 232, 'Pitcairn Islands', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Adamstown', 'NZD', 'Dollar', '', 'PN', 'PCN', '612', '.pn');
INSERT INTO `#__dnagifts_lst_countries` VALUES(233, 233, 'Saint Helena', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Jamestown', 'SHP', 'Pound', '+290', 'SH', 'SHN', '654', '.sh');
INSERT INTO `#__dnagifts_lst_countries` VALUES(234, 234, 'South Georgia & South Sandwich Islands', '', 'Dependency', 'Overseas Territory', 'United Kingdom', '', '', '', '', 'GS', 'SGS', '239', '.gs');
INSERT INTO `#__dnagifts_lst_countries` VALUES(235, 235, 'Turks and Caicos Islands', '', 'Dependency', 'Overseas Territory', 'United Kingdom', 'Grand Turk', 'USD', 'Dollar', '+1-649', 'TC', 'TCA', '796', '.tc');
INSERT INTO `#__dnagifts_lst_countries` VALUES(236, 236, 'Northern Mariana Islands', 'Commonwealth of The Northern Mariana Islands', 'Dependency', 'Commonwealth', 'United States', 'Saipan', 'USD', 'Dollar', '+1-670', 'MP', 'MNP', '580', '.mp');
INSERT INTO `#__dnagifts_lst_countries` VALUES(237, 237, 'Puerto Rico', 'Commonwealth of Puerto Rico', 'Dependency', 'Commonwealth', 'United States', 'San Juan', 'USD', 'Dollar', '+1-787 and', 'PR', 'PRI', '630', '.pr');
INSERT INTO `#__dnagifts_lst_countries` VALUES(238, 238, 'American Samoa', 'Territory of American Samoa', 'Dependency', 'Territory', 'United States', 'Pago Pago', 'USD', 'Dollar', '+1-684', 'AS', 'ASM', '016', '.as');
INSERT INTO `#__dnagifts_lst_countries` VALUES(239, 239, 'Baker Island', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(240, 240, 'Guam', 'Territory of Guam', 'Dependency', 'Territory', 'United States', 'Hagatna', 'USD', 'Dollar', '+1-671', 'GU', 'GUM', '316', '.gu');
INSERT INTO `#__dnagifts_lst_countries` VALUES(241, 241, 'Howland Island', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(242, 242, 'Jarvis Island', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(243, 243, 'Johnston Atoll', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(244, 244, 'Kingman Reef', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(245, 245, 'Midway Islands', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(246, 246, 'Navassa Island', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(247, 247, 'Palmyra Atoll', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '581', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(248, 248, 'U.S. Virgin Islands', 'United States Virgin Islands', 'Dependency', 'Territory', 'United States', 'Charlotte Amalie', 'USD', 'Dollar', '+1-340', 'VI', 'VIR', '850', '.vi');
INSERT INTO `#__dnagifts_lst_countries` VALUES(249, 249, 'Wake Island', '', 'Dependency', 'Territory', 'United States', '', '', '', '', 'UM', 'UMI', '850', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(250, 250, 'Hong Kong', 'Hong Kong Special Administrative Region', 'Proto Dependency', 'Special Administrative Region', 'China', '', 'HKD', 'Dollar', '+852', 'HK', 'HKG', '344', '.hk');
INSERT INTO `#__dnagifts_lst_countries` VALUES(251, 251, 'Macau', 'Macau Special Administrative Region', 'Proto Dependency', 'Special Administrative Region', 'China', 'Macau', 'MOP', 'Pataca', '+853', 'MO', 'MAC', '446', '.mo');
INSERT INTO `#__dnagifts_lst_countries` VALUES(252, 252, 'Faroe Islands', '', 'Proto Dependency', '', 'Denmark', 'Torshavn', 'DKK', 'Krone', '+298', 'FO', 'FRO', '234', '.fo');
INSERT INTO `#__dnagifts_lst_countries` VALUES(253, 253, 'Greenland', '', 'Proto Dependency', '', 'Denmark', 'Nuuk (Godthab)', 'DKK', 'Krone', '+299', 'GL', 'GRL', '304', '.gl');
INSERT INTO `#__dnagifts_lst_countries` VALUES(254, 254, 'French Guiana', 'Overseas Region of Guiana', 'Proto Dependency', 'Overseas Region', 'France', 'Cayenne', 'EUR', 'Euro', '+594', 'GF', 'GUF', '254', '.gf');
INSERT INTO `#__dnagifts_lst_countries` VALUES(255, 255, 'Guadeloupe', 'Overseas Region of Guadeloupe', 'Proto Dependency', 'Overseas Region', 'France', 'Basse-Terre', 'EUR', 'Euro', '+590', 'GP', 'GLP', '312', '.gp');
INSERT INTO `#__dnagifts_lst_countries` VALUES(256, 256, 'Martinique', 'Overseas Region of Martinique', 'Proto Dependency', 'Overseas Region', 'France', 'Fort-de-France', 'EUR', 'Euro', '+596', 'MQ', 'MTQ', '474', '.mq');
INSERT INTO `#__dnagifts_lst_countries` VALUES(257, 257, 'Reunion', 'Overseas Region of Reunion', 'Proto Dependency', 'Overseas Region', 'France', 'Saint-Denis', 'EUR', 'Euro', '+262', 'RE', 'REU', '638', '.re');
INSERT INTO `#__dnagifts_lst_countries` VALUES(258, 258, 'Aland', '', 'Proto Dependency', '', 'Finland', 'Mariehamn', 'EUR', 'Euro', '+358-18', 'AX', 'ALA', '248', '.ax');
INSERT INTO `#__dnagifts_lst_countries` VALUES(259, 259, 'Aruba', '', 'Proto Dependency', '', 'Netherlands', 'Oranjestad', 'AWG', 'Guilder', '+297', 'AW', 'ABW', '533', '.aw');
INSERT INTO `#__dnagifts_lst_countries` VALUES(260, 260, 'Netherlands Antilles', '', 'Proto Dependency', '', 'Netherlands', 'Willemstad', 'ANG', 'Guilder', '+599', 'AN', 'ANT', '530', '.an');
INSERT INTO `#__dnagifts_lst_countries` VALUES(261, 261, 'Svalbard', '', 'Proto Dependency', '', 'Norway', 'Longyearbyen', 'NOK', 'Krone', '+47', 'SJ', 'SJM', '744', '.sj');
INSERT INTO `#__dnagifts_lst_countries` VALUES(262, 262, 'Ascension', '', 'Proto Dependency', 'Dependency of Saint Helena', 'United Kingdom', 'Georgetown', 'SHP', 'Pound', '+247', 'AC', 'ASC', '', '.ac');
INSERT INTO `#__dnagifts_lst_countries` VALUES(263, 263, 'Tristan da Cunha', '', 'Proto Dependency', 'Dependency of Saint Helena', 'United Kingdom', 'Edinburgh', 'SHP', 'Pound', '+290', 'TA', 'TAA', '', '');
INSERT INTO `#__dnagifts_lst_countries` VALUES(264, 268, 'Australian Antarctic Territory', '', 'Antarctic Territory', 'External Territory', 'Australia', '', '', '', '', 'AQ', 'ATA', '010', '.aq');
INSERT INTO `#__dnagifts_lst_countries` VALUES(265, 269, 'Ross Dependency', '', 'Antarctic Territory', 'Territory', 'New Zealand', '', '', '', '', 'AQ', 'ATA', '010', '.aq');
INSERT INTO `#__dnagifts_lst_countries` VALUES(266, 270, 'Peter I Island', '', 'Antarctic Territory', 'Territory', 'Norway', '', '', '', '', 'AQ', 'ATA', '010', '.aq');
INSERT INTO `#__dnagifts_lst_countries` VALUES(267, 271, 'Queen Maud Land', '', 'Antarctic Territory', 'Territory', 'Norway', '', '', '', '', 'AQ', 'ATA', '010', '.aq');
INSERT INTO `#__dnagifts_lst_countries` VALUES(268, 272, 'British Antarctic Territory', '', 'Antarctic Territory', 'Overseas Territory', 'United Kingdom', '', '', '', '', 'AQ', 'ATA', '010', '.aq');

DROP TABLE IF EXISTS `#__dnagifts_lst_language_codes`;
CREATE TABLE `#__dnagifts_lst_language_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique row identifier',
  `language_code` varchar(2) NOT NULL COMMENT 'The 2 character language code',
  `language_string` varchar(20) NOT NULL COMMENT 'The full language string',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='This table is used to translate between the language code and language string' AUTO_INCREMENT=0;

INSERT INTO `#__dnagifts_lst_language_codes` VALUES(NULL, 'en', 'English');
INSERT INTO `#__dnagifts_lst_language_codes` VALUES(NULL, 'af', 'Afrikaans');

