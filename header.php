<?php
/**
 * Header
 * ========================================================================
 * header.php
 * @version    2.1 | 6th June 2013
 * @package    WordPress
 * @subpackage lt3
 * @author     Beau Charman | @beaucharman | http://www.beaucharman.me
 * @link       https://github.com/beaucharman/lt3
 * @license    MIT license
 * ======================================================================== */ ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>
      <?php lt3_title(); ?>
    </title>

    <meta name="description" content="<?php lt3_meta_tag_description(); ?>">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?v=' .  LT3_STYLE_CACHE_REFRESH; ?>" media="all">
    <link rel="pingback" href="<?php bloginfo("pingback_url"); ?>">

    <!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php /* Google Webmaster Tools and Analytics */
    if (! LT3_DEVELOPMENT_MODE) : global $lt3_site_settings; ?>
    <!-- <meta name="google-site-verification" content=""> -->
    <!-- <script>
      var _gaq=[['_setAccount','<?php echo $lt3_site_settings['google_analytics']; ?>'],['_trackPageview']];
      (function(d,t) {var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
      g.src='//www.google-analytics.com/ga.js';
      s.parentNode.insertBefore(g,s)}(document,'script'));
    </script> -->
    <?php endif  ?>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>

    <div class="page-wrap">

      <header role="banner" class="page-header">

        <?php /* Site title */ ?>
        <?php if (is_home() || is_front_page()) echo '<h1>'; ?>
        <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?> home page link" class="site-title">
          <?php bloginfo('name'); ?>
        </a>
        <?php if (is_home() || is_front_page()) echo '</h1>'; ?>

        <?php /* Site description */ ?>
        <?php if (get_bloginfo('description')): ?>
        <p class="site-description"><?php bloginfo('description'); ?></p>
        <?php endif; ?>

        <?php /* Header sibar widgets */ ?>
        <?php if (is_active_sidebar('header-sidebar-widgets'))
          dynamic_sidebar('header-sidebar-widgets'); ?>

        <?php /* Display the page header menu */ ?>
        <?php lt3_page_header_menu(); ?>
      </header>

      <section class="page-content">