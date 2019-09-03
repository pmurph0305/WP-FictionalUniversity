<?php
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
?>