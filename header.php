<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Bootstrap_Starter
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>

</head>


<body <?php body_class(); ?>>
<div class="shadow-load "><img src="/loading.svg"></div>

<div id="page" class="site">




	
    <?php if(!is_page_template( 'blank-page.php' ) && !is_page_template( 'blank-page-with-container.php' )): ?>
	<header id="masthead" class="site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
        <div class="container">
            <nav class="navbar navbar-expand-xl p-0">
                <div class="logo">
                    <a href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img src="<?php echo esc_attr(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    </a>
                </div>
                <div style="  display: flex;  justify-content: center;  align-items: center; margin-left: auto;">
                    <?php
                    if (isusr("administrator")){
                        wp_nav_menu(array(
                        'theme_location'    => 'primary',
                        'container'       => 'div',
                        'container_id'    => '',
                        'container_class' => '',
                        'menu_id'         => false,
                        'menu_class'      => 'navbar-nav',
                        'depth'           => 3,
                        'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
                        'walker'          => new wp_bootstrap_navwalker()
                        ));
                    }
                    ?>
                    
                    <div class="menu-login">
                        <div class="inline">
                        <?php 
                        if ( is_user_logged_in() ) {
                            if (isusr('administrator')){

                                ?>
                                <span style="padding: 0 7px 0 0; color: #29b473; font-weight: bold;"> | </span>
                                <div class="more-menu">
                                    <i class="far fa-caret-square-down fa-1x"></i>
                                    <div class="more-menu-item">
                                        <a href="/wp-admin/admin.php?page=checklist-admin.php"><i class="fas fa-cog"></i> Setting</a>                                        
                                        <a href="<?php echo wp_logout_url(home_url()); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                    </div>
                                </div>                                
                                <?php  

                            }else{
                                ?>
                                <a style="color:#4fb880" href="/"><i class="fas fa-home"></i>My Property &nbsp;  </a>
                                <span style="padding: 4px 7px 0 0; color: #29b473; font-weight: bold;"> | </span>
                                <a href="<?php echo wp_logout_url(home_url()) ?>"> &nbsp; <i class="fas fa-sign-out-alt"></i> Logout</a>
                                <?php                                
                            }

                            
                            
                        } else {
                            echo '<a href="/login/"><i class="fas fa-sign-in-alt"></i> Login</a>';
                        }
                        ?>
                        </div>
                    </div>
                </div>            
            </nav>
        </div>
	</header><!-- #masthead -->
   
    <?php endif; ?>
	
                