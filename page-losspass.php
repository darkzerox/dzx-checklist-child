<?php
/**
* Template Name: Page Losspass
 */

get_header(); ?>

  <section id="primary" class="content-area col-sm-12 full-height">
    <main id="main" class="site-main" role="main">

      <div class="login-page">
        <div class="logo-login center">
          <a href="<?php echo esc_url( home_url( '/' )); ?>">
            <img src="<?php echo esc_attr(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
          </a>
        </div>
        <h4 class="center">Expat Living Guide & Moving Checklist</h4>



        <article id="post-8" class="post-8 page type-page status-publish hentry">
          <div class="entry-content">
            <div class="tml tml-lostpassword" id="theme-my-login">
              <p class="message">Please enter your username or email address. You will receive a link to create a new password via email.</p>

              <form name="lostpasswordform" id="lostpasswordform" action="/lostpassword/" method="post">
                <div class="form-group tml-user-login-wrap">
                
                  <input type="text" name="user_login" id="user_login" class="input form-control" value="" size="20" placeholder="Username or E-mail">
                </div>



                <p class="tml-submit-wrap center">
                  <input class="btn btn-success" type="submit" name="wp-submit" id="wp-submit" value="Get New Password">
                  <input type="hidden" name="redirect_to" value="/login/?checkemail=confirm">
                  <input type="hidden" name="instance" value="">
                  <input type="hidden" name="action" value="lostpassword">
                </p>
              </form>


            </div>


          </div>

        </article>




      </div>



    </main>
    <!-- #main -->
  </section>
  <!-- #primary -->

  <?php
get_footer();