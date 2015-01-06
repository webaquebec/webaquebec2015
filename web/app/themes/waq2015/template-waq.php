<?php
/*
 * Template Name: WAQ 2015
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="waq2015 dark">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
    <div class="content">
      <div class="top">
        <div class="infos">
          <div class="description">
            <?= get_the_content() ?>
          </div>
        </div>
        <div class="volounteers">
          <h2 class="lower title">Des bénévoles essentiels!</h2>
        </div>
      </div>
    </div>
    <div class="bottom">
      <div class="board">
        <h2 class="sub title lined">Conseil d'administration</h2>
        <hr class="sub-line">
      </div>
      <div class="admin">
        <h2 class="sub title lined">Administration</h2>
        <hr class="sub-line">
      </div>
      <div class="welcome">
        <h2 class="sub title lined">Comité d'accueil</h2>
        <hr class="sub-line">
      </div>
      <div class="volounteers-committee">
        <h2 class="sub title lined">Comité des bénévoles</h2>
        <hr class="sub-line">
      </div>
      <div class="communications">
        <h2 class="sub title lined">Comité des communications</h2>
        <hr class="sub-line">
      </div>
      <div class="logisitic">
        <h2 class="sub title lined">Comité logisitique</h2>
        <hr class="sub-line">
      </div>
      <div class="schedule">
        <h2 class="sub title lined">Comité de programmation</h2>
        <hr class="sub-line">
      </div>
      <div class="international">
        <h2 class="sub title lined">Comité des relations internationales</h2>
        <hr class="sub-line">
      </div>
    </div>
  </div>

</section>

<?php endwhile; endif; ?>

<?php
get_footer_once();
?>