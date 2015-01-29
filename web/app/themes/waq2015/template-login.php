<?php
/*
 * Template Name: Login
 */
get_header();
?>


<section id="login">

  <header>
    <div class="container">
      <h1 class="main title border-left">
        <?= get_the_title() ?>
        <div class="border-bottom"></div>
      </h1>
    </div>
  </header>

  <div class="cols container">
    <div class="col wide">
      <?php the_content(); ?>
    </div>
    <div class="narrow">
     <article class="form card narrow">
        <?php
        $loginForm = wp_login_form( array(
          'echo' => false,
          'id_submit' => 'submit-login',
          'redirect'       => get_permalink(get_ID_from_slug('mon-horaire')),
          'label_username' => __( 'Nom d\'utilisateur', 'waq' ),
              'label_password' => __( 'Mot de passe', 'waq' ),
              'label_remember' => __( 'Rester connecté', 'waq' ),
              'label_log_in'   => __( 'Connexion','waq' )
        ));
        $loginForm = preg_replace('/<p(.*?)>(.*?)<\/p>/is', "<div class=\"field\"><p$1>$2</p></div>", $loginForm);
        echo $loginForm;
        ?>
      </article>
    </div>
  </div>
</section>

<?php
get_footer();
?>


