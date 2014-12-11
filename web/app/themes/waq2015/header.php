<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
		
		<!-- dns prefetch -->
		<link href="//www.google-analytics.com" rel="dns-prefetch">
		
		<!-- meta -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width,initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
		<meta name="description" content="<?php bloginfo('description'); ?>" />
		
		<!-- icons -->
		<link href="<?= get_bloginfo('siteurl') ?>/favicon.ico" rel="shortcut icon">
		<!-- <link href="<?= get_bloginfo('siteurl') ?>/img/icons/touch.png" rel="apple-touch-icon-precomposed"> -->
			
		<?php // HASHBANG ?>
		<?php 
		if(get_post_type()=="page" && $post->ID != 2):
		// if(get_post_type()=="page" && $post->ID != icl_object_id(2, 'page', true)): // AVEC WPML?>
		<script type="text/javascript">var bang = true;</script>
		<?php endif; ?>

		<!-- css + javascript -->
		<?php wp_head(); ?>
		<!-- author's styles -->
		<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
		
	</head>
	<body <?php body_class(); ?>>
		<div class="wrapper">
			<header role="banner" class="container">
				
				<div class="logo">
					<a href="<?php echo home_url(); ?>">
						<img src="<?= get_bloginfo('siteurl') ?>/img/logo.png" alt="Logo">
					</a>
				</div>
			
				<nav role="navigation" class="main">
					<?php wp_nav_menu( array(
						'theme_location'  => 'main'
					)); ?> 
				</nav>
			
			</header>

			<main role="main" class="container">