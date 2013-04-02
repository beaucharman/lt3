<?php
/*

  lt3 Template Functions - Foundations

------------------------------------------------
	template-functions.php
	@version 2.0 | April 1st 2013
  @package lt3
  @author  Beau Charman | @beaucharman | http://beaucharman.me
  @link    https://github.com/beaucharman/lt3
  @licence GNU http://www.gnu.org/licenses/lgpl.txt

	All functionality that effects the front end of the theme is located in this file.
------------------------------------------------ */

/*

	Template Functions

------------------------------------------------ */

/* Set the content width
------------------------------------------------ */
global $content_width;
if(! isset($content_width)) $content_width = LT3_PAGE_CONTENT_WIDTH;

/* Set post thumbnail size
------------------------------------------------ */
set_post_thumbnail_size(LT3_PAGE_CONTENT_WIDTH / 4, 9999);

/* Add Custom Image Styles
------------------------------------------------ */
add_image_size('large-hero-image', HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true);
add_image_size('small-feature-image',  LT3_PAGE_CONTENT_WIDTH / 2 , 300, true);

/* Render Title Function. Assign title names and attributes conditionally.
------------------------------------------------ */
function lt3_title()
{
	global $post;
	if((is_archive()) && (!is_front_page()))
	{
		if(is_category())
		{
			single_cat_title(); echo ' &#045; ';
		}
		elseif(is_tag())
		{
			echo 'Tag Archive for "'; single_tag_title(); echo '" &#045; ';
		}
		elseif(is_day())
		{
			echo 'Archive for '; the_time('F jS, Y'); echo ' &#045; ';
		}
		elseif(is_month())
		{
			echo 'Archive for '; the_time('F, Y'); echo ' &#045; ';
		}
		elseif(is_year())
		{
			echo 'Archive for '; the_time('Y'); echo ' &#045; ';
		}
		elseif(is_author())
		{
			echo 'Author Archive &#045; ';
		}
		elseif(is_tax())
		{
			global $wp_query; $taxonomy_term = $wp_query->get_queried_object(); echo $taxonomy_term->name; echo ' Archive &#045; ';
		}
		elseif(lt3_is_post_type())
		{
			global $wp_query; $post_type_obj = get_post_type_object(get_post_type($wp_query->post->ID));
			print $post_type_obj->labels->singular_name; echo ' Archive &#045; ';
		}
	}
	elseif(is_search())
	{
		echo 'Search for "'; the_search_query(); echo '" &#045; ';
	}
	elseif((!is_404()) && (get_the_title()) && (!is_front_page()) && ((is_single()) || (is_page())))
	{
		the_title(); echo ' &#045; ';
	}
	elseif(is_404())
	{
		$window_title = 'Nothing Found Here &#040;404&#041; &#045; ';
	}
	bloginfo('name'); if(get_bloginfo('description')){ echo ' &#045; '; bloginfo('description'); } /* Always include */
}

/* Default header description meta tag - Filter Function
------------------------------------------------ */
function lt3_meta_tag_description()
{
	global $post;
	$content = '';
	if(is_single() || is_page())
	{
		$meta_description = get_post_meta($post->ID, "metadescription", true);
		if($meta_description != '')
		{
		  $content .= esc_attr($meta_description);
		}
		else
		{
		  if(have_posts()){
  		  while(have_posts())
  		  {
  		    the_post();
  		    $excerpt = esc_attr(strip_tags(get_the_excerpt()));
  		    if(strlen($excerpt) > 140) $excerpt = substr($excerpt, 0, 137) .'&hellip;';
  		    $content .= $excerpt;
				}
			}
		}
	}
	elseif(is_home() || is_front_page())
	{
		$content .= get_bloginfo('description');
	}
	elseif(is_category())
	{
		$cat_desc = esc_attr(trim(strip_tags(category_description ())));
		if($cat_desc != '')
			$content .= $cat_desc;
		else
			$content .= 'Archive for the category '. single_cat_title('', false);
	}
	elseif(is_tag())
	{
		$tag_desc = esc_attr(trim(strip_tags(tag_description())));
		if($tag_desc != '')
			$content .= $tag_desc;
		else
			$content .= 'Archive for the tag '. single_tag_title('', false);
	}
	elseif(is_author())
	{
		if(isset($_GET['author_name']))
			$curauth = get_user_by('slug', $author_name);
		else
			$curauth = get_userdata(intval($author));
 		$content .= 'Archive for the author '. $curauth->display_name;
	}
	elseif(is_year())
	{
		$content .= 'Archive for ' . get_the_time('Y');
	}
	elseif(is_month())
	{
		$content .= 'Archive for ' . get_the_time('F, Y');
	}
	elseif(is_day())
	{
		$content .= 'Archive for ' . get_the_time('jS F, Y');
	}
	echo $content;
}

