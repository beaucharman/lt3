<?php
/**
 * Template
 * ========================================================================
 * template.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 * ======================================================================== */

/* Set the content width
   ======================================================================== */
global $content_width;
if (! isset($content_width)) $content_width = LT3_PAGE_CONTENT_WIDTH;

/* Add Theme Support
   ======================================================================== */
add_theme_support('post-thumbnails');

/* Set post thumbnail size
   ======================================================================== */
set_post_thumbnail_size(LT3_PAGE_CONTENT_WIDTH / 4, 9999);

/* Add custom image sizes
   ======================================================================== */
add_action('init', 'lt3_add_image_sizes');
/**
 * Declare various image sizes for WordPress image size sampling
 */
function lt3_add_image_sizes()
{
  // Large hero image, usefull for hero banner / feature image fader
  add_image_size('large-hero-image', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);

  // Small feature image, useful for a smaller feature image alternate
  add_image_size('small-feature-image',  LT3_PAGE_CONTENT_WIDTH / 2, 300, true);

  // Small feature image, useful for a smaller feature image alternate
  add_image_size('small-feature-image',  LT3_PAGE_CONTENT_WIDTH, 300, true);

  // Small editor image size, half of the content's width
  add_image_size('small',  LT3_PAGE_CONTENT_WIDTH / 2, 200, false);

  // Large image size, usefull for light box output, or retina ready large content image
  add_image_size('massive',  LT3_PAGE_CONTENT_WIDTH * 1.5, LT3_PAGE_CONTENT_WIDTH, false);

  /**
   * Add more sizes here.
   */
}

/**
 * Add image sizes for selection in the WordPress editor.
 */
add_filter('image_size_names_choose', 'lt3_show_image_sizes');
function lt3_show_image_sizes($sizes)
{
  $sizes['small']   = __('Small');
  $sizes['massive'] = __('Massive');
  return $sizes;
}

/* Add excerpt field to pages
   ======================================================================== */
add_action('init', 'lt3_add_page_excerpts');
function lt3_add_page_excerpts()
{
  add_post_type_support('page', 'excerpt');
}

/* Clean up the <head>
   ======================================================================== */
add_action('init', 'lt3_remove_head_links');
function lt3_remove_head_links()
{
  remove_action('wp_head', 'rsd_link');
  remove_action('wp_head', 'wlwmanifest_link');
  remove_action('wp_head', 'wp_generator');
  remove_action('wp_head', 'feed_links', 2);
  remove_action('wp_head', 'index_rel_link');
  remove_action('wp_head', 'feed_links_extra', 3);
  remove_action('wp_head', 'start_post_rel_link', 10, 0);
  remove_action('wp_head', 'parent_post_rel_link', 10, 0);
  remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
}

/* ========================================================================
   Custom Theme Functions
   ======================================================================== */

/* Function create a custom comment list
   ======================================================================== */
function lt3_advanced_comment($comment, $args, $depth)
{
  $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <div class="comment-vcard">
      <?php echo get_avatar($comment, '56'); ?>
    </div>
    <div class="comment-body">
      <div class="comment-author">
        <a href="<?php the_author_meta('user_url'); ?>">
          <?php printf(__('%s'), get_comment_author_link()); ?>
        </a> said:
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
      <div>
        <em><?php _e('Your comment is awaiting moderation.'); ?></em>
        <br>
      </div>
      <?php endif; ?>
      <div class="comment-text"><?php comment_text() ?></div>
      <div class="comment-meta">
        <small>on the <?php printf(__('%1$s'), get_comment_date('l, F j, Y')); ?>
          <?php if (current_user_can('edit_post')) : ?>
          (<?php edit_comment_link(__('Edit'), '', '') ?><?php lt3_delete_comment_link(get_comment_ID()); ?>)
          <?php endif; ?>
        </small>
      </div>
      <div class="reply">
        <?php comment_reply_link(
          array_merge($args,
            array('depth' => $depth, 'max_depth' => $args['max_depth'])
         )
       ); ?>
      </div>
    </div>
<?php }
