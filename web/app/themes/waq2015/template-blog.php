<?php
/*
 * Template Name: Blogue
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>
<section id="<?= $post->post_name ?>" class="blog dark">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
    <?php endwhile; endif; ?>
    <div class="posts">
      <div class="sticky">
        <div class="col narrow">
          <?php

            $args = array('showposts' => 1 );
            $the_query = new WP_Query( $args ); // New query

          ?>
          <?php if( $the_query->have_posts() ): ?>
          <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

          <article class="featured">
            <div class="image">
              <?php
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail('wide');
                }
              ?>
            </div>
            <div class="content">
                <div class="article-info">
                  <span class="meta small"><?php echo get_the_author(); ?> <span class="separator">&#183;</span> <?php echo get_the_date(); ?></span>
                  <h1 class="sub title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h2>
                </div>
                <p><?= get_the_excerpt(); ?></p>
            </div>
          </article>
          <?php endwhile; endif; ?>
          <div class="view-all btn autowidth bold link">
            <a href="<?= get_permalink(126) ?>" class=""><span>Voir tous les articles</span></a>
          </div>
        </div>
      </div>
      <div class="col wide feed">

      <?php
      $hashtags = get_field('hashtags', 'options');
      $tags = array();
      foreach($hashtags as $tag ){
        array_push($tags, str_replace('#','',$tag['hashtag']) );
      }

      $count = get_field('tagboard_count', 'options');
      $socialfeed = new social_feed(array(
          'tag' => $tags,
          'count' => $count,
        ));

      // var_dump(($socialfeed));
      if($socialfeed->have_posts()):
        ?>

        <div class="grid">
          <div class="left">

          <?php
          while($socialfeed->have_posts()):
            $post = $socialfeed->the_post();
            if($socialfeed->post_counter-1 == floor($socialfeed->count/2)):
            ?>
          </div>
          <div class="right">
            <?php endif; ?>
            <article class="feed-post border-bottom <?= $post->type=='tweet' ? 'twitter' : 'instagram' ?>">
                <div class="post-infos">
                  <div class="thumb">
                    <img src="<?= $post->profile_picture ?>" alt="<?= $post->username ?>">
                  </div>
                  <div class="user">
                    <span class="name"><?= $post->name ?></span>
                    <a href="<?= $post->profile_url ?>" class="username" target="_blank"><?= $post->username ?></a>
                    <span class="separator">&#183;</span>
                    <span class="date"><?= strftime('%e %b %Y',$post->timestamp) ?></span>
                  </div>
                </div>
                <div class="content">
                  <?php if($post->type =='video'): ?>
                    <video controls <?php if(isset($post->images)): ?>poster="<?= $post->images->standard_resolution->url ?>"<?php endif; ?>>
                      <?php if(isset($post->videos)): ?><source src="<?= $post->videos->standard_resolution->url ?>" type="video/mp4" /><?php endif; ?>
                      <?= __('Votre navigateur ne supporte pas les vidéos', 'waq'); ?>
                    </video>
                  <?php 
                  elseif(isset($post->images)): ?>
                    <div class="image">
                      <img src="<?= $post->images->standard_resolution->url ?>" alt="Image de <?= $post->name ?>" />
                    </div>
                  <?php endif; ?>
                  <p><?= $socialfeed->rich_text($post->text, $post->type) ?></p>
                </div>

                <?php if($post->type =='tweet'): ?>
                <ul class="actions">
                  <li>
                    <a href="https://twitter.com/intent/tweet?in_reply_to=<?= $post->id ?>" class="reply" target="_blank">Répondre</a>
                  </li>
                  <li>
                    <a href="https://twitter.com/intent/retweet?tweet_id=<?= $post->id ?>" class="retweet" target="_blank">Retweeter</a>
                  </li>
                  <li>
                    <a href="https://twitter.com/intent/favorite?tweet_id=<?= $post->id ?>" class="favorite" target="_blank">Ajouter aux favoris</a>
                  </li>
                </ul>
                <?php endif ?>
              </article>

            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

          </div>
        </div>

        <?php endif; ?>

        <?php if(false): ?>

          <p class="note">Il n'y a aucun article à afficher.</p>

        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php
get_footer_once();
?>