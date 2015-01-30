<?php
global $user_ID;
$user_ID = $post->ID;
$favorites_str = get_field('favorites','user_'.$user_ID);

get_header_once();
?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="account">

  <header>

    <div class="container">

      <?php var_dump($post); ?>
      <h1 class="main title border-left">
        <small><?= __('L\'horaire de', 'waq') ?></small>
        <?= $current_user->data->display_name ?>
        <div class="border-bottom"></div>
      </h1>

    </div>


  </header>

</section>

<?php
//
//
// get user_schedule
get_template_part( 'user-schedule' );
?> 

<?php endwhile; endif; ?>

<?php
wp_reset_query();
get_footer_once();
?>


