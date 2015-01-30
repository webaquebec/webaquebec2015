<?php
/*
 * Template Name: Profile
 */
global  $wp_query, $current_user, $user_ID;
$vars = $wp_query->query_vars;
$user_ID = $current_user->ID;
$loggedin = is_user_logged_in();
$favorites_str = '';
if($loggedin) $favorites_str = get_field('favorites','user_'.$user_ID);

if(!$loggedin){
  wp_redirect(get_permalink(get_ID_from_slug('connexion')));
  exit;
}

if(isset($vars['update'])){
  $add = isset($_POST['add']) ? $_POST['add'] : [];
  $remove = isset($_POST['remove']) ? $_POST['remove'] : [];
  echo update_favorites($current_user->ID, $add, $remove);
  exit;
};

get_header_once();
?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="account single">

  <header>

    <div class="container">


      <?php
      // echo link to dashboard
      if(is_user_logged_in()): ?>
      <a class="logout-link note" href="<?= wp_logout_url() ?>"><?= __('Déconnexion','waq') ?></a>
      <?php endif; ?>

      <?php
      // echo link to dashboard
      if(is_user_logged_in() && in_array('administrator', $current_user->roles)): ?>
      <a class="dashboard-link note" href="/admin"><?= __('Administration du site','waq') ?></a>
      <?php endif; ?>


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
include( 'user-schedule.php' );
?> 

<?php endwhile; endif; ?>

<?php
wp_reset_query();
get_footer_once();
?>


