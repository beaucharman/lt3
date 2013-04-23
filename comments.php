<?php
/**
 * Comments
 * ------------------------------------------------------------------------
 * comments.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license GNU http://www.gnu.org/licenses/lgpl.txt
 * ------------------------------------------------------------------------ */ ?>
<?php if ( !defined( 'ABSPATH' ) ) exit;

if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
  die ( 'Please do not load this page directly. Thanks!' );

if ( post_password_required() )
{
  echo _e( 'This post is password protected. Enter the password to view comments.' );
  return;
}

if ( have_comments() ) : ?>

<h3 id="comments"><?php comments_number( 'No Responses', 'One Response', '% Responses' );?></h3>

<ol class="commentlist">
  <?php wp_list_comments( 'type=comment&callback=lt3_advanced_comment' ); ?>
</ol>

<div class="comments-navigation">
  <div class="comments-navigation-next-posts"><?php previous_comments_link() ?></div>
  <div class="comments-navigation-prev-posts"><?php next_comments_link() ?></div>
</div>

<?php else : /* this is displayed if there are no comments so far */ ?>

<?php if ( comments_open() ) : ?>

<?php else : // comments are closed ?>
<p class="comments-closed-message"><?php echo _e( 'Comments are closed.' ); ?></p>
<?php endif; ?>

<?php endif; ?>

<?php if ( comments_open() ) : ?>

<?php /* use comment_form(); for the generic comment form */ ?>

<div id="respond" class="clear">

  <h3><?php comment_form_title( 'Leave a Reply', 'Leave a Reply to %s' ); ?></h3>

  <div class="cancel-comment-reply">
    <?php cancel_comment_reply_link(); ?>
  </div>

  <?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
  <p><?php echo _e( 'You must be' ); ?> <a href="<?php echo wp_login_url( get_permalink() ); ?>">
    <?php echo _e( 'logged in' ); ?></a>
  <?php echo _e( 'to post a comment.' ); ?></p>
  <?php else : ?>

  <form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform">

  <?php if ( is_user_logged_in() ) : ?>

    <p><?php echo _e( 'Logged in as' ); ?> <a href="<?php echo home_url(); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.
    <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Log out of this account"><?php echo _e( 'Log out &rarr;' ); ?></a></p>

    <?php else : ?>

    <div>
      <input type="text" placeholder="Name&hellip;" name="author" id="author" value="<?php echo esc_attr( $comment_author ); ?>" size="22" tabindex="1" <?php if ( $req ) echo "aria-required='true'"; ?>>
      <label for="author"><span><?php echo _e( 'Name' ); ?></span> <?php if ( $req ) echo "*"; ?></label>
    </div>

    <div>
      <input type="email" placeholder="Email&hellip;" name="email" id="email" value="<?php echo esc_attr( $comment_author_email ); ?>" size="22" tabindex="2" <?php if ( $req ) echo "aria-required='true'"; ?>>
      <label for="email"><span><?php echo _e( 'Email' ); ?></span> <?php if ( $req ) echo "*"; ?> <small class="subtle-text">
        <?php echo _e( '( will not be published )' ); ?></small>
      </label>
    </div>

    <div>
      <input type="url" placeholder="Website&hellip;" name="url" id="url" value="<?php echo esc_attr( $comment_author_url ); ?>" size="22" tabindex="3">
      <label for="url"><span><?php echo _e( 'Website' ); ?></span></label>
    </div>

    <?php endif; ?>

    <p class="subtle-text"><?php echo _e( 'You can use these tags: ' ); ?><code><?php echo allowed_tags(); ?></code></p>

    <div>
      <textarea name="comment" placeholder="Your comment&hellip;" id="comment" cols="58" rows="10" tabindex="4"></textarea>
    </div>

    <div>
      <input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment &rarr;">
      <?php comment_id_fields(); ?>
    </div>

    <?php do_action( 'comment_form', $post->ID ); ?>

  </form>

  <?php endif; /* If registration required and not logged in */  ?>

</div>

<?php endif; ?>