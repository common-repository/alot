<?php

class Alot_Of_Corners {

	function wp_head(){
		if( apply_filters( 'not_alot_of_corners_on_this_page', false ) )
			return;
		echo '<style>
	a#alot_of_corners {
		position:fixed!important;
		bottom:0px!important;
		right:0px!important;
	}
</style>';
	}

	function wp_footer() {
		if( apply_filters( 'not_alot_of_corners_on_this_page', false ) )
			return;
		echo '<a id="alot_of_corners" href="http://hyperboleandahalf.blogspot.com/2010/04/alot-is-better-than-you-at-everything.html" target="_blank"><img alt="I am the alot of corners" src="'.plugins_url('alot/img/alot_of_corners.png').'" title="I am the alot of corners" /></a>';
	}

}

add_action( 'wp_head', array( 'Alot_Of_Corners', 'wp_head' ) );
add_action( 'wp_footer', array( 'Alot_Of_Corners', 'wp_footer' ) );

