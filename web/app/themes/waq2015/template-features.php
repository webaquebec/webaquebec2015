<?php
global $post;
setup_postdata($post);
?>

<section id="<?= $post->post_name ?>" class="features l-grey">

  <div class="grid">

    <figure class="panel top left" itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <h3>
          <span class="name" itemprop="name">David Eaves</span>
          <span class="job" itemprop="jobTitle">Open Data Expert</span>
        </h3>
      </figcaption>

      <span class="image">
        <img src="http://2014.webaquebec.org/wp-content/uploads/2014/01/davideaves-227x190.jpg" alt="" itemprop="image">
      </span>
    </figure>

    <figure class="panel top right" itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <h3>
          <span class="name" itemprop="name">Sylvain Carle</span>
          <span class="job" itemprop="jobTitle">Évangéliste Techno, Twitter</span>
        </h3>
      </figcaption>

      <span class="image">
        <img src="http://2014.webaquebec.org/wp-content/uploads/2014/01/sylvain_carle-227x190.png" alt="" itemprop="image">
      </span>
    </figure>

    <figure class="panel bottom left" itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <h3>
          <span class="name" itemprop="name">Sylvain Carle</span>
          <span class="job" itemprop="jobTitle">Évangéliste Techno, Twitter</span>
        </h3>
      </figcaption>

      <span class="image">
        <img src="http://2014.webaquebec.org/wp-content/uploads/2014/01/sylvain_carle-227x190.png" alt="" itemprop="image">
      </span>
    </figure>

    <figure class="panel bottom right" itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <h3>
          <span class="name" itemprop="name">David Eaves</span>
          <span class="job" itemprop="jobTitle">Open Data Expert</span>
        </h3>
      </figcaption>

      <span class="image">
        <img src="http://2014.webaquebec.org/wp-content/uploads/2014/01/davideaves-227x190.jpg" alt="" itemprop="image">
      </span>
    </figure>
    
  </div>

</section>
