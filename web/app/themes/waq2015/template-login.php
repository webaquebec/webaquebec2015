<?php
/*
 * Template Name: Login
 */
get_header();
?>


<section id="login" class="dark">

  <header>

    <div class="container">
      <h1 class="main title border-left">
        <?= get_the_title() ?>
        <div class="border-bottom expandable"></div>
      </h1>
    </div>

  </header>

  <div class="container">
   <article class="form">
      <?php
      wp_login_form( array(
        'id_submit' => 'submit-login',
        'redirect'       => get_permalink(get_ID_from_slug('mon-horaire')),
        'label_username' => __( 'Nom d\'utilisateur', 'waq' ),
            'label_password' => __( 'Mot de passe', 'waq' ),
            'label_remember' => __( 'Rester connecté', 'waq' ),
            'label_log_in'   => __( 'Connexion','waq' )
      ));
      ?>
    </article>
  </div>
</section>

<?php
get_footer();
?>


