<?php get_header_once(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section>
  <header class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom"></div>
    </h1>
  </header>
</section>

<div class="cols container">
  <section class="col wide" role="main">
    <div class="post">
      <div class="content">
        <?php the_content() ?>
      </div>

    </div>

  </section>
</div>

<?php endwhile; endif; ?>

<?php get_footer_once(); ?>
