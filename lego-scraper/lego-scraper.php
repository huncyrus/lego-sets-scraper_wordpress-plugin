<?php
/**
 * Plugin Name: Lego sets Custom post type
 * Plugin URI: nope.no
 * Description: A plugin to create a custom post type for Lego sets
 * Version:  1.0
 * Author: huncyrus
 * Author URI: http://www.pixeltankstudio.hu
 * License:  GPL2
 */

// Config
define('LSS__PLUGIN_URL', plugin_dir_url(__FILE__));
define('LSS__PLUGIN_DIR', plugin_dir_path(__FILE__));

require_once(LSS__PLUGIN_DIR . 'smallCurl.php');
require_once(LSS__PLUGIN_DIR . 'lego-scrape.php');
require_once(LSS__PLUGIN_DIR . 'lego-scraper-model.php');

// Post type & menu registering
add_action('init', 'lego_init');
add_action('admin_menu', 'register_my_custom_submenu_page');


/**
 * Menu handler hoak for plugin
 */
function register_my_custom_submenu_page() {
	add_menu_page('Lego Set Manager custom page', 'Lego set manager', 'manage_options', 'mtls', 'mtls_callback');
	add_submenu_page( 'mtls', 'Lego set manager', 'Lego scraper', 'manage_options', 'mtls', 'mtls_callback');
	add_submenu_page( 'mtls', 'Update sets', 'Update sets', 'manage_options', 'mtls2', 'lego_fetch');
}

function mtls_callback() {
	echo '
		<div class="wrap">
			<div id="icon-tools" class="icon32"></div>
			<h2>Lego sets manager</h2>
			<p> &nbsp; </p>
		</div>
	';

	$db = new legoScraperModel();
	$links = $db->getLinks();
	if (null != $links) {
		echo 'Available shops in Database: <ul>';
		foreach ( $links as $link_item ) {
			echo '<li><a href="' . $link_item->shop_url . '">' . $link_item->shop_title . '</a></li>';
		}
		echo '</ul>';
	} else {
		echo '<b>There isn\'t any stored link... </b>';
	}

}


/**
 * @return bool
 */
function lego_init() {
	$labels = array(
		'name' => __('Lego Sets', 'Lego Sets', 'your-plugin-textdomain'),
		'singular_name' => __('Lego', 'Lego sets', 'your-plugin-textdomain'),
		'menu_name' => __('Lego sets', 'admin menu', 'your-plugin-textdomain'),
		'all_items'     => __('All lego sets', 'your-plugin-textdomain'),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => false,
		'show_in_menu'       => false,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'lego_sets'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'Hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
    );

	register_post_type('lego', $args);

	return true;
}

/**
 * Fetch the lego sets & store into database
 */
function lego_fetch() {
	echo '<h2>Updating lego sets...</h2>';

	$legoScrape = new legoScrape();
	$db = new legoScraperModel();
	$links = $db->getLinks();
	if (null != $links) {
		echo 'Shops for fetch: <ul>';

		foreach ( $links as $link_item ) {
			echo '<b> ' . $link_item->shop_title . ' </b> (' . $link_item->shop_url . ' )<br />';

			$legoScrape->setUrl($link_item->shop_url);
			$result = $legoScrape->run();

			if (true == $result) {
				echo '... data retrieved: <b>[ok]</b> <br />';
				$storeResult = $db->storeLegoSets($legoScrape->getTemp(), $link_item->id);
				echo '... data store: <b>[';
				if (true == $storeResult) {
					echo 'ok';
				} else {
					echo 'fail';
				}
				echo ']</b> <br />';
			} else {
				echo '... data retrieved: <b>[error]</b> <br />';
			}
		}
	} else {
		echo '<b>There isn\'t any stored link... </b>';
	}
}

