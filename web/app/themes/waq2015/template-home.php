<?php
/*
 * Template Name: Accueil
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section class="<?= $post->post_name ?>">

  <?= get_the_title() ?>  
  
</section>

<?php endwhile; endif; ?>

<?php 
//  PROGRAMMATION ------> ID 4
include_page_part(4);
?>


  
<?php 
get_footer_once();
?>