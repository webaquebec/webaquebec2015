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
      <div class="board group">
        <?php

        // board of directors
        $board_members = get_field('board');

        ?>
        <h2 class="sub title lined">Conseil d'administration</h2>
        <hr class="sub-line">
        <ul class="board-members-list grid">
        <?php foreach ($board_members as $board_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $board_member['image']['sizes']['thumbnail']; ?>" alt="<?= $board_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $board_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $board_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $board_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $board_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="welcome group">
        <?php

        // welcome
        $welcome_members = get_field('welcome');

        ?>
        <h2 class="sub title lined">Accueil</h2>
        <hr class="sub-line">
        <ul class="welcome-members-list grid">
        <?php foreach ($welcome_members as $welcome_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $welcome_member['image']['sizes']['thumbnail']; ?>" alt="<?= $welcome_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $welcome_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $welcome_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $welcome_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $welcome_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="admin group">
        <?php

        // admin
        $admin_members = get_field('admin');

        ?>
        <h2 class="sub title lined">Administration</h2>
        <hr class="sub-line">
        <ul class="admin-members-list grid">
        <?php foreach ($admin_members as $admin_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $admin_member['image']['sizes']['thumbnail']; ?>" alt="<?= $admin_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $admin_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $admin_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $admin_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $admin_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="volounteers-committee group">
        <?php

        // volounteers
        $volounteers_committee_members = get_field('volounteers_committee');

        ?>
        <h2 class="sub title lined">Bénévoles</h2>
        <hr class="sub-line">
        <ul class="volounteers-committee-members-list grid">
        <?php foreach ($volounteers_committee_members as $volounteers_committee_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $volounteers_committee_member['image']['sizes']['thumbnail']; ?>" alt="<?= $volounteers_committee_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $volounteers_committee_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $volounteers_committee_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $volounteers_committee_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $volounteers_committee_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="communications group">
        <?php

        // communications
        $communications_members = get_field('communications');

        ?>
        <h2 class="sub title lined">Communications</h2>
        <hr class="sub-line">
        <ul class="communications-members-list grid">
        <?php foreach ($communications_members as $communications_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $communications_member['image']['sizes']['thumbnail']; ?>" alt="<?= $communications_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $communications_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $communications_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $communications_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $communications_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="logisitics group">
        <?php

        // logistics
        $logistics_members = get_field('logistics');

        ?>
        <h2 class="sub title lined">Logisitique</h2>
        <hr class="sub-line">
        <ul class="logistics-members-list grid">
        <?php foreach ($logistics_members as $logistics_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $logistics_member['image']['sizes']['thumbnail']; ?>" alt="<?= $logistics_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $logistics_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $logistics_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $logistics_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $logistics_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="schedule group">
        <?php

        // schedule
        $schedule_members = get_field('schedule');

        ?>
        <h2 class="sub title lined">Programmation</h2>
        <hr class="sub-line">
        <ul class="schedule-members-list grid">
        <?php foreach ($schedule_members as $schedule_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $schedule_member['image']['sizes']['thumbnail']; ?>" alt="<?= $schedule_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $schedule_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $schedule_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $schedule_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $schedule_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="welcome group">
        <?php

        // protocol
        $protocol_members = get_field('protocol');

        ?>
        <h2 class="sub title lined">Protocole</h2>
        <hr class="sub-line">
        <ul class="wprotocol-list grid">
        <?php foreach ($protocol_members as $protocol_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $protocol_member['image']['sizes']['thumbnail']; ?>" alt="<?= $protocol_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $protocol_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $protocol_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $protocol_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $protocol_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
      <div class="international group">
        <?php

        // international
        $international_members = get_field('international');

        ?>
        <h2 class="sub title lined">Relations internationales</h2>
        <hr class="sub-line">
        <ul class="international-members-list grid">
        <?php foreach ($international_members as $international_member) : ?>
          <li>
            <figure class="profile">
              <div>
                <div class="thumb">
                  <img src="<?= $international_member['image']['sizes']['thumbnail']; ?>" alt="<?= $international_member['name']; ?>" />
                </div>

                <figcaption class="infos">
                  <h3 class="name"><?= $international_member['name']; ?></h3>
                  <nav class="links">
                    <ul>
                      <li><a href="<?= $international_member['facebook']; ?>" target="_blank" class="facebook">facebook</a></li>
                      <li><a href="<?= $international_member['twitter']; ?>" target="_blank" class="twitter">twitter</a></li>
                      <li><a href="<?= $international_member['linked_in']; ?>" target="_blank" class="linkedin">Linkedin</a></li>
                    </ul>
                  </nav>
                </figcaption>
              </div>
            </figure>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

</section>

<?php endwhile; endif; ?>

<?php
get_footer_once();
?>