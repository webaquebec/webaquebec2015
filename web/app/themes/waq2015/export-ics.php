<?php
global $user_ID;
$favorites_str = get_field('favorites','user_'.$user_ID);

if(has($favorites_str)):

  $session_IDs = explode('|', $favorites_str);

  // create sessions array width grid IDs and session objects
  $sessions = [];
  foreach($session_IDs as $session_ID){
    if(has($session_ID)){
      $session = new session(intval($session_ID));
      if(!isset($sessions[$session->grid_ID])) $sessions[$session->grid_ID] = [];
      $sessions[$session->grid_ID][] = $session;
    }
  }
  // sort sessions by start time
  function sortByStartTime($a, $b){
    if($a->time->start == $b->time->start) return 0;
    return ($a->time->start < $b->time->start) ? -1 : 1;
  }

  $schedules = new WP_query(array(
      'post_type' => 'grid',
      'posts_per_page' => -1,
      'orderby'=> 'menu_order',
    ));

  ?>


  <?php if($schedules->have_posts()): while($schedules->have_posts()): $schedules->the_post(); ?>

  <?php
  if(isset($sessions[$post->ID])):
    usort($sessions[$post->ID], 'sortByStartTime');
    ?>

    <p>Session</p>

    <?php
  endif; ?>
  <?php endwhile; endif; ?>

<?php else : ?>
  <span class="small title"><?= __('Vous êtes maintenant prêt à créer votre horaire WAQ.','waq') ?></span>
  <span class="small title"><?= __('Retournez à la section','waq') ?> <a href="<?= get_home_url() ?>/#programmation" ><?= __('programmation','waq') ?></a> <?= __('pour ajouter des conférences à votre horaire.','waq') ?></span>
<?php endif; ?>