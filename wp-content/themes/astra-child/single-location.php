<?php
/**
 * The template for displaying all single location posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

<?php
function custom_breadcrumb() {

    $separator = ' > ';
    $home_url = home_url('/');
    $home_text = 'Home';

    $breadcrumbs = array();
    $breadcrumbs[] = '<a href="' . $home_url . '">' . $home_text . '</a>';

    if (is_single()) {

        $categories = get_the_category();
        if ($categories) {
            foreach ($categories as $category) {
                $breadcrumbs[] = '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
            }
        }

        // Add the post type name
        $post_type = get_post_type();
        if ($post_type && $post_type != 'post') {
            $post_type_object = get_post_type_object($post_type);
            $breadcrumbs[] = '<a href="' . get_post_type_archive_link($post_type) . '">' . $post_type_object->labels->singular_name . '</a>';
        }

        // Add the post title
        $breadcrumbs[] = get_the_title();
    } elseif (is_category()) {
        // For category pages, just show the category name
        $breadcrumbs[] = single_cat_title('', false);
    } elseif (is_page()) {
        // For regular pages, show the page title
        $breadcrumbs[] = get_the_title();
    }

    echo implode($separator, $breadcrumbs);
}


?>
<?php if ( astra_page_layout() == 'left-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>
<?php
if ( have_posts() ) : 
    while ( have_posts() ) : the_post(); ?>
	
<div class="location-container">
        <!-- Banner Section -->
        <section class="banner-section" style="background-image: url('http://localhost/travelerwp/wp-content/uploads/2024/11/banner-search-form-min.png'); background-size: cover; background-position: center; height: 300px; margin-top:-45px;">
        <div class="breadcrumb-sec">    
            <h1 class="post-title"><?php the_title(); ?></h1>
                    <nav class="breadcrumb">
                            <?php
                            echo custom_breadcrumb();
                        ?>
                    </nav>
        </div>
        </section>
        <!-- Post Content Section -->
        <section class="post-content">
            <div class="post-slider">
                <?php
                $image_data = get_field('image_slider');
                foreach($image_data as $slider_img){?>
                    <div class="slider_img"><img src="<?php echo $slider_img?>"></div>
                <?php }
                ?>
            </div>
            <div class="container" style="max-width: 1140px; margin: 0 auto; padding: 20px;">
                <!-- Post Content -->
                <div class="post-body">
                    <?php
                    if(get_field('location_duration')){
                        $duration_data =  get_field('location_duration');
                    };
                    if(get_field('tour_type')){
                        $tour_data = get_field('tour_type');
                    }
                    if(get_field('group_size')){
                        $group_size = get_field('group_size');
                    }
                    if(get_field('languages')){
                        $languagas = get_field('languages');
                    }
                    if(get_field('tour_highlight')){
                        $tour_highlight = get_field('tour_highlight');
                    }

                    ?>
                    <div class="location-row">
                        <div class="location-sec">
                            <div class="icon">
                            <span class="dashicons <?php echo $duration_data['select_icon']?>"></span>
                            </div>
                            <div class="info">
                                <h4><?php echo $duration_data['duration_head']?></h4>
                                <p><?php echo $duration_data['duration_hour']?></p>
                            </div>
                        </div>
                        <div class="location-sec">
                            <div class="icon">
                            <span class="dashicons <?php echo $tour_data['tour_type_icon']?>"></span>
                            </div>
                            <div class="info">
                                <h4><?php echo $tour_data['tour_head']?></h4>
                                <p><?php echo $tour_data['select_days']?></p>
                            </div>
                        </div>
                        <div class="location-sec">
                            <div class="icon">
                            <span class="dashicons <?php echo $group_size['group_icon']?>"></span>
                            </div>
                            <div class="info">
                                <h4><?php echo $group_size['group_head']?></h4>
                                <p><?php echo $group_size['group_count'].' People'?></p>
                            </div>
                        </div>
                        <div class="location-sec">
                            <div class="icon">
                            <span class="dashicons <?php echo $languagas['language_icon']?>"></span>
                            </div>
                            <div class="info">
                                <h4><?php echo $languagas['language_head_']?></h4>
                                <p>
                                <?php if(is_array($languagas['select_langauge'])){
                                    foreach($languagas['select_langauge'] as $lang){
                                        echo $lang.',';
                                    }
                                }?></p>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="location-info-content">
                        <h2 class="location-post-tittle">About this tour</h2>
                        <?php the_content(); ?>
                        <div class="location-highlight">
                        <h2 class="location-post-tittle">Highlights</h2>
                            <ul>
                            <?php 
                            if ( ! empty( $tour_highlight ) ) {
                                foreach ( $tour_highlight as $highlight ) {
                                    ?>
                                    <li><i class="fas fa-check"></i><?php echo esc_html( $highlight );?></li>
                                <?php }
                            }
                            ?>
                            </ul>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </section>
</div>

    <?php endwhile;
else :
    // If no posts are found
    echo '<p>No posts found.</p>';
endif;?>

<?php if ( astra_page_layout() == 'right-sidebar' ) : ?>

	<?php get_sidebar(); ?>

<?php endif ?>


<?php get_footer(); ?>
