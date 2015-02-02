<?php
global $wp_query, $user_ID, $has_share;
$has_share = true;
$vars = $wp_query->query_vars;
$profile = isset($vars['author_name']) ? get_user_by('slug', $vars['author_name']) : $vars['author'];
$user_ID = $profile->ID;
get_header();
?>
<section class="account single">

  <header>

    <div class="container">
      <h1 class="main title border-left">
        <small><?= __('L\'horaire de', 'waq') ?></small>
        <?= $profile->data->display_name ?>
        <div class="border-bottom"></div>
      </h1>

    </div>

  </header>
</section>


<section class="profile-schedule">
  <div class="container">
    <?php
    //
    //
    // USER SCHEDULE
    include( 'user-schedule.php' );
    ?>
  </div>
</section>

<?php
get_footer();
?>


