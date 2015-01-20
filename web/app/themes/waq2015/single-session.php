<?php get_header();
$session = new session($post->ID);
?>

<article class="session single no-padding">

  <hgroup class="">
    <div class="container">

      <button class="btn seamless toggle favorite" toggle-content="<?= __('J\'y serai','waq') ?>"><span><?= __('Ajouter à mon horaire','waq') ?></span></button>

      <div class="main title">
        <div class="name">
          <h2 class="title"><?= $session->speaker->name ?></h2>
        </div>
        <h1><?= $session->title ?></h1>
      </div>
      <div class="conference-info-container dark">
        <div class="conferencer-info btn">
            <span class="wrap ">

              <span class="meta room-border" style="border-left-color:<?= $session->location->color ?>;">
                <time class="date" datetime="">
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

              <span class="conference-room">
                <span class="v-align">
                  <span class="sub title"><?= __('Salle','waq') ?></span>
                  <span class="small title"><?= $session->location->title ?> &#183; <?= $session->location->subtitle ?></span>
                </span>
              </span>

            </span>
        </div>
      </div>
    </div>
  </hgroup>

  <div class="cols container">

    <section class="col wide" role="main">

      <div class="conference">

        <div class="content">
          <?= $session->content ?>
        </div>

        <div class="tags-section">
          <h4 class="sub title"><?= __('Thématiques', 'waq') ?></h4>
          <ul class="tags">
            <?php foreach($session->themes as $theme): ?>
            <li class="btn">
                <a href="<?= get_permalink(4); ?>filtre/<?= $theme->slug ?>">
                  <?= $theme->name ?>
                </a>
            </li>
            <?php endforeach; ?>
          </ul>

          <a href="<?= get_permalink(4); ?>" class="btn back">
            <span><?= __('Retour à l\'horaire','waq') ?></span>
          </a>

        </div>
      </div>
    </section>

    <aside class="col narrow" role="complementary">
      <?php $has_thumb = has($session->speaker->image); ?>
      <div class="conferencer<?php if($has_thumb) echo ' has-thumb' ?>">
          <div class="about">
            <?php if($has_thumb): ?>
            <div class="thumb">
              <img src="<?= $session->speaker->image['sizes']['thumbnail'] ?>" alt="<?= $session->speaker->name ?>" />
            </div>
            <?php endif; ?>
            <div class="name">
              <span class="sub title"><?= __('À propos <br>du Conférencier', 'waq') ?></span>
              <h2 class="title"><?= $session->speaker->name ?></h2>
            </div>
          </div>

          <div class="content">
            <?= $session->speaker->bio ?>
          </div>
          <?php if(has($session->speaker->social)): ?>
            <ul class="social">
            <?php foreach($session->speaker->social as $social): ?>
              <li>
                <a class="<?= $social['provider'] ?>" href="<?= $social['url'] ?>"><?= $social['label'] ?></a>
              </li>
            <?php endforeach; ?>
            </ul>
          <?php endif; ?>
      </div>

    </aside>

  </div>

</article>

<?php get_footer(); ?>