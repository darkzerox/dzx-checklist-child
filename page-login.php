<?php
/**
* Template Name: Page Login
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


            <form name="loginform" id="loginform" action="/login/" method="post" _lpchecked="1">
              <div class="form-group tml-user-login-wrap">
                <label for="user_login">Username</label>
                <input type="text" name="log" id="user_login" class="input form-control" placeholder="Email">
              </div>

              <p class="tml-user-pass-wrap">
                <label for="user_pass">Password</label>
                <input type="password" name="pwd" id="user_pass" class="input form-control" value=""  autocomplete="off" placeholder="1234">
              </p>

              <input type="hidden" name="_wp_original_http_referer" value="/">
              <div class="tml-rememberme-submit-wrap">
                <p class="tml-rememberme-wrap" style="text-align: right;">
                  <input name="rememberme" type="checkbox" id="rememberme" value="forever">
                  <label for="rememberme">Remember Me</label>
                </p>

                <p class="tml-submit-wrap">
                  <input type="submit" name="wp-submit" id="wp-submit" value="LOG IN" class="btn btn-success btn-block">
                  <input type="hidden" name="redirect_to" value="/wp-admin/">
                  <input type="hidden" name="instance" value="">
                  <input type="hidden" name="action" value="login">
                </p>
              </div>
              <div class="txt-rignt"><a href="/lostpassword/">Lost password?</a></div>
            </form>
            
           
            <!-- <ul class="tml-action-links">
              <li>
                <a href="http://128.199.198.222/lostpassword/" rel="nofollow">Lost Password</a>
              </li>
            </ul> -->

            <?php 
             
              if ($_GET['checkemail'] == 'confirm'){                
                echo '<div class="alert alert-success" role="alert">A confirmation email has been sent to your email address.</div>';
              }
            ?>



          </div>
          <!-- .entry-content -->

        </article>




      </div>
              

      <div class="row">
        <h4>demo user</h4>
        <ul>
          <li>dbpth_admin : admin234@#$</li>          
          <li>landlord02 : landlord02</li>
          <li>tanant 01 : tanant01</li>
          
        </ul>
      </div>


    </main>
    <!-- #main -->
  </section>
  <!-- #primary -->

  <?php
get_footer();