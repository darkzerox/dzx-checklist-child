<?php 
/**
 * Template Name: page-expat
 */

get_header();



?>

<div id="content" class="site-content">
  <div class="container">
    <h1 class="center title">Expat Living Guide</h1>

    <div class="row">
    

    <?php
    $args = array(
        'post_type' => 'post'
    );

    $post_query = new WP_Query($args);
    if($post_query->have_posts() ) {
      while($post_query->have_posts() ) {
        $post_query->the_post();
        ?>
        <div class="expat-article">
          <div class="article-contener">
            <div class="post-thumbnail">
              <a href=" <?php echo esc_url( get_permalink() ); ?>" >
                <?php the_post_thumbnail(); ?>
              </a>
            </div>
            <h2 class="entry-title">
              <?php the_title( '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a>' ); ?>
            </h2>
          </div>
        </div>

        <?php
      }
    }
?>





<?php get_footer(); ?>