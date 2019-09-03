<?php

    require get_theme_file_path('/includes/search-route.php');

    require get_theme_file_path('/includes/page-banner.php');

    require get_theme_file_path('/includes/files.php');

    require get_theme_file_path('/includes/features.php');

    require get_theme_file_path('/includes/custom-queries.php');

    // Example if you have a valid Google API Key.
    function universityMapKey($api) {
    $api['key'] = 'AIzaSyDuixh5dYEw4z1yhUuNLKRncySSqpTuO30';
    return $api;
    }
    add_filter('acf/fields/google_map/api', 'universityMapKey');


    function universityCustomizeRest() {
        register_rest_field('post', 'authorName', array(
            'get_callback' => function() { return get_the_author(); }
        ));
    }

    add_action('rest_api_init', 'universityCustomizeREST')
?>