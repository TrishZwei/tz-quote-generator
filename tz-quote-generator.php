<?php
/*
Plugin Name: TrishZwei's Simple Custom Quotes
Description: Lets you add a random quote from a list of quotes you create to your site that appear where you place a widget. These can also be used for simple testimonials.
Author: Trish Ladd
Plugin URI: http://trishladd.com
Author URI: http://trishladd.com
Version: 0.1
License: GPLv3
 */

/**
 * Create "Quotes" post type
 * @since  0.1
 */
defined('ABSPATH') or die("No script kiddies please!");
add_action( 'init', 'tz_quotes_setup' );
function tz_quotes_setup(){
	register_post_type( 'quote', array(
			'public' 		=> true,
			'has_archive' 	=> true, //this is for you to be able to review the list of quotes.
			'menu_position' => 5,
			'menu_icon'		=> 'dashicons-format-quote',
			'exclude_from_search' => true,
			'rewrite' => array('slug' => 'quotes'),
			'supports' 		=> array('editor', 'title'), //editor for the quote content, title so that you have a handle for them - title will not show.
			'labels' 		=> array(
                'name' => 'Quotes',
                'singular_name' => 'Quote',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Quote',
                'edit' => 'Edit',
                'edit_item' => 'Edit Quote',
                'new_item' => 'New Quote',
                'view' => 'View',
                'view_item' => 'View Quote',
                'search_items' => 'Search Quotes',
                'not_found' => 'No Quotes found',
                'not_found_in_trash' => 'No Quotes found in Trash',
				),
		) );
}

/**
 * Fix permalink 404 errors when the plugin activates
 * @since  0.1
 */
function tzQuotes_rewrite_flush(){
	tz_quotes_setup(); //call the func that registers CPT/Taxos
	flush_rewrite_rules(); //re-create the .htaccess rules
}
register_activation_hook( __FILE__, 'tzQuotes_rewrite_flush' );

////////////////////////////
//Register the custom function when wordpress admin interface is visited.
add_action( 'admin_init', 'tzQuotes_admin' );

//implementing the custom function
function tzQuotes_admin(){
    add_meta_box('quote_data', //required html attribute 
        'Additional Quote Info', //text visible in the heading of the metabox
        'display_quote_data', //name of the callback to render the contents of the metabox
        'quote', //custom post type of metabox
        'normal', //defines the part of the page where the edit screen section should be shown
        'high' //defines the priority within the context where the boxes show.
        );
}


//callback function, displaying the meta box function
function display_quote_data( $quote) {
    $quote_attribution = esc_html( get_post_meta( $quote->ID, 'quote_attribution', true ) ); 
    ?>
    <table class="form-table">
        <!--GM -->
        <tr valign="top">
            <th scope="row"><label>Quote Attribution</label></th>
            <td>
            	<!-- this should be a drop down that gets the list of available GMs -->
            	<input type="text" size="80" name="quote_attribution" value="<?php echo $quote_attribution; ?>" />
                <span class="description">who said it</span>
            </td>
        </tr>
    </table>
    <?php
}
//Registering a save post function this calls the function to save/add/update the additional data to the post
add_action( 'save_post', 'save_tzQuotes_data_fields', 10, 2 );
//unsure of what args 10, 2 do.

$quote_id = get_post_meta($quote->ID);

//whatever is added to the display_quote_data function needs to also be added here in order to be saved.

function save_tzQuotes_data_fields( $quote_id, $quote ) {
    // Check post type 
    if ( $quote->post_type == 'quote' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['quote_attribution'] ) && $_POST['quote_attribution'] != '' ) {
            update_post_meta( $quote_id, 'quote_attribution', wp_filter_nohtml_kses($_POST['quote_attribution'] ));
        }
    }

}
//this ends the admin adding portion of the plugin. Next is to display the quote in a widget.

function tzQuotes_register_widget(){
 register_widget( 'tzQuotes_widget' );
}
add_action('widgets_init', 'tzQuotes_register_widget');

//Our new widget is a copy of the WP_Widget object class
class tzQuotes_Widget extends WP_Widget{
	//give the first function the same name as the class
	function tzQuotes_Widget(){
		//Widget Settings
		$widget_ops = array(
			'classname' => 'tzquotes-widget',
			'description' => 'Where you place this widget is where your random quote will appear'			
		);
		//Widget Control Settings
		$control_ops = array(
			//necessary for multiple instances of the widget to work. WP will append a unique number to the end of the ID base
			'id_base' => 'tzquotes-widget',
			'width' => 300
		);
		//WP_Widget(id-base, name, widget ops, control ops)
		$this->WP_Widget('tzquotes-widget', 'TZ Quotes Widget', $widget_ops, $control_ops);
	}

	//Front end display (always use 'widget')
	function widget( $args,  $instance ){
		//args contains all the settings defined when the widget area was registered 
		//(see theme functions.php)
		extract($args); 
		
		//make this title filter-able
		$title = apply_filters( 'widget-title', $instance['title'] ); 
		//Widget output begins
		echo $before_widget;
		
		//show the title if the user filled one in
		if($title):
			echo $before_title . $title . $after_title;
		endif;		
//	do a custom wp query --
			$tzQuote_query= new WP_Query(array(
			'post_type' => 'quote',
			'orderby' => 'rand',
			'posts_per_page'=> '1'
			));
		if($tzQuote_query->have_posts()){
			$tzQuote_query->the_post();
			$the_quote_id = get_the_ID();
			$theAuthor = get_post_meta( $the_quote_id, 'quote_attribution', true );
			remove_filter ('the_content', 'wpautop'); // this is so that the p is removed.
			?>
			<blockquote><?php the_content(); ?>
				<?php if($theAuthor !=''){ ?>
				<span class="quote-attribution"> &#8212;&nbsp;<?php echo $theAuthor;?></span>
				<?php }//end if there is content in $theAuthor ?>
			</blockquote>
			<?php
		}
		 wp_reset_postdata(); //clear the custom post data
		echo $after_widget;
	}
	
	//handle saves and widget locations. always use 'update'
	function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		
		//strip evil scripts from all fields
		$instance['title'] = wp_filter_nohtml_kses($new_instance['title']);
		//more fields go here
	
		return $instance;
		
	}
	
	//optional function for the admin form
	function form( $instance ){
		//set up default settings for each field
		$defaults = array(
			'title' => 'Quote:'
		);
		
		//merge defaults with the form values
		$instance = wp_parse_args( (array) $instance, $defaults );	
		//HTML time!
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input type="text" name="<?php echo $this->get_field_name('title') ?>" id="<?php echo $this->get_field_id('title');
			?>" value="<?php echo $instance['title'] ?>" />
		</p>
		<?php
	}	
}

?>