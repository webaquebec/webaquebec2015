<?php
get_header();
$url = get_permalink(get_id_from_slug('blogue'));
$author_ID = $post->post_author;
$author = get_user_by('id', $author_ID);
$categories = get_the_category();
?>

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54ee9bd91f5ccd85" async="async"></script>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article class="article single single-article no-padding">

  <hgroup>
    <div class="container">
      <div class="main title">
        <h2 class="article-info title"><?= $author->data->display_name ?> <span class="separator">&#183;</span> <?= get_the_date() ?></h2>
        <h1><?= get_the_title() ?></h1>
      </div>
    </div>
  </hgroup>

  <div class="cols container">
    <section class="col wide" role="main">
      <div class="post">
        <div class="content">
          <?php $image = get_field('featured');
          if($image): ?>
          <div class="article-image">
              <img src="<?= $image['sizes']['large'] ?>" alt="<?= __('Image de l\'article','waq') ?>" />
          </div>
          <?php endif; ?>
          <div class="addthis_sharing_toolbox"></div>
          <?php the_content() ?>
        </div>

      </div>

    </section>

     <aside class="col narrow" role="complementary">
      <?php
      $profile_infos = get_field('profile_infos', 'user_'.$author_ID);
      $image = $profile_infos[0]['image'];
      $bio = $profile_infos[0]['bio'];
      $socials = $profile_infos[0]['social'];
      ?>
      <?php $has_thumb = has($image); ?>
      <div class="conferencer<?php if($has_thumb) echo ' has-thumb' ?>">
          <div class="about">
            <?php if($has_thumb): ?>
            <div class="thumb">
              <img src="<?= $image['sizes']['thumbnail'] ?>" alt="<?= $author->data->display_name ?>" />
            </div>
            <?php endif; ?>
            <div class="name">
              <span class="sub title"><?= __('À propos de', 'waq') ?></span>
              <h2 class="title"><?= $author->data->display_name ?></h2>
            </div>
          </div>
          <div class="content">
            <?= $bio ?>
          </div>
          <?php if(has($socials)): ?>
            <ul class="social">
            <?php foreach($socials as $social): ?>
              <li>
                <a class="<?= $social['provider'] ?>" href="<?= $social['url'] ?>"><?= $social['label'] ?></a>
              </li>
            <?php endforeach; ?>
            </ul>
          <?php endif; ?>
      </div>
    </aside>
  </div>

  <?php
  //
  //
  // CATEGORIES
  $categories_ids = array();
  if(has($categories)):
  ?>
  <?php endif; ?>

  <div class="container section-category">
    <div class="cols posts">
      <div class="col">
        <h4 class="sub title"><?= __('Dans la catégorie', 'waq') ?></h4>
        <ul class="tags">
          <?php
          foreach($categories as $category):
            array_push($categories_ids, $category->term_id);
          ?>
          <li class="btn">
            <a href="<?= $url.'categorie/'.$category->slug ?>">
              <?= $category->name ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>


      <?php

      $related =  new WP_query(array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'category__in' => $categories_ids,
        'post__not_in' => array($post->ID),
      ));

      if ($related->have_posts()) : while ($related->have_posts()) : $related->the_post();?>
      <article class="col">
        <div class="post">
          <div class="content">
              <div class="article-info">
                <span class="meta small">
                 <div><?= get_the_category()[0]->name ?></div>
                  <?= get_the_author(); ?> <span class="separator">&#183;</span> <?= get_the_date(); ?>
                </span>
                <h1 class="sub title">
                  <a href="<?php the_permalink(); ?>"><?= get_the_title(); ?></a>
                </h2>
              </div>
              <p><?= get_the_excerpt(); ?></p>
          </div>
        </div>
      </article>
      <?php endwhile; endif; ?>

    </div>
  </div>

  <div class="container">
    <nav>
      <div class="left">
        <a href="<?= get_permalink(126); ?>" class="btn back">
          <span><?= __('blogue','waq') ?></span>
        </a>
      </div>

      <div class="right">
        <?php
        $next = adjacent_post('next');
        $prev = adjacent_post('prev');
        if(!!$prev): ?>
        <a href="<?= get_permalink($prev->ID); ?>" class="btn prev">
          <span><?= __('Article précédent','waq') ?></span>
        </a>
        <?php endif;
        if(!!$next): ?>
        <a href="<?= get_permalink($next->ID); ?>" class="btn next">
          <span><?= __('Article suivant','waq') ?></span>
        </a>
        <?php endif; ?>
      </div>
    </nav>
  </div>

</article>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
