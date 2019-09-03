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
        if (!is_admin() AND is_post_type_archive('campus') AND $query->is_main_query()) {
            $query->set('posts_per_page', -1);
        }
    }
    add_action('pre_get_posts', 'universityAdjustQueries');

    // Example if you have a valid Google API Key.
    function universityMapKey($api) {
    $api['key'] = 'AIzaSyDuixh5dYEw4z1yhUuNLKRncySSqpTuO30';
    return $api;
    }
    add_filter('acf/fields/google_map/api', 'universityMapKey');
?>