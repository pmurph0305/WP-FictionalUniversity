<?php
    function universityPostTypes() {
        register_post_type('event', array(
            'rewrite' => array('slug' => 'events'),
            'public' => true,
            'labels' => array(
                'name' => 'Events',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'all_items' => 'All Events',
                'singular_name' => 'Event'
            ),
            'supports' => array('title', 'editor', 'excerpt'),
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar-alt'
        ));
    }
    add_action('init', 'universityPostTypes');
?>