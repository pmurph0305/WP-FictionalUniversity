<?php 

function pageBanner($args = NULL) {
  if (!$args['title']) {
      $args['title'] = get_the_title();
  }
  if (!$args['subtitle']) {
      $args['subtitle'] = get_field('page_banner_subtitle');
  }
  if (!$args['image_src']) {
      if (get_field('page_banner_background_image')) {
          $args['image_src'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
      } else {
          $args['image_src'] = get_theme_file_uri('/images/ocean.jpg');
      }
  }
  ?>
  <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url(
      <?php echo $args['image_src']; ?>);"></div>
      <div class="page-banner__content container container--narrow">
          <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
          <div class="page-banner__intro">
              <p><?php echo $args['subtitle']; ?></p>
          </div>
      </div>  
  </div>
<?php
}

?>