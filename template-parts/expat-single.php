<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="entry-content">  	
    <div class="expat-content">
      <header class="entry-header">
        <?php
        the_title( '<h1 class="entry-title">', '</h1>' ); 
        ?>
      </header><!-- .entry-header -->
    



      <?php
      the_content();
      ?>
    </div>
	</div><!-- .entry-content -->
  <div class="row group">
    <div class="col">
      <a class="btn btn-success" href="/expat/">Back</a>
    </div>
  </div>
  

</article><!-- #post-## -->
