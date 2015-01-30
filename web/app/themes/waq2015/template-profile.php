<?php
/*
 * Template Name: Profile
 */
global $current_user;
get_currentuserinfo();
$loggedin = is_user_logged_in();
$isTeam = current_user_can( 'edit_posts' );
if(!$loggedin){
  wp_redirect(get_permalink(get_ID_from_slug('connexion')));
  exit;
}
get_header_once();
?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="account">

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
        <?= $current_user->data->display_name ?>
        <div class="border-bottom"></div>
      </h1>

    </div>


  </header>

</section>

<section class="program">

</section>

<?php endwhile; endif; ?>

<?php
get_footer_once();
?>