/* Function to change the read more text on Archive pages
------------------------------------------------ */
function lt3_read_more_text()
{
	if(is_attachment())
	{
		echo 'View Full Size Image &rarr;';
	}
	else
	{
		echo 'Read More &rarr;';
	}
}

/* Function to get defined Messages
------------------------------------------------ */
function lt3_get_message($message_name)
{
	switch(strtoupper($message_name))
	{
		case 'NOT FOUND':
			echo '<section class="error-message not-found">' . "\n";
			echo '<h3>'. __('Oops! Nothing Found Here :(') .'</h3><div>' . "\n";
			echo '<p>'. __('The page you are looking for does not exist. (404)') .'</p>' . "\n";
			if(LT3_ENABLE_SITE_SEARCH)
			{
				echo '<p>'. __('Try searching our site for what you are after.') .'</p></div>' . "\n";
				get_search_form();
			}
			echo "\n" . '</section>';
			break;
		case 'NO POSTS':
			echo '<section class="error-message no-posts">' . "\n";
			echo '<h3>'. __('Oops! Nothing Found Here :(') .'</h3><div>' . "\n";
			echo '<p>'. __('There are currently no posts associated with the <strong>');
			single_cat_title();
			echo __('</strong> category.') .'</p>' . "\n";
			if(LT3_ENABLE_SITE_SEARCH)
			{
				echo '<p>'. __('Try searching our site for what you are after.') .'</p></div>' . "\n";
				get_search_form();
			}
			echo "\n" . '</section>';
			break;
		case 'NO ARTICLES':
			echo '<section class="error-message no-articles">' . "\n";
			echo '<h3>'. __('Oops! Nothing Found Here :(') .'</h3><div>' . "\n";
			echo '<p>'. __('There are currently no articles here.') . '</p>' . "\n";
			if(LT3_ENABLE_SITE_SEARCH)
			{
				echo '<p>'. __('Try searching our site for what you are after.') .'</p></div>' . "\n";
				get_search_form();
			}
			echo "\n" . '</section>';
			break;
		case 'NO RESULTS':
			echo '<section class="no-results">' . "\n";
			echo '<h3>'. __('Sorry! We couldn\'t find anything&hellip;') .'</h3>' . "\n";
			if(LT3_ENABLE_SITE_SEARCH)
			{
				echo '<p>'. __('Maybe try searching with a different keyword?') .'</p>' . "\n";
				get_search_form();
			}
			echo "\n" . '</section>';
		break;
	}
}

/* Search form request filter
------------------------------------------------ */
add_filter('request', 'lt3_search_form_request_filter');
function lt3_search_form_request_filter($query_vars)
{
  if(isset($_GET['s']) && empty($_GET['s']))
  {
    $query_vars['s'] = " ";
  }
  return $query_vars;
}

/* Search form replacement
------------------------------------------------ */
add_filter('get_search_form', 'lt3_html5_search_form');
function lt3_html5_search_form($form)
{
  $form = '<form role="search" method="get" id="searchform" action="' . home_url('/') . '">
  <input type="text" placeholder="'. __("Search&hellip;").'" value="" name="s" id="s">
  <input type="submit" id="searchsubmit" value="Go">
  </form>';
  return $form;
}

