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
      <h2 class="title border-middle">
        <span>
          <span class="sub title">Les favoris populaires</span>
        </span>
      </h2>
      <?php
      // Select users favorites
      $favorites = $wpdb->get_col("SELECT meta_value FROM  `wp_usermeta` WHERE `meta_key` =  'favorites';");
      $favorites_sums = array();

      // Sum favorites per post ID
      foreach ($favorites as $values) {
        if(empty(trim($values))) continue;
        $ids = explode('|', $values);
        foreach ($ids as $id) {
          if(empty($favorites_sums[$id])) {
            $favorites_sums[$id] = 1;
          } else {
            $favorites_sums[$id] += 1;
          }
        }
      }

      // Sort by popularity
      arsort($favorites_sums);
      $posts_ids = array_keys($favorites_sums);
      $posts_ids = implode(',', $posts_ids);

      // Fetch post details we need
      $posts = $wpdb->get_results("SELECT `id`, `post_title`, `post_name` FROM  `wp_posts` WHERE id IN($posts_ids)");
      $posts_details = array();
      foreach ($posts as $post) {
        $posts_details[$post->id] = $post;
      }
      ?>
      <ul>
        <?php foreach ($favorites_sums as $post_id => $sum): ?>
          <?php if($sum < 5) continue; ?>
          <?php $post = $posts_details[$post_id]; ?>
          <li><?php echo $sum; ?> <a href="/activite/<?php echo $post->post_name; ?>"><?php echo $post->post_title; ?></a></li>
        <?php endforeach ?>
      </ul>

    </div>

  </section>
</div>

<?php endwhile; endif; ?>

<?php get_footer_once(); ?>
