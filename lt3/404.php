<?php
/**
 * 404
 * ========================================================================
 * 404.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * 404 error template page.
 */

get_header(); ?>

  <?php lt3_get_message('not-found'); ?>

<?php get_footer();
