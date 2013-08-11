<!doctype html>
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

    <meta name="description" content="<?php lt3_meta_description(); ?>">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="<?php echo get_stylesheet_uri() . '?v=' . LT3_STYLE_CACHE_BREAK; ?>" media="all">
    <link rel="pingback" href="<?php bloginfo("pingback_url"); ?>">

    <!--[if IE]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <?php if (! LT3_DEVELOPMENT_MODE) : ?>
    <!-- Google Analytics Code -->
    <?php endif; ?>

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>

    <div class="page-wrap container">

      <header class="page-header" role="banner">

        <?php /* Site title */ ?>
        <?php if (is_home() || is_front_page()) { echo '<h1 class="site-heading">'; } ?>
        <a href="<?php echo home_url('/'); ?>" title="<?php bloginfo('name'); ?> home page link" class="site-title">
          <?php bloginfo('name'); ?>
        </a>
        <?php if (is_home() || is_front_page()) { echo '</h1>'; } ?>

        <?php /* Site description */ ?>
        <?php if (get_bloginfo('description')) : ?>
        <div class="site-description"><?php bloginfo('description'); ?></div>
        <?php endif; ?>

        <?php /* Display the main navigation menu */ ?>
        <?php lt3_main_navigation_menu(); ?>

      </header>

      <section class="page-content">
