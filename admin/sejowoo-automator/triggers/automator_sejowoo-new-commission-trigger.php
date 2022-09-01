<?php

use Uncanny_Automator\Recipe;

/**
 * Class Automator_Sejowoo_New_Commission_Trigger
 *
 * @package Uncanny_Automator
 */
class Automator_Sejowoo_New_Commission_Trigger {

	/**
	 * Integration code
	 *
	 * @var string
	 */
	public static $integration = 'SEJOWOO';

	private $trigger_code;
	private $trigger_meta;

	/**
	 * Set up Automator trigger constructor.
	 */
	public function __construct() {

		$this->trigger_code = 'SEJOWOO_NEW_COMMISSION';
		$this->trigger_meta = 'SEJOWOO_CREATE_COMMISSION';

		$this->define_trigger();

	}

	/**
	 * Define and register the trigger by pushing it into the Automator object
	 */
	public function define_trigger() {

		$trigger = array(
			'author'              => Automator()->get_author_name( $this->trigger_code ),
			'integration'         => self::$integration,
			'code'                => $this->trigger_code,
			'sentence'            => sprintf( esc_attr__( 'If there is a new commission', 'sejoli-uncanny-automator' ) ),
			'select_option_name'  => esc_attr__( 'If there is a new commission', 'sejoli-uncanny-automator' ),
			'action'              => 'sejowoo/commission/add',
			'priority'            => 999,
			'accepted_args'       => 2,
			// 'type'                => 'anonymous',
			'validation_function' => array( $this, 'validate_trigger' ),
			'options_callback'    => '',
		);

		Automator()->register->trigger( $trigger );

	}

	/**
	 * Validate Trigger
	 * @return bool
	 */
	public function validate_trigger( $respond ) : bool {

		$order_id     = $order_data[0]['ID'];
		$affiliate_id = intval($order_data[0]['affiliate_id']);

	    if ( empty( $order_data ) && empty( $order_id ) ) {

			return false;

		} else {

			if ( 0 === $affiliate_id ) {

				return false;

			} else {

				return true;

			}
			
		}

	}

	/**
	 * Set Order ID
	 * @param mixed $args
	 */
	protected function prepare_to_run( $respond ) {

		// Set Order ID
		$order_id = absint( $order_data[0]['ID'] );
		$this->set_ignore_post_id( $order_id );

	}

}
