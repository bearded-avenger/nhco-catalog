<?php
/*
Author: Nick Haskins
Author URI: http://nickhaskins.co
Plugin Name: NH & CO Catalog
Plugin URI: http://nickhaskins.co/products/nhco-catalog
Version: 1.0
Description: Displays all products and keeps track of installed products from Nick Haskins & CO.
*/

class nhCoCatalog {

	public function __construct(){

		require_once('inc/data.php');
		require_once('inc/news-feed.php');
		require_once('inc/load.php');

		// Load Updater
		if( !class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// load our custom updater
			require_once( 'EDD_SL_Plugin_Updater.php' );
		}

		require_once('updater.php');
	}
}
new nhCoCatalog;