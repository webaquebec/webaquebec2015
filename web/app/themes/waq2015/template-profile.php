<?php
/*
 * Template Name: Profile
 */
global $current_user, $wp_query;
$vars = $wp_query->query_vars;
get_currentuserinfo();
$loggedin = is_user_logged_in();
$favorites_str = '';
if($loggedin) $favorites_str = get_field('favorites','user_'.$current_user->ID);

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


$session_IDs = explode('|', $favorites_str);
$sessions = [];
foreach($session_IDs as $session_ID){
  if(has($session_ID)){
    $session = new session(intval($session_ID));
    if(!isset($sessions[$session->grid_ID])) $sessions[$session->grid_ID] = [];
    $sessions[$session->grid_ID][] = $session;
  }
}

$schedules = new WP_query(array(
        'post_type' => 'grid',
        'posts_per_page' => -1,
        'orderby'=> 'menu_order',
      ));
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
        <small><?= __('L\'horaire de', 'waq') ?></small>
        <?= $current_user->data->display_name ?>
        <div class="border-bottom"></div>
      </h1>

    </div>


  </header>

</section>

<section class="my-schedule">
  <div class="container">
    <?php if($schedules->have_posts()): while($schedules->have_posts()): $schedules->the_post(); ?>

    <?php if(isset($sessions[$post->ID])): ?>

    <article class="schedule">
      <h2 class="title border-middle">
        <span>
          <span class="sub title"><?= get_the_title($post->ID) ?></span>
          <span class="small title"><?= strftime('%e %B %Y', DateTime::createFromFormat('d/m/y', get_field('date', $post->ID))->getTimestamp()) ?></span>
        </span>
      </h2>
      <div class="my-sessions">
        <ul>
        <?php foreach($sessions[$post->ID] as $session): ?>
          <li class="session btn light <?= $session->location->class ?> <?php if($session->speaker->image) echo ' has-thumb' ?>" location="<?= $session->location->ID ?>" themes="<?= $themes ?>" >
            <div class="wrap">

              <div class="thumb">
                <img src="<?= $session->speaker->image['sizes']['thumbnail'] ?>" alt="<?= $session->speaker->name ?>" />
              </div>

              <div class="location border-bottom">
                <span class="small sub title">
                  <?= __('Salle', 'waq').' '.$session->location->title ?>
                </span>
              </div>

              <a href="<?= $session->permalink ?>">
                <h3 class="session-title title"><?= $session->title ?></h3>

                <div class="speaker">
                  <h4 class="infos">
                    <span class="wrap">
                      <span class="name small title"><?= $session->speaker->name ?></span>
                      <?php if(has($session->speaker->job)) : ?>
                      <span class="job note"><?= $session->speaker->job ?></span>
                      <?php endif; ?>
                    </span>
                  </h4>
                </div>
              </a>
            </div>
          </li>
        <?php endforeach ?>
        </ul>
      </div>
    </article>

    <?php endif; ?>

    <?php endwhile; endif; ?>
  </div>
</section>

<?php endwhile; endif; ?>

<?php
wp_reset_query();
get_footer_once();
?>


