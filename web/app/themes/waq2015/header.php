<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <!-- dns prefetch -->
    <link href="//www.google-analytics.com" rel="dns-prefetch">
    <!-- meta -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />

    <?php
    // SET VARIABLES
    $is404 = is_404();
    $is_home = get_page_template_slug()=="template-home.php";
    $bang = get_post_type()=="page" && get_field('bang');
    $scheduleStatus = get_field('my_schedule', 'options');

    //
    //
    // SEO, META, OG TAGS
    if(!$is404) acf_seo(); // functions_seo.php
    ?>

    <!-- icons -->
    <link href="<?= get_home_url() ?>/favicon.ico" rel="shortcut icon">

    <?php
    //
    //
    // HASHBANG
    if($bang): ?>
    <script type="text/javascript">var bang = true;</script>
    <div class"bang-coverall"></div>
    <?php endif; ?>

    <!-- css + javascript -->
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <div class="wrapper<?php if(is_array($scheduleStatus)){echo ' ' . $scheduleStatus[0];} ?>">
      <header role="banner">

        <?php
        if($is_home) get_template_part('template-intro');
        ?>

        <nav role="navigation">
          <div class="intro logo waq">
            <a href="/">
              <img src="/img/@2x/logo-waq.png" alt="<?= __('Web à Québec', 'waq') ?>" />
            </a>
          </div>

          <?php wp_nav_menu( array(
            'theme_location'  => 'secondary',
            'menu_class' => 'secondary'
          )); ?>

          <?php wp_nav_menu( array(
            'theme_location'  => 'main',
            'menu_class' => 'main'
          )); ?>
        </nav>

      </header>

      <main role="main">