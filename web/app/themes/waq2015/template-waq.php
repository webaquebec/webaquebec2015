<?php
/*
 * Template Name: WAQ 2015
 */

get_header_once();
?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<section id="<?= $post->post_name ?>" class="waq2015 dark">

  <div class="container">
    <h1 class="main title border-left">
      <?= get_the_title() ?>
      <div class="border-bottom expandable"></div>
    </h1>
    <div class="content">
      <div class="top grid">
        <div class="waq-infos">
          <div class="description">
            <?= get_the_content() ?>
          </div>
        </div>
        <div class="volounteers">
          <?php
          // featured volounteers
          $featured_volounteers = get_field('volounteers');
          ?>
          <h2 class="lower title"><?= __('Des bénévoles essentiels!','waq') ?></h2>
          <p><?= __('Un merci tout spécial à notre équipe du tonnerre!','waq') ?></p>
          <?php if(has($featured_volounteers)): ?>
          <ul class="volounteers-list">
          <?php foreach ($featured_volounteers as $featured_volounteer) : ?>
            <li><?= $featured_volounteer['name']; ?></li>
          <?php endforeach; ?>
          </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="bottom">
      <?php

      function has_social($member){
        return has($member['facebook']) || has($member['facebook']) || has($member['facebook']);
      }

      function social_links($member){ ?>
        <nav class="links">
          <ul>
          <?php if(has($member['facebook'])): ?>
            <li><a href="<?= $member['facebook'] ?>" target="_blank" class="facebook">Facebook</a></li>
          <?php endif;
          if(has($member['twitter'])): ?>
            <li><a href="<?= $member['twitter'] ?>" target="_blank" class="twitter">Twitter</a></li>
          <?php endif;
          if(has($member['linked_in'])): ?>
            <li><a href="<?= $member['linked_in'] ?>" target="_blank" class="linkedin">Linkedin</a></li>
          <?php endif; ?>
          </ul>
        </nav>
      <?php
      }

      function list_members($title, $members){
        if(has($members)):
        ?>
        <h2 class="sub title lined"><?= $title ?></h2>
        <hr class="sub-line">
        <ul class="<?= sanitize_title($title) ?>'-list grid">
        <?php foreach ($members as $member) : ?>
         <li>
            <figure class="profile<?php if(has_social($member)) echo ' has-social'; ?>">
              <div>
                <div class="thumb">
                  <img src="<?= $member['image']['sizes']['thumbnail']; ?>" alt="<?= $member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $member['name']; ?></h3>
                    <?php social_links($member); ?>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
        <?php
        endif;
      }

      // List Members
      ?>
      <div class="board group">
        <?php
        // board of directors
        $board_members = get_field('board');
        list_members(__('Conseil d\'administration','waq'), $board_members);
        ?>
      </div>

      <div class="welcome group">
        <?php
        // welcome
        $welcome_members = get_field('welcome');
        list_members(__('Accueil','waq'), $welcome_members);
        ?>
      </div>

      <div class="admin group">
        <?php
        // admin
        $admin_members = get_field('admin');
        list_members(__('Administration','waq'), $admin_members);
        ?>
      </div>

      <div class="volounteers-committee group">
        <?php
        // volounteers
        $volounteers_committee_members = get_field('volounteers_committee');
        list_members(__('Bénévoles','waq'), $volounteers_committee_members);
        ?>
      </div>

      <div class="communications group">
        <?php
        // communications
        $communications_members = get_field('communications');
        list_members(__('Communications','waq'), $communications_members);
        ?>
      </div>

      <div class="logisitics group">
        <?php
        // logistics
        $logistics_members = get_field('logistics');
        list_members(__('Logisitique','waq'), $logistics_members);
        ?>
      </div>

      <div class="schedule group">
        <?php
        // schedule
        $schedule_members = get_field('schedule');
        list_members(__('Programmation','waq'), $schedule_members);
        ?>
      </div>

      <div class="welcome group">
        <?php
        // protocol
        $protocol_members = get_field('protocol');
        list_members(__('Protocole','waq'), $protocol_members);
        ?>
      </div>

      <div class="international group">
        <?php
        // international
        $international_members = get_field('international');
        list_members(__('Relations internationales','waq'), $international_members);
        ?>
      </div>

    </div>
  </div>

</section>

<?php endwhile; endif; ?>

<?php
get_footer_once();
?>