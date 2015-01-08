<?php
/*
 * Template Name: Blogue
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
<section id="<?= $post->post_name ?>" class="blog dark">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
    <?php endwhile; endif; ?>
    <div class="blog">
      <div class="col narrow">
        <?php

          $args = array('showposts' => 1 );
          $the_query = new WP_Query( $args ); // New query

        ?>
        <?php if( $the_query->have_posts() ): ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

        <article class="featured">
          <div class="image">
            <?php
              if ( has_post_thumbnail() ) {
                  the_post_thumbnail('wide');
              }
            ?>
          </div>
          <div class="content">
              <div class="article-info">
                <span class="meta small"><?php echo get_the_author(); ?> <span class="separator">&#183;</span> <?php echo get_the_date(); ?></span>
                <h1 class="sub title">
                  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h2>
              </div>
              <p><?= get_the_excerpt(); ?></p>
          </div>
        </article>
        <?php endwhile; endif; ?>
        <div class="btn bold autowidth link">
          <a href="<?= get_permalink(126) ?>" class=""><span>Voir tous les articles</span></a>
        </div>
      </div>
      <div class="col wide feed">
        <?php if(false): ?>
        <div class="cols-2">
          <div class="left col">
            <article class="feed-post border-bottom twitter">
              <div class="post-infos">
                <div class="thumb">
                  <img src="http://2014.webaquebec.org/wp-content/uploads/2013/12/martin_huard.png" alt="USERNAME">
                </div>
                <div class="user">
                  <span class="name">Web à Québec</span>
                  <a href="#_" class="username">@webaquebec</a>
                  <span class="separator">&#183;</span>
                  <span class="date">6 Nov</span>
                </div>
              </div>
              <div class="content">
                <p>Petite danse de la victoire! Merci aux 150 personnes qui ont déjà confirmé leur présence pour le <a href="#_">#WAQ15</a></p>
              </div>
              <ul class="share">
                <li>
                  <a href="#_" class="reply">Répondre</a>
                </li>
                <li>
                  <a href="#_" class="retweet">Retweeter</a>
                </li>
                <li>
                  <a href="#_" class="favorite">Ajouter aux favoris</a>
                </li>
              </ul>
            </article>
            <article class="feed-post instagram">
              <div class="post-infos">
                <div class="thumb">
                  <img src="http://2014.webaquebec.org/wp-content/uploads/2013/12/martin_huard.png" alt="USERNAME">
                </div>
                <div class="user">
                  <a href="#_" class="username">@webaquebec</a>
                  <span class="separator">&#183;</span>
                  <span class="date">6 Nov</span>
                </div>
              </div>
              <div class="content">
                <img src="http://distilleryimage2.ak.instagram.com/cc743b1eb16011e3b85612a7545bb72a_8.jpg" alt="IMAGENAME">
              </div>
            </article>
          </div>
          <div class="right col">
            <article class="feed-post border-bottom instagram">
              <div class="post-infos">
                <div class="thumb">
                  <img src="http://2014.webaquebec.org/wp-content/uploads/2013/12/martin_huard.png" alt="USERNAME">
                </div>
                <div class="user">
                  <a href="#_" class="username">@webaquebec</a>
                  <span class="separator">&#183;</span>
                  <span class="date">6 Nov</span>
                </div>
              </div>
              <div class="content">
                <img src="http://distilleryimage10.ak.instagram.com/624ca586b12a11e3a7b912f132ba8f8e_8.jpg" alt="IMAGENAME">
              </div>
            </article>
            <article class="feed-post twitter">
              <div class="post-infos">
                <div class="thumb">
                  <img src="http://2014.webaquebec.org/wp-content/uploads/2013/12/martin_huard.png" alt="USERNAME">
                </div>
                <div class="user">
                  <span class="name">Web à Québec</span>
                  <a href="#_" class="username">@webaquebec</a>
                  <span class="separator">&#183;</span>
                  <span class="date">6 Nov</span>
                </div>
              </div>
              <div class="content">
                <p>Petite danse de la victoire! Merci aux 150 personnes qui ont déjà confirmé leur présence pour le <a href="#_">#WAQ15</a></p>
              </div>
              <ul class="share">
                <li>
                  <a href="#_" class="reply">Répondre</a>
                </li>
                <li>
                  <a href="#_" class="retweet">Retweeter</a>
                </li>
                <li>
                  <a href="#_" class="favorite">Ajouter aux favoris</a>
                </li>
              </ul>
            </article>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php
get_footer_once();
?>