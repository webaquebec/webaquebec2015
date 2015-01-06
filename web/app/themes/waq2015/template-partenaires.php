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
      <ul class="logos">
      <?php foreach ($presenters as $presenter) : ?>
        <li>
          <img src="<?= $presenter['image']['url']; ?>" alt="<?= $presenter['name']; ?>">
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="main_partners">
      <h2 class="sub title lined">Partenaires principaux</h2>
      <hr class="sub-line">
      <ul class="logos">
      <?php foreach ($main_partners as $main_partner) : ?>
        <li>
          <img src="<?= $main_partner['image']['url']; ?>" alt="<?= $main_partner['name']; ?>">
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="associates">
      <h2 class="sub title lined">Associés</h2>
      <hr class="sub-line">
      <ul class="logos small">
      <?php foreach ($associates as $associate) : ?>
        <li>
          <img src="<?= $associate['image']['url']; ?>" alt="<?= $associate['name']; ?>">
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="publics">
      <h2 class="sub title lined">Publics</h2>
      <hr class="sub-line">
      <ul class="logos small">
      <?php foreach ($publics as $public) : ?>
        <li>
          <img src="<?= $public['image']['url']; ?>" alt="<?= $public['name']; ?>">
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="medias">
      <h2 class="sub title lined">Médias</h2>
      <hr class="sub-line">
      <ul class="logos small">
      <?php foreach ($medias as $media) : ?>
        <li>
          <img src="<?= $media['image']['url']; ?>" alt="<?= $media['name']; ?>">
        </li>
      <?php endforeach; ?>
      </ul>
    </div>

    <div class="supporters">
      <h2 class="sub title lined">Supporteurs</h2>
      <hr class="sub-line">
      <ul class="logos small">
      <?php foreach ($supporters as $supporter) : ?>
        <li>
          <img src="<?= $supporter['image']['url']; ?>" alt="<?= $supporter['name']; ?>">
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