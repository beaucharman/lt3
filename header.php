<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  
  <title><?php lt3_title(); ?></title>
  
  <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
  <meta name="description" content="<?php lt3_meta_tag_description(); ?>">
  <meta name="viewport" content="width=device-width">

  <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" media="all">
  <link rel="pingback" href="<?php bloginfo("pingback_url"); ?>">

  <!--[if IE]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <?php wp_head(); ?>
  
  <script>
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php global $lt3_site_settings; echo $lt3_site_settings['google_analytics']; ?>']);
    _gaq.push(['_trackPageview']);

    (function() 
    {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    }
    )();
  </script>

</head>

<body <?php body_class(); ?>>

<div class="page-wrap">

  <header role="banner" class="page-header">
	
    <hgroup>

      <h1 class="site-title">
        <a href="<?php echo home_url(); ?>/" title="<?php echo the_title_attribute(); ?>" >
          <?php bloginfo('name'); ?>
        </a>
      </h1>

      <h2 class="site-description"><?php bloginfo('description'); ?></h2>

    </hgroup>

    <?php if(is_active_sidebar('header-sidebar-widgets')) dynamic_sidebar('header-sidebar-widgets'); ?>

    <?php lt3_page_header_menu(); ?>

  </header>

  <section role="content" class="page-content">