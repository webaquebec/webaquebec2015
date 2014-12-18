<?php
global $post;
setup_postdata($post);
?>

<section id="<?= $post->post_name ?>" class="features l-grey">

  <div class="grid">

  <?php 
  //
  //
  // FEATURED CONFERENCERS
  $featured = get_field('featured');
  $i = 0; // counter
  foreach($featured as $conference):
    
    // the conference
    $id = $conference['conference'];
    $title = get_the_title($id);
    // the conferencer
    $about = get_field('about', $id);
    $name = $about[0]['infos'][0]['name'];
    $job = $about[0]['infos'][0]['job'];
    // the time
    $timeframe = get_field('timeframe', $id);
    $day = get_the_title($timeframe[0]['day']);
    $frameID = $timeframe[0]['frame_'.$timeframe[0]['day']];
    // the place
    $room = $timeframe[0]['room']->post_title;
    // the image
    $image = $conference['image']; // custom image
    if(!has($image)) $image = $about[0]['infos'][0]['image'] // conferencer image fallback

    ?>

    <figure class="panel <?= $i%2==0 ? 'left' : 'right' ?> <?= $i<2 ? 'top' : 'bottom' ?>" itemprop="performer" itemscope="" itemtype="http://schema.org/Person">
      <figcaption>
        <?php //var_dump($about) ?>
        <h3>
          <span class="name" itemprop="name"><?= $name ?></span>
          <span class="job" itemprop="jobTitle"><?= $job ?></span>
        </h3>
      </figcaption>

      <span class="image">
        <img src="<?= $image['sizes']['wide'] ?>" alt="" itemprop="image"/>
      </span>
    </figure>

    <?php 
    $i++;
  endforeach;
  ?> 
    
  </div>

</section>
