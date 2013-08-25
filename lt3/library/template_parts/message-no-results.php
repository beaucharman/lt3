<?php
/**
 * No Posts Message
 * ========================================================================
 * message-no-posts.php
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 * @author       Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link         https://github.com/beaucharman/lt3
 * @license      MIT license
 *
 * No search results message.
 */
?>

<section class="message message--no-results">

  <h3>Sorry! We couldn't find anything&hellip;</h3>
  <?php if (LT3_ENABLE_SITE_SEARCH) : ?>
  <p>
    Maybe try searching with a different keyword?
  </p>
  <?php get_search_form(); ?>
  <?php endif; ?>

</section>

