<?php while(have_posts()) : the_post(); ?>

<article <?php post_class('page post-'. get_the_ID()); ?>>

  <h2 class="article-title"><?php the_title(); ?></h2>

  <?php if(has_post_thumbnail()) : ?>
  <figure class="post-thumbnail">
    <?php the_post_thumbnail('medium'); ?>
  </figure>
  <?php endif; ?>

  <div class="entry content">
    <?php the_content(); ?>
  </div>

</article>

<?php lt3_include_page_pagination(); ?>

<?php lt3_get_comments_template(); ?>

<?php endwhile; ?>