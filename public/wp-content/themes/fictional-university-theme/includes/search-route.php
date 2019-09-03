<?php

  function universityRegisterSearch() {
    register_rest_route('university/v1', 'search', array(
      'methods' => WP_REST_SERVER::READABLE,
      'callback' => 'universitySearchResults',
    ));
  }

  function universitySearchResults($data) {
    // holds related programs found through posts of type professor and event.
    // to prevent duplication of results, and unrelated results.
    // don't want to query for all the events for a course a professor teacher, when searching for a professor!
    // but you do want to see his programs.
    $relatedProgramsFound = array();
    
    $query = new WP_Query(array(
      'post_type' => array('post', 'page', 'professor', 'program', 'campus', 'event'),
      's' => sanitize_text_field($data['term'])
    ));
    $results = array(
      'generalInfo' => array(),
      'professors' => array(),
      'programs' => array(),
      'events' => array(),
      'campuses' => array()
    );
    while($query->have_posts()) {
      $query->the_post();
      if (get_post_type() == 'post' OR get_post_type() === 'page') {
        array_push($results['generalInfo'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'postType' => get_post_type(),
          'authorName' => get_the_author()
        ));
      } else if (get_post_type() == 'professor') {
        array_push($results['professors'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
        ));

        // add programs to seperate relatedPrograms array, not $results['programs'] to prevent unrelated results in 2nd query.
        $relatedPrograms = get_field('related_programs');
        if($relatedPrograms) {
          foreach($relatedPrograms as $program) {
            array_push($relatedProgramsFound, array(
              'title' => get_the_title($program),
              'permalink' => get_the_permalink($program),
              'id' => $program->ID
            ));
          }
        }
      } else if (get_post_type() == 'program') {
        $relatedCampuses = get_field('related_campus');
        if ($relatedCampuses) {
          foreach($relatedCampuses as $campus) {
            array_push($results['campuses'], array(
              'title' => get_the_title($campus),
              'permalink' => get_the_permalink($campus),
            ));
          }
        }
        array_push($results['programs'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'id' => get_the_id(),
        ));
      } else if (get_post_type() == 'event') {
        $eventDate = new DateTime(get_field('event_date'));
        $description = null;
        if (has_excerpt()) {
          $description = get_the_excerpt();
        } else { 
          $description = wp_trim_words(get_the_content(), 18); 
        } 
        array_push($results['events'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
          'month' => $eventDate->format('M'),
          'day' => $eventDate->format('d'),
          'description' => $description,
        ));
        // add programs to seperate relatedPrograms array, not $results['programs'] to prevent unrelated results in 2nd query.
        $relatedPrograms = get_field('related_programs');
        if($relatedPrograms) {
          foreach($relatedPrograms as $program) {
            array_push($relatedProgramsFound, array(
              'title' => get_the_title($program),
              'permalink' => get_the_permalink($program),
              'id' => $program->ID
            ));
          }
        }
      }
      else if (get_post_type() == 'campus') {
        array_push($results['campuses'], array(
          'title' => get_the_title(),
          'permalink' => get_the_permalink(),
        ));
      }
    }

    if ($results['programs']) {
      $programsMetaQuery = array(
        'relation' => 'OR'
      );

      foreach($results['programs'] as $program) {
        array_push($programsMetaQuery, array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => '"' . $program['id'] . '"'
        ));
      }

      $programRelationshipQuery = new WP_Query(array(
        'post_type' => array('professor', 'event'),
        'meta_query' => $programsMetaQuery,
      ));

      while($programRelationshipQuery->have_posts()) {
        $programRelationshipQuery->the_post();
        if (get_post_type() == 'professor') {
          array_push($results['professors'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
          ));
        } else if (get_post_type() == 'event') {
          $eventDate = new DateTime(get_field('event_date'));
          $description = null;
          if (has_excerpt()) {
            $description = get_the_excerpt();
          } else { 
            $description = wp_trim_words(get_the_content(), 18); 
          } 
          array_push($results['events'], array(
            'title' => get_the_title(),
            'permalink' => get_the_permalink(),
            'month' => $eventDate->format('M'),
            'day' => $eventDate->format('d'),
            'description' => $description,
          ));
        }
      }
    }

    // add the related programs found (through events & professors) to the programs field after the 2nd query
    if($relatedProgramsFound) {
      foreach($relatedProgramsFound as $program) {
        array_push($results['programs'], $program);
      }
    }

    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));
    $results['campuses'] = array_values(array_unique($results['campuses'], SORT_REGULAR));
    $results['programs'] = array_values(array_unique($results['programs'], SORT_REGULAR));

     return $results;
    
  }

  add_action('rest_api_init', 'universityRegisterSearch');
?>