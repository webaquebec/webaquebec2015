<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section>
  <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable">
    </h1>
	
</section>

<?php endwhile; endif; ?>
	
<?php get_footer(); ?>