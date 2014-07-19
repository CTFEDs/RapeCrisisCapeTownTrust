<?php

// add a menu

add_action( 'after_setup_theme', 'hardboilerplate_setup' );

if ( ! function_exists( 'hardboilerplate_setup' ) ):

function hardboilerplate_setup() {
	register_nav_menu( 'primary', __( 'Primary Menu', 'hardboilerplate' ) );

	add_theme_support( 'post-thumbnails' );
}

endif;

// register a sidebar

add_action( 'widgets_init', 'hardboilerplate_widgets_init' );

function hardboilerplate_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'hardboilerplate' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
}

// add a custom meta box

function hardboilerplate_add_custom_meta() {

	add_meta_box(
		'hardboilerplate-custom-meta',			// Unique ID
		__( 'Custom Meta', 'hardboilerplate' ),		// Title
		'hardboilerplate_custom_meta_box',		// Callback function
		'page',					// post, page, custom post type
		'normal',					// normal, advanced, side
		'default'					// Priority
	);
}

function hardboilerplate_custom_meta_box($object, $box ) {

	wp_nonce_field( basename( __FILE__ ), 'hardboilerplate_custom_meta_nonce' );
	/*
	?>
		<textarea <?php //echo 'class="theEditor" '; ?>rows="5" style="width: 100%;" name="hardboilerplate-custom-meta" id="hardboilerplate-custom-meta"><?php echo esc_attr( get_post_meta( $object->ID, 'hardboilerplate_custom_meta', true ) ); ?></textarea>
or
		<input <?php //echo 'class="theEditor" '; ?> name="hardboilerplate-custom-meta" id="hardboilerplate-custom-meta" value="<?php echo esc_attr( get_post_meta( $object->ID, 'hardboilerplate_custom_meta', true ) ); ?>" />
	<?php
	*/

}

function hardboilerplate_save_custom_meta( $post_id, $post ) {

	if ( !isset( $_POST['hardboilerplate_custom_meta_nonce'] ) || !wp_verify_nonce( $_POST['hardboilerplate_custom_meta_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );

	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;

	$new_meta_value = $_POST['hardboilerplate-custom-meta'];

	$meta_key = 'hardboilerplate_custom_meta';
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}

/* for editing 1,000 hearts */


add_action('admin_menu', 'onethousandhearts_menu');

function onethousandhearts_menu() {
	add_management_page('1,000 hearts', '1,000 hearts', 5, 'one-thousand-hearts', 'one_thousand_hearts');
}

function one_thousand_hearts() {

	$offset = max(1, $_GET['offset']);
	$number_to_show = max(20, $_GET['show']);

	if($_POST) {
		foreach($_POST as $posted_name => $posted_value) {
			update_option( $posted_name, $posted_value );
		}
	}


	echo '<h2>1,000 Hearts</h2>';

	echo '<p>Displaying hearts ' . $offset . ' to ' . ($offset + $number_to_show) . '.</p>';

	echo '<p>Hearts to show per page: ';

	$show_selections = array(20, 50, 100, 1000);

	foreach ($show_selections as $show_selection) {
		echo '<a href="tools.php?page=one-thousand-hearts&show=' . $show_selection . '&offset=' . $offset . '">' . $show_selection . '</a> ';
	}



	echo '.</p>';

	echo '<p>';

	echo 'Show hearts: ';

	$number_of_pages = 1000 / $number_to_show;
	for($p = 1; $p <= $number_of_pages; $p++) {
		echo '<a href="tools.php?page=one-thousand-hearts&show=' . $number_to_show . '&offset=' . (($p-1) * $number_to_show + 1) . '">' . (($p-1) * $number_to_show + 1) . '-' . ($p * $number_to_show) . '</a>&nbsp; &nbsp;';
	}

	echo '.</p>';

	echo '

<form action="tools.php?page=one-thousand-hearts&show=' . $number_to_show . '&offset=' . $offset . '" method="POST">

<p><input type="submit" value="Save changes" class="button-primary"/></p>

<table class="widefat">
	<thead>
		<tr>
			<th scope="col">Heart number</th>
			<th scope="col">Sponsor (text)</th>
			<th scope="col">Heart style (number between 2 and 121)</th>
		</tr>
	</thead>

	<tbody>';

	for ($h = $offset; $h < $number_to_show + $offset; $h ++) {
#		if(get_option( 'heart' . $h )) {
			echo '
			<tr>
				<td>' . $h . '</td>
				<td>
					<input type="text" name="heart' . $h . 'sponsor" id="heart' . $h . 'sponsor" value="' . get_option( 'heart' . $h . 'sponsor') . '"/>
				</td>
				<td>
					<input type="text" name="heart' . $h . 'design" id="heart' . $h . 'design" value="' . get_option( 'heart' . $h . 'design') . '"/>
				</td>
			</tr>
			';
#		}
	}

	echo '
	</tbody>
</table>

<p><input type="submit" value="Save changes" class="button-primary"/></p>

</form>
';
}

?>
