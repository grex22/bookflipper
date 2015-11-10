<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

/**
 * Add <body> classes
 */

function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', 'sage') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');



// Adding extra column for admin user list to display user meta data


function add_user_columns( $defaults ) {
  $defaults['search_count'] = __('Searches', 'user-column');
  return $defaults;
}
add_filter('manage_users_columns', 'Roots\Sage\Extras\add_user_columns');

function gbb_add_search_number_column($value, $column_name, $user_id) {
  $count = get_user_meta( $user_id, 'search_count',true );
  if ( 'search_count' == $column_name ) return intval($count);
}
add_action('manage_users_custom_column', 'Roots\Sage\Extras\gbb_add_search_number_column', 10, 3);

function my_sortable_searches_column( $columns ) {
    $columns['search_count'] = 'search_count';
    return $columns;
}
add_filter( 'manage_users_sortable_columns', 'Roots\Sage\Extras\my_sortable_searches_column' );

