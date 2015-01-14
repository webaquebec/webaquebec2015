<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article class="single no-padding">

  <hgroup class="dark">
    <div class="container">
      <div class="main title border-left">
        <div class="article-info">
          <span class="meta"><?php echo get_the_author(); ?> <span class="separator">&#183;</span> <?php echo get_the_date(); ?></span>
        </div>
        <h1><?= get_the_title() ?></h1>
        <div class="border-bottom expandable"></div>
      </div>
    </div>
  </hgroup>

  <div class="cols container">
    <section class="col wide" role="main">
      <div class="single-article">
        <div class="content">
          <div class="image-une">
            <?php
              if ( has_post_thumbnail() ) {
                  the_post_thumbnail('large');
              }
            ?>
          </div>
          <?php the_content() ?>
        </div>

        <div class="tags-section">
          <h4 class="sub title"><?= __('Catégorie', 'waq') ?></h4>
            <?php the_tags('<ul class="tags"><li class="btn"><span>', '</span></li><li class="btn"><span>','</span></li></ul>'); ?>
        </div>
        <div class="btn back">
          <a href="<?= get_site_url(); ?>/actualites" class=""><span>Retour aux articles</span></a>
        </div>
      </div>

    </section>

    <aside class="col narrow" role="complementary">

      <div class="aside-content">

      </div>

    </aside>
  </div>

</article>

<?php endwhile; endif; ?>

<?php get_footer(); ?>