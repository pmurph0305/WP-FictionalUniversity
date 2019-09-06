<div class="hero-slider">
  <?php 
   $file_url = get_the_post_thumbnail_url($post,'frontpageSlideShow');
   if (!$file_url) {
     $file_url = get_theme_file_uri('/images/bus.jpg');
   }
  ?>
  <div class="hero-slider__slide" style="background-image: url(<?php echo $file_url ?>;">
    <div class="hero-slider__interior container">
      <div class="hero-slider__overlay">
        <h2 class="headline headline--medium t-center"><?php the_title(); ?></h2>
        <p class="t-center"><?php echo get_the_content(); ?></p>
        <p class="t-center no-margin"><a href="<?php echo esc_url(get_field('slideshow_link'))?>" class="btn btn--blue">Learn more</a></p>
      </div>
    </div>
  </div>
</div>