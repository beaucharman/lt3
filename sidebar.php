<?php
/**
 * Sidebar
 * ========================================================================
 * sidebar.php
 * @version 2.0 | April 12th 2013
 * @package lt3
 * @author  Beau Charman | @beaucharman | http://beaucharman.me
 * @link    https://github.com/beaucharman/lt3
 * @license MIT license
 * ======================================================================== */ ?>
<aside class="primary-sidebar">
<?php
  if (is_active_sidebar('primary-sidebar-widgets'))
  {
    dynamic_sidebar('primary-sidebar-widgets');
  }
?>
</aside>