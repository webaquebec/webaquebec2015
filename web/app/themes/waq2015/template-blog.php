<?php
/*
 * Template Name: Blogue
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); //Just enough to fetch the layout name ?>
<section id="<?= $post->post_name ?>" class="blog dark">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
    <?php endwhile; endif; ?>
    <div class="blog-container">
      <div class="col narrow">
        <?php 

          $args = array('showposts' => 1 ); 
          $the_query = new WP_Query( $args ); // New query
          // $temp_query = $wp_query; // Stock the old query
          // $wp_query   = NULL; // Reset the query
          // $wp_query   = $the_query; // Assign the new query to wp_query

        ?>
        <?php if( $the_query->have_posts() ): ?>
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

        <article class="">
          <div class="contenu-article">
            <div class="content">
                <div class="image-une">                       
                  <?php
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail('wide');
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
        <?php endwhile; endif; ?>
        <?php 
          // $wp_query = NULL; // Reset the query
          // $wp_query = $temp_query; // Re-assign the old query to the current one
        ?>
        <?php //wp_reset_query(); ?>
        <div class="btn link">
          <a href="<?= get_site_url(); ?>/actualites" class=""><span>Voir tous les articles</span></a>
        </div>
      </div>
      <div class="col wide stream-container">
        
      </div>
    </div>
  </div>
  
</section>
<?php 
get_footer_once();
?>