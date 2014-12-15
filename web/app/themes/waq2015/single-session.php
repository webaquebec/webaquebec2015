<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article class="single">

  <hgroup class="dark">
    <div class="container">

      <button class="btn seamless toggle favorite" toggle-content="<?= __('Ajouté à mon horaire','waq') ?>"><span><?= __('Ajouter à mon horaire','waq') ?></span></button>

      <div class="main title border-left">
        
        <span class="meta">
            <span class="date">
              <time datetime="2014-03-19">mercredi 19 mars</time>
            </span>
            <span class="separator">•</span>
            <span class="time">
              <time itemprop="startDate" datetime="2014-03-19 14:00">14 h 00</time>
              à
              <time itemprop="endDate" datetime="2014-03-19 15:30">15 h 30</time>
            </span>
            <span class="separator">•</span>
            <span class="location" itemprop="location" itemscope="" itemtype="http://schema.org/Place">
                <span itemprop="address" itemscope="" itemtype="http://schema.org/Place">
                    <span itemprop="name">Grand Hall</span>
                </span>
            </span>
        </span>

        <h1><?= get_the_title() ?></h1>
        <div class="border-bottom expandable">

      </div>
    </div>
  </hgroup>

  <div class="cols container">
    
    <section class="col wide" role="main">
      <div class="session">
        
        <div class="content">
          <?php the_content() ?>
        </div>
        
        <div>
          <h4 class="sub title"><?= __('Thématiques', 'waq') ?></h4>
          <ul class="tags">
            <li class="btn">
              <span>Culture</span>
            </li>
            <li class="btn">
              <span>Données</span>
            </li>
            <li class="btn">
              <span>Médias Sociaux</span>
            </li>
          </ul>
        </div>
      </div>
    </section>

    <aside class="col narrow" role="complementary">

      <div class="conferencer">
          <div class="about">
            <div class="thumb">
              <img src="http://2014.webaquebec.org/wp-content/uploads/2014/01/sylvain_carle-227x190.png" alt="Sylvain Carle" />
            </div>
            <div class="name">
              <span class="sub title">À propos de</span>
              <h2 class="title">Sylvain Carles</h2>
            </div>
          </div>

          <div class="content">
            <p>Sylvain Carle est un adepte des technologies émergentes, il s’émerveille et s’amuse au croisement des médias, des technologies et des réseaux depuis 15 ans. L’entrepreneurship, le développement logiciel internet, les médias numériques et sociaux ainsi que les logiciels libres et les standards ouverts font partie de ses compétences et passions. Il habite présentement à San Franciso et travaille pour Twitter comme évangéliste techno. Il est aussi sur le conseil d’administration de la fondation OSMO, derrière le projet de la maison Notman à Montréal. Socialiste, idéaliste et pragmatique, il s’interroge sur le rôle de la technologie à l’ère de la société en réseau. Une de ses obsessions du moment est à propos de l’impact de la culture des hackers (au sens noble) sur les organisations publique et privées, de l’innovation par la collaboration massive, à la manière Github.</p>
          </div>

          <ul class="social">
            <li>
              <a class="website" href="http://afroginthevalley.com">afroginthevalley.com</a>
            </li>
            <li >
              <a class="twitter" href="http://twitter.com/Sylvain">@Sylvain</a>
            </li>
          </ul>
      </div> 

    </aside>
    
  </div>

</article>

<?php endwhile; endif; ?>
	
<?php get_footer(); ?>