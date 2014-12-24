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
	<section class="blog dark">
  
    <div class="container">
      <div class="blog-container">
        
        <?php if (have_posts()) : /*query_posts("posts_per_page=1");*/ while (have_posts()) : the_post();?>
        <div class="col wide">
          <article class="">
            <div class="contenu-article">
              <div class="content">
                  <div class="image-une">                       
                    <?php
                      if ( has_post_thumbnail() ) {
                          the_post_thumbnail();
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
        </div>
        <?php endwhile; ?>
        <div class="pagination-container">
          <?php posts_nav_link(' | ','<div class="btn back"><span >Précédent</span></div>','<div class="btn link"><span>Suivant</span></div>'); ?>
        </div>
        <?php else : ?>
          <p><?php _e('Aucun articles correspond à vos critères.'); ?></p>
          <?php endif; ?>
          <div class="clearfix"></div>
          <a href="<?= get_site_url(); ?>" class="btn back"><span>Retour à l'accueil</span></a>
      </div>
    </div>
  </section>

</article>
<?php 
get_footer();
?>