<?php
/*
 * Template Name: Blogue
 */

get_header_once();
?>

<?php //if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="blog dark">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable">
    </h1>
    <div class="blog-container">
      <div class="col narrow">
        <?php if (have_posts()) : ?>
        <?php query_posts("showposts=1"); // show one latest post only ?>
        <?php while (have_posts()) : the_post(); ?>
        <article class="">
          <div class="contenu_article">
            <div class="content">
                <div class="image-une">                       
                  <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail('blog-thumb');
                    } 
                  ?>
                </div>
                <div class="featured-article">
                  <div class="article-info">
                    <span class="meta small"><?php echo get_the_author(); ?> <span class="separator">&#183;</span> <?php echo get_the_date(); ?></span>
                  </div>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <hr>
                <?php the_excerpt(); ?>
                </div>            
            </div>
          </div>
        </article>
        <?php endwhile; ?>
        <div class="btn link">
         <a href="<?= get_site_url(); ?>/actualites" class=""><span>Voir toutes les articles</span></a>
        </div>
      </div>
      <div class="col wide stream-container">

      </div>
    </div>
  </div>
  
</section>

<?php endif; ?>
  
<?php 
get_footer_once();
?>