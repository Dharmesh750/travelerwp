<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );
	wp_enqueue_style( 'astra-child-single-css', get_stylesheet_directory_uri() . '/location-style.css', array('astra-theme-css'));
  wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css');
  wp_enqueue_style('slick-theme-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');
  wp_enqueue_script('slick-js', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js', array('jquery'), null, true);
	wp_enqueue_script( 'child-theme-js', get_stylesheet_directory_uri() . '/script.js',array( 'jquery' ),false);

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

function enquiry(){
	?>
	
  <form class="booking-form">
    <!-- Location Field -->
    <div class="form-field">
      <label for="location">
        <!-- Location Icon (SVG) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon bi bi-geo-alt" viewBox="0 0 16 16">
          <path d="M8 0C5.79 0 4 2.16 4 4c0 2.43 2.35 4.7 4 7.35 1.65-2.65 4-4.92 4-7.35 0-1.84-1.79-4-4-4zM8 5c-.93 0-1.8-.43-2.35-1.15.52-.69.72-1.55.72-2.35 0-1.1-.34-2.05-.87-2.9.38.16.8.25 1.2.25 1.5 0 2.75-1.25 3.5 3.5 3.5 1.5 0 2.5 1 2.5 2.5 0 2.5-2 3.5-3 3.5z"/>
        </svg> Location
      </label>
      <select id="location" name="location" required>
        <option value="">Select where you want to go</option>
        <option value="new_york">New York</option>
        <option value="los_angeles">Los Angeles</option>
        <option value="miami">Miami</option>
      </select>
    </div>

    <!-- Check-in Field -->
    <div class="form-field">
      <label for="check-in">
        <!-- Check-in Icon (SVG) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon bi bi-calendar" viewBox="0 0 16 16">
          <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H1a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10h14V4H1z"/>
        </svg> Check-in
      </label>
      <input type="date" id="check-in" name="check-in" required>
    </div>

    <!-- Check-out Field -->
    <div class="form-field">
      <label for="check-out">
        <!-- Check-out Icon (SVG) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon bi bi-calendar-x" viewBox="0 0 16 16">
          <path d="M12 0a.5.5 0 0 1 .5.5V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H1a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10h14V4H1zm4 1h6v6H5V5z"/>
        </svg> Check-out
      </label>
      <input type="date" id="check-out" name="check-out" required>
    </div>

    <!-- Guests Field (Room, Adults, Children) -->
    <div class="form-field">
      <label for="guests">
        <!-- Guests Icon (SVG) -->
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon bi bi-person-fill" viewBox="0 0 16 16">
          <path d="M3 14s-1 0-1-1V9s0-1 1-1h10s1 0 1 1v4s0 1-1 1H3zM8 0a3 3 0 1 1 0 6 3 3 0 0 1 0-6z"/>
        </svg> Guests
      </label>
      <div class="guest-options">
        <!-- Rooms Field -->
        <div class="guest-option">
          <label for="rooms">Rooms</label>
          <input type="number" id="rooms" name="rooms" min="1" value="1" required>
        </div>
        <!-- Adults Field -->
        <div class="guest-option">
          <label for="adults">Adults</label>
          <input type="number" id="adults" name="adults" min="1" value="2" required>
        </div>
        <!-- Children Field -->
        <div class="guest-option">
          <label for="children">Children</label>
          <input type="number" id="children" name="children" min="0" value="0">
        </div>
      </div>
    </div>

    <!-- Search Button -->
    <div class="form-field">
      <button type="submit" class="search-btn">Search</button>
    </div>
  </form>

<?php }
add_shortcode("room_enquiry","enquiry");

function display_posts_grid() {
  
  // Query the posts based on the given parameters
  $args = array(
      'posts_per_page' => -1,
      'post_status' => 'publish',
  );

  $query = new WP_Query($args);

  // Check if there are posts
  if ($query->have_posts()) {
      $output = '<div class="posts-grid-slider">';  // This will be the wrapper for Slick Slider

      // Loop through posts
      while ($query->have_posts()) {
          $query->the_post();
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'medium');
          $categories = get_the_category();
          $category = !empty($categories) ? esc_html($categories[0]->name) : 'Uncategorized';
          $title = get_the_title();
          $excerpt = get_the_excerpt();

          // Create the HTML for each post
          $output .= '<div class="grid-item">';
          if ($image_url) {
              $output .= '<div class="post-image"><img src="' . esc_url($image_url) . '" alt="' . esc_attr($title) . '"></div>';
          }
          $output .= '<div class="post-details">';
          $output .= '<span class="category">' . esc_html($category) . '</span>';
          $output .= '<h3 class="post-title">' . esc_html($title) . '</h3>';
          $output .= '<p class="post-excerpt">' . esc_html($excerpt) . '</p>';
          $output .= '</div></div>';
      }

      $output .= '</div>'; 
      wp_reset_postdata();    
      return $output;
  } else {
      return '<p>No posts found.</p>';
  }
}

// Register the shortcode
add_shortcode('posts_grid', 'display_posts_grid');
