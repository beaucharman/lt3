<?php
/**
 * Sidebar
 *
 * @version      2.1 | June 6th 2013
 * @package      WordPress
 * @subpackage   lt3
 */
?>

<aside class="sidebar sidebar__primary" role="complementary">
<?php
  if (is_active_sidebar('primary-sidebar-widgets'))
  {
    dynamic_sidebar('primary-sidebar-widgets');
  }
?>
</aside>
