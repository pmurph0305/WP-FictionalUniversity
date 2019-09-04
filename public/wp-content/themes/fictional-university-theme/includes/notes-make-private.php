<?php
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