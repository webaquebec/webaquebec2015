<?php
/*
 * Template Name: Programmation
 */

if(!is_ajax()):

//
//
// REGULAR REQUEST

get_header_once();
global $current_user;
get_currentuserinfo();
$loggedin = is_user_logged_in();
$favorites_str = '';

if($loggedin) $favorites_str = get_field('favorites','user_'.$current_user->ID);
if(have_posts()): while(have_posts()): the_post();
$self_url = remove_hashbang(get_permalink());
?>

<section id="<?= $post->post_name ?>" class="program">

  <hgroup>
    <div class="container">
      <h1 class="main title border-left">
        <?= get_the_title() ?>
        <div class="border-bottom expandable"></div>
      </h1>
      <?php $schedules = new WP_query(array(
        'post_type' => 'grid',
        'posts_per_page' => -1,
        'orderby'=> 'menu_order',
      ));
      if($schedules->have_posts()):
        $activeSchedule = has(isset($_COOKIE['schedule'])&&!empty($_COOKIE['schedule'])) ? $_COOKIE['schedule'] : $schedules->posts[0]->ID;
        $active = false;
        $isToday = false;
        $bypassCookie = false;
        $today = date('d/m/y');
        ?>

      <div class="days">
        <nav class="sticky">
          <ul>
            <?php
            foreach($schedules->posts as $k=>$post):
              $date = strftime('%d/%m/%y', DateTime::createFromFormat('d/m/y', get_field('date', $post->ID))->getTimestamp() );
              $isToday = $today == $date;
              if($isToday  || $today > $date ){
                $bypassCookie = true;
              }
              $active = (($bypassCookie && $isToday) || (!$bypassCookie && $post->ID==$activeSchedule) );
            ?>
            <li>
              <button class="btn toggle<?php if($active) echo ' active' ?>" schedule="<?= $post->ID ?>" >
                <div class="wrap">
                  <span class="sub title"><?= get_the_title($post->ID) ?></span>
                  <span class="small title"><?= strftime('%e %B %Y', DateTime::createFromFormat('d/m/y', get_field('date', $post->ID))->getTimestamp()) ?></span>
                </div>
              </button>
            </li>
            <?php endforeach; ?>
          </ul>
        </nav>
      </div>
    <?php
    wp_reset_postdata();
    endif;
    ?>

    </div>
  </hgroup>

<?php
//
//
// FILTERS
$filters = get_terms( 'theme', array(
  'hide_empty' => 1,
 ));
if(has($filters)):
?>
   <nav class="filters">
    <div class="container">
      <h3 class="title toggle">
        <?= __('Filtrer par thématique', 'waq') ?>
      </h3>

      <div class="content">
      <?php foreach($filters as $filter): ?>
        <button class="filter btn toggle" theme="<?= $filter->term_id ?>">
          <span><?= $filter->name ?></span>
        </button>
      <?php endforeach; ?>
      </div>
    </div>
  </nav>