/* Remove more text on search page
------------------------------------------------ */
add_filter('excerpt_more', 'lt3_search_excerpt_more');
function lt3_search_excerpt_more($more)
{
  if(is_search())
  {
    global $post;
  	return '&hellip;';
	}
}

/* Use Shortcodes in Widgets
------------------------------------------------ */
add_filter('widget_text', 'do_shortcode');

/* Custom post excerpt: Remove <script> tags, set
	 'Read More' and 'Excerpt Length', allow links
------------------------------------------------ */
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'lt3_trim_excerpt');
function lt3_trim_excerpt($text)
{
	global $post;
	if ('' == $text)
	{
		$text = get_the_content('');
		$text = apply_filters('the_content', $text);
		$text = str_replace('\]\]\>', ']]&gt;', $text);
		$text = strip_shortcodes($text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text, '<a>');
		$excerpt_length = apply_filters('excerpt_length', LT3_EXCERPT_LENGTH);
		$excerpt_more = apply_filters('excerpt_more', ' '
			. '&hellip; <a href="'. get_permalink($post->ID)
			. '" class="excerpt-read-more" title="link to article: '
			. the_title_attribute(array('echo' => 0))
			.'">'. LT3_EXCERPT_MORE
			.'</a>'
		);
		$text = wp_trim_words($text, $excerpt_length, $excerpt_more);
	}
	return $text;
}

/* Clean up the <head>
------------------------------------------------ */
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

/* Add browser type to body class
------------------------------------------------ */
add_filter('body_class','lt3_browser_body_class');
function lt3_browser_body_class($classes)
{
	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
	if($is_lynx) $classes[] = 'browser-lynx';
	elseif($is_gecko) $classes[] = 'browser-gecko';
	elseif($is_opera) $classes[] = 'browser-opera';
	elseif($is_NS4) $classes[] = 'browser-ns4';
	elseif($is_safari) $classes[] = 'browser-safari';
	elseif($is_chrome) $classes[] = 'browser-chrome';
	elseif($is_IE) $classes[] = 'browser-ie';
	else $classes[] = 'browser-unknown';
	if($is_iphone) $classes[] = 'browser-iphone';
	return $classes;
}

/* Add to the Body Class filter
------------------------------------------------ */
add_filter('post_class', 'lt3_add_to_body_class');
add_filter('body_class', 'lt3_add_to_body_class');
function lt3_add_to_body_class($classes)
{
	global $post;
	if (!is_front_page() && !is_search())
	{
		$classes[] = 'not-front-page';
		$classes[] = 'page-'.$post->post_name;
	}
	elseif (is_front_page())
	{
		$classes[] = 'front-page';
	}
	return $classes;
}

/* HTML5 friendly figure tags instead of captions
------------------------------------------------ */
add_filter('img_caption_shortcode', 'lt3_img_caption_shortcode_filter',10,3);
function lt3_img_caption_shortcode_filter($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));
	if(1 > (int) $width || empty($caption)) return $val;
	$capid = '';
	if($id)
	{
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
	}
	return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '" style="width: '
	. (10 + (int) $width) . 'px">' . do_shortcode($content) . '<figcaption ' . $capid
	. 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}

/*

	Custom Theme Functions

------------------------------------------------ */

/* Add google analytics
------------------------------------------------ */
function lt3_show_google_analytics($analytics_key = '')
{
	if($analytics_key) : ?>
		<script>
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', '<?php echo $analytics_key; ?>']);
		  _gaq.push(['_trackPageview']);

		  (function()
		  {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  }
		  )();
		</script>
	<?php endif;
}

