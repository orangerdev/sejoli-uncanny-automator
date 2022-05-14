<?php

namespace Uncanny_Automator;

// use Uncanny_Automator_Pro\Sejoli_Pro_Helpers;
use WP_Error;

/**
 * Class Sejoli_Helpers
 *
 * @package Uncanny_Automator
 */
class Sejoli_Helpers {
	/**
	 * @var Sejoli_Helpers
	 */
	public $options;

	/**
	 * @var Sejoli_Pro_Helpers
	 */
	// public $pro;

	/**
	 * @var bool
	 */
	public $load_options;

	/**
	 *
	 */
	public function __construct() {
		$this->load_options = Automator()->helpers->recipe->maybe_load_trigger_options( __CLASS__ );
	}

	/**
	 * @param Sejoli_Helpers $options
	 */
	public function setOptions( Sejoli_Helpers $options ) {
		$this->options = $options;
	}

	/**
	 * @param Sejoli_Pro_Helpers $pro
	 */
	// public function setPro( Sejoli_Pro_Helpers $pro ) {
	// 	$this->pro = $pro;
	// }

	/**
	 * @param string $label
	 * @param string $option_code
	 *
	 * @return mixed
	 */
	public function subscription_first_time( $label = null, $option_code = 'SEJOLITOKEN' ) {

		if ( ! $this->load_options ) {
			return Automator()->helpers->recipe->build_default_options_array( $label, $option_code );
		}

		if ( ! $label ) {
			$label = esc_attr__( 'Order', 'uncanny-automator' );
		}
		__debug($option_code);

		// $args = array(
		// 	'post_type'      => 'product',
		// 	'posts_per_page' => 999,
		// 	'orderby'        => 'title',
		// 	'order'          => 'ASC',
		// 	'post_status'    => 'publish',
		// );

		// $options = Automator()->helpers->recipe->options->wp_query( $args, true, esc_attr__( 'Any product', 'uncanny-automator' ) );
		$options = array(
			// $option_code                => esc_attr__( 'Product titlesss', 'uncanny-automator' ),
			// $option_code . '_ID'        => esc_attr__( 'Product IDsssss', 'uncanny-automator' ),
			// $option_code . '_URL'       => esc_attr__( 'Product URL', 'uncanny-automator' ),
			// $option_code . '_THUMB_ID'  => esc_attr__( 'Product featured image ID', 'uncanny-automator' ),
			// $option_code . '_THUMB_URL' => esc_attr__( 'Product featured image URL', 'uncanny-automator' ),
			// $option_code . '_ORDER_QTY' => esc_attr__( 'Product quantity', 'uncanny-automator' ),
		);
		$option = array(
			'option_code'     => $option_code,
			'label'           => $label,
			'input_type'      => 'select',
			'required'        => true,
			'options'         => $options,
			'relevant_tokens' => array(
				$option_code                => esc_attr__( 'Product titlesss', 'uncanny-automator' ),
				$option_code . '_ID'        => esc_attr__( 'Product IDsssss', 'uncanny-automator' ),
				$option_code . '_URL'       => esc_attr__( 'Product URL', 'uncanny-automator' ),
				$option_code . '_THUMB_ID'  => esc_attr__( 'Product featured image ID', 'uncanny-automator' ),
				$option_code . '_THUMB_URL' => esc_attr__( 'Product featured image URL', 'uncanny-automator' ),
				$option_code . '_ORDER_QTY' => esc_attr__( 'Product quantity', 'uncanny-automator' ),
			),
		);

		// __debug(apply_filters( 'uap_option_subscription_first_time', $option ));

		// error_log(print_r($option, true));
		return apply_filters( 'automator_option_subscription_first_time', $option );
	}

}
