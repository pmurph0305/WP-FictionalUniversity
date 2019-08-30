<?php
    function universityFiles() {
        // cache fix from quick note using microtime() for versions for styles & bundled scripts.
        wp_enqueue_script('main-university-js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, microtime(), true);
        wp_enqueue_style('custom_google_font', '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i');
        wp_enqueue_style('font_awesome_icons', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_enqueue_style('university_main_styles', get_stylesheet_uri(), NULL, microtime());
    }

    add_action('wp_enqueue_scripts', 'universityFiles');

    function universityFeatures() {
        register_nav_menu('headerMenuLocation', 'Header Menu Location');
        register_nav_menu('footerMenuLocation1', 'Footer Location One');
        register_nav_menu('footerMenuLocation2', 'Footer Location Two');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_image_size('professorLandscape', '400', '260', true);
        add_image_size('professorPortrait', '320', '400', true);
    }
    add_action('after_setup_theme', 'universityFeatures');

    function universityAdjustQueries($query) {
        if (!is_admin() AND is_post_type_archive('event') AND $query->is_main_query()) {
            $today = date('Ymd');
            $query->set('order', 'ASC');
            $query->set('order_by', 'meta_value_num');
            $query->set('meta_key', 'event_date');
            $query->set('meta_query', array(
                array(
                  'key' => 'event_date',
                  'value' => $today,
                  'compare' => '>=',
                  'type' => 'numeric',
                )
            ));
        }
        if (!is_admin() AND is_post_type_archive('program') AND $query->is_main_query()) {
            $query->set('order', 'ASC');
            $query->set('orderby', 'title');
            $query->set('posts_per_page', -1);
        }
    }
    add_action('pre_get_posts', 'universityAdjustQueries');
?>