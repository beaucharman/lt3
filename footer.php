<?php
/**
 * Footer
 * ========================================================================
 * footer.php
 * @version 2.0 | April 1st 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 * ======================================================================== */ ?>
      </section> <!-- /.content -->

      <footer class="page-footer">
        <?php if (is_active_sidebar('footer-sidebar-widgets'))
              { dynamic_sidebar('footer-sidebar-widgets'); } ?>

        <?php lt3_page_footer_menu(); ?>

        <p class="site-information">
          &copy;<?php echo date('Y'); ?>&nbsp;<?php echo bloginfo('name'); ?>
        </p>

      </footer>

    </div> <!-- /.page-wrap -->

    <?php wp_footer(); ?>

  </body>
</html>