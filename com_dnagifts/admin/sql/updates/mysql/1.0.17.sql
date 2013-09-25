DROP TABLE IF EXISTS `#__dnagifts_testresults`;
CREATE TABLE `#__dnagifts_testresults` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Standard ID for each record',
  `user_test_id` int(11) NOT NULL COMMENT 'Links each result record to a user-test instance',
  `position` int(11) NOT NULL COMMENT 'Orders these results records',
  `score` int(11) NOT NULL COMMENT 'final score for the related user-test instance',
  `gift_id` int(11) NOT NULL COMMENT 'links this record to a gifting',
  PRIMARY KEY (`id`),
  KEY `idx_testresults_position` (`position`),
  KEY `idx_testresults_user_test_id` (`user_test_id`),
  KEY `idx_testresults_score` (`score`),
  KEY `idx_testresults_gift_id` (`gift_id`)
) COMMENT='This table logs the final score and gift positions for each completed test' AUTO_INCREMENT=1;
