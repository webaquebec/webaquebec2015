<?php
/*
 * Template Name: HOME
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


<?php 
// PAGE PART ------> ID 8
query_posts(array(
    'post_type' => 'page',
    'p'         => 8
    //  'p'         => icl_object_id(8, 'page', true) // AVEC WPML
    ));
get_template_part('template_custom'); 
?>

<?php endwhile; endif; ?>
  
<?php 
if(has($main_template)){
  get_footer();
}else{
  wp_reset_query();
}
?>