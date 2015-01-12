<?php
global $post;
setup_postdata($post);
?>

<section id="<?= $post->post_name ?>" class="features">

  <div class="grid">

  <?php
  //
  //
  // FEATURED CONFERENCERS
  $featured_sessions = get_field('featured');
  foreach($featured_sessions as $k=>$featured_session):


    $session = new session($featured_session['id']);



    // the conference
    $id = $conference['conference'];
    $title = get_the_title($id);
    $url = get_the_permalink($id);
    // the conferencer
    $about = get_field('about', $id);
    $name = $about[0]['infos'][0]['name'];
    $job = $about[0]['infos'][0]['job'];
    // the time
    $timeframe = get_field('timeframe', $id);
    $day = get_the_title($timeframe[0]['day']);
    $date = get_field('date',$timeframe[0]['day']);
    $frameID = $timeframe[0]['frame_'.$timeframe[0]['day']];
    // the place
    $location = $timeframe[0]['room']->post_title;
    $color = get_field('color',$timeframe[0]['room']->ID);
    // the image
    $image = $conference['image']; // custom image
    if(!has($image)) $image = $about[0]['infos'][0]['image'] // conferencer image fallback

    ?>

    <figure class="panel <?= $k%2==0 ? 'left' : 'right' ?> <?= $k<2 ? 'top' : 'bottom' ?>" itemprop="performer" itemscope="" itemtype="http://schema.org/Person">

      <span class="image">
        <img src="<?= $image['sizes']['wide'] ?>" alt="" itemprop="image"/>
      </span>

      <figcaption class="infos">
        <div class="wrap">

          <button class="btn seamless toggle favorite icon-only" toggle-content="<?= __('À mon horaire', 'waq') ?>" schedule="3|10">
            <span>
              <?= __('Ajouter à mon horaire', 'waq') ?>
            </span>
          </button>

          <div class="speaker">
            <span class="name title" itemprop="name"><?= $name ?></span>
            <span class="job" itemprop="jobTitle"><?= $job ?></span>
          </div>

          <a class="session btn link" href="<?= $url ?>">
            <span class="wrap">

              <span class="meta dark">
                <time class="date" datetime="<?= $date ?>">
                  <span class="v-align">
                    <span class="sub title"><?= substr($day,0,3) ?></span>
                    <span class="small title"><?= '18' ?></span>
                  </span>
                </time>

                <time class="time" itemprop="startDate" datetime="2014-03-19 14:00">
                  <span class="v-align">
                    <span class="sub title">10h</span>
                    <span class="small title">30</span>
                  </span>
                </time>
              </span>

              <span class="session-title sub title"><?= $title ?></span>

            </span>
          </a>

        </div>
      </figcaption>

    </figure>

    <?php endforeach; ?>
  </div>

</section>
