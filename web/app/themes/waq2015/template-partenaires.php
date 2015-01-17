<?php
/*
 * Template Name: Partenaires
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="partners">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
    <?php

    $presenters = get_field('presenters');
    $main_partners = get_field('main_partners');
    $associates = get_field('associates');
    $publics = get_field('publics');
    $medias = get_field('medias');
    $supporters = get_field('supporters');

    ?>

    <div class="presenters">
      <h2 class="sub title lined">Présentateur</h2>
      <hr class="sub-line">
      <ul class="logos grid">
      <?php foreach ($presenters as $presenter) : ?>
        <li>
          <?php if($presenter['url']) : ?>
          <a href="<?= $presenter['url'] ?>" target="_blank">
          <?php endif; ?>
            <img src="<?= $presenter['image']['url']; ?>" alt="<?= $presenter['name']; ?>">
          <?php if($presenter['url']) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="main_partners">
      <h2 class="sub title lined">Principaux</h2>
      <hr class="sub-line">
      <ul class="logos grid">
      <?php foreach ($main_partners as $main_partner) : ?>
        <li>
          <?php if($main_partner['url']) : ?>
          <a href="<?= $main_partner['url'] ?>" target="_blank">
          <?php endif; ?>
            <img src="<?= $main_partner['image']['url']; ?>" alt="<?= $main_partner['name']; ?>">
          <?php if($main_partner['url']) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="associates">
      <h2 class="sub title lined">Associés</h2>
      <hr class="sub-line">
      <ul class="logos small grid">
      <?php foreach ($associates as $associate) : ?>
        <li>
          <?php if($associate['url']) : ?>
          <a href="<?= $associate['url'] ?>" target="_blank">
          <?php endif; ?>
            <img src="<?= $associate['image']['url']; ?>" alt="<?= $associate['name']; ?>">
          <?php if($associate['url']) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="publics">
      <h2 class="sub title lined">Publics</h2>
      <hr class="sub-line">
      <ul class="logos small grid">
      <?php foreach ($publics as $public) : ?>
        <li>
          <?php if($public['url']) : ?>
          <a href="<?= $public['url'] ?>" target="_blank">
          <?php endif; ?>
            <img src="<?= $public['image']['url']; ?>" alt="<?= $public['name']; ?>">
          <?php if($public['url']) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="supporters">
      <h2 class="sub title lined">Supporteurs</h2>
      <hr class="sub-line">
      <ul class="logos small grid">
      <?php foreach ($supporters as $supporter) : ?>
        <li>
          <?php if($supporter['url']) : ?>
          <a href="<?= $supporter['url'] ?>" target="_blank">
          <?php endif; ?>
            <img src="<?= $supporter['image']['url']; ?>" alt="<?= $supporter['name']; ?>">
          <?php if($supporter['url']) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="medias">
      <h2 class="sub title lined">Médias</h2>
      <hr class="sub-line">
      <ul class="logos small grid">
      <?php foreach ($medias as $media) : ?>
        <li>
          <?php if($media['url']) : ?>
          <a href="<?= $media['url'] ?>" target="_blank">
          <?php endif; ?>
            <img src="<?= $media['image']['url']; ?>" alt="<?= $media['name']; ?>">
          <?php if($media['url']) : ?>
          </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

  </div>

</section>

<?php endwhile; endif; ?>

<?php
get_footer_once();
?>