<?php endif; ?>

  <?php if($schedules->have_posts()): ?>
  <div class="schedules">
  <?php
  // loop throught schedules
  foreach($schedules->posts as $post):
    $date = strftime('%d/%m/%y', DateTime::createFromFormat('d/m/y', get_field('date', $post->ID))->getTimestamp() );
    $isToday = $today == $date;
    if($isToday  || $today > $date ){
      $bypassCookie = true;
    }
    $active = (($bypassCookie && $isToday) || (!$bypassCookie && $post->ID==$activeSchedule) );
    ?>
    <article  class="schedule<?php if($post->ID==$activeSchedule) echo ' active' ?>"
              schedule="<?= $post->ID ?>"
              <?php if(!$active): ?>
              lazy-load="<?= $self_url ?>ajax/<?= $post->ID ?>"
              lazy-callback="initFavorites|enableMobileSchedules"
              <?php endif; ?>
    >
    <?php
    //
    // PRINT ONLY ACTIVE SCHEDULE
    if($post->ID==$activeSchedule):

      //
      // format for time labels
      $time_labels_format = '<div class="time">'.
                              '<span class="sub title">%kh</span>'.
                              '<span class="small title">%M</span>'.
                            '<div>';

      // get schedule object
      $schedule = new schedule(array(
        'grid_ID'=>$post->ID,
        'table_class' => 'light',
        'render_thead'=> true,
        'render_time_labels' => true,
        'time_labels_format' => $time_labels_format,
      ));

      //
      // loop throught each column header of the grid
      if($schedule->have_sessions()):
        while($schedule->have_headers()):
          $header = $schedule->the_header();
          ?>
          <div class="location" style="border-color:<?= $header->color ?>;" location="<?= $header->ID ?>" >
            <span class="sub title"><?= __('Salle','waq') ?></span>
            <span class="title"><?= $header->title ?></span>
            <span class="note title"><?= $header->subtitle ?></span>
          </div>
          <?php
          $schedule->after_header();
        endwhile;
      endif;

      //
      // loop throught each session of the grid
      if($schedule->have_sessions()):
        while($schedule->have_sessions()):
          $session = $schedule->the_session();
          if($session->location->hide):
          ?>

          <div class="pause">
            <h3 class="sub title"><?= $session->title ?></h3>
          </div>

          <?php elseif($session->location->class=='pause'||$session->location->class == 'lunch'): ?>

          <div class="session <?= $session->location->class ?> <?= $wide ? 'wide' : 'small' ?>" themes>
            <h3 class="sub title">
              <span class="location">
                <?= ($session->location->class!='pause' ? __('Salle', 'waq').' ' : '').$session->location->title?>
              </span>
              <span class="separator">·</span>
              <?= $session->title ?>
            </h3>
          </div>

          <?php else:
          $themes = '|';
          foreach($session->themes as $theme){
            $themes .= $theme->term_id.'|';
          }
          $wide = $session->columns->span > 1;
          ?>
          <div>
            <div class="session btn light <?= $session->location->class ?> <?= $wide ? 'wide' : 'small' ?><?php if($session->speaker->image) echo ' has-thumb' ?>" location="<?= $session->location->ID ?>" themes="<?= $themes ?>" >
              <div class="wrap">

                <?php if($wide && $session->speaker->image): ?>
                  <div class="thumb">
                    <img src="<?= $session->speaker->image['sizes']['thumbnail'] ?>" alt="<?= $session->speaker->name ?>" />
                  </div>
                <?php endif; ?>

                <button class="btn seamless toggle favorite icon-only<?php if(session_is_favorite($session->ID, $favorites_str)) echo ' active' ?>" session="<?= $session->ID ?>">
                  <span>
                    <?= __('Ajouter à mon horaire', 'waq') ?>
                  </span>
                </button>

                <div class="location border-bottom">
                  <span class="small sub title">
                    <?= __('Salle', 'waq').' '.$session->location->title ?>
                  </span>
                </div>

                <a href="<?= $session->permalink ?>">
                  <h3 class="session-title title"><?= $session->title ?></h3>

                  <div class="speaker">
                    <?php if(!$wide && $session->speaker->image): ?>
                    <div class="thumb">
                      <img src="<?= $session->speaker->image['sizes']['thumbnail'] ?>" alt="<?= $session->speaker->name ?>" />
                    </div>
                    <?php endif; ?>

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
            </div>
          </div>

          <?php
          endif;
          $schedule->after_session();
        endwhile;
      endif;

      //
      // Print messages and errors
      if(is_user_logged_in() && in_array('administrator', $current_user->roles)){
        $schedule->print_messages();
        $schedule->print_errors();
      }

    //
    // ENDIF - PRINT ONLY ACTIVE SCHEDULE
    endif;
    ?>
    </article>
  <?php endforeach; ?>
  </div>
  <?php
  wp_reset_postdata();
  endif;
  ?>


</section>

<?php
endwhile; endif;
get_footer_once();
?>

<?php
else:
//
//
// AJAX REQUEST

