<?php while(have_posts()) : the_post(); ?>

<article <?php post_class('attachment post-'. get_the_ID()); ?>>

  <h3 class="article-title"><?php the_title(); ?></h3>

  <?php lt3_include_default_meta(); ?>

  <figure>
    <figcaption><?php global $post; echo $post->post_content; ?></figcaption>
    <?php echo wp_get_attachment_image($post->ID, 'full'); ?>
  <figure>

  <footer class="article-footer"><?php lt3_back_to_parent_link(); ?></footer>

</article>

<?php endwhile; ?>