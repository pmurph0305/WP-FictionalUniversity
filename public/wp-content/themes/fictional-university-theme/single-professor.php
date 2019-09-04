<?php
    get_header();
    while(have_posts()) {
        the_post();
        pageBanner();
        ?>


<div class="container container--narrow page-section">
  <div class="generic-content">
    <div class="row group">
      <div class="one-third"><?php the_post_thumbnail('professorPortrait'); ?></div>
      <div class="two-thirds">
        <?php 
            $likes = new WP_Query(array(
              'post_type' => 'like',
              'meta_query' => array(
                array(
                  'key' => 'liked_professor_id',
                  'compare' => '=',
                  'value' => get_the_ID()
                )
              ),
            ));
            $userLikedStatus = 'no';
            if (is_user_logged_in()) {
              $hasLikedQuery = new WP_Query(array(
                'author' => get_current_user_id(),
                'post_type' => 'like',
                'meta_query' => array(
                  array(
                    'key' => 'liked_professor_id',
                    'compare' => '=',
                    'value' => get_the_ID()
                  )
                ),
              ));
              if ($hasLikedQuery->found_posts) {
                $userLikedStatus = 'yes';
              }
            }
        ?>
        <span class="like-box" data-professor-id="<?php the_ID(); ?>" data-like-id="<?php echo $hasLikedQuery->posts[0]->ID; ?>" data-exists="<?php echo $userLikedStatus; ?>">
          <i class="fa fa-heart-o" area-hidden="true"></i>
          <i class="fa fa-heart" area-hidden="true"></i>
          <span class="like-count"><?php echo $likes->found_posts; ?></span>
        </span>
        <?php the_content(); ?>
      </div>
    </div>
  </div>

  <?php 
    $relatedPrograms = get_field('related_programs'); 
    if ($relatedPrograms) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
        echo '<ul class="link-list min-list">';
        foreach($relatedPrograms as $program) { ?>
  <li>
    <a href="<?php echo get_the_permalink($program); ?>">
      <?php echo get_the_title($program); ?>
    </a>
  </li>
  <?php }
        echo '</ul>';
    }
?>

</div>
<?php }

    get_footer();
?>