<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section>

</section>

<?php endwhile; endif; ?>
	
<?php get_footer(); ?>