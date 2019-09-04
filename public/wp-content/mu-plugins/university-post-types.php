<?php
    function universityPostTypes() {
        // Event post type.
        register_post_type('event', array(
            'capability_type' => 'event',
            'map_meta_cap' => true,
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
            'menu_icon' => 'dashicons-calendar-alt',
        ));

        // Program post type.
        register_post_type('program', array(
            'rewrite' => array('slug' => 'programs'),
            'public' => true,
            'labels' => array(
                'name' => 'Programs',
                'add_new_item' => 'Add New Program',
                'edit_item' => 'Edit Program',
                'all_items' => 'All Programs',
                'singular_name' => 'Program'
            ),
            'supports' => array('title'),
            'has_archive' => true,
            'menu_icon' => 'dashicons-awards'
        ));

        // Professor post type
        register_post_type('professor', array(
            'public' => true,
            'labels' => array(
                'name' => 'Professors',
                'add_new_item' => 'Add New Professor',
                'edit_item' => 'Edit Professor',
                'all_items' => 'All Professors',
                'singular_name' => 'Professor'
            ),
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-welcome-learn-more',
            'show_in_rest' => true,
        ));

        // Campus post type
        register_post_type('campus', array(
            'capability_type' => 'campus',
            'map_meta_cap' => true,
            'rewrite' => array('slug' => 'campuses'),
            'public' => true,
            'labels' => array(
                'name' => 'Campuses',
                'add_new_item' => 'Add New Campus',
                'edit_item' => 'Edit Campus',
                'all_items' => 'All Campuses',
                'singular_name' => 'Campus'
            ),
            'supports' => array('title', 'editor', 'excerpt'),
            'has_archive' => true,
            'menu_icon' => 'dashicons-location-alt'
        ));

        // Note post type
        register_post_type('note', array(
            'capability_type' => 'note',
            'map_meta_cap' => true,
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Notes',
                'add_new_item' => 'Add New Note',
                'edit_item' => 'Edit Note',
                'all_items' => 'All Notes',
                'singular_name' => 'Note'
            ),
            'supports' => array('title', 'editor'),
            'menu_icon' => 'dashicons-welcome-write-blog',
            'show_in_rest' => true,
        ));

        // Like post type
        register_post_type('like', array(
            'public' => false,
            'show_ui' => true,
            'labels' => array(
                'name' => 'Likes',
                'add_new_item' => 'Add New Like',
                'edit_item' => 'Edit Like',
                'all_items' => 'All Likes',
                'singular_name' => 'Like'
            ),
            'supports' => array('title'),
            'menu_icon' => 'dashicons-heart',
        ));
    }
    add_action('init', 'universityPostTypes');
?>