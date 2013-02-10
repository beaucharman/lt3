  </section>

  <footer class="page-footer">

    <?php if(is_active_sidebar('footer-sidebar-widgets')) dynamic_sidebar('footer-sidebar-widgets'); ?>

    <p class="site-information">&copy;<?php echo date('Y'); ?>&nbsp;<?php bloginfo('name'); ?></p>

  </footer>

</ div>

<?php wp_footer(); ?>

</body>
</html>
