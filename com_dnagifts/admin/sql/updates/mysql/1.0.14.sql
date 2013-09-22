DROP TABLE IF EXISTS `#__dnagifts_healthchecks`;
CREATE TABLE `#__dnagifts_healthchecks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `generated_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date and time the cron ran to add this record',
  `total_tests` int(11) NOT NULL DEFAULT '0' COMMENT 'Total number of records in the user-tests table',
  `new_tests` int(11) NOT NULL DEFAULT '0' COMMENT 'total new tests since last run',
  `total_good` int(11) NOT NULL DEFAULT '0' COMMENT 'total tests with 100% progress',
  `new_good` int(11) NOT NULL DEFAULT '0' COMMENT 'total new tests with 100% progress since last run',
  `total_noreport` int(11) NOT NULL DEFAULT '0' COMMENT 'total 100% progress with no report',
  `new_noreport` int(11) NOT NULL DEFAULT '0' COMMENT 'new 100% progress with no report since last run',
  `total_incomplete` int(11) NOT NULL DEFAULT '0' COMMENT 'Total number od tests started but not completed',
  `new_incomplete` int(11) NOT NULL DEFAULT '0' COMMENT 'new incomplete since last run',
  `total_extraanswers` int(11) NOT NULL DEFAULT '0' COMMENT 'Total number of tests with extra answers',
  `new_extraanswers` int(11) NOT NULL DEFAULT '0' COMMENT 'new tests with extra answers since last run',
  `sent_datetime` int(11) NOT NULL COMMENT 'date and time the report was sent to Admins',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_generated_date` (`generated_datetime`),
  KEY `idx_total_tests` (`total_tests`),
  KEY `idx_new_tests` (`new_tests`),
  KEY `idx_good_tests` (`total_good`),
  KEY `idx_new_good_tests` (`new_good`),
  KEY `idx_noreport_tests` (`total_noreport`),
  KEY `idx_new_noreport_tests` (`new_noreport`),
  KEY `idx_incomplete_tests` (`total_incomplete`),
  KEY `idx_new_incomplete_tests` (`new_incomplete`),
  KEY `idx_extraanswers_tests` (`total_extraanswers`),
  KEY `idx_new_extraanswers_tests` (`new_extraanswers`)
) COMMENT='This table tracks the health checks on the users-tests table' AUTO_INCREMENT=1;

