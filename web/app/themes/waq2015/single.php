<?php
get_header();
$author_ID = $post->post_author;
$author = get_user_by('id', $author_ID);
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article class="article single no-padding">

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
      <?php
      // print_r($author);
      $profile_infos = get_field('profile_infos', 'user_'.$author_ID);
      if(false):
      ?>
      <?php $has_thumb = has($profile_picture); ?>
      <div class="conferencer<?php if($has_thumb) echo ' has-thumb' ?>">
          <div class="about">
            <?php if($has_thumb): ?>
            <div class="thumb">
              <img src="<?= $profile_picture['sizes']['thumbnail'] ?>" alt="<?= $author->data->display_name ?>" />
            </div>
            <?php endif; ?>
            <div class="name">
              <span class="sub title"><?= __('À propos de', 'waq') ?></span>
              <h2 class="title"><?= $author->data->display_name ?></h2>
            </div>
          </div>
          <div class="content">
            <?= $session->speaker->bio ?>
          </div>
          <?php if(has($session->speaker->social)): ?>
            <ul class="social">
            <?php foreach($session->speaker->social as $social): ?>
              <li>
                <a class="<?= $social['provider'] ?>" href="<?= $social['url'] ?>"><?= $social['label'] ?></a>
              </li>
            <?php endforeach; ?>
            </ul>
          <?php endif; ?>
      </div>
      <?php endif; ?>
    </aside>

  </div>

</article>

<?php endwhile; endif; ?>

<?php get_footer(); ?>