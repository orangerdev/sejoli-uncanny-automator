<?php
use Uncanny_Automator\Recipe;

/**
 * Class Automator_Sejoli_New_Commission_Trigger
 */
class Automator_Sejoli_New_Commission_Trigger {
	
	use Recipe\Triggers;

	/**
	 * Automator_Sejoli_New_Commission_Trigger constructor.
	 */
	public function __construct() {
	
		$this->setup_trigger();
	
	}

	/**
	 * Setup Trigger
	 */
	protected function setup_trigger() {

		$this->set_integration( 'SEJOLI' );

		$this->set_trigger_code( 'SEJOLI_NEW_COMMISSION' ); // Unique Trigger code

		$this->set_trigger_meta( 'SEJOLI_CREATE_COMMISSION' ); // Re-useable meta, selectable value in blue boxes

		/* Translators: Some information for translators */
		$this->set_sentence( sprintf( 'If there is a new commission' ) ); // Sentence to appear when trigger is added. {{a page:%1$s}} will be presented in blue box as selectable value

		/* Translators: Some information for translators */
		$this->set_readable_sentence( 'If there is a new commission' ); // Non-active state sentence to show

		$this->add_action( 'sejoli/order/new', 999, 2 ); // which do_action() fires this trigger

		$this->register_trigger(); // Registering this trigger

	}

	/**
	 * Validate Trigger
	 * @return bool
	 */
	protected function validate_trigger( $order_data ) : bool {

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
	protected function prepare_to_run( $order_data ) {

		// Set Order ID
		$order_id = absint( $order_data[0]['ID'] );
		$this->set_ignore_post_id( $order_id );

	}

}
