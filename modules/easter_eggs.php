<?php

class Alot_Of_Easter_Eggs {
	function wp_loaded(){
		wp_register_script( 'trbamc', plugins_url('alot/js/k.js'), array('jquery'), '0.1' );
		wp_register_script( 'alotofalot', plugins_url( 'alot/js/alotofalot.js'), array( 'trbamc' ), '0.1' );
		wp_localize_script( 'alotofalot', 'AoA', array(
			'a' => false,
			'i' => implode( ',', array('1','2','3','4','5','6','8','9','12','13','14','15') ),
			'u' => trailingslashit( plugins_url( 'alot/img/' ) )
		));
		wp_enqueue_script( 'alotofalot' );
	}
}

add_action( 'wp_loaded', array( 'Alot_Of_Easter_Eggs', 'wp_loaded' ) );

