<?php get_header(); ?>	

<article class="single no-padding">

  <hgroup class="dark">
    <div class="container">


      <div class="main title border-left">
        <h1>Actualités</h1>
        <div class="border-bottom expandable"></div>

    	</div>
   </div>
  </hgroup>
	<section class="blog">
  
  <div class="container">
    <div class="blog-container">
      
      <?php if (have_posts()) : ?>
      <?php while (have_posts()) : the_post(); ?>
      <div class="col wide">
        <article class="">
          <div class="contenu_article">
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

    </div>
  </div>
 
</section>

<?php endif; ?>

</article>
<?php 
get_footer();
?>