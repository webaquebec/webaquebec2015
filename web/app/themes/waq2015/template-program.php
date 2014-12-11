
<?php
/*
 * Template Name: Programmation
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section class="<?= $post->post_name ?>">

  <?= get_the_title() ?>
  
</section>

<?php endwhile; endif; ?>
  
<?php 
get_footer_once();
?>