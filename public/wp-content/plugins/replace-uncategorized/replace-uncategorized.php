<?php 
/*
Plugin Name: Replace Uncategorized
Description: Replaces "Uncategorized" as a category to "General" for blog posts.
*/

  function removeUncategorized($categoryList) {
    foreach($categoryList as $category) {
      if ($category->name == 'Uncategorized') {
        $category->name = 'General';
      }
    }
    return $categoryList;
  }

  add_filter('the_category_list', 'removeUncategorized');
?>