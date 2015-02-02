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

      <article class="schedule">
        <h2 class="title border-middle">
          <span>
            <span class="sub title"><?= get_the_title($post->ID) ?></span>
            <span class="small title"><?= strftime('%e %B %Y', DateTime::createFromFormat('d/m/y', get_field('date', $post->ID))->getTimestamp()) ?></span>
          </span>
        </h2>
        <div class="profile-sessions">
          <ul>
          <?php foreach($sessions[$post->ID] as $session): ?>
            <li class="session btn light <?= $session->location->class ?> <?php if($session->speaker->image) echo ' has-thumb' ?>" location="<?= $session->location->ID ?>" >
              <div class="wrap">

               <?php if($session->speaker->image): ?>
                <div class="thumb">
                  <img src="<?= $session->speaker->image['sizes']['thumbnail'] ?>" alt="<?= $session->speaker->name ?>" />
                </div>
                <?php endif; ?>

                <div class="location border-bottom"  <?php if(has($session->location->color)) echo 'style="border-color:'.$session->location->color.'"'?> >
                  <span class="small title"><?= strftime('%kH%M', $session->time->start) ?> <?= __('à')  ?> <?= strftime('%kH%M', $session->time->end) ?></span>
                  <span class="small sub title">
                    <?= __('Salle', 'waq').' '.$session->location->title ?>  &#183; <?= $session->location->subtitle ?>
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

<?php else : ?>
  <span class="small title"><?= __('Vous êtes maintenant prêt à créer votre horaire WAQ.','waq') ?></span>
  <span class="small title"><?= __('Retournez à la section','waq') ?> <a href="<?= get_home_url() ?>/#programmation" ><?= __('programmation','waq') ?></a> <?= __('pour ajouter des conférences à votre horaire.','waq') ?></span>
<?php endif; ?>