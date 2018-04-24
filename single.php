<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WP_Bootstrap_Starter
 */

get_header(); ?>

<div id="content" class="site-content">
  <div class="container">
    <div class="row">

		<?php
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/expat-single', get_post_format() );

				//	the_post_navigation();
					
		endwhile; 
		?>


<?php

get_footer();
