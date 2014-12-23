<?php
/*
 * Template Name: Programmation
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="program dark">

  <hgroup>
    <div class="container">
      <h1 class="main title border-left">
        <?= get_the_title() ?>
        <div class="border-bottom expandable"></div>
      </h1>

      <h2 class="title"><?= __('Disponible bientôt', 'waq') ?></h2>

<!--       <nav class="days">
        <ul>
          <li>
            <button class="btn">
              <div>
                <span class="sub title">Mercredi</span>
                <span class="small title">18 mars 2014</span>
              </div>
            </button>
          </li>
          <li>
            <button class="btn">
              <div>
                <span class="sub title">Jeudi</span>
                <span class="small title">19 mars 2014</span>
              </div>
            </button>
          </li>
          <li>
            <button class="btn">
              <div>
                <span class="sub title">Vendredi</span>
                <span class="small title">20 mars 2014</span>
              </div>
            </button>
          </li>
        </ul>
      </nav> -->

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

</section>

<?php endwhile; endif; ?>
  
<?php 
get_footer_once();
?>