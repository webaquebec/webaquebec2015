<?php
/*
 * Template Name: Coordonnées
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="event-location l-grey">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
    <div class="cols-2 large-margins">
      <div class="content">
        <?php the_content() ?>
        <div class="hashtag">
          <div class="img">
            <img src="/img/hashtag-waq.png" alt="#WAQ2015" />
          </div>
        </div>
        <ul class="social">
          <li>
            <a href="#_" class="facebook">Facebook</a>
          </li>
          <li>
            <a href="#_" class="twitter">Twitter</a>
          </li>
          <li>
            <a href="#_" class="linkedin">LinkedIn</a>
          </li>
          <li>
            <a href="#_" class="instagram">Instagram</a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <?php
  // marker location
  $loc = get_field('gmap');
  ?>
  <div id="gmap" class="map" lat="<?= $loc['lat'] ?>" lng="<?= $loc['lng'] ?>" ></div>

</section>

<?php endwhile; endif; ?>

<?php
get_footer_once();
?>