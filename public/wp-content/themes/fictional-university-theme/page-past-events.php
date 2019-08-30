<?php
  get_header();
  pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => "Checkout what we've done in the past",
  ));
?>

<div class="container container--narrow page-section">
  <?php
    $today = date('Ymd');
    $pastEventPosts = new WP_Query(array(
    'paged' => get_query_var('paged', 1),
    'post_type' => 'event',
    'orderby' => 'meta_value_num',
    'meta_key' => 'event_date',
    'meta_query' => array(
        array(
        'key' => 'event_date',
        'value' => $today,
        'compare' => '<',
        'type' => 'numeric',
        )
    )
    ));

    while($pastEventPosts->have_posts()) {
        $pastEventPosts->the_post();
        $eventDate = new DateTime(get_field('event_date'));
        get_template_part('template-parts/content-event');
    }
    echo paginate_links(array(
        'total' => $pastEventPosts->max_num_pages,
    ));
  ?>
</div>


<?php
  get_footer();
?>