<?php
/**
 * Sidebar
 * ========================================================================
 * sidebar.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 * ======================================================================== */ ?>
<aside class="primary-sidebar">
<?php
  if (is_active_sidebar('primary-sidebar-widgets'))
  {
    dynamic_sidebar('primary-sidebar-widgets');
  }
?>
</aside>
