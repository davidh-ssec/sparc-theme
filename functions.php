<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

class StarterSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		parent::__construct();
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['foo'] = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::get_context();';
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );
		return $twig;
	}

}

new StarterSite();

function myfoo( $text ) {
	$text .= ' bar!';
	return $text;
}

// Advanced Custom Fields for Experiment Posts (requires ACF plugin)
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_experiment',
		'title' => 'Experiment',
		'fields' => array (
			array (
				'key' => 'field_54c8180bc1c5d',
				'label' => 'Begin Date',
				'name' => 'begin_date',
				'type' => 'date_picker',
				'instructions' => 'Begin date of the experiment',
				'required' => 1,
				'date_format' => 'yymmdd',
				'display_format' => 'yy/mm/dd',
				'first_day' => 0,
			),
			array (
				'key' => 'field_54c8189ac1c5f',
				'label' => 'End Date',
				'name' => 'end_date',
				'type' => 'date_picker',
				'instructions' => 'End date of the experiment',
				'required' => 1,
				'date_format' => 'yymmdd',
				'display_format' => 'yy/mm/dd',
				'first_day' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'experiment',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
