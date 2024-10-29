<?php
/*
Plugin Name: Alot
Description: There's alot of meaning in this plugin.
Version: 0.1
Author: John P. Bloch
License: GPLv2
*/

/*  Copyright 2010 John P. Bloch (john@johnpbloch.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Alot_Of_Code {
	
	var $slug = 'alot';
	var $settings_name = 'alot_settings';
	var $settings;
	var $version = '0.1';
	var $version_name = 'alot_version';
	var $url;
	var $dir;
	var $mod_dir;
	
	function Alot_Of_Code(){
		$this->__construct();
	}

	function __construct(){
		$this->settings = get_option( $this->settings_name );
		$installed_version = get_option( $this->version_name );
		$this->url = trailingslashit( plugins_url( '', __FILE__ ) );
		$this->dir = trailingslashit( dirname( __FILE__ ) );
		$this->mod_dir = $this->dir . 'modules/';
		if( empty( $this->settings ) )
			$this->install();
		elseif ( 0 !== version_compare( $installed_version, $this->version ) )
			$this->update( $installed_version );
		foreach( array( 'init', 'admin_menu', 'admin_init' ) as $hook )
			add_action( $hook, array( &$this, $hook ), 1 );
		$this->td[] = basename(dirname(__FILE__));
		$this->td[] = trailingslashit($this->td[0]) . 'languages';
	}

	function install(){
		$this->settings = array(
			'modules' => array(
				'easter_eggs' => false,
				'bottom_corner' => false,
			),
		);
		update_option( $this->settings_name, $this->settings );
		update_option( $this->version_name, $this->version );
	}

	function update( $installed ){
		switch( $installed ){
			case '1.0':
			default:
				break;
		}
		update_option( $this->settings_name, $this->settings );
		update_option( $this->version_name, $this->version );
	}

	function init(){
		load_plugin_textdomain( $this->td[0], null, $this->td[1] );
		foreach( $this->settings['modules'] as $module => $include ){
			if( $include && file_exists( $this->mod_dir . $module . '.php' ) )
				include_once( $this->mod_dir . $module . '.php' );
		}
	}

	function admin_init(){
		$this->settings_group = $this->slug . '_settings_group';
		register_setting( $this->settings_group, $this->settings_name, array( &$this, 'settings_san' ) );
		add_settings_section( $this->settings_group . '_mods', _x( 'Modules', 'Section title', $this->td[0] ), '__return_false', $this->slug );
		add_settings_field( $this->settings_group . '_modules', _x( 'Modules Available', 'option name', $this->td[0] ), array( &$this, 'mods_available' ), $this->slug, $this->settings_group . '_mods' );
		do_action( 'alot_settings' );
	}

	function admin_menu(){
		$this->admin_page_title = $page_title = sprintf( __( '%s of Options', $this->td[0] ), 'Alot' );
		add_options_page( $page_title, $page_title, 'manage_options', $this->slug, array( &$this, 'menu' ) );
	}

	function menu(){
		?>
		<h2><?php echo $this->admin_page_title; ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields( $this->settings_group ); ?>
			<?php do_settings_sections( $this->slug ); ?>
			<p class="submit"><input type="submit" class="button-primary" value="Save Alot" /></p>
		</form>
		<?php
	}

	function settings_san( $settings ){
		$raw_settings = $settings;
		$settings['modules'] = isset($settings['modules']) && is_array($settings['modules']) ? $settings['modules'] : array();
		$settings['modules'] = array_map( '__return_true', $settings['modules'] );
		$diff = array_diff_key( $this->settings['modules'], $settings['modules'] );
		$diff = array_map( '__return_false', $diff );
		$settings['modules'] = array_merge( $settings['modules'], $diff );
		return apply_filters( 'sanitize_alot_of_settings', $settings, $this->settings );
	}

	function mods_available(){
		?>
		<h3><?php _ex( 'Easter Eggs', 'module name', $this->td[0] ); ?></h3>
		<p><?php _e( 'This module will enable <a href="http://en.wikipedia.org/wiki/Easter_egg_(media)" target="_blank" alt="Easter Eggs">Easter Eggs</a> across the whole site.', $this->td[0] ); ?><br />
		<label><input type="checkbox" name="<?php echo $this->settings_name; ?>[modules][easter_eggs]" value="active" <?php checked( $this->settings['modules']['easter_eggs'] ); ?>/> Active</label></p>
		<h3><?php printf( _x( 'Corner %s', 'adjective', $this->td[0] ), 'Alot' ); ?></h3>
		<p><?php printf( __( 'This module will place an alot (linked to Allie Brosh\'s blog, %s) in the bottom right corner of the screen on the public views of your site.', $this->td[0] ), '<a href="http://hyperboleandahalf.blogspot.com/">Hyperbole and a Half</a>' ); ?><br />
		<label><input type="checkbox" name="<?php echo $this->settings_name; ?>[modules][bottom_corner]" value="active" <?php checked( $this->settings['modules']['bottom_corner'] ); ?>/> Active</label></p>
		<?
		do_action( 'alot_of_modules_available', &$this );
	}

}

$Alot_Of_Code = new Alot_Of_Code();

