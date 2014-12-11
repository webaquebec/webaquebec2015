<?php
/*
 * Template Name: CUSTOM
 */
global $header_rendered;
$main_template = false;

if(!has($header_rendered)){
  $header_rendered = true;
  $main_template = true;
  get_header();
}
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section>

  <?= get_the_title() ?>
  
</section>

<?php endwhile; endif; ?>
  
<?php 
if(has($main_template)){
  get_footer();
}else{
  wp_reset_query();
}
?>