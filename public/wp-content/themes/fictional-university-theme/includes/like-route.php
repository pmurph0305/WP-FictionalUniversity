<?php

  function universityLikeRoutes() {
    register_rest_route('university/v1', 'like', array(
      'methods' => 'POST',
      'callback' => 'handleCreateLike',
    ));

    register_rest_route('university/v1', 'like', array(
      'methods' => 'DELETE',
      'callback' => 'handleDeleteLike',
    ));
  }

  add_action('rest_api_init', 'universityLikeRoutes');

  function handleCreateLike($data) {
    if(is_user_logged_in()) {
      $professorId = sanitize_text_field($data['professorId']);
      $hasLikedQuery = new WP_Query(array(
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => array(
          array(
            'key' => 'liked_professor_id',
            'compare' => '=',
            'value' => $professorId
          )
        ),
      ));
      if ($hasLikedQuery->found_posts == 0 && get_post_type($professorId) == 'professor') {
        return wp_insert_post(array(
          'post_type' => 'like',
          'post_status' => 'publish',
          'post_title' => '2',
          'meta_input' => array(
            'liked_professor_id' => $professorId
          )
        ));
      } else {
        die("Invalid professor ID");
      }
    } else {
      die("Only logged in users can like professors.");
    }
  }

  function handleDeleteLike($data) {
    $likeId = sanitize_text_field($data['likeId']);
    $n = get_post_field('post_author', $likeId);
    if (get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
      wp_delete_post($likeId, true);
      return 'Like removed.';
    } else {
      die('You do not have the correct permissions to delete that.');
    }
  }
?>