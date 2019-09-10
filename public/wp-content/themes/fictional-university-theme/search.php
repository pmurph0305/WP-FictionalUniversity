<?php
  get_header();
  pageBanner(array(
    'title' => 'Search Results',
    'subtitle' => 'You searched for &ldquo;'. esc_html(get_search_query(false)) .'&rdquo;'
  ))
?>

<div class="container container--narrow page-section">
  <?php 
    $term = sanitize_text_field(get_query_var('s'));
    if ($term) {
      $results = universitySearchResults(array(
        'term' => $term
      ));
        echo '<h2 class="search-overlay__section-title">General Info</h2>';
        echo ($results['generalInfo'] ? '<ul class="link-list min-list">' : '<p>No results found.</p>');
        
        foreach($results['generalInfo'] as $result) {
          echo '<li><a href="' . $result['permalink'] . '">';
          echo $result['title'];
          echo '</a></li>';
        }
        echo '</ul>';
        
        echo '<h2 class="search-overlay__section-title">Events</h2>';
        echo ($results['events'] ? '<br>' :  '<p>No events found. <a href="'. site_url('/events') .'">View all events.</a></p>');
        foreach($results['events'] as $result) {
          echo '<div class="event-summary">';
          echo '<a class="event-summary__date t-center" href="' . $result['permalink'] . '">';
          echo '<span class="event-summary__month">' . $result['month'] . '</span>';
          echo '<span class="event-summary__day">' . $result['day'] . '</span>';
          echo '</a>';
          echo '<div class="event-summary__content">';
          echo '<h5 class="event-summary__title headline headline--tiny"><a href="' . $result['permalink'] . '">' . $result['title'] . '</a></h5>';
          echo '<p>' . $result['description'] . '<a href="' . $result['permalink'] . '" class="nu gray">Learn more</a>';
          echo '</p></div></div>';
        }
    }
  ?>
  <?php
    if (have_posts()) {
      while(have_posts()) {
        the_post();
        get_template_part('template-parts/content', get_post_type()); 
      }
      echo paginate_links();
    } else {
      echo '<h2 class="headline headline--small-plus">No results found.</h2>';
    }
    get_search_form();
  ?>

</div>


<?php
  get_footer();
?>