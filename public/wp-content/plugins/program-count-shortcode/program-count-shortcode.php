<?php

/*
Plugin Name: Program count shortcode
Description: Enables the use of [programCount] to get the # of programs.
*/

add_shortcode('programCount', 'getTotalProgramCount');

function getTotalProgramCount() {
  return wp_count_posts('program')->publish;
}
?>