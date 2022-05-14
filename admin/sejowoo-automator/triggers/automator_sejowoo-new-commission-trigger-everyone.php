<?php
// use Uncanny_Automator\Recipe;

// /**
//  * Class Automator_Sejowoo_New_Commission_Trigger_Everyone
//  */
// class Automator_Sejowoo_New_Commission_Trigger_Everyone {
	
// 	use Recipe\Triggers;

// 	/**
// 	 * Automator_Sejowoo_New_Commission_Trigger_Everyone constructor.
// 	 */
// 	public function __construct() {
	
// 		$this->setup_trigger();
	
// 	}

// 	/**
// 	 * Setup Trigger
// 	 */
// 	protected function setup_trigger() {

// 		$this->set_integration( 'SEJOWOO' );

// 		$this->set_trigger_code( 'SEJOWOO_NEW_COMMISSION' ); // Unique Trigger code

// 		$this->set_trigger_meta( 'SEJOWOO_CREATE_COMMISSION' ); // Re-useable meta, selectable value in blue boxes

// 		/* Translators: Some information for translators */
// 		$this->set_sentence( sprintf( 'If there is a new commission' ) ); // Sentence to appear when trigger is added. {{a page:%1$s}} will be presented in blue box as selectable value

// 		/* Translators: Some information for translators */
// 		$this->set_readable_sentence( 'If there is a new commission' ); // Non-active state sentence to show

// 		$this->add_action( 'sejowoo/commission/add', 999, 2 ); // which do_action() fires this trigger

// 		$this->register_trigger(); // Registering this trigger

// 	}


namespace Uncanny_Automator;

/**
 * Class Automator_Sejowoo_New_Commission_Trigger_Everyone
 *
 * @package Uncanny_Automator
 */
class Automator_Sejowoo_New_Commission_Trigger_Everyone {

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

		$this->trigger_code = 'SEJOWOO_NEW_COMMISSION_EVERYONE';
		$this->trigger_meta = 'SEJOWOO_CREATE_COMMISSION_EVERYONE';

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
			'type'                => 'anonymous',
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
