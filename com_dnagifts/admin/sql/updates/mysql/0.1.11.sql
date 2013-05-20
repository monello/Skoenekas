ALTER TABLE `#__dnagifts_lst_gift` ADD `position1_html` TEXT NULL COMMENT 'This is the text that needs to be displayed when this gift is in position 1' AFTER `color_rgb`;
ALTER TABLE `#__dnagifts_lst_gift` ADD `position2_html` TEXT NULL COMMENT 'This is the text that needs to be displayed when this gift is in position 2' AFTER `position1_html`;
ALTER TABLE `#__dnagifts_lst_gift` ADD `position3_html` TEXT NULL COMMENT 'This is the text that needs to be displayed when this gift is in position 3' AFTER `position2_html`;
ALTER TABLE `#__dnagifts_lst_gift` ADD `position4_html` TEXT NULL COMMENT 'This is the text that needs to be displayed when this gift is in position 4' AFTER `position3_html`;
ALTER TABLE `#__dnagifts_lst_gift` ADD `position5_html` TEXT NULL COMMENT 'This is the text that needs to be displayed when this gift is in position 5' AFTER `position4_html`;
ALTER TABLE `#__dnagifts_lst_gift` ADD `position6_html` TEXT NULL COMMENT 'This is the text that needs to be displayed when this gift is in position 6' AFTER `position5_html`;
ALTER TABLE `#__dnagifts_lst_gift` ADD `position7_html` TEXT NULL COMMENT 'This is the text that needs to be displayed when this gift is in position 7' AFTER `position6_html`;

ALTER TABLE `#__dnagifts_lst_gift` ADD `tag_line` VARCHAR(255) NULL COMMENT 'This is the tag-line text used for this gift in the report' AFTER `position7_html`;

ALTER TABLE `#__dnagifts_lst_gift` DROP `text_token`;