/* Function create a custom comment list
------------------------------------------------ */
function lt3_advanced_comment($comment, $args, $depth)
{
  $GLOBALS['comment'] = $comment; ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div class="comment-vcard">
      <?php echo get_avatar($comment,$size='56',$default='<path_to_url>'); ?>
    </div>
    <div class="comment-body">
      <div class="comment-author">
        <a href="<?php the_author_meta('user_url'); ?>">
          <?php printf(__('%s'), get_comment_author_link()) ?>
        </a> said:
      </div>
      <?php if ($comment->comment_approved == '0') : ?>
      <div>
        <em><?php _e('Your comment is awaiting moderation.') ?></em>
        <br>
      </div>
      <?php endif; ?>
      <div class="comment-text"><?php comment_text() ?></div>
      <div class="comment-meta">
        <small>on the <?php printf(__('%1$s'), get_comment_date('l, F j, Y')) ?>
          <?php if (current_user_can('edit_post')) : ?>
          (<?php edit_comment_link(__('Edit'),'','') ?><?php lt3_delete_comment_link() ?>)
          <?php endif; ?>
        </small>
      </div>
      <div class="reply">
        <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </div>
    </div>
<?php }

/* Function to add more edit buttons to comments
------------------------------------------------ */
function lt3_delete_comment_link($id)
{
  if(current_user_can('edit_post'))
  {
    echo ' | <a href="'.admin_url("comment.php?action=cdc&c=$id").'">Delete</a> | ';
    echo '<a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id").'">Spam</a>';
  }
}

/* Adds a back to parent category, page, etc link
------------------------------------------------
	Need to add functionality for post type, taxonomy,
------------------------------------------------ */
function lt3_back_to_parent_link(){
	global $post;
	$post = get_post($post);
	$category = get_the_category();
	if(is_attachment())
	{
		$post_parent = get_post($post->post_parent);
		$slug = get_permalink($post_parent->ID);
		$name = get_the_title($post_parent->ID);
	}
	else if(is_single())
	{
		$category = get_the_category();
		get_category_link($category[0]->term_id).'">'.$category[0]->cat_name;
		$slug = get_category_link($category[0]->term_id);
		$name = $category[0]->cat_name;
	}
	else
	{
		$slug = home_url();
		$name = get_bloginfo('name');
	}
	if($name)
	{
		echo '<a class="back-to-parent-link" href="'.$slug.'">&larr; Back to '.$name.'</a>';
	}
}

/* Sticky Notes
------------------------------------------------ */
function lt3_default_sticky_posts()
{
  if(LT3_ENABLE_STICKY_POSTS)
  {
	  get_template_part(LT3_TEMPLATE_PARTS_PATH . '/loop', 'sticky');
	}
}

/* Get the Comments Template
------------------------------------------------ */
function lt3_get_comments_template()
{
  if(LT3_ENABLE_GLOBAL_COMMENTS) comments_template();
}

/* Function to get categories and taxonomies for a post
------------------------------------------------ */
function lt3_get_taxonomies_terms_links()
{
	global $post, $post_id;
	$post = &get_post($post->ID); // get post by post id
	$post_type = $post->post_type; // get post type by post
	$taxonomies = get_object_taxonomies($post_type); // get post type taxonomies
	foreach($taxonomies as $taxonomy)
	{
		$terms = get_the_terms($post->ID, $taxonomy); // get the terms related to post
		if(!empty($terms))
		{
			$out = array();
			foreach($terms as $term)
				$out[] = '<a href="' .get_term_link($term->slug, $taxonomy) .'">'. $term->name .'</a>';
			$return = join(', ', $out);
		}
		return $return;
	}
}

/* Function to get Post Nav Links
------------------------------------------------ */
function lt3_get_single_nav_links()
{
	echo '<div class="next-single">';
	next_post_link('%link', 'Next Article &rarr;', TRUE);
	echo '</div>';
	echo '<div class="previous-single">';
	previous_post_link('%link', '&larr; Previous Article', TRUE);
	echo '</div>';
}

/* Function to get Category Nav Links
------------------------------------------------ */
function lt3_get_archive_nav_links()
{
	posts_nav_link(' &mdash; ', '&larr; Previous Page', 'Next Page &rarr;');
}

/* Functions to include site pagination
------------------------------------------------ */
function lt3_include_single_navigation()
{
	echo '<nav class="single-navigation clear-fix">';
	lt3_get_single_nav_links();
	echo '</nav>';
}

