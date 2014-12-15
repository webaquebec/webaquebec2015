<?php
global $post;
setup_postdata($post);
?>

<section id="<?= $post->post_name ?>" class="features l-grey">

  <div class="grid">

    <figure itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <span class="name" itemprop="name">David Eaves</span>
        <span class="job" itemprop="jobTitle">Open Data Expert</span>
      </figcaption>

      <span class="image">
        <img src="wp-content/uploads/2014/01/davideaves-227x190.jpg" alt="" itemprop="image">
      </span>
    </figure>

    <figure itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <span class="name" itemprop="name">Sylvain Carle</span>
        <span class="job" itemprop="jobTitle">Évangéliste Techno, Twitter</span>
      </figcaption>

      <span class="image">
        <img src="wp-content/uploads/2014/01/sylvain_carle-227x190.png" alt="" itemprop="image">
      </span>
    </figure>

    <figure itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <span class="name" itemprop="name">Sylvain Carle</span>
        <span class="job" itemprop="jobTitle">Évangéliste Techno, Twitter</span>
      </figcaption>

      <span class="image">
        <img src="wp-content/uploads/2014/01/sylvain_carle-227x190.png" alt="" itemprop="image">
      </span>
    </figure>

    <figure itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <span class="name" itemprop="name">David Eaves</span>
        <span class="job" itemprop="jobTitle">Open Data Expert</span>
      </figcaption>

      <span class="image">
        <img src="wp-content/uploads/2014/01/davideaves-227x190.jpg" alt="" itemprop="image">
      </span>
    </figure>
    
  </div>

</section>

<?php 
get_footer_once();
?>


