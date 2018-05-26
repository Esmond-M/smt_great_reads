<?php
/*
Plugin Name: SMT Great Reads
Plugin URI: https://socialmovementtechnologies.org
Description: Deploys the SMT Great Reads custom post type.
Author: eman5608
Version: 0.1
Author URI: https://socialmovementtechnologies.org
Text Domain: smt_great_reads
*/

//Custom post type for Great Reads
function great_reads_post_type() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x('Reads', 'Post Type General Name', 'smt_great_reads'),
		'singular_name'       => _x('Great Read', 'Post Type Singular Name', 'smt_great_reads'),
		'menu_name'           => __('Great Reads', 'smt_great_reads'),
		'parent_item_colon'   => __('Parent Great Reads', 'smt_great_reads'),
		'all_items'           => __('All Great Reads', 'smt_great_reads'),
		'view_item'           => __('View Great Reads', 'smt_great_reads'),
		'add_new_item'        => __('Add New Great Reads', 'smt_great_reads'),
		'add_new'             => __('Add New', 'smt_great_reads'),
		'edit_item'           => __('Edit Great Reads', 'smt_great_reads'),
		'update_item'         => __('Update Great Reads', 'smt_great_reads'),
		'search_items'        => __('Search Great Reads', 'smt_great_reads'),
		'not_found'           => __('Not found', 'smt_great_reads'),
		'not_found_in_trash'  => __('Not found in trash', 'smt_great_reads'),
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => __('Great Reads', 'smt_great_reads'),
		'description'         => __('Great books for campaigners', 'smt_great_reads'),
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array('title', 'editor', 'excerpt', 'thumbnail'),
		/* A hierarchical CPT is like Pages and can have
		* Parent and child items. A non-hierarchical CPT
		* is like Posts.
		*/
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
    'menu_position'       => 5,
		'show_in_nav_menus'   => false,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
    'query_var' => true,
    'rewrite' => false
	);

	// Registering Great Reads CPT
	register_post_type('Great Reads', $args);

}

// Initialize CPTs
add_action('init', 'great_reads_post_type');

// Define show metabox for post types in $screens array
function great_reads_meta_box() {
  $screens = array('Great Reads');
  foreach ($screens as $screen) {
    add_meta_box(
        'member_sectionid',
        __('Book info', 'smt_great_reads'),
        'great_reads_meta_box_callback',
        $screen
   );
  }
}

// Initialize metaboxes
add_action('add_meta_boxes', 'great_reads_meta_box');

/**
 * Prints the box content.
 * @param WP_Post $post The object for the current post/page.
 */
function great_reads_meta_box_callback($post) {

  // Add a nonce field so we can check for it later.
  wp_nonce_field('save_great_reads_meta_box_data', 'great_reads_meta_box_callback_nonce');

  /*
  * Use get_post_meta() to retrieve an existing value
  * from the database and use the value for the form.
  */
  $meta_author = get_post_meta($post->ID, '_smt_great_reads_author', true);
  $meta_language = get_post_meta($post->ID, '_smt_great_reads_language', true);
  $meta_year = get_post_meta($post->ID, '_smt_great_reads_year', true);
  $meta_votes = get_post_meta($post->ID, '_smt_great_reads_votes', true);
  ?>

  <table>
    <tr>
      <td>
        <b>Author:</b>
      </td>
      <td>
        <input type="text" id="author_field" name="author_field" value="<?php echo esc_attr($meta_author); ?>" size="35" />
      </td>
    </tr>
    <tr>
      <td>
        <b>Language:</b>
      </td>
      <td>
        <input type="text" id="language_field" name="language_field" value="<?php echo esc_attr($meta_language); ?>" size="35" />
      </td>
    </tr>
    <tr>
      <td>
        <b>Year:</b>
      </td>
      <td>
        <input type="number" id="year_field" name="year_field" value="<?php echo esc_attr($meta_year); ?>" size="8" />
      </td>
    </tr>
    <tr>
      <td>
        <b>Votes:</b>
      </td>
      <td>
        <input type="number" id="votes_field" name="votes_field" value="<?php echo esc_attr($meta_votes); ?>" size="8" />
      </td>
    </tr>
  </table>
  <?php
} //End external link metabox callback

/**
 * When the post is saved, saves our custom data.
 * @param int $post_id The ID of the post being saved.
 */
function save_great_reads_meta_box_data($post_id) {

  if (!isset($_POST['great_reads_meta_box_callback_nonce'])) {
    return;
  }
  if (!wp_verify_nonce($_POST['great_reads_meta_box_callback_nonce'], 'save_great_reads_meta_box_data')) {
    return;
  }
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  // Check the user's permissions.
  if (!current_user_can('edit_post', $post_id)) {
     return;
  }

  $text_input = array('author','language','year','votes'); //No formatting

  foreach ($text_input as $text_item) { //Sanitize and update text data
    if (isset($_POST[$text_item . '_field'])) {
      $text_data = sanitize_text_field($_POST[$text_item . '_field']);
      update_post_meta($post_id, '_smt_great_reads_' . $text_item, $text_data);
    }
  }
}
add_action('save_post', 'save_great_reads_meta_box_data');

//Custom page template
function smt_great_reads_template($page_template) {
    if (is_page('great-reads')) {
        $page_template = dirname(__FILE__) . '/great-reads-template.php';
    }
    return $page_template;
}
add_filter('page_template', 'smt_great_reads_template');

//Custom post template
function smt_great_reads_single_template($post_template) {
    global $post;
    if ($post->post_type == "greatreads") {
      $post_template = dirname(__FILE__) . '/single-great-reads-template.php';
    }
    return $post_template;
}
add_filter('single_template', 'smt_great_reads_single_template');

//Custom stylesheet and script
// function smt_great_reads_enqueue_scripts() {
//   //Styles
//     wp_enqueue_style('smtGreatReadsStyle',dirname(__FILE__) . '/smt_style.css',__FILE__);
// }
// add_action('wp_enqueue_scripts','smt_great_reads_enqueue_scripts');