global $current_user;
get_currentuserinfo();
$loggedin = is_user_logged_in();
$favorites_str = '';
if($loggedin) $favorites_str = get_field('favorites','user_'.$current_user->ID);
$schedule_ID = $wp_query->query_vars['ajax'];
if(has($schedule_ID)):

  $post = get_post($schedule_ID);

  //
  // format for time labels
  $time_labels_format = '<div class="time">'.
                          '<span class="sub title">%kh</span>'.
                          '<span class="small title">%M</span>'.
                        '<div>';

  // get schedule object
  $schedule = new schedule(array(
    'grid_ID'=>$post->ID,
    'table_class' => 'light',
    'render_thead'=> true,
    'render_time_labels' => true,
    'time_labels_format' => $time_labels_format,
  ));

  //
  // loop throught each column header of the grid
  if($schedule->have_sessions()):
    while($schedule->have_headers()):
      $header = $schedule->the_header();
      ?>
      <div class="location" style="border-color:<?= $header->color ?>;" location="<?= $header->ID ?>" >
        <span class="sub title"><?= __('Salle','waq') ?></span>
        <span class="title"><?= $header->title ?></span>
        <span class="note title"><?= $header->subtitle ?></span>
      </div>
      <?php
      $schedule->after_header();
    endwhile;
  endif;

  //
  // loop throught each session of the grid
  if($schedule->have_sessions()):
    while($schedule->have_sessions()):
      $session = $schedule->the_session();
      if($session->location->hide):
      ?>

      <div class="pause">
        <h3 class="sub title"><?= $session->title ?></h3>
      </div>

      <?php elseif($session->location->class=='pause'||$session->location->class == 'lunch'): ?>

      <div class="session <?= $session->location->class ?> <?= $wide ? 'wide' : 'small' ?>" themes>
        <h3 class="sub title">
          <span class="location">
            <?= ($session->location->class!='pause' ? __('Salle', 'waq').' ' : '').$session->location->title?>
          </span>
          <span class="separator">·</span>
          <?= $session->title ?>
        </h3>
      </div>

      <?php else:
      $themes = '|';
      foreach($session->themes as $theme){
        $themes .= $theme->term_id.'|';
      }
      $wide = $session->columns->span > 1;
      ?>
      <div>
        <div class="session btn light <?= $session->location->class ?> <?= $wide ? 'wide' : 'small' ?><?php if($session->speaker->image) echo ' has-thumb' ?>" location="<?= $session->location->ID ?>" themes="<?= $themes ?>" >
          <div class="wrap">

            <?php if($wide && $session->speaker->image): ?>
              <div class="thumb">
                <img src="<?= $session->speaker->image['sizes']['thumbnail'] ?>" alt="<?= $session->speaker->name ?>" />
              </div>
            <?php endif; ?>

            <button class="btn seamless toggle favorite icon-only<?php if(session_is_favorite($session->ID, $favorites_str)) echo ' active' ?>" session="<?= $session->ID ?>">
              <span>
                <?= __('Ajouter à mon horaire', 'waq') ?>
              </span>
            </button>

            <div class="location border-bottom">
              <span class="small sub title">
                <?= __('Salle', 'waq').' '.$session->location->title ?>
              </span>
            </div>

            <a href="<?= $session->permalink ?>">
              <h3 class="session-title title"><?= $session->title ?></h3>

              <div class="speaker">
                <?php if(!$wide && $session->speaker->image): ?>
                <div class="thumb">
                  <img src="<?= $session->speaker->image['sizes']['thumbnail'] ?>" alt="<?= $session->speaker->name ?>" />
                </div>
                <?php endif; ?>

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
        </div>
      </div>

      <?php
      endif;
      $schedule->after_session();
    endwhile;
  endif;

  //
  // Print messages and errors
  if(is_user_logged_in() && in_array('administrator', $current_user->roles)){
    $schedule->print_messages();
    $schedule->print_errors();
  }


endif;
?>

<?php endif; ?>
