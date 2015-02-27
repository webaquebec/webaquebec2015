<?php
/*
 * Template Name: Login
 */
get_header();
if(have_posts()): while(have_posts()): the_post();
?>


<section id="login" class="single">

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
            $login_errors =  isset($_GET['login']) ? explode(' ', $_GET['login']) : [];
            $registration_errors =  isset($_GET['registration']) ? explode(' ', $_GET['registration']) : [];
            $success =  isset($_GET['success']);
            ?>

            <div tab="login" class="tab-content <?php if(!isset($_GET['registration'])) echo ' active' ?>">
               <?php
              // Success
              if($success):?>
              <h3 class="message success title">
                <?= __( 'Votre compte a bien été créé.', 'waq' ) ?>
              </h3>
              <?php else: ?>

              <div class="social-account">
                <h3>
                  <div class="message"><?= __('Connectez-vous avec') ?></div>
                  <?= fb_login_form() ?>
                </h3>
              </div>

              <div class="centered border-middle"><?= __('ou','waq') ?></div>

              <?php endif; ?>

              <div class="wp-account">
                <?= user_login_form($login_errors) ?>
              </div>

            </div>

            <div tab="register" class="tab-content<?php if(isset($_GET['registration'])) echo ' active' ?>">

              <?php
              // Success
              if($success):?>
              <h3 class="message success title">
                <?= __( 'Votre compte a bien été créé.', 'waq' ) ?>
              </h3>
              <?php else: ?>

              <div class="social-account">
                <h3>
                  <div class="message"><?= __('Connectez-vous avec') ?></div>
                  <?= fb_login_form() ?>
                </h3>
              </div>

              <div class="centered border-middle"><?= __('ou','waq') ?></div>

              <?php endif; ?>


              <form id="registerform" class="form" action="<?= site_url('wp-login.php?action=register', 'login_post') ?>" method="post">
                <div class="field required">
                  <label for="user_login"><?= __( 'Nom d\'utilisateur', 'waq' ) ?></label>
                  <?php // empty username
                  if(in_array('empty_username', $registration_errors)):?>
                    <p class="error message note"><?= __( 'Un nom d\'utilisateur est requis', 'waq' ) ?></p>
                  <?php endif; ?>
                  <?php // username already exists
                  if(in_array('username_exists', $registration_errors)):?>
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
                  <?php // email is empty
                  if(in_array('empty_email', $registration_errors)):?>
                    <p class="error message note"><?= __( 'Une adresse courriel est requise', 'waq' ) ?></p>
                  <?php endif; ?>
                  <?php // email is invalid
                  if(in_array('invalid_email', $registration_errors)):?>
                    <p class="error message note"><?= __('Veuillez entrer une adresse courriel valide','waq') ?></p>
                  <?php endif; ?>
                  <?php // email already exists
                  if(in_array('email_exists', $registration_errors)):?>
                    <p class="error message note"><?= __( 'L\'adresse courriel est déjà utilisée', 'waq' ) ?></p>
                  <?php endif; ?>
                  <input type="text" name="user_email" id="user_email" class="input" <?php if(isset($_GET['email'])) echo 'value="'.urldecode($_GET['email']).'"'; ?> />
                </div>

                <div class="field required">
                  <label for="user_password"><?= __( 'Mot de passe', 'waq' ) ?></label>
                  <?php // passowrd is empty
                  if(in_array('password_missing', $registration_errors)):?>
                    <p class="error message note"><?= __( 'Un mot de passe est requis', 'waq' ) ?></p>
                  <?php endif; ?>
                  <input type="password" name="user_password" id="user_password" class="input" />
                </div>

                <div class="field required">
                  <label for="user_password_repeat"><?= __( 'Répétez le mot de passe', 'waq' ) ?></label>
                  <?php // passowrd_repeat is empty
                  if(in_array('password_repeat_missing', $registration_errors)):?>
                    <p class="error message note"><?= __( 'Rétépez le mot de passe ici', 'waq' ) ?></p>
                  <?php endif; ?>
                  <input type="password" name="user_password_repeat" id="user_password_repeat" class="input"/>
                </div>

                <?php do_action('register_form'); ?>
                <div class="field">
                  <div class="register-submit">
                    <input type="submit" value="<?= __( 'Envoyer', 'waq' ) ?>" id="register" />
                  </div>
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


