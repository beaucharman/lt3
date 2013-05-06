<?php
/**
 * Search
 * ------------------------------------------------------------------------
 * search.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 *
 * Search results template.
 * ------------------------------------------------------------------------ */ ?>
<?php get_header(); ?>

<?php if ( LT3_ENABLE_SITE_SEARCH ) : ?>

  <?php global $wp_query; $total_results = $wp_query->found_posts; ?>

  <h1 class="content-title">Search Results</h1>

  <p class="search-query">
    <?php echo $total_results ?> result<?php if ( $total_results != 1 ) echo 's'; ?>
    found for the search term: <span><?php echo esc_html( $s, 1 ); ?></span>
  </p>

  <?php if ( have_posts() ) : ?>

    <?php get_template_part( LT3_TEMPLATE_PARTS_PATH . '/loop', 'search' ); ?>

    <?php lt3_include_archive_pagination(); ?>

    <p><?php echo _e( 'Still not what you are looking for?' ); ?></p>
    <?php get_search_form(); ?>

  <?php else : ?>

    <?php lt3_get_message( 'No Results' ); ?>

  <?php endif; ?>

<?php else : ?>

  <?php lt3_get_message( 'Not Found' ); ?>

<?php endif; ?>

<?php get_footer(); ?>