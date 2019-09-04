<?php
  //customize login screen
  function headerUrl() {
      return esc_url(site_url('/'));
  }
  add_filter('login_headerurl', 'headerUrl');

  function enableLoginCSS() {
    // fonts
    wp_enqueue_style('custom_google_font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
    // css
    wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
  }
  add_action('login_enqueue_scripts', 'enableLoginCSS');

  function customizeHeaderTitle() {
      return get_bloginfo('name');
  }
  add_filter('login_headertitle', 'customizeHeaderTitle');
?>