<?php get_header(); ?>

<?php if(have_posts()): while(have_posts()): the_post(); ?>

<article class="single">

  <hgroup class="l-grey">
    <div class="container">

      <button class="btn seamless favorite toggle" toggle-content="<?= __('Ajouté à mon horaire','waq') ?>"><span><?= __('Ajouter à mon horaire','waq') ?></span></button>

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
      <div class="content">
        <p>Je vais vous jaser de culture. Je vais vous expliquer pourquoi j’ai décidé de m’expatrier en Californie pour travailler pour Twitter. Je vais vous raconter comment je me suis rendu à l’évidence que l’internet allait révolutionner la planète entière (en 1993). Je vais vous parler d’innovation, de hackers, de startups, de hackweek, de github. Je vais explorer avec vous la mémétique en temps réel, l’explosion de données, l’univers derrière la trou de serrure qu’est votre liste d’abonnement Twitter (ou Facebook ou Pinterest). On va se gosser un présent et un futur en réseau au Québec, on va se tisser une ceinture fléchée 2.0. On va se parler des petites affaires pis des grandes (mais pas de « vraies affaires », ok)? On va se faire un conte pas piqué de vers numériques, on va trouver une meilleure conclusion que celle qu’on a pas encore vue, que celle qui va nous arriver inopinément si on ne fait rien. On va se chimer l’univers, on va se retrouver un passé, on va se conversationner un possible. Ça devrait pas être compliqué, ça sera un peu utopique, mais pas trop, surtout pragmatique. Ça serait comme un genre de manifeste de quoi faire, mettons qu’on aurait une politique numérique, le après (qui est le maintenant). En prime, ça devrait pas être plate.</p>  
      </div>
    </section>

    <aside class="col narrow" role="complementary">

      <div class="content">

        <div class="thumb">
          <img src="http://2014.webaquebec.org/wp-content/uploads/2014/01/sylvain_carle-227x190.png" alt="Sylvain Carle" />
        </div>

        <span class="small title">À propos de</span>
        <h2 class="sub title">Sylvain Carles</h2>


      </div> 

    </aside>
    
  </div>

</article>

<?php endwhile; endif; ?>
	
<?php get_footer(); ?>