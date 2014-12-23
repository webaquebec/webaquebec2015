<?php get_header_once(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section>
  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
  </div>
	
</section>

<?php endwhile; endif; ?>
	
<?php get_footer_once(); ?>