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
    $image = $featured_session['image']; // custom image
    if(!has($image)) $image = $this->speaker->image; // conferencer image fallback
    ?>

    <figure class="panel <?= $k%2==0 ? 'left' : 'right' ?> <?= $k<2 ? 'top' : 'bottom' ?>" itemprop="performer" itemscope="" itemtype="http://schema.org/Person">

      <span class="image">
        <img src="<?= $image['sizes']['wide'] ?>" alt="" itemprop="image"/>
      </span>

      <figcaption class="infos">
        <div class="wrap">

          <button class="btn seamless toggle favorite icon-only" toggle-content="<?= __('À mon horaire', 'waq') ?>">
            <span>
              <?= __('Ajouter à mon horaire', 'waq') ?>
            </span>
          </button>

          <div class="speaker">
            <span class="name title" itemprop="name"><?= $session->speaker->name ?></span>
            <span class="job" itemprop="jobTitle"><?= $session->speaker->job ?></span>
          </div>

          <a class="session btn link" href="<?= $session->permalink ?>">
            <span class="wrap">

              <span class="meta dark">
                <time class="date" datetime="<?= $session->date ?>">
                  <span class="v-align">
                    <span class="sub title"><?= substr($session->grid_title,0,3) ?></span>
                    <span class="small title"><?= strftime('%e', $session->date) ?></span>
                  </span>
                </time>

                <time class="time" itemprop="startDate" datetime="2014-03-19 14:00">
                  <span class="v-align">
                    <span class="sub title"><?= strftime('%k', $session->time->start) ?>h</span>
                    <span class="small title"><?= strftime('%M', $session->time->start) ?></span>
                  </span>
                </time>
              </span>

              <span class="session-title sub title"><?= $session->title ?></span>

            </span>
          </a>

        </div>
      </figcaption>

    </figure>

    <?php endforeach; ?>
  </div>

</section>
