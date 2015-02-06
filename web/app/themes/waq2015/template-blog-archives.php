<?php
/*
 * Template Name: Blogue Archives
 */
get_header();
global $wp_query;
$url = get_permalink(get_id_from_slug('actualites'));
$categories_ids = array();
$activeCategory = false;
if(isset($wp_query->query_vars['categorie'])){
  $activeCategory = get_category_by_slug($wp_query->query_vars['categorie'])->term_id;
  $categories_ids = array($activeCategory);
}
query_posts(array(
  'post_type' => 'post',
  'posts_per_page' => -1,
  'category__in' => $categories_ids
));

?>

<section class="single news no-padding">

  <hgroup class="dark">
    <div class="container">

      <div class="main title border-left">
        <h1><?= __('Blogue','waq') ?></h1>
        <div class="border-bottom expandable"></div>

      </div>
   </div>
  </hgroup>

  <?php
  //
  //
  // CATEGORIES
  $categories = get_categories(array(
    'hide_empty' => 1,
   ));
  if(has($categories)):
  ?>
    <nav class="filters dark">
      <div class="container">
        <h3 class="title toggle">
          <?= __('Filtrer par catégorie', 'waq') ?>
        </h3>

        <div class="content">
        <?php foreach($categories as $category):
          $active = $category->term_id == $activeCategory;
          ?>
          <a class="filter btn toggle<?php if($active) echo ' active' ?>" href="<?= $active ? $url :  $url.'categorie/'.$category->slug ?>">
            <span><?= $category->name ?></span>
          </a>
        <?php endforeach; ?>
        </div>
      </div>
    </nav>
  <?php endif; ?>

</section>


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


<?php
get_footer();
?>