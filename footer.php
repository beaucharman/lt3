  </section>

  <footer class="page-footer">

    <?php if(is_active_sidebar('footer-sidebar-widgets')) dynamic_sidebar('footer-sidebar-widgets'); ?>

    <p class="site-information">&copy;<?php echo date('Y'); ?>&nbsp;<?php echo bloginfo('name'); ?></p>

  </footer>

</div>

<?php wp_footer(); ?>

<?php global $lt3_site_settings; lt3_show_google_analytics($lt3_site_settings['google_analytics']); ?>

</body>
</html>
