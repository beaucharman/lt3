<?php while(have_posts()) : the_post(); ?>

<article <?php post_class('category post-'. get_the_ID()); ?>>

  <h3 class="article-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

  <?php lt3_include_post_meta(); ?>

  <?php if(has_post_thumbnail()) : ?>
  <figure class="post-thumbnail">
    <?php the_post_thumbnail('thumbnail'); ?>
  </figure>
  <?php endif; ?>

  <div class="entry excerpt">
    <?php the_excerpt(); ?>
  </div>

  <footer class="article-footer">
    <a class="read-more" href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php lt3_read_more_text(); ?></a>
  </footer>

</article>

<?php endwhile; ?>