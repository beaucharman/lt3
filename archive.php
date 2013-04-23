<?php
/**
 * Archive
 * ------------------------------------------------------------------------
 * archive.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license GNU http://www.gnu.org/licenses/lgpl.txt
 *
 * Archived content template page. Requires the lt3_is_post_type() function.
 * ------------------------------------------------------------------------ */ ?>
<?php get_header(); ?>

<?php global $post; global $wp_query; $post = $posts[0]; ?>

  <h1 class="content-title"><?php
  /* Category Archive */ if ( is_category() ) :
  single_cat_title();

  /* Tag Archive */ elseif ( is_tag() ) :
  echo _e( 'Articles Tagged &#8216;' ); single_tag_title(); echo _e( '&#8217;' );

  /* Daily Archive */ elseif ( is_day() ) :
  echo _e( 'Archive for ' ); the_time( 'F jS, Y' );

  /* Monthly archive */ elseif ( is_month() ) :
  echo _e( 'Archive for ' ); the_time( 'F, Y' );

  /* Yearly Archive */ elseif ( is_year() ) :
  echo _e( 'Archive for ' ); the_time( 'Y' );

  /* Author Archive */ elseif ( is_author() ) :
  echo _e( 'Author Archive' );

  /* Taxonomy Archive */ elseif ( is_tax() ) :
  $taxonomy_term = $wp_query->get_queried_object();
  echo $taxonomy_term->name; echo _e( 'Archive' );

  /* Post Type Archive */ elseif ( lt3_is_post_type() ) :
  $post_type_obj = get_post_type_object( get_post_type( $wp_query->post->ID ) );
  print $post_type_obj->labels->name; echo _e( 'Archive' );

  /* Paged Archive */ elseif ( isset( $_GET['paged'] ) && !empty( $_GET['paged'] ) ) :
  echo _e( 'Article Archives' );

  /* Archive */ else :
  echo _e( 'Article Archive' );

  endif; ?></h1>

  <?php if ( term_description() ) : ?>
  <p class="term-description"><?php echo term_description(); ?></p >
  <?php endif; ?>

  <?php if ( have_posts() ) : ?>

    <?php get_template_part( LT3_TEMPLATE_PARTS_PATH . '/loop', 'archive' ); ?>

    <?php lt3_include_archive_pagination(); ?>

  <?php else : ?>

    <?php lt3_get_message( 'No Posts' ); ?>

  <?php endif; ?>

<?php get_footer(); ?>
