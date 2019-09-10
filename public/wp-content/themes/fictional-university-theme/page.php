<?php
    get_header();

    while(have_posts()) {
        the_post();
        pageBanner();
        ?>

        

        <div class="container container--narrow page-section">
            <?php 
                $parentId = wp_get_post_parent_id(get_the_ID());
                if ($parentId) {
            ?>
                <div class="metabox metabox--position-up metabox--with-home-link">
                    <p><a class="metabox__blog-home-link" 
                            href="<?php echo get_permalink($parentId); ?>">
                            <i class="fa fa-home" aria-hidden="true"></i> 
                            Back to 
                            <?php echo get_the_title($parentId); ?>
                        </a> <span class="metabox__main"><?php the_title(); ?></span></p>
                </div>
            <?php 
                }
            ?>
            <?php 
                $testArray = get_pages(array(
                    'child_of' => get_the_ID()
                ));
                if ($parentId or $testArray) { ?>
                <div class="page-links">
                    <h2 class="page-links__title">
                        <a href="<?php echo get_permalink($parentId) ?>">
                            <?php echo get_the_title($parentId); ?>
                        </a>
                    </h2>
                    <ul class="min-list">
                        <?php
                            if ($parentId) {
                                $findChildrenOf = $parentId;
                            } else {
                                $findChildrenOf = get_the_ID();
                            }
                            wp_list_pages(array(
                                'title_li' => NULL,
                                'child_of' => $findChildrenOf,
                                'sort_column' => 'menu_order'
                            ));
                        ?>
                    </ul>
                </div>
            <?php } ?>
            
            <div class="generic-content">
            <?php the_content(); 
            $skyColor = sanitize_text_field(get_query_var('skyColor'));
            if ($skyColor) {
                echo '<p>Sky is '.$skyColor.".</p>";
            }
               ?>

               <form method="get">
                    <input name="skyColor" placeholder="Sky Color">
                    <button>Submit</button>
               </form>
            </div>

        </div>



    <?php }

    get_footer();
?>
