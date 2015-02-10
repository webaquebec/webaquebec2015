<?php
/*
 * Template Name: Profile
 */
global  $wp_query, $current_user, $user_ID, $has_share;
$has_share = true;
$vars = $wp_query->query_vars;
$user_ID = $current_user->ID;
$loggedin = is_user_logged_in();
$favorites_str = '';

if(!$loggedin){
  wp_redirect(get_permalink(get_ID_from_slug('connexion')));
  exit;
}

if($loggedin) $favorites_str = get_field('favorites','user_'.$user_ID);

if(isset($vars['update'])){
  $add = isset($_POST['add']) ? $_POST['add'] : [];
  $remove = isset($_POST['remove']) ? $_POST['remove'] : [];
  echo update_favorites($current_user->ID, $add, $remove);
  exit;
};

if(isset($vars['export'])){
  $format = $vars['export'];
  if($format=='ics') require_once('export-ics.php');
  exit;
}

get_header_once();
?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="account single my-account">

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
        <small><?= __('Mon horaire', 'waq') ?></small>
        <?= $current_user->data->display_name ?>
        <div class="border-bottom"></div>
      </h1>

    </div>


  </header>

</section>


<section class="profile-schedule my-profile">
  <div class="container">

    <?php
    //
    //
    // USER SCHEDULE
    include( 'user-schedule.php' );
    ?>

    <div class="actions">

      <div class="share">
        <h3 class="title border-middle"><?= __('Partager mon horaire', 'waq') ?></h3>
        <div class="share-container">
          <span class='st_facebook_large' displayText='Facebook'></span>
          <span class='st_twitter_large' displayText='Tweet'></span>
          <span class='st_linkedin_large' displayText='LinkedIn'></span>
          <span class='st_email_large' displayText='Email'></span>
        </div>
      </div>

      <div class="export">
        <h3 class="title border-middle"><?= __('Exporter mon horaire', 'waq') ?></h3>
        <div class="export-container">
          <a href="/mon-horaire/export/ics" class="btn ics" target="_blank" rel="nofollow">
            <span><?= __('Vers mon calendrier (.ics)') ?></span>
          </a>
        </div>
      </div>

    </div>
  </div>
</section>

<?php endwhile; endif; ?>

<?php
wp_reset_query();
get_footer_once();
?>


