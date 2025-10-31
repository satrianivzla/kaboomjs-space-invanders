-- SQL statements to update the blog schema for multilingual (EN/ES) content.
-- Run these queries on your existing database.

-- Note: This script assumes the original columns will be for the default language (e.g., English).
-- We will add new columns for Spanish.

-- Modify `categories` table
ALTER TABLE `categories`
  ADD `name_es` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `name`,
  CHANGE `name` `name_en` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

-- Modify `tags` table
ALTER TABLE `tags`
  ADD `name_es` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `name`,
  CHANGE `name` `name_en` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

-- Modify `posts` table
ALTER TABLE `posts`
  ADD `title_es` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `title`,
  ADD `content_es` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `content`,
  ADD `seo_title_es` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `seo_title`,
  ADD `seo_description_es` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL AFTER `seo_description`,
  CHANGE `title` `title_en` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  CHANGE `content` `content_en` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  CHANGE `seo_title` `seo_title_en` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  CHANGE `seo_description` `seo_description_en` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;

-- Note: You might want to populate the new Spanish columns with the
-- content from the English columns as a starting point.
-- Example:
-- UPDATE `categories` SET `name_es` = `name_en`;
-- UPDATE `tags` SET `name_es` = `name_en`;
-- UPDATE `posts` SET `title_es` = `title_en`, `content_es` = `content_en`, etc.;
