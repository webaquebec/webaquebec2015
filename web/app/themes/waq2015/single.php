<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section>

	
		<h3 class=""><?php the_title(); ?></h3>
		<?php the_content(); ?>

</section>

<?php endwhile; endif; ?>
	
<?php get_footer(); ?>