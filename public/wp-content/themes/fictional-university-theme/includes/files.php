<?php
    function universityFiles() {
      // cache fix from quick note using microtime() for versions for styles & bundled scripts.
      wp_enqueue_script('googleMap', "//maps.googleapis.com/maps/api/js?key=AIzaSyDuixh5dYEw4z1yhUuNLKRncySSqpTuO30", NULL, microtime(), true);
      wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
      wp_enqueue_style('custom_google_font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
      wp_enqueue_style('font_awesome_icons', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
      wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
      wp_localize_script('main-university-js', 'universityData', array(
          'rootUrl' =>  get_site_url(),
      ));
    }

    add_action('wp_enqueue_scripts', 'universityFiles');
?>
