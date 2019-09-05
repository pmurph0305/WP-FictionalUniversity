<?php

    require get_theme_file_path('/includes/search-route.php');

    require get_theme_file_path('/includes/like-route.php');

    require get_theme_file_path('/includes/page-banner.php');

    require get_theme_file_path('/includes/files.php');

    require get_theme_file_path('/includes/features.php');

    require get_theme_file_path('/includes/custom-queries.php');

    // redirect and hide admin bar for subscribers.
    require get_theme_file_path('/includes/subscriber-customize.php');
    
    // customize login header, url, logo
    require get_theme_file_path('/includes/login-customize.php');

    // make notes route private
    require get_theme_file_path('/includes/notes-make-private.php');

    // Example if you have a valid Google API Key.
    function universityMapKey($api) {
    $api['key'] = 'AIzaSyDuixh5dYEw4z1yhUuNLKRncySSqpTuO30';
    return $api;
    }
    add_filter('acf/fields/google_map/api', 'universityMapKey');

    //example customize rest api for author name.
    function universityCustomizeRest() {
        register_rest_field('post', 'authorName', array(
            'get_callback' => function() { return get_the_author(); }
        ));
        register_rest_field('note', 'userNoteCount', array(
            'get_callback' => function() { return count_user_posts(get_current_user_id(), 'note'); }
        ));
    }
    add_action('rest_api_init', 'universityCustomizeREST');
?>