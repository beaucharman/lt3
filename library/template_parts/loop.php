<?php while(have_posts()) : the_post(); ?>

<article <?php post_class('post-'. get_the_ID()); ?>>

  <h2 class="article-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	
  <?php lt3_include_default_meta(); ?>

  <?php if(has_post_thumbnail()) : ?>
  <figure class="post-thumbnail">
    <?php the_post_thumbnail('medium'); ?>
	</figure>
	<?php endif; ?>

	<div class="entry <?php echo (is_single()) ? 'excerpt' : 'content'; ?> content">
		<?php (is_single()) ? the_excerpt() : the_content(); ?>
	</div>

</article>

<?php lt3_get_comments_template(); ?>

<?php endwhile; ?>