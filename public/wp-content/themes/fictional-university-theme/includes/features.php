<?php
  function universityFeatures() {
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerMenuLocation1', 'Footer Location One');
    register_nav_menu('footerMenuLocation2', 'Footer Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 320, 400, true);
    add_image_size('pageBanner', 1500, 350, true);
  }
  add_action('after_setup_theme', 'universityFeatures');
?>