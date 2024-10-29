<?php
/*
Plugin Name: Almost All Categories
Plugin URI: http://www.Stephanis.info/
Description: Displays all categories except those selected in widget preferences.
Author: E. George Stephanis
Author URI: http://www.Stephanis.info/
Version: 1.0
*/

register_activation_hook	(	__FILE__,			array('almost_all_categories', 'activate')	);
register_deactivation_hook	(	__FILE__,			array('almost_all_categories', 'deactivate')	);
add_action					(	"widgets_init",		array('almost_all_categories', 'register')	);

class almost_all_categories
{

	function activate()
	{
		if( get_option( 'almost_all_categories_w_title' ) === FALSE ) {
			update_option( 'almost_all_categories_w_title', 'Almost All Categories' );
		}
		if( get_option( 'almost_all_categories_w_categories' ) === FALSE ) {
			update_option( 'almost_all_categories_w_categories', '' );
		}
	}
	
	function deactivate()
	{
		delete_option( 'almost_all_categories_w_title' );
		delete_option( 'almost_all_categories_w_categories' );
	}
	
	function register()
	{
		wp_register_sidebar_widget( 'almost-all-categories', 'Almost All Categories', array('almost_all_categories', 'widget'));
		wp_register_widget_control( 'almost-all-categories', 'Almost All Categories', array('almost_all_categories', 'control'));
	}
	
	function control()
	{
		if (isset($_POST['almost_all_categories_w_title']))			update_option(	'almost_all_categories_w_title',		attribute_escape($_POST['almost_all_categories_w_title'])		);
		if (isset($_POST['almost_all_categories_w_categories']))	update_option(	'almost_all_categories_w_categories',	attribute_escape($_POST['almost_all_categories_w_categories'])	);
		?>
		<p><label>
			<strong>Widget Title:</strong><br />
			<input class="widefat" type="text" name="almost_all_categories_w_title" value="<?php echo get_option( 'almost_all_categories_w_title' ); ?>" />
		</label></p>
		<p><label>
			<strong>Categories To Omit:</strong><br />
			<input class="widefat" type="text" name="almost_all_categories_w_categories" value="<?php echo get_option( 'almost_all_categories_w_categories' ); ?>"	 />
		</label></p>
		<p>Enter categories as a comma-seperated list of ID numbers, i.e. <code>2,5,12</code></p>
		<?php
	}
	
	function widget( $args )
	{
		echo $args['before_widget'];
		echo $args['before_title'] . get_option( 'almost_all_categories_w_title' ) . $args['after_title'];
		echo '<ul id="almost_all_categories_widget">';
			$cat_params = Array(
					'hide_empty'	=>	FALSE,
					'title_li'		=>	''
				);
			if( strlen( trim( get_option( 'almost_all_categories_w_categories' ) ) ) > 0 ){
				$cat_params['exclude'] = trim( get_option( 'almost_all_categories_w_categories' ) );
			}
			wp_list_categories( $cat_params );
		echo '</ul>';
		echo $args['after_widget'];
	}
	
}
