<?php

    require get_theme_file_path('/includes/search-route.php');

    require get_theme_file_path('/includes/page-banner.php');

    require get_theme_file_path('/includes/files.php');

    require get_theme_file_path('/includes/features.php');

    require get_theme_file_path('/includes/custom-queries.php');

    // redirect and hide admin bar for subscribers.
    require get_theme_file_path('/includes/subscriber-customize.php');
    
    // customize login header, url, logo
    require get_theme_file_path('/includes/login-customize.php');

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
    


    // Force note posts to be private.
    function forceNotesToBePrivate($data, $postarr) {
        if ($data['post_type'] == 'note') {
            if (count_user_posts(get_current_user_id(), 'note') > 4 AND !$postarr['ID']) {
                die('You have reached your maximum note limit.');
            }
            $data['post_content'] = sanitize_textarea_field($data['post_content']);
            $data['post_title'] = sanitize_text_field($data['post_title']);
        }
        if ($data['post_type'] == 'note' AND $data['post_status'] != 'trash') {
            $data['post_status'] = 'private';
        }
        return $data;
    }
    add_filter('wp_insert_post_data', 'forceNotesToBePrivate', 10, 2);
?>