<?php $sticky_loop = new WP_Query(array('posts_per_page' => LT3_NUMBER_OF_STICKY_POSTS, 'post__in'  => get_option('sticky_posts'), 'ignore_sticky_posts' => 1)); ?>

<?php if($sticky_loop->have_posts()) : ?>

<section class="featured">

<?php while($sticky_loop->have_posts()) : $sticky_loop->the_post(); ?>

<?php if(!is_sticky()) continue; ?>

  <article <?php post_class('sticky post-'. get_the_ID()); ?>>

    <h3 class="sticky-article-title"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>

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

</section>

<?php endif; ?>