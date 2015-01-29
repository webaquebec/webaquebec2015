<?php
/*
 * Template Name: Login
 */
get_header();
if(have_posts()): while(have_posts()): the_post();
?>


<section id="login">

  <header>
    <div class="container narrow">
      <h1 class="main title border-left">
        <?= get_the_title() ?>
        <div class="border-bottom"></div>
      </h1>
    </div>
  </header>
  <div class="container narrow">
   <article>
      <div class="card form">
        <div class="tabs">
          <nav class="tab-triggers">
            <button tab="login" class="tab-trigger title<?php if(!isset($_GET['registration'])) echo ' active' ?>">
              <?= __('J\'ai déjà <br>un compte', 'waq') ?>
            </button>
            <button tab="register" class="tab-trigger title<?php if(isset($_GET['registration'])) echo ' active' ?>">
              <?= __('Je veux me créer <br>un compte', 'waq') ?>
            </button>
          </nav>

          <div class="tab-contents">
            <?php
            $login =  isset($_GET['login']) ? explode(' ', $_GET['login']) : [];
            $registration =  isset($_GET['registration']) ? explode(' ', $_GET['registration']) : [];
            ?>

            <div tab="login" class="tab-content <?php if(!isset($_GET['registration'])) echo ' active' ?>">

              <div class="social-account">
                <?php
                  ob_start();
                  do_action( 'wordpress_social_login' );
                  $loginForm = ob_get_contents();
                  ob_end_clean();
                  $loginForm = preg_replace('/<a(.*?)>(.*?)<\/a>/is', "<a$1 tab-index=\"2\"><span>$2</span></a>", $loginForm);
                  echo $loginForm;
                ?>
              </div>

              <div class="centered border-middle"><?= __('ou','waq') ?></div>

              <div class="wp-account">
                <?php
                $loginForm = wp_login_form( array(
                  'echo' => false,
                  'id_submit' => 'submit-login',
                  'redirect'       => get_permalink(get_ID_from_slug('mon-horaire')),
                  'label_username' => __( 'Nom d\'utilisateur', 'waq' ),
                      'label_password' => __( 'Mot de passe', 'waq' ),
                      'label_remember' => __( 'Rester connecté', 'waq' ),
                      'label_log_in'   => __( 'Connexion','waq' ),
                      'value_username' =>isset($_GET['user']) ? urldecode($_GET['user']) : NULL
                ));
                $loginForm = preg_replace('/<p(.*?)>(.*?)<\/p>/is', "<div class=\"field\"><p$1>$2</p></div>", $loginForm);
                echo $loginForm;
                ?>
              </div>

            </div>

            <div tab="register" class="tab-content<?php if(isset($_GET['registration'])) echo ' active' ?>">
              <form id="registerform" class="form" action="<?= site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
              <?php
              // Success
              if(in_array('success', $registration)):?>
              <h3 class="message success sub title">
                <?= __( 'Votre compte a bien été créé. Vérifiez vos courriels pour récupérer votre mot de passe', 'waq' ) ?>
              </h3>
              <?php endif; ?>

                <div class="field required">
                  <label for="user_login"><?= __( 'Nom d\'utilisateur', 'waq' ) ?></label>
                  <?php
                  // empty username
                  if(in_array('empty_username', $registration)):?>
                    <p class="error message note"><?= __( 'Un nom d\'utilisateur est requis', 'waq' ) ?></p>
                  <?php endif; ?>
                  <?php
                  // username already exists
                  if(in_array('username_exists', $registration)):?>
                    <p class="error message note"><?= __( 'Le nom d\'utilisateur est déjà utilisé', 'waq' ) ?></p>
                  <?php endif; ?>
                  <input type="text" name="user_login" id="user_login" class="input" <?php if(isset($_GET['user'])) echo 'value="'.urldecode($_GET['user']).'"'; ?>/>
                </div>

                <div class="field">
                  <label for="user_name"><?= __( 'Nom complet (affiché sur le site)', 'waq' ) ?></label>
                  <input type="text" name="user_name" id="user_name" class="input" />
                </div>
                 <div class="field required">
                  <label for="user_email"><?= __( 'Adresse courriel', 'waq' ) ?></label>
                  <?php
                  // email is empty
                  if(in_array('empty_email', $registration)):?>
                    <p class="error message note"><?= __( 'Une adresse courriel est requise', 'waq' ) ?></p>
                  <?php endif; ?>
                  <?php
                  // email is invalid
                  if(in_array('invalid_email', $registration)):?>
                    <p class="error message note"><?= __('Veuillez entrer une adresse courriel valide','waq') ?></p>
                  <?php endif; ?>
                  <?php
                  // email already exists
                  if(in_array('email_exists', $registration)):?>
                    <p class="error message note"><?= __( 'L\'adresse courriel est déjà utilisée', 'waq' ) ?></p>
                  <?php endif; ?>
                  <input type="text" name="user_email" id="user_email" class="input" <?php if(isset($_GET['email'])) echo 'value="'.urldecode($_GET['email']).'"'; ?> />
                </div>
                <?php do_action('register_form'); ?>
                <div class="field">
                  <div class="register-submit">
                    <input type="submit" value="<?= __( 'Envoyer', 'waq' ) ?>" id="register" />
                  </div>
                  <p class="small title"><?= __( 'Un mot de passe vous sera envoyé par courriel.', 'waq' ) ?></p>
                </div>
              </form>

            </div>
          </div>
      </div>
    </article>
  </div>
</section>
<?php
endwhile; endif;
get_footer();
?>


