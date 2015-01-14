<?php
/*
 * Template Name: Programmation
 */
get_header_once();
global $current_user;
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="program dark">

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
      if($schedules->have_posts()): ?>    

      <nav class="days">
        <ul>
          <?php foreach($schedules->posts as $post): ?>
          <li>
            <button class="btn" schedule-ID="<?= $post->ID ?>" >
              <div>
                <span class="sub title"><?= get_the_title($post->ID) ?></span>
                <span class="small title"><?= strftime('%e %B %Y', DateTime::createFromFormat('d/m/y', get_field('date', $post->ID))->getTimestamp()) ?></span>
              </div>
            </button>
          </li>
          <?php endforeach; ?>
        </ul>
      </nav>
    <?php
    wp_reset_postdata();
    endif; 
    ?>

    </div>
  </hgroup>


 <!--  <nav class="filters dark">
    <div class="container">
      <h3 class="title border-middle">
        <?= __('Filtrer par thématique', 'waq') ?>
      </h3>
      <div class="group">
        <button class="btn toggle">
          <span>Accessibilité</span>
        </button>
      </div>
    </div>
  </nav> -->


  <?php if($schedules->have_posts()): ?>
  <div class="schedules">
  <?php
  // loop throught schedules
  foreach($schedules->posts as $post):
    ?>
    <article class="schedule container" schedule-ID="<?= $post->ID ?>">
    <?php
    // get schedule object
    $schedule = new schedule(array(
      'grid_ID'=>$post->ID,
      'table_class' => 'light',
      'render_thead'=> true,
      'render_time_labels'=> true,
    ));
 
    // loop throught each column header of the grid
    while($schedule->have_headers()):
      $header = $schedule->the_header();
      ?>
      <div class="btn dark <?= $header->class ?>">
        <div class="wrap">
          <h3>
            <span class="small title"><?= __('Salle','waq') ?></span>
            <span class="title"><?= $header->title ?></span>
            <span class="subtitle"><?= $header->subtitle ?></span>
          </h3>
        </div>
      </div>
      <?php
      $schedule->after_header();
    endwhile;

    // loop throught each session of the grid
    while($schedule->have_sessions()):
      $session = $schedule->the_session();
      ?>
      <div class="btn light <?= $session->location->class ?>">
        <div class="wrap">
          <h3 class="title"><?= $session->title ?></h3>
        </div>
      </div>
      <?php
      $schedule->after_session();
    endwhile;
    
    if(is_user_logged_in() && in_array('administrator', $current_user->roles))
      $schedule->print_messages();
      $schedule->print_errors();
    ?>
    </article>
  <?php endforeach; ?>
  </div>
  <?php
  wp_reset_postdata();
  endif; 
  ?>


</section>

<?php endwhile; endif; ?>
  
<?php 
get_footer_once();
?>