function lt3_include_page_pagination()
{
	if(lt3_has_page_pagination())
	{
		if(function_exists('wp_pagenavi'))
		{
			echo '<nav class="page-pagination">';
			wp_pagenavi(array('type' => 'multipart'));
			echo '</nav>';
		}
		else
		{
			lt3_include_page_navigation();
		}
	}
}

function lt3_include_page_navigation()
{
	if(lt3_has_page_pagination())
	{
		wp_link_pages(array(
			'before' => '<nav class="page-navigation">' . __('Pages:','lt3'),
			'after' => '</nav>',
			'nextpagelink' => __('Next page &rarr;','lt3'),
			'previouspagelink' => __('Previous &larr;','lt3'),
			'pagelink' => '%')
		);
	}
}

function lt3_include_archive_pagination()
{
	if(function_exists('wp_pagenavi'))
	{
		echo '<nav class="archive-pagination">';
		wp_pagenavi();
		echo '</nav>';
	}
	else
	{
		lt3_include_archive_navigation();
	}
}

function lt3_include_archive_navigation()
{
	echo '<nav class="archive-navigation">';
	lt3_get_archive_nav_links();
	echo '</nav>';
}

/* Default post meta information
------------------------------------------------ */
function lt3_include_post_meta()
{
  if(LT3_ENABLE_META_DATA)
  {
		echo '<p class="postmetadata">';
		echo '<span class="post-categories-time">';
		echo _e('Posted ');
		if(lt3_get_taxonomies_terms_links())
		{
			echo _e(' in ');
 			echo lt3_get_taxonomies_terms_links();
 			echo ', ';
		}
		echo 'on the ';
		the_time('jS \o\f F, Y');
		echo '.';
		if(LT3_ENABLE_GLOBAL_COMMENTS)
		{
			echo ' ';
			comments_popup_link('No Comments', '1 Comment &rarr;', '% Comments &rarr;', 'comments-link', '');
		}
		echo '</span><br>';
		the_tags('<span class="post-tags">Tags: ', ', ', '</span>');
		echo '</p>';
	}
}

/* Limit the number of words in a given output
------------------------------------------------ */
function lt3_excerpt($text_raw = '', $text_limit = 20, $text_echo = TRUE){
	$text = explode(' ', $text_raw);
	$ellipses = false;
	if(sizeof($text) > $text_limit){
		 for($counter = sizeof($text); $counter > $text_limit; $counter--){
			array_pop($text);
		 }
		 $output_text = implode(' ', $text);
		 $ellipses = true;
	}
	else
	{
		 $output_text = implode(' ', $text);
	}
	if($ellipses)
	{
		$output_text .= '&hellip;';
	}
	if($text_echo)
	{
		echo $output_text;
	}
	else
	{
		return	$output_text;
	}
}

/* Remove empty paragraph tags from the_content
------------------------------------------------ */
add_filter('the_content', 'lt3_remove_empty_paragraphs', 20, 1);
function lt3_remove_empty_paragraphs($content)
{
  $content = force_balance_tags($content);
  return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
}

/* Remove <p> tags around images in the editor
------------------------------------------------ */
add_filter('the_content', 'lt3_filter_ptags_on_images');
function lt3_filter_ptags_on_images($content)
{
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

/* Add Video Mode Transparent to all WP Embed Files
------------------------------------------------ */
add_filter('embed_oembed_html', 'lt3_add_video_wmode_transparent', 10, 3);
function lt3_add_video_wmode_transparent($html, $url, $attr)
{
	if(strpos($html, "<embed src=") !== false)
	{
		return str_replace('</param><embed', '</param><param name="wmode" value="opaque"></param><embed wmode="opaque" ', $html);
	}
	elseif(strpos ($html, 'feature=oembed') !== false)
	{
		return str_replace('feature=oembed', 'feature=oembed&wmode=opaque', $html);
	}
	else
	{
		return $html;
	}
}