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
		$is404 = is_404();
		$is_home = get_page_template_slug()=="template-home.php";
		if(!$is404){
			acf_seo(); // functions_seo.php
		}
		?>

		<!-- icons -->
		<link href="<?= get_bloginfo('siteurl') ?>/favicon.ico" rel="shortcut icon">
			
		<?php // HASHBANG 
		$bang = get_post_type()=="page" && get_field('bang');
		if($bang):
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
				
				<nav role="navigation" class="main">
					<?php wp_nav_menu( array(
						'theme_location'  => 'main'
					)); ?> 
				</nav>
			

				<?php
				if($is_home){
				?>
				<section class="<?= $post->post_name ?>">
					<div class="bg">
						<?php
						$video = array(
								'mp4' => get_field('video_mp4'),
								'ogv' => get_field('video_ogv'),
								'webm' => get_field('video_webm'),
								'image' => get_field('video_image')
							);
						?>
						<video autoplay <?php if($video['image']): ?>poster="<?= $video['image']['url'] ?>"<?php endif; ?>>
				      <?php if($video['mp4']): ?><source src="<?= $video['mp4'] ?>" type="video/mp4" /><?php endif; ?>
				      <?php if($video['webm']): ?><source src="<?= $video['webm'] ?>" type="video/webm" /><?php endif; ?>
				      <?php if($video['ogv']): ?><source src="<?= $video['ogv'] ?>" type="video/ogg" /><?php endif; ?>
				 			<?= __('Votre navitageur ne supporte pas les vidéos', 'waq'); ?>
				    </video>
				  </div>
				</section>
				<?php } ?>

			</header>

			<main role="main" class="container">