<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article class="article single no-padding">

  <hgroup>
    <div class="container">
      <div class="main title">
        <div class="article-info">
          <h2 class="title"><?= get_the_author() ?> <span class="separator">&#183;</span> <?= get_the_date() ?></h2>
        </div>
        <h1><?= get_the_title() ?></h1>
      </div>
    </div>
  </hgroup>

  <div class="cols container">
    <section class="col wide" role="main">
      <div class="single-article">
        <div class="content">
          <div class="article-image">
            <?php $image = get_field('featured');
              if($image): ?>
              <img src="<?= $image['sizes']['large'] ?>" alt="<?= __('Image de l\'article','waq') ?>" />
              <?php endif; ?>
          </div>
          <?php the_content() ?>
        </div>

        <div class="tags-section">
          <h4 class="sub title"><?= __('Catégorie', 'waq') ?></h4>
            <?php the_tags('<ul class="tags"><li class="btn"><span>', '</span></li><li class="btn"><span>','</span></li></ul>'); ?>
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