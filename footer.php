<?php
/**
 * Footer
 * ========================================================================
 * footer.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 * ======================================================================== */ ?>
      </section> <!-- /.content -->

      <footer class="page-footer">

        <?php /* Footer sidebar widgets */
          if (is_active_sidebar('footer-sidebar-widgets'))
          {
            dynamic_sidebar('footer-sidebar-widgets');
          }
        ?>

        <?php /* Page footer menu */ ?>
        <?php lt3_page_footer_menu(); ?>

        <?php /* Site information */ ?>
        <p class="site-information">
          &copy;<?php echo date('Y'); ?>&nbsp;<?php echo bloginfo('name'); ?>
        </p>

      </footer>

    </div> <!-- /.page-wrap -->

    <?php wp_footer(); ?>
  </body>
</html>