<?php get_header(); ?>

<article class="single actualites no-padding">

  <hgroup class="dark">
    <div class="container">


      <div class="main title border-left">
        <h1>Actualités</h1>
        <div class="border-bottom expandable"></div>

      </div>
   </div>
  </hgroup>
  <section class="blog-page dark">

    <div class="container">
      <div class="posts">

        <?php if (have_posts()) : while (have_posts()) : the_post();?>
        <article>
          <div class="post">
            <div class="image">
              <?php $image = get_field('featured');
              if($image): ?>
              <img src="<?= $image['sizes']['blog-thumb'] ?>" alt="<?= __('Image de l\'article','waq') ?>" />
              <?php endif; ?>
            </div>
            <div class="content">
                <div class="article-info">
                  <span class="meta small"><?= get_the_author(); ?> <span class="separator">&#183;</span> <?= get_the_date(); ?></span>
                  <h1 class="sub title">
                    <a href="<?php the_permalink(); ?>"><?= get_the_title(); ?></a>
                  </h2>
                </div>
                <p><?= get_the_excerpt(); ?></p>
            </div>
          </div>
        </article>
        <?php endwhile; ?>
        <?php else : ?>
          <p><?php _e('Aucun articles correspond à vos critères.'); ?></p>
          <?php endif; ?>
      </div>
      <div class="btn back">
        <a href="<?= get_permalink(7); ?>" class=""><span>Retour à l'accueil</span></a>
      </div>
    </div>
  </section>

</article>
<?php
get_footer();
?>